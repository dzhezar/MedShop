<?php


namespace App\Service;


use App\Entity\Orders;
use Twig\Environment;

class MailService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $environment;

    /**
     * MailService constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $environment
     */
    public function __construct(\Swift_Mailer $mailer, Environment $environment)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    public function sendNewOrderMail(Orders $order)
    {
        $data = $order->getOrderData();
        $data['products'] = \json_decode($data['products'], true);
        $html = $this->environment->render('checkout/email.html.twig', ['order' => $order, 'data' => $data]);
        $this->sendMail($order->getEmail(), $html, 'Thank You For Order');
    }

    public function sendMail($mailTo, $body, $name)
    {
        $message = (new \Swift_Message($name))
            ->setFrom('qq@gmail.com')
            ->setTo($mailTo)
            ->setBody(
                $body,
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}