<?php
/**
 * This file is part of the Symony Axstrad Edition Project.
 *
 * (c) Dan Kempster <dev@dankempster.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2014-2015 Dan Kempster <dev@dankempster.co.uk>
 */

namespace AppBundle\Tests\PlugAndPlay;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * AppBundle\Tests\PlugAndPlay\AxstradPageBundleTest
 *
 * Tests the installation of AxstradPageBundle.
 *
 * This testcse is not AxstradPageBundle specific, it just tests the site does
 * have a "general page" with
 *  - a heading
 *  - copy
 *  - meta data
 *
 * @group functional
 * @group plugandplay
 */
class AxstradPageBundleTest extends WebTestCase
{
    public function testPageBundleShowAboutUsPage()
    {
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\ORM\LoadPageData'
        ));

        $client = self::createClient();
        $crawler = $client->request('GET', '/about-us');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $heading = $crawler->filter('main article h1');
        $this->assertTrue(
            $heading->count() > 0,
            'Page deosn\'t have a heading'
        );

        $this->assertEquals(
            'About Us',
            $heading->text(),
            'Page heading has unexpected value'
        );

        $this->assertEquals(
            'A page about us.',
            $crawler->filter('p')->text(),
            'General page has no contemt'
        );

        $this->assertEquals(
            'About Us | Symfony Axstrad Edition',
            $crawler->filter('title')->text(),
            'Page doesn\'t have expected page title'
        );

        $this->assertEquals(
            'about, us',
            $crawler->filter('meta[name="keywords"]')->attr('content'),
            'Page doesn\'t have expected meta keywords'
        );

        $this->assertEquals(
            'Meta description about us.',
            $crawler->filter('meta[name="description"]')->attr('content'),
            'Page doesn\'t have expected meta description'
        );
    }
}
