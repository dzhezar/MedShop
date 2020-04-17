<?php


namespace App\Controller\Admin;


use App\DataMapper\Article\ArticleFormMapper;
use App\Entity\Article;
use App\Entity\Language;
use App\Form\ArticleForm;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{

    /**
     * @var ArticleService
     */
    private $articleService;
    /**
     * @var ArticleFormMapper
     */
    private $articleFormMapper;

    public function __construct(ArticleService $articleService, ArticleFormMapper $articleFormMapper)
    {
        $this->articleService = $articleService;
        $this->articleFormMapper = $articleFormMapper;
    }

    public function index()
    {
        $articles = $this->articleService->getAll(Language::EN_LANGUAGE_NAME);
        return $this->render('admin/article/index.html.twig', ['articles' => $articles]);
    }

    public function create(Request $request)
    {
        $form = $this->createForm(ArticleForm::class, null, ['image_required' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->articleService->create($data);

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render(
            'admin/form.html.twig',
            [
                'form' => $form->createView(),
                'tooltips' => ArticleService::TOOLTIPS_ARRAY
            ]
        );
    }

    public function update(Article $id, Request $request)
    {
        $model = $this->articleFormMapper->entityToModel($id);
        $form = $this->createForm(ArticleForm::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->articleService->update($model, $id);

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render(
            'admin/form.html.twig',
            [
                'form' => $form->createView(),
                'tooltips' => ArticleService::TOOLTIPS_ARRAY
            ]
        );
    }

    public function remove(Article $id)
    {
        $this->articleService->remove($id);
        return $this->redirectToRoute('admin_article_index');
    }
}