<?php

namespace ck\RecipesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ck\RecipesBundle\Entity\RecipesTag;
use ck\RecipesBundle\Form\RecipesTagType;

/**
 * RecipesTag controller.
 *
 * @Route("/recipestag")
 */
class RecipesTagController extends Controller
{

    /**
     * Lists all RecipesTag entities.
     *
     * @Route("/", name="recipestag")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ckRecipesBundle:RecipesTag')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new RecipesTag entity.
     *
     * @Route("/", name="recipestag_create")
     * @Method("POST")
     * @Template("ckRecipesBundle:RecipesTag:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new RecipesTag();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('recipestag_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a RecipesTag entity.
    *
    * @param RecipesTag $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(RecipesTag $entity)
    {
        $form = $this->createForm(new RecipesTagType(), $entity, array(
            'action' => $this->generateUrl('recipestag_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new RecipesTag entity.
     *
     * @Route("/new", name="recipestag_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new RecipesTag();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a RecipesTag entity.
     *
     * @Route("/{id}", name="recipestag_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:RecipesTag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecipesTag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing RecipesTag entity.
     *
     * @Route("/{id}/edit", name="recipestag_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:RecipesTag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecipesTag entity.');
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
    * Creates a form to edit a RecipesTag entity.
    *
    * @param RecipesTag $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RecipesTag $entity)
    {
        $form = $this->createForm(new RecipesTagType(), $entity, array(
            'action' => $this->generateUrl('recipestag_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing RecipesTag entity.
     *
     * @Route("/{id}", name="recipestag_update")
     * @Method("PUT")
     * @Template("ckRecipesBundle:RecipesTag:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ckRecipesBundle:RecipesTag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecipesTag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('recipestag_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a RecipesTag entity.
     *
     * @Route("/{id}", name="recipestag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ckRecipesBundle:RecipesTag')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RecipesTag entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('recipestag'));
    }

    /**
     * Creates a form to delete a RecipesTag entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recipestag_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Lists Recipes tags entities for autocomplete fields.
     *
     * @Route("/recipes_tags_autocomplete", name="recipes_tags_aucomplete", options={"expose"=true})
     */
    public function recipesTagsAutoCompleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->request->get('q');
        $page = $request->request->get('page');
        $nb_results = $request->request->get('page_limit');

        $recipesTags = $em->getRepository('ckRecipesBundle:RecipesTag')->findLikeName($term, $page, $nb_results);
        $total_results = $em->getRepository('ckRecipesBundle:RecipesTag')->getNbResults($term);

        $recipesTagsList = array();

        if($recipesTags)
        {
            foreach ($recipesTags as $recipesTag)
            {
                $recipesTagsList[] = array(
                    'id'          => $recipesTag->getId(),
                    'title'       => $recipesTag->getName()
                );
            }
        }

        $response = new Response(json_encode(array('items' => $recipesTagsList, 'total' => $total_results)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Retrieve an Ingredient Tag entity
     *
     * @Route("/{ids}", name="recipes_tags_get", options={"expose"=true})
     */
    public function getAction(Request $request, $ids)
    {
        $recipesTags_ids = array($ids);

        if(preg_match("/,/", $ids))
            $recipesTags_ids = explode(",", $ids);

        $em = $this->getDoctrine()->getManager();
        $recipesTags = $em->getRepository('ckRecipesBundle:RecipesTag')->findBy( array('id' => $recipesTags_ids) );

        if(!$recipesTags)
            throw new v3dException($this->get('translator')->trans( 'recipesTags #' . $ids . ' can\'t be found' ));

        $recipesTagList = array();

        foreach ($recipesTags as $recipesTag)
        {
            $recipesTagList[] = array(
                'id'          => $recipesTag->getId(),
                'title'       => $recipesTag->getName()
            );
        }

        return new Response(json_encode($recipesTagList));
    }
}
