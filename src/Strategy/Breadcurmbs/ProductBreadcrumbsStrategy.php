<?php


namespace App\Strategy\Breadcurmbs;


use App\Entity\ProductTranslation;
use App\Service\BreadcrumbsService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductBreadcrumbsStrategy implements BreadcrumbsStrategyInterface
{
    const TYPE_NAME = 'product_breadcrumbs';
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var UrlGeneratorInterface
     */
    private $router;
    /**
     * @var BreadcrumbsService
     */
    private $breadcrumbsService;

    /**
     * ProductBreadcrumbsStrategy constructor.
     * @param TranslatorInterface $translator
     * @param UrlGeneratorInterface $router
     * @param BreadcrumbsService $breadcrumbsService
     */
    public function __construct(
        TranslatorInterface $translator,
        UrlGeneratorInterface $router,
        BreadcrumbsService $breadcrumbsService
    ) {
        $this->translator = $translator;
        $this->router = $router;
        $this->breadcrumbsService = $breadcrumbsService;
    }

    public function supports(string $type)
    {
        return $type === self::TYPE_NAME;
    }

    /** @var ProductTranslation $productTranslation */
    public function generateBreadcrumbs($productTranslation): array
    {
        $breadcrumbs = [];

        $langId = $productTranslation->getLanguage()->getId();

        foreach ($productTranslation->getProduct()->getCategory()->getCategoryTranslations() as $categoryTranslation) {
            if ($categoryTranslation->getLanguage()->getId() === $langId) {
                $breadcrumbs = $this->breadcrumbsService->generateBreadcrumbs(
                    $categoryTranslation,
                    CategoryBreadCrumbStrategy::TYPE_NAME
                );
            }
        }

        $breadcrumbs[] = [
            'name' => $productTranslation->getTitle(),
            'url' => $this->router->generate('single_product', ['slug' => $productTranslation->getProduct()->getSlug()])
        ];


        return $breadcrumbs;
    }
}