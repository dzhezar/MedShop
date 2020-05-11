<?php


namespace App\Controller\Admin;


use App\Entity\Orders;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends AbstractController
{
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * OrdersController constructor.
     * @param OrderService $orderService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(OrderService $orderService, EntityManagerInterface $entityManager)
    {
        $this->orderService = $orderService;
        $this->entityManager = $entityManager;
    }

    public function index(Request $request)
    {
        /** @var Orders[] $orders */
        $orders = $this->orderService->getAllWithPagination($request->query->getInt('page', 1));

        return $this->render('admin/orders/index.html.twig', ['orders' => $orders]);
    }

    public function show(Orders $order)
    {
        $data = $order->getOrderData();
        $data['products'] = \json_decode($data['products'], true);
        $order->setOrderData($data);


        return $this->render('admin/orders/show.html.twig', ['order' => $order, 'statuses' => Orders::STATUSES_ARRAY]);
    }

    public function changeStatus(Orders $order, $status)
    {
        if(in_array($status, Orders::STATUSES_ARRAY)) {
            $order->setPayStatus($status);
            $order->setDateUpdated(new \DateTime());
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('admin_orders_update', ['id' => $order->getId()]);
    }
}