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

namespace AppBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use FrequenceWeb\Bundle\ContactBundle\EventDispatcher\Event\MessageSubmitEvent;

/**
 * AppBundle\EventListener\ContactListener
 *
 * This listener listens for contact.submit events (triggered by FrequenceWebContactBundle). When it recieves one, it
 * takes the contact (an BostonMowersAppBundle:ContactEnquiry entity) from the event and persists it to the database via
 * Doctrine's ObjectManager.
 */
class ContactListener
{
    /**
     * Doctrine's ObjectManager
     *
     * @var ObjectManager
     */
    private $om;

    /**
     * Class constructor
     *
     * @param ObjectManager $om
     * @return ContactSubmitListener
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * The event handler
     *
     * @param  MessageSubmitEvent $event
     * @return void
     */
    public function onSubmit(MessageSubmitEvent $event)
    {
        // Save the enquiry message to the database
        $this->om->persist($event->getContact());
        $this->om->flush();
    }
}
