<?php

namespace ck\RecipesBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RecipeRestController extends Controller
{
	public function getRecipesAction()
	{
		$em = $this->getDoctrine()->getManager();
		$recipes = $em->getRepository('ckRecipesBundle:Recipe')->findAll();

		if(!($recipes))
		{
			throw $this->createNotFoundException();
		}

		$return = array('recipes' => $recipes);

		return $return;
	}

	public function putRecipeAction($recipe_id)
	{
		
	}

	public function getRecipeAction($recipe_slug)
	{
		$em = $this->getDoctrine()->getManager();
		$recipe = $em->getRepository('ckRecipesBundle:Recipe')->findOneBySlug($recipe_slug);

		if(!($recipe))
		{
			throw $this->createNotFoundException();
		}

		$return = array('recipe' => $recipe);

		return $return;
	}
}