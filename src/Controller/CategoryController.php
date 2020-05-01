<?php


namespace App\Controller;


use App\Model\OutputModel\CategoryModel;
use App\Model\OutputModel\ProductModel;
use App\Service\CategoryService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{

    /**
     * @var CategoryService
     */
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function singleCategory(Request $request, $slug)
    {
        /** @var CategoryModel $category */
        $category = $this->categoryService->getCategoryBySlugAndLanguage($slug, $request->getLocale());

        dd($category);

        if(!$category) {
            return $this->createNotFoundException();
        }

        return $this->render('product/singe.html.twig', ['product' => $product]);
    }

    public function singleCategoryWithSubCategory(Request $request, $subcategoryslug, $slug)
    {
        $category = $this->categoryService->getCategoryBySlugAndLanguage($slug, $request->getLocale(), $subcategoryslug);

        dd($category);

        if(!$category) {
            return $this->createNotFoundException();
        }

        return $this->render('product/singe.html.twig', ['product' => $product]);
    }
}