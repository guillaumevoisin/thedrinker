<?php

namespace ck\RecipesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use ck\RecipesBundle\Entity\Recipe;
use ck\RecipesBundle\Form\RecipeType;

/**
 * Recipe controller.
 *
 * @Route("/")
 */
class RecipeController extends Controller
{

    /**
     * Lists all Recipe entities.
     *
     * @Route("/recipes", name="recipe")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ckRecipesBundle:Recipe')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Recipe entity.
     *
     * @Route("/admin/recipes", name="recipe_create")
     * @Method("POST")
     * @Template("ckRecipesBundle:Recipe:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->createCreateForm($recipe);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();

            // ACL Creation
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($recipe);
            $acl = $aclProvider->createAcl($objectIdentity);

            // Get current user
            $securityContext = $this->get('security.context');
            $user = $securityContext->getToken()->getUser();

            $userSecurityIdentity = UserSecurityIdentity::fromAccount($user);
            $roleSecurityIdentity = new RoleSecurityIdentity('ROLE_SUPER_ADMIN');

            // Give access to owner
            $acl->insertObjectAce($userSecurityIdentity, MaskBuilder::MASK_OWNER);

            // Give access to super admin
            $acl->insertObjectAce($roleSecurityIdentity, MaskBuilder::MASK_MASTER);
            
            $aclProvider->updateAcl($acl);

            return $this->redirect($this->generateUrl('recipe_edit', array('id' => $recipe->getId())));
        }

        return array(
            'entity' => $recipe,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Recipe entity.
    *
    * @param Recipe $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Recipe $entity)
    {
        $form = $this->createForm(new RecipeType(), $entity, array(
            'action' => $this->generateUrl('recipe_create'),
            'method' => 'POST',
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
     * Displays a form to create a new Recipe entity.
     *
     * @Route("/admin/recipes/new", name="recipe_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Recipe();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Recipe entity.
     *
     * @Route("/recipes/{slug}", name="recipe_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $recipe = $em->getRepository('ckRecipesBundle:Recipe')->findOneBySlug($slug);

        if (!$recipe) {
            throw $this->createNotFoundException('Unable to find Recipe recipe.');
        }

        $deleteForm = $this->createDeleteForm($recipe->getId());

        return array(
            'recipe'      => $recipe,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Recipe entity.
     *
     * @Route("/admin/recipes/{id}/edit", name="recipe_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $recipe = $em->getRepository('ckRecipesBundle:Recipe')->find($id);

        $securityContext = $this->get('security.context');

        // Check user rights
        if (false === $securityContext->isGranted('EDIT', $recipe))
        {
            throw new AccessDeniedException();
        }

        if (!$recipe) {
            throw $this->createNotFoundException('Unable to find Recipe recipe.');
        }

        $editForm = $this->createEditForm($recipe);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'recipe'      => $recipe,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Recipe entity.
    *
    * @param Recipe $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Recipe $entity)
    {
        $form = $this->createForm(new RecipeType(), $entity, array(
            'action' => $this->generateUrl('recipe_update', array('id' => $entity->getId())),
            'method' => 'PUT',
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
     * Edits an existing Recipe entity.
     *
     * @Route("/admin/recipes/{id}", name="recipe_update")
     * @Method("PUT")
     * @Template("ckRecipesBundle:Recipe:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $recipe = $em->getRepository('ckRecipesBundle:Recipe')->find($id);

        $securityContext = $this->get('security.context');

        // Check user rights
        if (false === $securityContext->isGranted('EDIT', $recipe))
        {
            throw new AccessDeniedException();
        }

        if (!$recipe) {
            throw $this->createNotFoundException('Unable to find Recipe recipe.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($recipe);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->persist($recipe);
            $em->flush();

            return $this->redirect($this->generateUrl('recipe_show', array('id' => $id)));
        }

        return array(
            'recipe'      => $recipe,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Recipe entity.
     *
     * @Route("/admin/recipes/{id}", name="recipe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $recipe = $em->getRepository('ckRecipesBundle:Recipe')->find($id);

            $securityContext = $this->get('security.context');

            // Check user rights
            if (false === $securityContext->isGranted('DELETE', $recipe))
            {
                throw new AccessDeniedException();
            }

            if (!$recipe) {
                throw $this->createNotFoundException('Unable to find Recipe recipe.');
            }

            $em->remove($recipe);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('recipe'));
    }

    /**
     * Creates a form to delete a Recipe entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recipe_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
