<?php


namespace App\Form;


use App\Entity\Category;
use App\Model\FormModel\CategoryModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $required = $options['image_required'];

        $builder
            ->add('image', FileType::class, [
                'required' => $required,
                'label' => 'Изображение'
            ])
            ->add('category', EntityType::class, [
                'label' => 'Категория',
                'class' => Category::class,
                'required'   => false,
                'empty_data' => null,
                'placeholder' => 'Пустая категория',
                'choice_label' => function (Category $category) {
                    return $category->getCategoryTranslations()->first()->getTitle();
                }
            ])
            ->add('titleRU', TextType::class, [
                'required' => true,
                'label' => 'Тайтл'
            ])
            ->add('descriptionRU', TextareaType::class, [
                'required' => false,
                'label' => 'Описание',
                'attr' => [
                    'class' => 'enable-ckeditor'
                ]
            ])
            ->add('seoTitleRU', TextType::class, [
                'required' => true,
                'label' => 'Сео тайтл'
            ])
            ->add('seoDescriptionRU', TextType::class, [
                'required' => true,
                'label' => 'Сео описание'
            ])
            ->add('titleEN', TextType::class, [
                'required' => true,
                'label' => 'Тайтл'
            ])
            ->add('descriptionEN', TextareaType::class, [
                'required' => false,
                'label' => 'Описание',
                'attr' => [
                    'class' => 'enable-ckeditor'
                ]
            ])
            ->add('seoTitleEN', TextType::class, [
                'required' => true,
                'label' => 'Сео тайтл'
            ])
            ->add('seoDescriptionEN', TextType::class, [
                'required' => true,
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
                'data_class' => CategoryModel::class,
                'image_required' => false
            ]
        );
    }
}