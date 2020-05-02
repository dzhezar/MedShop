<?php


namespace App\Form;


use App\Model\FormModel\MainPageSliderModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainPageSliderForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $required = $options['image_required'];

        $builder
            ->add('image', FileType::class, [
                'required' => $required,
                'label' => 'Изображение'
            ])
            ->add('textRU', TextareaType::class, [
                'required' => false,
                'label' => 'Текст',
                'attr' => [
                    'class' => 'enable-ckeditor'
                ]
            ])
            ->add('textEN', TextareaType::class, [
                'required' => false,
                'label' => 'Текст',
                'attr' => [
                    'class' => 'enable-ckeditor'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Сохранить'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => MainPageSliderModel::class,
                'image_required' => false,
            ]
        );
    }
}