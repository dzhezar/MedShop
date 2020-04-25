<?php


namespace App\Controller\Admin;


use App\DataMapper\Product\ProductFormMapper;
use App\Entity\Language;
use App\Entity\Product;
use App\Form\ProductForm;
use App\Form\ProductOnMainForm;
use App\Service\ProductService;
use App\Service\SpecificationService;
use App\Service\TooltipService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
     * @var SpecificationService
     */
    private $specificationService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     * @param ProductFormMapper $productFormMapper
     * @param SpecificationService $specificationService
     */
    public function __construct(
        ProductService $productService,
        ProductFormMapper $productFormMapper,
        SpecificationService $specificationService
    ) {
        $this->productService = $productService;
        $this->productFormMapper = $productFormMapper;
        $this->specificationService = $specificationService;
    }

    public function index()
    {
        $products = $this->productService->getAll(Language::EN_LANGUAGE_NAME);

        return $this->render('admin/product/index.html.twig', ['products' => $products]);
    }

    public function create(Request $request)
    {
        $specifications = $this->specificationService->getAll();
        $form = $this->createForm(ProductForm::class, null, ['image_required' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->productService->create($data);

            return $this->redirectToRoute('admin_product_index');
        }


        return $this->render(
            'admin/product/create.html.twig',
            [
                'form' => $form->createView(),
                'specifications' => $specifications
            ]
        );
    }

    public function update(Product $id, Request $request)
    {
        $specifications = $this->specificationService->getAll();
        $productSpecifications = $this->specificationService->getSpecificationsForProduct($id->getId());
        $model = $this->productFormMapper->entityToModel($id);
        $form = $this->createForm(ProductForm::class, $model, ['product_id' => $id->getId()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->productService->update($data, $id);

            return $this->redirectToRoute('admin_product_index');
        }

        $tooltips['product_form_image'] = TooltipService::createImageElement($id->getImage(), TooltipService::OLD_IMAGE);


        return $this->render(
            'admin/product/update.html.twig',
            [
                'form' => $form->createView(),
                'specifications' => $specifications,
                'productSpecifications' => $productSpecifications,
                'tooltips' => $tooltips
            ]
        );
    }

    public function remove(Product $id)
    {
        $this->productService->remove($id);
        return $this->redirectToRoute('admin_product_index');
    }

    public function showOnMain(Request $request)
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findBy(['is_on_main' => true]);
        $form = $this->createForm(ProductOnMainForm::class, ['product' => $products]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->productService->updateMainPageCategories($data['product'],  (array) $products);
            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render(
            'admin/form.html.twig',
            [
                'form' => $form->createView(),
                'tooltips' => [
                    'product_on_main_form_product' => TooltipService::createImageElement(
                        '/admin/img/tooltips/popular_products.png',
                        'Если у товара не включено отображение, то его не будет видно на главной странице'
                    )
                ],
                'dont_show_lang_block' => true
            ]
        );
    }

    public function switchVisibility(Request $request)
    {
        $id = $request->request->getInt('id');
        $checked = $request->request->getBoolean('checked');

        if(!$this->productService->switchVisibility($id, $checked)) {
            throw new BadRequestHttpException();
        }

        return new Response();
    }
}