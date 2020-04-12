<?php


namespace App\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SpecificationController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $english = $request->request->get('english');
        $russian = $request->request->get('russian');

        if(!$english || !$russian) {
            throw new BadRequestHttpException();
        }

        return $this->json(['qq' => 'qq']);
    }
}