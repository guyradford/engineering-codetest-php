<?php
namespace Awin\Tools\CoffeeBreak\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("staff_member")
 * @ORM\Entity(repositoryClass="Awin\Tools\CoffeeBreak\Repository\StaffMemberRepository")
 */
class StaffMember
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    /**
     * @ORM\Column(name="name", length="255")
     * @var string
     */
    private $name;
    /**
     * @ORM\Column(name="email", length="255")
     * @var string
     */
    private $email;
    /**
     * @ORM\Column(name="hip_chat_identifier", length="255")
     * @var string
     */
    private $SlackIdentifier;

    /**
     * @ORM\OneToMany(targetEntity="Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference", mappedBy("requestedBy")
     * @var ArrayCollection
     */
    private $preferences;

    public function __construct()
    {
        $this->preferences = new ArrayCollection();
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    /**
     * @return string
     */
    public function getSlackIdentifier()
    {
        return $this->SlackIdentifier;
    }
    /**
     * @param string $SlackIdentifier
     */
    public function setSlackIdentifier(string $SlackIdentifier)
    {
        $this->SlackIdentifier = $SlackIdentifier;
    }
    /**
     * @return ArrayCollection
     */
    public function getPreferences()
    {
        return $this->preferences;
    }
    /**
     * @param ArrayCollection $preferences
     */
    public function setPreferences($preferences)
    {
        $this->preferences = $preferences;
    }
}
