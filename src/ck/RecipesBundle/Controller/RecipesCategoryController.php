<?php

namespace ck\RecipesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ck\RecipesBundle\Entity\RecipesCategory;
use ck\RecipesBundle\Form\RecipesCategoryType;

/**
 * RecipesCategory controller.
 *
 * @Route("/recipescategory")
 */
class RecipesCategoryController extends Controller
{

    /**
     * Lists all RecipesCategory entities.
     *
     * @Route("/", name="recipescategory")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ckRecipesBundle:RecipesCategory')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new RecipesCategory entity.
     *
     * @Route("/", name="recipescategory_create")
     * @Method("POST")
     * @Template("ckRecipesBundle:RecipesCategory:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new RecipesCategory();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('recipescategory_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a RecipesCategory entity.
    *
    * @param RecipesCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(RecipesCategory $entity)
    {
        $form = $this->createForm(new RecipesCategoryType(), $entity, array(
            'action' => $this->generateUrl('recipescategory_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new RecipesCategory entity.
     *
     * @Route("/new", name="recipescategory_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new RecipesCategory();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a RecipesCategory entity.
     *
     * @Route("/{id}", name="recipescategory_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:RecipesCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecipesCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing RecipesCategory entity.
     *
     * @Route("/{id}/edit", name="recipescategory_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:RecipesCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecipesCategory entity.');
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
    * Creates a form to edit a RecipesCategory entity.
    *
    * @param RecipesCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RecipesCategory $entity)
    {
        $form = $this->createForm(new RecipesCategoryType(), $entity, array(
            'action' => $this->generateUrl('recipescategory_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing RecipesCategory entity.
     *
     * @Route("/{id}", name="recipescategory_update")
     * @Method("PUT")
     * @Template("ckRecipesBundle:RecipesCategory:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:RecipesCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecipesCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('recipescategory_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a RecipesCategory entity.
     *
     * @Route("/{id}", name="recipescategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ckRecipesBundle:RecipesCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RecipesCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('recipescategory'));
    }

    /**
     * Creates a form to delete a RecipesCategory entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recipescategory_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Lists Recipes categories entities for autocomplete fields.
     *
     * @Route("/recipes_categories_autocomplete", name="recipes_categories_aucomplete", options={"expose"=true})
     */
    public function recipesCategoriesAutoCompleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->request->get('q');
        $page = $request->request->get('page');
        $nb_results = $request->request->get('page_limit');

        $recipesCategories = $em->getRepository('ckRecipesBundle:RecipesCategory')->findLikeName($term, $page, $nb_results);
        $total_results = $em->getRepository('ckRecipesBundle:RecipesCategory')->getNbResults($term);

        $recipesCategoriesList = array();

        if($recipesCategories)
        {
            foreach ($recipesCategories as $recipesCategory)
            {
                $recipesCategoriesList[] = array(
                    'id'    => $recipesCategory->getId(),
                    'title' => $recipesCategory->getName()
                );
            }
        }

        $response = new Response(json_encode(array('items' => $recipesCategoriesList, 'total' => $total_results)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Retrieve an Ingredient Category entity
     *
     * @Route("/{ids}", name="recipes_categories_get", options={"expose"=true})
     */
    public function getAction(Request $request, $ids)
    {
        $recipesCategories_ids = array($ids);

        if(preg_match("/,/", $ids))
            $recipesCategories_ids = explode(",", $ids);

        $em = $this->getDoctrine()->getManager();
        $recipesCategories = $em->getRepository('ckRecipesBundle:RecipesCategory')->findBy( array('id' => $recipesCategories_ids) );

        if(!$recipesCategories)
            throw new v3dException($this->get('translator')->trans( 'recipesCategories #' . $ids . ' can\'t be found' ));

        $recipesCategoryList = array();

        foreach ($recipesCategories as $recipesCategory)
        {
            $recipesCategoryList[] = array(
                'id'    => $recipesCategory->getId(),
                'title' => $recipesCategory->getName()
            );
        }

        return new Response(json_encode($recipesCategoryList));
    }
}
