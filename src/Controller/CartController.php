<?php

namespace App\Controller;


use App\Service\CartService;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService)
    {
        return $this->render('cart/index.html.twig', [
            'panierDetails' => $cartService->panierDetails(),
            'total' => $cartService->calculTotal()
        ]);
    }

    /**
     * @Route("/panier/add/{id}",name="cart_add")
     *
     */
     public function add($id,CartService $cartService){
         $cartService->add($id);
         return $this->redirectToRoute('cart_index');
     }

     /**
      * @Route("/panier/remove/{id}",name="cart_remove")
      *
      */
     public function remove($id,CartService $cartService){
         $cartService->remove($id);
         return $this->redirectToRoute('cart_index');
     }
}
