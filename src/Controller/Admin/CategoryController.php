<?php


namespace App\Controller\Admin;


use App\Entity\Language;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAll(Language::RU_LANGUAGE_NAME);
        return $this->render('admin/category/index.html.twig', ['categories' => $categories]);
    }
}