<?php


namespace App\Controller\Admin;


use App\DataMapper\Category\CategoryFormMapper;
use App\Entity\Category;
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
     * @var CategoryFormMapper
     */
    private $categoryFormMapper;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     * @param CategoryFormMapper $categoryFormMapper
     */
    public function __construct(CategoryService $categoryService, CategoryFormMapper $categoryFormMapper)
    {
        $this->categoryService = $categoryService;
        $this->categoryFormMapper = $categoryFormMapper;
    }

    public function index()
    {
        $categories = $this->categoryService->getAll(Language::EN_LANGUAGE_NAME);
        return $this->render('admin/category/index.html.twig', ['categories' => $categories]);
    }

    public function create(Request $request)
    {
        $form = $this->createForm(CategoryForm::class, null, ['image_required' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->categoryService->create($data);

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render(
            'admin/form.html.twig',
            [
                'form' => $form->createView(),
                'tooltips' => CategoryService::TOOLTIPS_ARRAY
            ]
        );
    }

    public function update(Category $id, Request $request)
    {
        $model = $this->categoryFormMapper->entityToModel($id);
        $form = $this->createForm(CategoryForm::class, $model, ['category_id' => $id->getId()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->update($model, $id);

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render(
            'admin/form.html.twig',
            [
                'form' => $form->createView(),
                'tooltips' => [
                    'category_form_category' => 'Внимание. Вы не увидите категорий, у которых уже установлена вложеность'
                ]
            ]
        );
    }

    public function remove(Category $id)
    {
        $this->categoryService->remove($id);
        return $this->redirectToRoute('admin_category_index');
    }
}