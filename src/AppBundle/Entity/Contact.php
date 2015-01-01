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

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FrequenceWeb\Bundle\ContactBundle\Model\ConcreteContact;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * AppBundle\Entity\Contact
 *
 * @ORM\Entity
 * @ORM\Table(name="app_contact")
 */
class Contact extends ConcreteContact
{
    use TimestampableEntity;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(name="subject", type="string", length=255)
     * @var string
     */
    protected $subject;

    /**
     * @ORM\Column(name="body", type="string", length=255)
     * @var string
     */
    protected $body;
}
