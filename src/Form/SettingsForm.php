<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsForm  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['options_array'] as $key => $option) {
            $builder->add($key, TextType::class, [
                'label' => $option['label'],
                'data' => $option['value'],
                'required' => true
            ]);
        }

        $builder
            ->add('submit', SubmitType::class,[
                'label' => 'Сохранить'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'options_array' => []
            ]
        );
    }
}