<?php

namespace ck\RecipesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use ck\RecipesBundle\Form\DataTransformer\IngredientsToStringTransformer;

class RecipesIngredientsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    
    private $recipe, $em;

    public function __construct($recipe, $em)
    {
        $this->recipe = $recipe;
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $this->em;

        $builder
            ->add('recipe', 'entity', array(
                'class' => 'ckRecipesBundle:Recipe',
                'attr' => array(
                    'class' => 'display-none'
                ),
                'data' => ($this->recipe != null) ? $this->recipe : null
            ))
            ->add('ingredient', 'entity', array(
                'class' => 'ckRecipesBundle:Ingredient',
                'label' => 'recipes.form.ingredients.ingredient'
            ));
        /*$transformer = new IngredientsToStringTransformer($entityManager);
            $builder->add(
                $builder->create('ingredient', 'hidden', array(
                    'required' => false,
                    'attr' => array(
                        'class'               => 'ajax-select',
                        'style'               => 'width:100%',
                        'data-multiple'       => false,
                        'data-pholder'        => 'ingredients.form.searchfor',
                        'data-ajax-route'     => 'ingredients_aucomplete',
                        'data-ajax-route-get' => 'ingredients_get'
                    ),
                    'label' => 'recipes.form.ingredients.ingredient'
                ))->addViewTransformer($transformer)
            );*/

        $builder->add('proportion', 'text', array(
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
