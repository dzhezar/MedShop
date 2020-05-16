<?php


namespace App\Controller;


use App\Service\ArticleService;
use App\Service\BreadcrumbsService;
use App\Strategy\Breadcurmbs\BlogMainBreadCrumbsStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    /**
     * @var ArticleService
     */
    private $articleService;
    /**
     * @var BreadcrumbsService
     */
    private $breadcrumbsService;

    /**
     * BlogController constructor.
     * @param ArticleService $articleService
     * @param BreadcrumbsService $breadcrumbsService
     */
    public function __construct(ArticleService $articleService, BreadcrumbsService $breadcrumbsService)
    {
        $this->articleService = $articleService;
        $this->breadcrumbsService = $breadcrumbsService;
    }

    public function index(Request $request)
    {
        $articles = $this->articleService->getAllWithPagination(
            $request->getLocale(),
            $request->query->getInt('page', 1)
        );

        $breadcrumbs = $this->breadcrumbsService->generateBreadcrumbs([], BlogMainBreadCrumbsStrategy::TYPE_NAME);

        return $this->render('blog/index.html.twig', ['articles' => $articles, 'breadcrumbs' => $breadcrumbs]);
    }

    public function post(Request $request, $slug)
    {
        $data = $this->articleService->findOneBySlugAndLanguage($slug, $request->getLocale());

        if(!$data) {
            throw $this->createNotFoundException();
        }

        return $this->render('blog/single_post.html.twig', $data);
    }
}
