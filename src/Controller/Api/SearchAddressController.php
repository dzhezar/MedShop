<?php


namespace App\Controller\Api;


use App\Service\AddressService;
use App\Service\ValidationService;
use App\Strategy\Validation\SearchAddressValidationStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchAddressController extends AbstractController
{
    /**
     * @var ValidationService
     */
    private $validationService;
    /**
     * @var AddressService
     */
    private $addressService;

    /**
     * SearchAddressController constructor.
     * @param ValidationService $validationService
     * @param AddressService $addressService
     */
    public function __construct(ValidationService $validationService, AddressService $addressService)
    {
        $this->validationService = $validationService;
        $this->addressService = $addressService;
    }

    public function search(Request $request)
    {
        return new JsonResponse($this->addressService->find($request));
    }
}