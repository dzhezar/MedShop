<?php


namespace App\Form;


use App\Entity\Category;
use App\Entity\Product;
use App\Model\FormModel\ProductModel;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $required = $options['image_required'];

        $builder
            ->add('image', FileType::class, [
                'required' => $required,
                'label' => 'Изображение'
            ])
            ->add('isVisible', CheckboxType::class, [
                'label' => 'Отображать',
                'required' => false
            ])
            ->add('isOnMain', CheckboxType::class, [
                'label' => 'Отображать на главной',
                'required' => false
            ])
            ->add('price', MoneyType::class, [
                'currency' => 'USD',
                'label' => 'Цена',
            ])
            ->add('relatedProducts', EntityType::class, [
                'label' => 'Похожие товары',
                'class' => Product::class,
                'required'   => false,
                'multiple' => true,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) use($options) {
                    return $er->createQueryBuilder('p')
                        ->select('p', 'productTranslations')
                        ->leftJoin('p.productTranslations', 'productTranslations')
                        ->where('p.id != :product_id')
                        ->setParameter('product_id', $options['product_id']);
                },
                'choice_label' => function (Product $product) {
                    return $product->getProductTranslations()->first()->getTitle();
                }
            ])
            ->add('category', EntityType::class, [
                'label' => 'Категория',
                'class' => Category::class,
                'required'   => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c', 'categoryTranslations')
                        ->leftJoin('c.categoryTranslations', 'categoryTranslations');
                },
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
            ->add('usageDescriptionRU', TextareaType::class, [
                'required' => false,
                'label' => 'Применение      ',
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
            ->add('usageDescriptionEN', TextareaType::class, [
                'required' => false,
                'label' => 'Применение',
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
            ->add('specifications', HiddenType::class)
            ->add('submit', SubmitType::class,[
                'label' => 'Сохранить'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ProductModel::class,
                'image_required' => false,
                'product_id' => 0
            ]
        );
    }
}