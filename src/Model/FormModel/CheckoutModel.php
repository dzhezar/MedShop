<?php


namespace App\Model\FormModel;

use Symfony\Component\Validator\Constraints as Assert;

class CheckoutModel
{
    /**
     * @Assert\NotBlank()
     */
    private $full_name;
    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;
    /**
     * @Assert\NotBlank()
     */
    private $address;
    /**
     * @Assert\NotBlank()
     */
    private $city;
    /**
     * @Assert\NotBlank()
     */
    private $state;
    /**
     * @Assert\Length(
     *     min="5",
     *     max="5"
     * )
     * @Assert\Type(
     *     type="integer"
     * )
     * @Assert\NotBlank()
     */
    private $zip;
    /**
     * @Assert\NotBlank()
     */
    private $phone;
    /**
     * @Assert\NotBlank()
     */
    private $payment;
    /**
     * @Assert\NotBlank()
     */
    private $language;

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     * @return CheckoutModel
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
     * @return CheckoutModel
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return CheckoutModel
     */
    public function setAddress($address)
    {
        $this->address = $address;
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
     * @return CheckoutModel
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
     * @return CheckoutModel
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
     * @return CheckoutModel
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
     * @return CheckoutModel
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param mixed $payment
     * @return CheckoutModel
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     * @return CheckoutModel
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }
}