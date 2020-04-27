<?php


namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainPageSliderController  extends AbstractController
{

//    public function __construct(MainPageSliderService $articleService, MainPageSliderFormMapper $articleFormMapper)
//    {
//    }
//
//    public function index()
//    {
//        $articles = $this->articleService->getAll(Language::EN_LANGUAGE_NAME);
//        return $this->render('admin/article/index.html.twig', ['articles' => $articles]);
//    }
//
//    public function create(Request $request)
//    {
//        $form = $this->createForm(ArticleForm::class, null, ['image_required' => true]);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//            $this->articleService->create($data);
//
//            return $this->redirectToRoute('admin_article_index');
//        }
//
//        return $this->render(
//            'admin/form.html.twig',
//            [
//                'form' => $form->createView(),
//                'tooltips' => $this->articleService->tooltipsArray
//            ]
//        );
//    }
//
//    public function update(Article $id, Request $request)
//    {
//        $model = $this->articleFormMapper->entityToModel($id);
//        $form = $this->createForm(ArticleForm::class, $model);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->articleService->update($model, $id);
//
//            return $this->redirectToRoute('admin_article_index');
//        }
//
//        $tooltips = $this->articleService->tooltipsArray;
//        $tooltips['article_form_image'] = TooltipService::createImageElement(
//            $id->getImage(),
//            TooltipService::OLD_IMAGE
//        );
//
//        return $this->render(
//            'admin/form.html.twig',
//            [
//                'form' => $form->createView(),
//                'tooltips' => $tooltips
//            ]
//        );
//    }
//
//    public function remove(Article $id)
//    {
//        $this->articleService->remove($id);
//        return $this->redirectToRoute('admin_article_index');
//    }
}