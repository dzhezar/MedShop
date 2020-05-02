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

    private $productService;

    public function __construct(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    public function categoryCatalog(Request $request)
    {
        $products = $this->productService->getPopularProducts($request->getLocale());
        return $this->render('categories/catalog.html.twig',['products' => $products]);
    }

    public function mainCategories()
    {
        return $this->render('categories/main.html.twig');
    }

    public function singleCategory(Request $request, $slug)
    {
        /** @var CategoryModel $category */
        $category = $this->categoryService->getCategoryBySlugAndLanguage($slug, $request->getLocale());

        if(!$category) {
            return $this->createNotFoundException();
        }

        return $this->render('categories/main.html.twig', ['products' => [], 'categories' => []]);
    }

    public function singleCategoryWithSubCategory(Request $request, $subcategoryslug, $slug)
    {
        $category = $this->categoryService->getCategoryBySlugAndLanguage($slug, $request->getLocale(), $subcategoryslug);

        if(!$category) {
            return $this->createNotFoundException();
        }

        dd($category);

    }

    public function subCategories()
    {
        return $this->render('categories/sub.html.twig');
    }
}
