<?php


namespace App\Controller\Admin;


use App\Service\SitemapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    /**
     * @var SitemapService
     */
    private $sitemapService;

    /**
     * SitemapController constructor.
     * @param SitemapService $sitemapService
     */
    public function __construct(SitemapService $sitemapService)
    {
        $this->sitemapService = $sitemapService;
    }

    public function generate()
    {
        $this->sitemapService->generate();
        die('Ready');
    }
}