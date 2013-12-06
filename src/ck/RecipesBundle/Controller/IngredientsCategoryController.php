<?php

namespace ck\RecipesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ck\RecipesBundle\Entity\IngredientsCategory;
use ck\RecipesBundle\Form\IngredientsCategoryType;

/**
 * IngredientsCategory controller.
 *
 * @Route("/ingredientscategory")
 */
class IngredientsCategoryController extends Controller
{

    /**
     * Lists all IngredientsCategory entities.
     *
     * @Route("/", name="ingredientscategory")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ckRecipesBundle:IngredientsCategory')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new IngredientsCategory entity.
     *
     * @Route("/", name="ingredientscategory_create")
     * @Method("POST")
     * @Template("ckRecipesBundle:IngredientsCategory:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IngredientsCategory();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ingredientscategory_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a IngredientsCategory entity.
    *
    * @param IngredientsCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(IngredientsCategory $entity)
    {
        $form = $this->createForm(new IngredientsCategoryType(), $entity, array(
            'action' => $this->generateUrl('ingredientscategory_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IngredientsCategory entity.
     *
     * @Route("/new", name="ingredientscategory_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IngredientsCategory();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IngredientsCategory entity.
     *
     * @Route("/{id}", name="ingredientscategory_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:IngredientsCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IngredientsCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IngredientsCategory entity.
     *
     * @Route("/{id}/edit", name="ingredientscategory_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:IngredientsCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IngredientsCategory entity.');
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
    * Creates a form to edit a IngredientsCategory entity.
    *
    * @param IngredientsCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IngredientsCategory $entity)
    {
        $form = $this->createForm(new IngredientsCategoryType(), $entity, array(
            'action' => $this->generateUrl('ingredientscategory_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IngredientsCategory entity.
     *
     * @Route("/{id}", name="ingredientscategory_update")
     * @Method("PUT")
     * @Template("ckRecipesBundle:IngredientsCategory:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:IngredientsCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IngredientsCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ingredientscategory_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IngredientsCategory entity.
     *
     * @Route("/{id}", name="ingredientscategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ckRecipesBundle:IngredientsCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IngredientsCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ingredientscategory'));
    }

    /**
     * Creates a form to delete a IngredientsCategory entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ingredientscategory_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Lists Ingredients categories entities for autocomplete fields.
     *
     * @Route("/ingredients_categories_autocomplete", name="ingredients_categories_aucomplete", options={"expose"=true})
     */
    public function ingredientsCategoriesAutoCompleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->request->get('q');
        $page = $request->request->get('page');
        $nb_results = $request->request->get('page_limit');

        $ingredientsCategories = $em->getRepository('ckRecipesBundle:IngredientsCategory')->findLikeName($term, $page, $nb_results);
        $total_results = $em->getRepository('ckRecipesBundle:IngredientsCategory')->getNbResults($term);

        $ingredientsCategoriesList = array();

        if($ingredientsCategories)
        {
            foreach ($ingredientsCategories as $ingredientsCategory)
            {
                $ingredientsCategoriesList[] = array(
                    'id'          => $ingredientsCategory->getId(),
                    'title'       => $ingredientsCategory->getName()
                );
            }
        }

        $response = new Response(json_encode(array('items' => $ingredientsCategoriesList, 'total' => $total_results)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Retrieve an Ingredient Category entity
     *
     * @Route("/{ids}", name="ingredients_categories_get", options={"expose"=true})
     */
    public function getAction(Request $request, $ids)
    {
        $ingredientsCategories_ids = array($ids);

        if(preg_match("/,/", $ids))
            $ingredientsCategories_ids = explode(",", $ids);

        $em = $this->getDoctrine()->getManager();
        $ingredientsCategories = $em->getRepository('ckRecipesBundle:IngredientsCategory')->findBy( array('id' => $ingredientsCategories_ids) );

        if(!$ingredientsCategories)
            throw new v3dException($this->get('translator')->trans( 'ingredientsCategories #' . $ids . ' can\'t be found' ));

        $ingredientsCategoryList = array();

        foreach ($ingredientsCategories as $ingredientsCategory)
        {
            $ingredientsCategoryList[] = array(
                'id'          => $ingredientsCategory->getId(),
                'title'       => $ingredientsCategory->getName()
            );
        }

        return new Response(json_encode($ingredientsCategoryList));
    }
}
