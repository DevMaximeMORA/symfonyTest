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
            dump($id);
            $product = $productRepository->find($id);
            dump($product);
            $totalQuantity += $quantity;
            $totalPrice += ($product->getPrice() * $quantity);
        }

        return $this->render('home/index.html.twig', [
            'products' => $productRepository->findBy(array(),array('name' => 'ASC')),
            'cart_quantity' => $totalQuantity,
            'cart_price' => $totalPrice,
        ]);
    }
}
