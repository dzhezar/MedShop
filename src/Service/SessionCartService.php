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
        $result = [];
        if($this->storage->offsetExists($id)) {
            $amount = $this->storage->get($id);
            if($amount-1 <= 0) {
                $this->storage->remove($id);
                $result = ['removed' => true];

            } else {
                $this->storage->set($id, $amount-1);
                $result = ['removed' => false];
            }

            $this->save();
        }

        return $result;
    }

    public function remove($id)
    {
        $this->storage->remove($id);
        $this->save();
    }

    public function save()
    {
        $this->session->set('cart', $this->storage->toArray());
    }

    public function ifProductAddedToCart(int $id)
    {
        return $this->storage->offsetExists($id);
    }

    public function getProductAmount(int $id)
    {
        return $this->storage->get($id);
    }

    public function all()
    {
        return $this->storage->toArray();
    }
}