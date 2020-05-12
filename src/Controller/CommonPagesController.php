<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommonPagesController extends AbstractController
{
    public function shippingAndPayment($_locale)
    {
        return $this->render('blog/shipping_and_payment.html.twig');
    }

    public function aboutUs()
    {
        return $this->render('blog/about_us.html.twig');
    }

    public function contacts($_locale)
    {
        return $this->render('blog/contacts.html.twig');
    }
}