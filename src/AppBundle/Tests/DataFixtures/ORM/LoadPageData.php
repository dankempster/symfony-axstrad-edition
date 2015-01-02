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

namespace AppBundle\Tests\DataFixtures\ORM;

use Axstrad\Bundle\PageBundle\Entity\Page;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Cmf\Bundle\SeoBundle\Model\SeoMetadata;

/**
 * AppBundle\DataFixtures\ORM\LoadPageData
 *
 * @author Dan Kempster <dev@dankempster.co.uk>
 * @license MIT
 * @package Axstrad/PageBundle
 * @subpackage Tests
 */
class LoadPageData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $aboutUs = new Page();
        $aboutUs->setHeading('About Us');
        $aboutUs->setCopy('<p>A page about us.</p>');
        $aboutUs->setSlug('about-us');
        $aboutUs->setActive(true);
        $manager->persist($aboutUs);

        $aboutUsSeo = new SeoMetadata();
        $aboutUsSeo->setMetaDescription('Meta description about us.');
        $aboutUsSeo->setMetaKeywords('about, us');
        $aboutUsSeo->setTitle('About Us');
        $manager->persist($aboutUsSeo);

        $aboutUs->setSeoMetadata($aboutUsSeo);

        $manager->flush();
    }
}
