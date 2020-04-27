<?php


namespace App\Service;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionCartService
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var mixed
     */
    private $storage;

    /**
     * SessionCartService constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->storage = new ArrayCollection($session->get('cart', []));
    }

    public function plus($id)
    {
        if(!$this->storage->offsetExists($id)) {
            $this->storage->set($id, 0);
        }

        $amount = $this->storage->get($id);
        $this->storage->set($id, $amount+1);
        $this->save();
    }

    public function minus($id)
    {

    }

    public function remove($id)
    {

    }

    public function save()
    {
        $this->session->set('cart', $this->storage->toArray());
    }

    public function ifProductAddedToCart(int $id)
    {
        return $this->storage->offsetExists($id);
    }
}