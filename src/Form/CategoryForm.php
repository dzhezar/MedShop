<?php


namespace App\Form;


use App\Entity\Category;
use App\Entity\Product;
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
            ->add('products', EntityType::class, [
                'label' => 'Товары',
                'class' => Product::class,
                'required'   => false,
                'multiple' => true,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->select('p', 'productTranslations')
                        ->leftJoin('p.productTranslations', 'productTranslations');
                },
                'choice_label' => function (Product $product) {
                    return $product->getProductTranslations()->first()->getTitle();
                }
            ])
            ->add('category', EntityType::class, [
                'label' => 'Категория',
                'class' => Category::class,
                'required'   => false,
                'empty_data' => null,
                'placeholder' => 'Пустая категория',
                'query_builder' => function (EntityRepository $er) use($options) {
                    return $er->createQueryBuilder('c')
                        ->select('c', 'categoryTranslations')
                        ->leftJoin('c.categoryTranslations', 'categoryTranslations')
                        ->where('c.id != :category_id')
                        ->setParameter('category_id', $options['category_id'])
                        ->andWhere('c.category is NULL');
                },
                 'choice_label' =>   function (Category $category) {
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
                'data_class' => CategoryModel::class,
                'image_required' => false,
                'category_id' => 0
            ]
        );
    }
}