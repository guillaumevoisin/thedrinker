<?php

namespace ck\RecipesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use ck\RecipesBundle\Form\DataTransformer\IngredientsCategoriesToStringTransformer;

class IngredientType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['em'];

        $builder
            ->add('name', 'text', array(
                'label' => 'ingredients.form.name'
            ))
            ->add('description', 'textarea', array(
                'label'    => 'ingredients.form.description',
                'required' => false
            ))
            ->add('volume', 'choice', array(
                'label' => 'ingredients.form.volume',
                'expanded' => true,
                'choices'  => array(
                    '20'  => '20 cl',
                    '50'  => '50 cl',
                    '70'  => '70 cl',
                    '100' => '100 cl'
                )
            ))
            ->add('alcoholVolume', 'text', array(
                'label'    => 'ingredients.form.alcoholVolume',
                'required' => false
            ))
            ->add('age', 'text', array(
                'label' => 'ingredients.form.age'
            ))
        ;

        $transformer = new IngredientsCategoriesToStringTransformer($entityManager);
        $builder->add(
            $builder->create('categories', 'hidden', array(
                'required' => false,
                'attr' => array(
                    'class'               => 'ajax-select',
                    'style'               => 'width:100%',
                    'data-multiple'       => true,
                    'data-pholder'        => 'users.searchfor',
                    'data-ajax-route'     => 'ingredients_categories_aucomplete',
                    'data-ajax-route-get' => 'ingredients_categories_get'
                ),
                'label' => 'ingredients.form.categories'
            ))->addViewTransformer($transformer)
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ck\RecipesBundle\Entity\Ingredient'
        ));

        $resolver->setRequired(array(
            'em'
        ));

        $resolver->setAllowedTypes(array(
            'em' => 'Doctrine\Common\Persistence\ObjectManager',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ingredient';
    }
}
