<?php

namespace ck\RecipesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'Recipe name'
                )
            ))
            ->add('description')
            ->add('file')
            ->add('glassType', 'choice', array(
                'expanded' => false,
                'choices' => array(
                    'tumbler'       => 'Tumbler',
                    'martini'       => 'Martini',
                    'old-fashioned' => 'Old fashioned',
                    'champagne'     => 'Champagne',
                    'Margarita'     => 'Margarita',
                    'highball'      => 'Highball',
                    'hurricane'     => 'Hurricane',
                    'wine'          => 'Wine'
                )
            ))
            ->add('preparationType', 'choice', array(
                'expanded' => true,
                'choices' => array(
                    'shaker'  => 'Shaker',
                    'blender' => 'Blender',
                    'stirred' => 'Stirred',
                )
            ))
            ->add('whereToDrink')
            ->add('creator')
            ->add('garnish')
            ->add('ingredients', 'collection', array(
                    'type'         => new RecipesIngredientsType(),
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'prototype'    => true,
                    'by_reference' => false
                ))
            ->add('categories')
            ->add('tags')
            ->add('difficulty', 'choice', array(
                'expanded' => true,
                'choices' => array(
                    'easy'     => 'easy',
                    'moderate' => 'moderate',
                    'hard'     => 'hard',
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ck\RecipesBundle\Entity\Recipe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'recipe';
    }
}
