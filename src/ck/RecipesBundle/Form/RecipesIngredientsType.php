<?php

namespace ck\RecipesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipesIngredientsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipe', 'entity', array(
                'class' => 'ckRecipesBundle:Recipe',
                'attr' => array(
                    'class' => 'display-none'
                )
            ))
            ->add('ingredient', 'entity', array(
                'class' => 'ckRecipesBundle:Ingredient',
                'label' => 'recipes.form.ingredients.ingredient'
            ))
            ->add('proportion', 'text', array(
                'label' => 'recipes.form.ingredients.proportion'
            ))
            ->add('baseSpirit', 'checkbox', array(
                'required' => false,
                'label' => 'recipes.form.ingredients.base_spirit'
            ))
            ->add('unit', 'choice', array(
                'label' => 'recipes.form.ingredients.unit',
                'choices' => array(
                    'oz'   => 'oz',
                    'cl'   => 'cl',
                    'g'    => 'g',
                    'dash' => 'dash',
                    'cup'  => 'cup',
                    'tbsp' => 'tbsp',
                    'tsp'  => 'tsp'
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
            'data_class' => 'ck\RecipesBundle\Entity\RecipesIngredients'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'recipes_ingredients';
    }
}
