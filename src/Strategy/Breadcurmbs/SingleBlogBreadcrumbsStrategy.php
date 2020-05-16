<?php


namespace App\Strategy\Breadcurmbs;


use App\Service\BreadcrumbsService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SingleBlogBreadcrumbsStrategy implements BreadcrumbsStrategyInterface
{



    const TYPE_NAME = 'single_blog_breadcrumbs';
    /**
     * @var BreadcrumbsService
     */
    private $breadcrumbsService;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * SingleBlogBreadcrumbsStrategy constructor.
     * @param BreadcrumbsService $breadcrumbsService
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(BreadcrumbsService $breadcrumbsService, UrlGeneratorInterface $urlGenerator)
    {
        $this->breadcrumbsService = $breadcrumbsService;
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(string $type)
    {
        return $type === self::TYPE_NAME;
    }

    public function generateBreadcrumbs($data): array
    {
        $breadCrumbs = $this->breadcrumbsService->generateBreadcrumbs(null, BlogMainBreadCrumbsStrategy::TYPE_NAME);

        $breadCrumbs[] = [
            'name' => $data->getTitle(),
            'url' => $this->urlGenerator->generate('blog_post', ['slug' => $data->getTitle()])
        ];

        return $breadCrumbs;
    }
}