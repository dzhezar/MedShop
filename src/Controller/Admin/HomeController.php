<?php


namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->redirectToRoute('admin_index_show');
    }

    public function show()
    {
        return $this->render('admin/index.html.twig');
    }
}