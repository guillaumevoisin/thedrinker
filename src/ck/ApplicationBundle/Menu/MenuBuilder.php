<?php

namespace ck\ApplicationBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(Request $request, $securityContext, $serviceContainer)
    {
        $menu = $this->factory->createItem('root');
        $menu->setCurrentUri($serviceContainer->get('request')->getRequestUri());

        $menu->addChild('Dashboard', array('label' => $serviceContainer->get('translator')->trans('dashboard.title'), 'route' => 'dashboard', 'attributes' => array('data-icon' => 'home-icon')));
        $menu['Dashboard']->addChild('Ingredients1', array('label' => $serviceContainer->get('translator')->trans('recipes.title'), 'route' => 'dashboard', 'attributes' => array('data-icon' => 'home-icon')));
        $menu['Dashboard']->addChild('Ingredients2', array('label' => $serviceContainer->get('translator')->trans('recipes.title'), 'route' => 'recipe', 'attributes' => array('data-icon' => 'home-icon')));
        $menu['Dashboard']->addChild('Ingredients3', array('label' => $serviceContainer->get('translator')->trans('recipes.title'), 'route' => 'ingredient', 'attributes' => array('data-icon' => 'home-icon')));

        $menu->addChild('Recipes', array('label' => $serviceContainer->get('translator')->trans('recipes.title'), 'route' => 'recipe', 'attributes' => array('data-icon' => 'home-icon')));

        switch($request->get('_route'))
        {
            case "medias_new":
                $menu['Medias']->setCurrent(true);
            break;
        }

        return $menu;
    }
}