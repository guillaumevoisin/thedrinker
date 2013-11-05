<?php

namespace ck\RecipesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IngredientType extends AbstractType
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
            ->add('volume', 'choice', array(
                'expanded' => true,
                'choices'  => array(
                    '20'  => '20 cl',
                    '50'  => '50 cl',
                    '70'  => '70 cl',
                    '100' => '100 cl'
                )
            ))
            ->add('alcoholVolume')
            ->add('age')
            ->add('categories')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ck\RecipesBundle\Entity\Ingredient'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ck_recipesbundle_ingredient';
    }
}
