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

namespace AppBundle\Tests\Functional;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * AppBundle\Tests\Functional\ContactTest
 *
 * Tests the site has a contact page that accepts user submitted enquiries.
 *
 * @group functional
 * @group plugandplay
 */
class ContactTest extends WebTestCase
{
    public function testContact()
    {
        // Initalise the DB schema
        $this->loadFixtures(array());

        $client = self::createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertTrue(
            $client->getResponse()->isSuccessful(),
            'Failed to request the contact page. Err '.
            $client->getResponse()->getStatusCode()
        );

        // Find the Form
        $form = $crawler->selectButton('contact_message_submit')->form();

        // Test the form doesn't submit if it's not complete
        $form->setValues(array(
            'contact[name]'    => 'John Doe',
            'contact[subject]' => 'I have a message for you.',
            'contact[body]'    => 'This is my message body.',
        ));
        $client->submit($form);
        $collector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertCount(0, $collector->getMessages());

        // Assert user remains on same page when form errors
        $this->assertNotInstanceOf(
            'Symfony\\Component\\HttpFoundation\\RedirectResponse',
            $client->getResponse()
        );
        $this->assertStringEndsWith(
            '/contact',
            $client->getRequest()->getUri()
        );

        // Assert for submits when filled in correctly
        $form = $crawler->selectButton('contact_message_submit')->form();
        $form->setValues(array(
            'contact[name]'    => 'John Doe',
            'contact[email]'   => 'john.doe@gmail.com',
            'contact[subject]' => 'I have a message for you.',
            'contact[body]'    => 'This is my message body.',
        ));
        $client->submit($form);

        // Assert an email was sent
        $collector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertCount(1, $collector->getMessages());

        // Assert enquiry was saved to DB
        $this->assertNotNull(
            $client
                ->getKernel()
                ->getContainer()
                ->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle\Entity\Contact')
                ->findOneBy(array(
                    'name' => 'John Doe'
                ))
        );

        // Assert user is redirected back to contact us page
        $this->assertInstanceOf(
            'Symfony\\Component\\HttpFoundation\\RedirectResponse',
            $client->getResponse()
        );
        $this->assertStringEndsWith(
            '/contact',
            $client->getResponse()->getTargetUrl()
        );
        $client->followRedirect();

        // Assert a success flash message is shown to the user
    }
}
