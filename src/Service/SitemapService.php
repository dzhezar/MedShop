<?php


namespace App\Service;


use App\Entity\Language;
use App\Model\OutputModel\CategoryModel;
use App\Service\FileManager\FileManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class SitemapService
{
    const CHANGEFREQ = 'weekly';
    const COMMON_PAGES_PRIORITY = 0.8;
    const CATEGORIES_PRIORITY = 0.8;
    const PRODUCTS_PRIORITY = 0.8;
    const ARTICLES_PRIORITY = 0.8;

    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var ArticleService
     */
    private $articleService;
    /**
     * @var FileManagerInterface
     */
    private $fileManager;
    /**
     * @var Environment
     */
    private $environment;
    private $sitemap_dir;
    /**
     * @var string|null
     */
    private $baseUrl;

    /**
     * SitemapService constructor.
     * @param $sitemap_dir
     * @param CategoryService $categoryService
     * @param ProductService $productService
     * @param UrlGeneratorInterface $urlGenerator
     * @param ArticleService $articleService
     * @param FileManagerInterface $fileManager
     * @param Environment $environment
     * @param RequestStack $requestStack
     */
    public function __construct(
        $sitemap_dir,
        CategoryService $categoryService,
        ProductService $productService,
        UrlGeneratorInterface $urlGenerator,
        ArticleService $articleService,
        FileManagerInterface $fileManager,
        Environment $environment,
        RequestStack $requestStack
    ) {
        $this->sitemap_dir = $sitemap_dir;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->urlGenerator = $urlGenerator;
        $this->articleService = $articleService;
        $this->fileManager = $fileManager;
        $this->environment = $environment;
        $this->baseUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
    }

    public function generate()
    {
        $data = $this->getSitemapData();
        $this->saveSitemap($this->renderHtml($data));
    }

    private function saveSitemap($html)
    {
        file_put_contents($this->sitemap_dir . 'sitemap.xml', $html);
    }

    private function renderHtml(array $data)
    {
        return $this->environment->render('sitemap/sitemap.html.twig', ['data' => $data]);
    }

    private function getSitemapData()
    {
        $data = [];
        $this->getCommonPagesData($data);
        $this->getCategoriesData($data);
        $this->getProductsData($data);
//        $this->getArticlesData($data);

        return $data;
    }

    private function getCommonPagesData(&$data)
    {
        foreach (Language::LANGUAGES_ARRAY as $language) {
            $data[] = [
                'loc' => $this->urlGenerator->generate(
                    'index',
                    ['_locale' => $language],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'changefreq' => self::CHANGEFREQ,
                'priority' => self::COMMON_PAGES_PRIORITY
            ];

            $data[] = [
                'loc' => $this->urlGenerator->generate(
                    'main_categories',
                    ['_locale' => $language],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'changefreq' => self::CHANGEFREQ,
                'priority' => self::COMMON_PAGES_PRIORITY
            ];
            $data[] = [
                'loc' => $this->urlGenerator->generate(
                    'blog_index',
                    ['_locale' => $language],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'changefreq' => self::CHANGEFREQ,
                'priority' => self::COMMON_PAGES_PRIORITY
            ];
        }
    }

    private function getCategoriesData(&$data)
    {
        /** @var CategoryModel[] $categories */
        $categories = array_merge(
            $this->categoryService->getAll(Language::RU_LANGUAGE_NAME),
            $this->categoryService->getAll(Language::EN_LANGUAGE_NAME)
        );
        foreach ($categories as $category) {
            $data[] = [
                'loc' => $this->baseUrl.$category->getLink(),
                'changefreq' => self::CHANGEFREQ,
                'priority' => self::CATEGORIES_PRIORITY
            ];
        }
    }

    private function getProductsData(&$data)
    {
        $products = $this->productService->getAll(Language::RU_LANGUAGE_NAME);
        foreach ($products as $product) {
            foreach (Language::LANGUAGES_ARRAY as $language) {
                $data[] = $this->generateSitemapBlock(
                    $product->getSlug(),
                    'single_product',
                    self::PRODUCTS_PRIORITY,
                    $language
                );
            }
        }
    }

    private function getArticlesData(&$data)
    {
        $articles = $this->articleService->getAll(Language::RU_LANGUAGE_NAME);
        foreach ($articles as $article) {
            foreach (Language::LANGUAGES_ARRAY as $language) {
                $data[] = $this->generateSitemapBlock(
                    $article->getSlug(),
                    'single_blog', //TODO make route
                    self::ARTICLES_PRIORITY,
                    $language
                );
            }
        }
    }

    private function generateSitemapBlock($slug, $route_name, $priority, $language)
    {
        return [
            'loc' => $this->urlGenerator->generate(
                $route_name,
                [
                    'slug' => $slug,
                    '_locale' => $language
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => self::CHANGEFREQ,
            'priority' => $priority
        ];
    }
}