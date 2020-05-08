<?php


namespace App\Form;


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
                    'paypal',
                    'card'
                ]
            ])
            ->add('language');
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