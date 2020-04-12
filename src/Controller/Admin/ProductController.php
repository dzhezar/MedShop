<?php


namespace App\Controller\Admin;


use App\DataMapper\Product\ProductFormMapper;
use App\Entity\Language;
use App\Entity\Product;
use App\Form\ProductForm;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var ProductFormMapper
     */
    private $productFormMapper;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     * @param ProductFormMapper $productFormMapper
     */
    public function __construct(ProductService $productService, ProductFormMapper $productFormMapper)
    {
        $this->productService = $productService;
        $this->productFormMapper = $productFormMapper;
    }

    public function index()
    {
        $products = $this->productService->getAll(Language::EN_LANGUAGE_NAME);

        return $this->render('admin/product/index.html.twig', ['products' => $products]);
    }

    public function create(Request $request)
    {
        $form = $this->createForm(ProductForm::class, null, ['image_required' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->productService->create($data);

            return $this->redirectToRoute('admin_product_index');
        }
        

        return $this->render('admin/product/create.html.twig', ['form' => $form->createView()]);
    }

    public function update(Product $id, Request $request)
    {
        $model = $this->productFormMapper->entityToModel($id);
        $form = $this->createForm(ProductForm::class, $model, ['product_id' => $id->getId()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->productService->update($data, $id);

            return $this->redirectToRoute('admin_product_index');
        }


        return $this->render('admin/product/create.html.twig', ['form' => $form->createView()]);
    }
}