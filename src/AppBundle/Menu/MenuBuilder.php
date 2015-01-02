<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * AppBundle\Menu\MenuBuilder
 *
 * Application menu builder.
 *
 * All app specific menus should originate here.
 */
class MenuBuilder
{
    protected $factory = null;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Creates the apps main menu and returns it.
     *
     * @param Request $request
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu(Request $request)
    {
        $root = $this->factory->createItem('root');

        $root->addChild('home', array(
            'label' => 'Home',
            'route' => 'homepage',
        ));
        $root->addChild('about', array(
            'label' => 'About Us',
            'route' => 'axstrad_page',
            'routeParameters' => array(
                'slug' => 'about-us',
            ),
        ));
        $root->addChild('contact', array(
            'label' => 'Contact Us',
            'route' => 'fw_contact_index',
        ));

        return $root;
    }
}
