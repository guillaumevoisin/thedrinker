<?php

namespace ck\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     * @Template()
     */
    public function indexAction()
    {
        $repositoryManager = $this->get('fos_elastica.manager.orm');
        $repository = $repositoryManager->getRepository('ckRecipesBundle:Recipe');

        $recipes = $repository->filterFind('Penicillin');

        return array(
            'recipes' => $recipes,
        );
    }

    /**
     * @Route("/admin", name="admin_dashboard")
     * @Template()
     */
    public function adminAction()
    {
        return array();
    }
}
