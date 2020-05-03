<?php


namespace App\Strategy\Breadcurmbs;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CatalogBreadcrumbsStrategy implements BreadcrumbsStrategyInterface
{
    const TYPE_NAME = 'catalog_breadcrumbs';
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * CategoryBreadCrumbStrategy constructor.
     * @param TranslatorInterface $translator
     * @param UrlGeneratorInterface $router
     */
    public function __construct(
        TranslatorInterface $translator,
        UrlGeneratorInterface $router
    ) {
        $this->translator = $translator;
        $this->router = $router;
    }

    public function supports(string $type)
    {
        return $type === self::TYPE_NAME;
    }

    public function generateBreadcrumbs($data): array
    {
        return [
            [
                'name' => $this->translator->trans('product.home'),
                'url' => $this->router->generate('index')
            ],
            [
                'name' => $this->translator->trans('navbar.product'),
                'url' => $this->router->generate('main_categories')
            ]
        ];
    }
}