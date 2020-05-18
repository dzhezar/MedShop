<?php


namespace App\Form;


use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductOnMainForm  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'label' => 'Товары',
                'class' => Product::class,
                'required'   => false,
                'empty_data' => null,
                'expanded' => false,
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->select('p', 'productTranslations')
                        ->leftJoin('p.productTranslations', 'productTranslations');
                },
                'choice_label' => function (Product $product) {
                    try{
                        return $product->getProductTranslations()->first()->getTitle();
                    } catch (\Exception $exception) {
                        return null;
                    }
                }
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Сохранить'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
            ]
        );
    }
}