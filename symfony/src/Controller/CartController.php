<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    //Cart index
    #[Route('/cart', name: 'app_cart')]
    public function index(ProductRepository $productRepository, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        $cartData = [];
        $total = 0;

        foreach($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            $cartData[] = [
                "product" => $product,
                "quantity" => $quantity,
            ];
            $total += ($product->getPrice() * $quantity);
        }

        return $this->renderForm('cart/index.html.twig', [
            'cart' => $cartData,
            'total' => $total,
        ]);
    }

    #[Route('/cart/clear', name: 'app_cart_clear')]
    public function clear(SessionInterface $session)
    {
        $session->set('cart', []);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/add/{id}/{quantity}', name: 'app_cart_add', methods: ['GET', 'POST'])]
    public function add(Request $request, Product $product, SessionInterface $session, $quantity = 0)
    {
        $cart = $session->get('cart', []);
        $id = $product->getId();

        if ($request->isMethod("GET")){
            if ($request->query->get('quantity') != 0)
                $quantity = $request->query->get('quantity');
        }

        if (!empty($cart[$id])) $cart[$id] = $cart[$id] + $quantity;
        else $cart[$id] = $quantity;

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/delete/{id}', name: 'app_cart_delete')]
    public function delete(Product $product, SessionInterface $session)
    {
        $cart = $session->get('cart', []);
        $id = $product->getId();

        if (!empty($cart[$id])){
            if ($cart[$id] > 1)
                $cart[$id]--;
            else
                unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove(Product $product, SessionInterface $session)
    {
        $cart = $session->get('cart', []);
        $id = $product->getId();

        unset($cart[$id]);

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }
}
