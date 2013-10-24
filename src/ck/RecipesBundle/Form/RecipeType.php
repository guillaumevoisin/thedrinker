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
            ->add('name')
            ->add('description')
            ->add('glassType', 'checkbox')
            ->add('preparationType', 'choice', array(
                'multiple' => false,
                'expanded' => true,
                'choices' => array(
                    'one' => 'One',
                    'two' => 'Two'
                )
            ))
            ->add('whereToDrink')
            ->add('creator')
            ->add('garnish')
            ->add('ingredients')
            ->add('categories')
            ->add('tags')
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
        return 'ck_recipesbundle_recipe';
    }
}
