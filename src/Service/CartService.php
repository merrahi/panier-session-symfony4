<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use PhpParser\Node\Expr\Cast\Double;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService{

    public $session;
    public $productRepository;
    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session=$session;
        $this->productRepository=$productRepository;
    }

    public function add(int $id)
    {
        $panier=$this->session->get("panier",[]);
        if(isset($panier[$id])){
            $panier[$id]++;
        }
        else{
            $panier[$id]=1;
        }
        $this->session->set('panier',$panier);
    }
    public function remove($id): bool
    {
        $panier=$this->session->get('panier');
        if(isset($panier[$id])){
            unset($panier[$id]);
        }
        $this->session->set('panier',$panier);
        return true;
    }
    public function panierDetails(): array
    {
        $panier=$this->session->get("panier",[]);
        $panierDetails=array();
        foreach ($panier as $id => $qt){

            $panierDetails[]=[
                'product'  => $this->productRepository->find($id),
                'quantity' => $qt
            ];
        }
        return $panierDetails;
    }
    public function calculTotal() : float
    {
        $total=0;
        foreach ($this->panierDetails() as $panierDetail ){
            $total += $panierDetail['product']->getPrice()*$panierDetail['quantity'];
        }
        return $total;

    }
}