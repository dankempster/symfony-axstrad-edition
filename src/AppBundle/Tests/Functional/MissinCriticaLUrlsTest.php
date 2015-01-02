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
 * AppBundle\Tests\Functional\MissinCriticalUrlsTest
 *
 * This test case asserts the existent of mission critical URLs. These URLs
 * should be hard coded in the test case, don't use the router. Otherwise you
 * won't know when they unexpectedly change.
 *
 * @group functional
 * @IgnoreAnnotation("dataProvider")
 * @IgnoreAnnotation("group")
 */
class MissinCriticalUrlsTest extends WebTestCase
{
    /**
     * URLs to assert return a successful response
     *
     * Recommend only testing for the app's missing critical links,
     */
    public function menuLinksToTestFor()
    {
        return array(
            ['/'],
            ['/contact'],
        );
    }


    // --- Tests


    /**
     * @dataProvider menuLinksToTestFor
     */
    public function testUrlIsScuccessful($url)
    {
        self::$client->request('GET', $url);
        $this->assertTrue(
            self::$client->getResponse()->isSuccessful()
        );
    }


    // --- Set Up / Tear Down


    protected static $client;

    public static function setUpBeforeClass()
    {
        self::$client = self::createClient();
    }
}
