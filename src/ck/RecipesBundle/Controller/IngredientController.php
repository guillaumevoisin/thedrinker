<?php

namespace ck\RecipesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ck\RecipesBundle\Entity\Ingredient;
use ck\RecipesBundle\Form\IngredientType;

/**
 * Ingredient controller.
 *
 * @Route("/")
 */
class IngredientController extends Controller
{

    /**
     * Lists all Ingredient entities.
     *
     * @Route("/ingredients", name="ingredient")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ckRecipesBundle:Ingredient')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Ingredient entity.
     *
     * @Route("/admin/ingredients", name="ingredient_create")
     * @Method("POST")
     * @Template("ckRecipesBundle:Ingredient:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Ingredient();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ingredient_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Ingredient entity.
    *
    * @param Ingredient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Ingredient $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new IngredientType(), $entity, array(
            'action' => $this->generateUrl('ingredient_create'),
            'method' => 'POST',
            'em'     => $em
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create',
            'attr' => array(
                'class' => 'buttonS bGreen'
            )
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Ingredient entity.
     *
     * @Route("/admin/ingredients/new", name="ingredient_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {        
        $entity = new Ingredient();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Ingredient entity.
     *
     * @Route("/ingredients/{id}", name="ingredient_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:Ingredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingredient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ingredient entity.
     *
     * @Route("/admin/ingredients/{id}/edit", name="ingredient_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:Ingredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingredient entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Ingredient entity.
    *
    * @param Ingredient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ingredient $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new IngredientType(), $entity, array(
            'action' => $this->generateUrl('ingredient_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'em'     => $em
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Update',
            'attr' => array(
                'class' => 'buttonS bGreen'
            )
        ));

        return $form;
    }
    
    /**
     * Edits an existing Ingredient entity.
     *
     * @Route("/admin/ingredients/{id}", name="ingredient_update")
     * @Method("PUT")
     * @Template("ckRecipesBundle:Ingredient:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:Ingredient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingredient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ingredient_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Ingredient entity.
     *
     * @Route("/ingredients/{id}", name="ingredient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ckRecipesBundle:Ingredient')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ingredient entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ingredient'));
    }

    /**
     * Creates a form to delete a Ingredient entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ingredient_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => 'buttonS bRed'
                )
            ))
            ->getForm()
        ;
    }
}
