<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'homepage'));
        $menu->addChild('Series', array('route' => 'series'));

        return $menu;
    }

    public function sidebarMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Guest');

        $menu['Guest']->addChild('Login', ['route' => 'fos_user_security_login']);
        $menu['Guest']->addChild('Register', ['route' => 'fos_user_register']);

        return $menu;
    }
}
