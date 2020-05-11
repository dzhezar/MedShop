<?php


namespace App\Service;


use App\DataMapper\Order\OrderMapper;
use App\Model\OutputModel\OrderModel;
use App\Repository\OrdersRepository;
use Knp\Component\Pager\PaginatorInterface;
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
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * OrderService constructor.
     * @param OrdersRepository $ordersRepository
     * @param Environment $environment
     * @param OrderMapper $orderMapper
     * @param PaginatorInterface $paginator
     */

    public function __construct(
        OrdersRepository $ordersRepository,
        Environment $environment,
        OrderMapper $orderMapper,
        PaginatorInterface $paginator
    ) {
        $this->ordersRepository = $ordersRepository;
        $this->environment = $environment;
        $this->orderMapper = $orderMapper;
        $this->paginator = $paginator;
    }

    public function getAllByCookies(Request $request)
    {
        /** @var OrderModel[] $result */
        $result = [];
        $language = $request->getLocale();
        $orders = \json_decode($request->cookies->get('orders', '{}'), true);
        foreach ($orders as $item) {
            if ($order = $this->ordersRepository->findOneBy(['hash' => $item])) {
                $result[] = $this->orderMapper->entityToModel($order, $language);
            }
        }

        return $result;
    }

    public function getAllWithPagination(int $page)
    {
        $orders = $this->ordersRepository->getOrdersQuery();
        return $this->paginator->paginate(
            $orders,
            $page,
            10
        );
    }
}
