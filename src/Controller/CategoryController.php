<?php


namespace App\Controller;


use App\Model\OutputModel\CategoryModel;
use App\Service\BreadcrumbsService;
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
    /**
     * @var BreadcrumbsService
     */
    private $breadcrumbsService;

    public function __construct(
        CategoryService $categoryService,
        ProductService $productService,
        BreadcrumbsService $breadcrumbsService
    ) {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->breadcrumbsService = $breadcrumbsService;
    }

    public function categoryCatalog(Request $request)
    {
        $products = $this->productService->getPopularProducts($request->getLocale());
        return $this->render('categories/catalog.html.twig', ['products' => $products]);
    }

    public function mainCategories(Request $request)
    {
        $categories = $this->categoryService->getAllWithSubcategories($request->getLocale());
        return $this->render('categories/main.html.twig', ['categories' => $categories]);
    }

    public function singleCategory(Request $request, $slug)
    {
        /** @var CategoryModel $category */
        $result = $this->categoryService->getCategoryBySlugAndLanguage($slug, $request->getLocale(), null, true);

        if (!$result) {
            return $this->createNotFoundException();
        }


        return $this->render('categories/sub.html.twig', $result);
    }

    public function singleCategoryWithSubCategory(Request $request, $subcategoryslug, $slug)
    {
        $result = $this->categoryService->getCategoryBySlugAndLanguage(
            $slug,
            $request->getLocale(),
            $subcategoryslug,
            true,
            true
        );

        if (!$result) {
            return $this->createNotFoundException();
        }

        return $this->render('categories/catalog.html.twig', $result);
    }
}
