<?php

namespace ck\RecipesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipesCommentType extends AbstractType
{
    private $user;
    private $recipe;

    public function __construct($user, $recipe)
    {
        $this->user = $user;
        $this->recipe = $recipe;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', 'entity', array(
                'class' => 'ckUsersBundle:User',
                'attr' => array(
                    'class' => 'display-none'
                ),
                'data' => ($this->user != null) ? $this->user : null
            ))
            ->add('recipe', 'entity', array(
                'class' => 'ckRecipesBundle:Recipe',
                'attr' => array(
                    'class' => 'display-none'
                ),
                'data' => ($this->recipe != null) ? $this->recipe : null
            ))
            ->add('message', 'textarea', array(
                'attr' => array(
                    'placeholder' => 'recipes.comments.form.create'
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
            'data_class' => 'ck\RecipesBundle\Entity\RecipesComment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'comment';
    }
}
