<?php


namespace App\Controller\Admin;


use App\Form\SettingsForm;
use App\Service\SettingsCRUDService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends AbstractController
{
    /**
     * @var SettingsCRUDService
     */
    private $service;

    /**
     * SettingsController constructor.
     * @param SettingsCRUDService $service
     */
    public function __construct(SettingsCRUDService $service)
    {
        $this->service = $service;
    }

    public function index()
    {

    }

    public function update(Request $request)
    {
        $form = $this->createForm(SettingsForm::class, null, ['options_array' => $this->service->getAll()]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->service->update($data);
        }

        return $this->render('admin/form.html.twig', ['form' => $form->createView()]);
    }
}