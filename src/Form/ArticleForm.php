<?php


namespace App\Form;


use App\Entity\Category;
use App\Entity\Product;
use App\Model\FormModel\ArticleModel;
use App\Model\FormModel\CategoryModel;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $required = $options['image_required'];

        $builder
            ->add('image', FileType::class, [
                'required' => $required,
                'label' => 'Изображение'
            ])
            ->add('titleRU', TextType::class, [
                'required' => true,
                'label' => 'Тайтл'
            ])
            ->add('shortDescriptionRU', TextareaType::class, [
                'required' => true,
                'label' => 'Короткое описание'
            ])
            ->add('descriptionRU', TextareaType::class, [
                'required' => false,
                'label' => 'Описание',
                'attr' => [
                    'class' => 'enable-ckeditor'
                ]
            ])
            ->add('seoTitleRU', TextType::class, [
                'required' => false,
                'label' => 'Сео тайтл'
            ])
            ->add('seoDescriptionRU', TextType::class, [
                'required' => false,
                'label' => 'Сео описание'
            ])
            ->add('titleEN', TextType::class, [
                'required' => true,
                'label' => 'Тайтл'
            ])
            ->add('shortDescriptionEN', TextareaType::class, [
                'required' => true,
                'label' => 'Короткое описание'
            ])
            ->add('descriptionEN', TextareaType::class, [
                'required' => false,
                'label' => 'Описание',
                'attr' => [
                    'class' => 'enable-ckeditor'
                ]
            ])
            ->add('seoTitleEN', TextType::class, [
                'required' => false,
                'label' => 'Сео тайтл'
            ])
            ->add('seoDescriptionEN', TextType::class, [
                'required' => false,
                'label' => 'Сео описание'
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Сохранить'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ArticleModel::class,
                'image_required' => false,
            ]
        );
    }
}