<?php
namespace Awin\Tools\CoffeeBreak\Entity;

/**
 * @ORM\Table("coffee_break_preference")
 * @ORM\Entity(repositoryClass="Awin\Tools\CoffeeBreak\Repository\CoffeeBreakPreferenceRepository")
 */
class CoffeeBreakPreference
{

    const TYPES = ["food", "drink"];
    const DRINK_TYPES = ["coffee", "tea"];
    const FOOD_TYPES = ["sandwich", "crisps", "toast"];

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="type", length=255)
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(name="sub_type", length=255);
     * @var string
     */
    private $subType;

    /**
     * @ORM\ManyToOne(targetEntity="Awin\Tools\CoffeeBreak\Entity\StaffMember", inversedBy="preferences")
     * @ORM\JoinColumn(name="requested_by", referencedColumnName="id")
     * @var StaffMember
     */
    private $requestedBy;

    /**
     * @ORM\Column(name="requested_date", type="datetime")
     * @var \DateTime
     */
    private $requestedDate;

    /**
     * @ORM\Column(name="details", type="json")
     * @var array
     */
    private $details = [];

    public function __construct($type, $subType, StaffMember $requestedBy, array $details = [])
    {
        if (!in_array($type, self::TYPES)) {
            throw new \InvalidArgumentException;
        }

        if ($type == "food") {
            if (!in_array($subType, self::FOOD_TYPES)) {
                throw new \InvalidArgumentException;
            }
        } else {
            if (!in_array($subType, self::DRINK_TYPES)) {
                throw new \InvalidArgumentException;
            }
        }

//        $this->type = $type;
        $this->setType($type);
        $this->setSubType($subType);
        $this->setRequestedBy($requestedBy);

//        $this->requestedBy = $requestedBy;
        $this->setDetails($details);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getSubType()
    {
        return $this->subType;
    }

    /**
     * @param string $subType
     */
    public function setSubType($subType)
    {
        $this->subType = $subType;
    }

    /**
     * @return StaffMember
     */
    public function getRequestedBy()
    {
        return $this->requestedBy;
    }

    /**
     * @param StaffMember $requestedBy
     */
    public function setRequestedBy(StaffMember $requestedBy)
    {
        $this->requestedBy = $requestedBy;
    }

    /**
     * @return \DateTime
     */
    public function getRequestedDate()
    {
        return $this->requestedDate;
    }

    /**
     * @param \DateTime $requestedDate
     */
    public function setRequestedDate($requestedDate)
    {
        $this->requestedDate = $requestedDate;
    }



    public function setDetails(array $details)
    {
        if ($this->type == "drink") {
            $this->details["number_of_sugars"] = isset($details["number_of_sugars"]) ?? 0;
            $this->details["milk"] = isset($details["milk"]) ?? false;
        } else {
            $this->details["flavour"] = isset($details["flavour"]) ?? "don't mind";
        }
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function getAsXmlElement()
    {
        $xml = "<preference type='".$this->getType()."' subtype='".$this->getSubType()."'>";
        $xml .= "<requestedBy>".$this->getRequestedBy()->getName()."</requestedBy>";
        $xml .= "<details>".$this->getDetails()."</details>";
        $xml .= "</preference>";
        return $xml;
    }

    public function getAsArray()
    {
        return [
            "type" => $this->getType(),
            "subType" => $this->getSubType(),
            "requestedBy" => [
                "name" => $this->getRequestedBy()->getName()
            ],
            "details" => $this->getDetails()
        ];
    }

    public function getAsListElement()
    {
        $detailsString = implode(
            ",",
            array_map(
                function ($detailKey, $detailValue) {
                    return "$detailKey : $detailValue";
                },
                array_keys($this->getDetails()),
                array_values($this->getDetails())
            )
        );
        return "<li>".$this->getRequestedBy()->getName()." would like a ".$this->getSubtype()." ($detailsString)</li>";
    }
}
