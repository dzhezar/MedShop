<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['options_array'] as $key => $option) {
            $type = TextType::class;
            $data = [
                'label' => $option['label'],
                'data' => $option['value'],
                'required' => true
            ];
            if (isset($option['text_editor'])) {
                $type = TextareaType::class;
                $data['required'] = false;
                $data['attr'] = [
                    'class' => 'enable-ckeditor'
                ];
            }
            $builder->add($key, $type, $data);
        }

        $builder
            ->add('submit', SubmitType::class, [
                    'label' => 'Сохранить'
                ]
            );
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