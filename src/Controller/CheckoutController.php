<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends AbstractController
{
    public function index(Request $request)
    {
        return $this->render('checkout/index.html.twig');
    }
}
