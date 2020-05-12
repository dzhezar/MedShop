<?php


namespace App\Controller\Admin;


use App\Form\RobotsTxtForm;
use App\Service\RobotsTxtService;
use App\Service\SitemapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SitemapController extends AbstractController
{
    /**
     * @var SitemapService
     */
    private $sitemapService;
    /**
     * @var RobotsTxtService
     */
    private $robotsTxtService;

    /**
     * SitemapController constructor.
     * @param SitemapService $sitemapService
     * @param RobotsTxtService $robotsTxtService
     */
    public function __construct(SitemapService $sitemapService, RobotsTxtService $robotsTxtService)
    {
        $this->sitemapService = $sitemapService;
        $this->robotsTxtService = $robotsTxtService;
    }

    public function uploadRobotsTxt(Request $request)
    {
        $form = $this->createForm(RobotsTxtForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->robotsTxtService->update($form->getData()['image']);
            return $this->redirectToRoute('admin_settings_index');
        }

        return $this->render(
            'admin/form.html.twig',
            [
                'dont_show_lang_block' => true,
                'form' => $form->createView()
            ]
        );
    }

    public function generate()
    {
        $this->sitemapService->generate();
        die('Ready');
    }

}