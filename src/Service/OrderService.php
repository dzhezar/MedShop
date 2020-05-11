<?php


namespace App\Service;


use App\DataMapper\Order\OrderMapper;
use App\Model\OutputModel\OrderModel;
use App\Repository\OrdersRepository;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class OrderService
{
    /**
     * @var OrdersRepository
     */
    private $ordersRepository;
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var OrderMapper
     */
    private $orderMapper;

    /**
     * OrderService constructor.
     * @param OrdersRepository $ordersRepository
     * @param Environment $environment
     * @param OrderMapper $orderMapper
     */

    public function __construct(OrdersRepository $ordersRepository, Environment $environment, OrderMapper $orderMapper)
    {
        $this->ordersRepository = $ordersRepository;
        $this->environment = $environment;
        $this->orderMapper = $orderMapper;
    }

    public function getAllByCookies(Request $request)
    {
        /** @var OrderModel[] $result */
        $result = [];
        $language = $request->getLocale();
        $orders = \json_decode($request->cookies->get('orders', []), true);
        foreach ($orders as $item) {
            if ($order = $this->ordersRepository->findOneBy(['hash' => $item])) {
                $result[] = $this->orderMapper->entityToModel($order, $language);
            }
        }

        return $result;
    }
}
