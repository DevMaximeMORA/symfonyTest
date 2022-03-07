<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);

        $totalQuantity = 0;
        $totalPrice = 0;

        foreach($cart as $id => $quantity){
            $product = $productRepository->find($id);
            if ($product){
                $totalQuantity += $quantity;
                $totalPrice += ($product->getPrice() * $quantity);
            } else {
                unset($cart[$id]);
                $session->set('cart', $cart);
            }
        }

        return $this->render('home/index.html.twig', [
            'products' => $productRepository->findBy(array(),array('name' => 'ASC')),
            'cart_quantity' => $totalQuantity,
            'cart_price' => $totalPrice,
        ]);
    }
}
