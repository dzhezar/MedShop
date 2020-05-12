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

    public function aboutUs()
    {
        return $this->render('blog/about_us.html.twig');
    }

    public function contacts($_locale)
    {
        return $this->render('blog/contacts.html.twig');
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

    public function post($_locale)
    {
        return $this->render('blog/single_post.html.twig');
    }

    public function shippingAndPayment($_locale)
    {
        return $this->render('blog/shipping_and_payment.html.twig');
    }
}
