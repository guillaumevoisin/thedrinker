<?php

namespace ck\RecipesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use ck\RecipesBundle\Form\DataTransformer\RecipesCategoriesToStringTransformer;
use ck\RecipesBundle\Form\DataTransformer\RecipesTagsToStringTransformer;

class RecipeType extends AbstractType
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
                'attr' => array(
                    'placeholder' => 'recipes.form.name'
                )
            ))
            ->add('description', 'textarea', array(
                'label'    => 'recipes.form.description',
                'required' => false
            ))
            ->add('file', 'file', array(
                'label'    => 'recipes.form.file',
                'required' => false
            ))
            ->add('glassType', 'choice', array(
                'expanded' => false,
                'label'    => 'recipes.form.glassType',
                'required' => false,
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
                'expanded'    => true,
                'label'       => 'recipes.form.preparationType',
                'required'    => false,
                'empty_value' => false,
                'choices' => array(
                    'shaker'  => 'Shaker',
                    'blender' => 'Blender',
                    'stirred' => 'Stirred',
                )
            ))
            ->add('whereToDrink', 'text', array(
                'label'    => 'recipes.form.whereToDrink',
                'required' => false
            ))
            ->add('creator', 'text', array(
                'label'    => 'recipes.form.creator',
                'required' => false
            ))
            ->add('garnish', 'text', array(
                'label'    => 'recipes.form.garnish',
                'required' => false
            ))
            ->add('ingredients', 'collection', array(
                    'label' => 'recipes.form.ingredients',
                    'type'         => new RecipesIngredientsType(),
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'prototype'    => true,
                    'by_reference' => false
                ))
            ->add('difficulty', 'choice', array(
                'expanded'    => true,
                'required'    => false,
                'empty_value' => false,
                'label'       => 'recipes.form.difficulty',
                'choices' => array(
                    'easy'     => 'easy',
                    'moderate' => 'moderate',
                    'hard'     => 'hard',
                )
            ));

            $transformer = new RecipesCategoriesToStringTransformer($entityManager);
            $builder->add(
                $builder->create('categories', 'hidden', array(
                    'required' => false,
                    'attr' => array(
                        'class'               => 'ajax-select',
                        'style'               => 'width:100%',
                        'data-multiple'       => true,
                        'data-pholder'        => 'users.searchfor',
                        'data-ajax-route'     => 'recipes_categories_aucomplete',
                        'data-ajax-route-get' => 'recipes_categories_get'
                    ),
                    'label' => 'recipes.form.categories'
                ))->addViewTransformer($transformer)
            );

            $transformer = new RecipesTagsToStringTransformer($entityManager);
            $builder->add(
                $builder->create('tags', 'hidden', array(
                    'required' => false,
                    'attr' => array(
                        'class'               => 'ajax-select',
                        'style'               => 'width:100%',
                        'data-multiple'       => true,
                        'data-pholder'        => 'users.searchfor',
                        'data-ajax-route'     => 'recipes_tags_aucomplete',
                        'data-ajax-route-get' => 'recipes_tags_get',
                        'data-tags'           => true
                    ),
                    'label' => 'recipes.form.tags'
                ))->addViewTransformer($transformer)
            );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ck\RecipesBundle\Entity\Recipe'
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
        return 'recipe';
    }
}
