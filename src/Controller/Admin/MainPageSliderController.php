<?php


namespace App\Controller\Admin;


use App\DataMapper\MainPageSlider\MainPageSliderFormMapper;
use App\Entity\Language;
use App\Entity\MainPageSlider;
use App\Form\MainPageSliderForm;
use App\Service\MainPageSliderService;
use App\Service\TooltipService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MainPageSliderController extends AbstractController
{

    /**
     * @var MainPageSliderService
     */
    private $mainPageSliderService;
    /**
     * @var MainPageSliderFormMapper
     */
    private $formMapper;

    public function __construct(MainPageSliderService $mainPageSliderService, MainPageSliderFormMapper $formMapper)
    {
        $this->mainPageSliderService = $mainPageSliderService;
        $this->formMapper = $formMapper;
    }

    public function index()
    {
        $slides = $this->mainPageSliderService->getAll(Language::EN_LANGUAGE_NAME);
        return $this->render('admin/slider/index.html.twig', ['slides' => $slides]);
    }

    public function create(Request $request)
    {
        $form = $this->createForm(MainPageSliderForm::class, null, ['image_required' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->mainPageSliderService->create($data);

            return $this->redirectToRoute('admin_main_page_slider_index');
        }

        return $this->render(
            'admin/form.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    public function update(MainPageSlider $id, Request $request)
    {
        $model = $this->formMapper->entityToModel($id);
        $form = $this->createForm(MainPageSliderForm::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->mainPageSliderService->update($model, $id);

            return $this->redirectToRoute('admin_main_page_slider_index');
        }

        return $this->render(
            'admin/form.html.twig',
            [
                'form' => $form->createView(),
                'tooltips' => [
                    'main_page_slider_form_image' => TooltipService::createImageElement(
                        $id->getImage(),
                        TooltipService::OLD_IMAGE
                    )
                ]
            ]
        );
    }

    public function remove(MainPageSlider $id)
    {
        $this->mainPageSliderService->remove($id);
        return $this->redirectToRoute('admin_main_page_slider_index');
    }
}