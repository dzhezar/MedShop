<?php


namespace App\Strategy\Breadcurmbs;


use App\Entity\CategoryTranslation;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryBreadCrumbStrategy implements BreadcrumbsStrategyInterface
{
    const TYPE_NAME = 'category_breadcrumbs';
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

    public
    function supports(
        string $type
    ) {
        return $type === self::TYPE_NAME;
    }

    /** @return array
     * @var CategoryTranslation $categoryTranslation
     */
    public function generateBreadcrumbs($categoryTranslation): array
    {
        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->translator->trans('product.home'),
            'url' => $this->router->generate('index')
        ];

        $breadcrumbs[] = [
            'name' => $this->translator->trans('navbar.product'),
            'url' => $this->router->generate('main_categories')
        ];

        $langId = $categoryTranslation->getLanguage()->getId();

        $subCategoryUrl = false;

        if ($subCategory = $categoryTranslation->getCategory()->getCategory()) {
            foreach ($subCategory->getCategoryTranslations() as $subCategoryTranslation) {
                if ($subCategoryTranslation->getLanguage()->getId() === $langId) {
                    $subCategoryUrl = $this->router->generate(
                        'single_category',
                        [
                            'slug' => $subCategoryTranslation->getCategory()->getSlug()
                        ]
                    );
                    $breadcrumbs[] = [
                        'name' => $subCategoryTranslation->getTitle(),
                        'url' => $subCategoryUrl
                    ];
                }
            }
        }

        if ($subCategoryUrl) {
            $categoryUrl = $subCategoryUrl . '/' . $categoryTranslation->getCategory()->getSlug();
        } else {
            $categoryUrl = $this->router->generate(
                'single_category',
                ['slug' => $categoryTranslation->getCategory()->getSlug()]
            );
        }

        $breadcrumbs[] = [
            'name' => $categoryTranslation->getTitle(),
            'url' => $categoryUrl
        ];


        return $breadcrumbs;
    }
}