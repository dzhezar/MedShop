<?php


namespace App\Form;


use App\Entity\Language;
use App\Entity\Orders as Order;
use App\Model\FormModel\CheckoutModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckoutForm  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('full_name')
            ->add('email')
            ->add('address')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('phone')
            ->add('payment', ChoiceType::class, [
                'choices' => [
                    Order::PAY_TYPE_PAYPAL,
                    Order::PAY_TYPE_CARD
                ]
            ])
            ->add('language', ChoiceType::class, [
                'choices' => [
                    Language::LANGUAGES_ARRAY
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => CheckoutModel::class,
                'csrf_protection' => false,
                'allow_extra_fields' => true,
            ]
        );
    }
}