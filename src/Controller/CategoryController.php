<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    public function index()
    {
        return $this->render('categories/main.html.twig');
    }
}
