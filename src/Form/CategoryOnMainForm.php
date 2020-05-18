<?php


namespace App\Form;


use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryOnMainForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'label' => 'Категории',
                'class' => Category::class,
                'required'   => false,
                'empty_data' => null,
                'expanded' => false,
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c', 'categoryTranslations')
                        ->leftJoin('c.categoryTranslations', 'categoryTranslations');
                },
                'choice_label' => function (Category $category) {
                    try{
                        return $category->getCategoryTranslations()->first()->getTitle();
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