<?php


namespace App\Model\OutputModel;


class OrderModel
{
    private $status;
    private $status_text;
    private $payment_link;
    private $date_created;
    private $date_updated;
    private $id;
    private $order_data;
    private $full_name;
    private $email;
    private $street;
    private $city;
    private $state;
    private $zip;
    private $phone;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return OrderModel
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusText()
    {
        return $this->status_text;
    }

    /**
     * @param mixed $status_text
     * @return OrderModel
     */
    public function setStatusText($status_text)
    {
        $this->status_text = $status_text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentLink()
    {
        return $this->payment_link;
    }

    /**
     * @param mixed $payment_link
     * @return OrderModel
     */
    public function setPaymentLink($payment_link)
    {
        $this->payment_link = $payment_link;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param mixed $date_created
     * @return OrderModel
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * @param mixed $date_updated
     * @return OrderModel
     */
    public function setDateUpdated($date_updated)
    {
        $this->date_updated = $date_updated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return OrderModel
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderData()
    {
        return $this->order_data;
    }

    /**
     * @param mixed $order_data
     * @return OrderModel
     */
    public function setOrderData($order_data)
    {
        $this->order_data = $order_data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     * @return OrderModel
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return OrderModel
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     * @return OrderModel
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return OrderModel
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return OrderModel
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     * @return OrderModel
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return OrderModel
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }



}