<?php


namespace App\Controller\Admin;


use App\Entity\Language;
use App\Form\CategoryForm;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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

    public function create(Request $request)
    {
        $form = $this->createForm(CategoryForm::class, null, ['image_required' => true]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->categoryService->create($data);

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/form.html.twig', ['form' => $form->createView()]);
    }
}