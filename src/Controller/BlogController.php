<?php


namespace App\Controller;


use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * BlogController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        $articles = $this->articleService->getAllWithPagination(
            $request->getLocale(),
            $request->query->getInt('page', 1)
        );

        return $this->render('blog/index.html.twig', ['articles' => $articles]);
    }
}
