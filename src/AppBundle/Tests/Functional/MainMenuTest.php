<?php
/**
 * This file is part of the Symony Axstrad Edition Project.
 *
 * (c) Dan Kempster <dev@dankempster.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2014-2015 Dan Kempster
 * @author Dan Kempster <dev@dankempster.co.uk>
 */

namespace AppBundle\Tests\Functional;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * AppBundle\Tests\Functional\MainMenuTest
 *
 * This testcase asserts the app has a main menu it the header and that it
 * contains certain links.
 *
 * @group functional
 */
class MainMenuTest extends WebTestCase
{
    /**
     * @var string Selector to find the app's main menu
     */
    public static $mainMenuSelector = 'header nav';

    /**
     * Links to assert exist in the menu.
     *
     * Recommend only testing for the app's missing critical links, to reduce
     * the chance of having to change the test if the main menu changes for
     * legitmate reasons.
     *
     * The links are defined using their Symfony route.
     * It's done this way for two reasons:
     *  1. I didn't want to tie these tests the specific URLs
     *  2. I'd have preferred to use the Router directly in this method, But
     *     this method is invoked before setUpBeforeClass. So the router is not
     *     initalised.
     */
    public function menuLinksToTestFor()
    {
        return array(
            // [ 'route-name', ['param' => 'value'] ],
            ["app_home", [] ],
            ['axstrad_page', array('slug' => 'about-us') ],
            ['fw_contact_index', [] ],
        );
    }


    // ---


    protected static $crawler;
    protected static $router;
    protected static $nav;

    public static function setUpBeforeClass()
    {
        self::$crawler = self::createClient()->request('GET', '/');
        self::$router = self::$kernel->getContainer()->get('router');
    }

    public function testMenuExists()
    {
        // Initalise the DB schema
        $this->loadFixtures(array(
            'AppBundle\Tests\DataFixtures\ORM\LoadPageData'
        ));

        // Find the main nav
        self::$nav = self::$crawler->filter(self::$mainMenuSelector);
        $this->assertEquals(
            1,
            self::$nav->count(),
            'Doesn\'t look like theres a main menu.'
        );
    }

    /**
     * @dataProvider menuLinksToTestFor
     * @depends testMenuExists
     */
    public function testNavHasLink($route, array $parameters = array())
    {
        $url = self::$router->generate($route, $parameters);

        $this->assertEquals(
            1,
            self::$nav->filter(sprintf('a[href="%s"]', $url))->count()
        );
    }
}
