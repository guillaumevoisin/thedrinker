<?php

namespace ck\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UsersController extends Controller
{
    /**
     * @Route("/admin/users", name="users_admin")
     * @Template()
     */
    public function adminUsersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('ckUsersBundle:User')->findAll();

        return array(
            'users' => $users,
        );
    }
}
