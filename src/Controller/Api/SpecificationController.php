<?php


namespace App\Controller\Api;


use App\Entity\Language;
use App\Entity\Specification;
use App\Entity\SpecificationTranslation;
use App\Service\LanguageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SpecificationController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var LanguageService
     */
    private $languageService;

    /**
     * SpecificationController constructor.
     * @param EntityManagerInterface $entityManager
     * @param LanguageService $languageService
     */
    public function __construct(EntityManagerInterface $entityManager, LanguageService $languageService)
    {
        $this->entityManager = $entityManager;
        $this->languageService = $languageService;
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $english = $request->request->get('english');
        $russian = $request->request->get('russian');

        if (!$english || !$russian) {
            throw new BadRequestHttpException();
        }

        $specification = new Specification();

        $this->entityManager->persist($specification);
        $this->entityManager->flush();

        $ruSpecification = new SpecificationTranslation();
        $ruSpecification->setName($russian);
        $ruSpecification->setLanguge($this->languageService->getLanguage(Language::RU_LANGUAGE_NAME));
        $ruSpecification->setSpecification($specification);

        $enSpecification = new SpecificationTranslation();
        $enSpecification->setLanguge($this->languageService->getLanguage(Language::EN_LANGUAGE_NAME));
        $enSpecification->setSpecification($specification);
        $enSpecification->setName($english);

        $this->entityManager->persist($ruSpecification);
        $this->entityManager->persist($enSpecification);

        $this->entityManager->flush();

        return $this->json(
            [
                'id' => $specification->getId(),
                'name' => $enSpecification->getName()
            ]
        );
    }
}