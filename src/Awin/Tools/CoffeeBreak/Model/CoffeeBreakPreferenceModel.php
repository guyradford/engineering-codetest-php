<?php


namespace Awin\Tools\CoffeeBreak\Model;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Repository\CoffeeBreakPreferenceRepository;

class CoffeeBreakPreferenceModel
{
    /**
     * @var CoffeeBreakPreferenceRepository
     */
    private CoffeeBreakPreferenceRepository $coffeeBreakPreferenceRepository;


    /**
     * CoffeeBreakPreferenceModel constructor.
     * @param CoffeeBreakPreferenceRepository $coffeeBreakPreferenceRepository
     */
    public function __construct(CoffeeBreakPreferenceRepository $coffeeBreakPreferenceRepository)
    {
        $this->coffeeBreakPreferenceRepository = $coffeeBreakPreferenceRepository;
    }

    /**
     * @return array
     */
    public function getPreferencesForToday() :array
    {
        return $this->coffeeBreakPreferenceRepository->getPreferencesForToday();
    }

    /**
     * @param StaffMember $staffMember
     * @param \DateTime $dateTime
     * @return CoffeeBreakPreference
     */
    public function getPreferencesFor(StaffMember $staffMember, \DateTime $dateTime) : CoffeeBreakPreference
    {
        return $this->coffeeBreakPreferenceRepository->getPreferencesFor($staffMember->getId(), $dateTime);
    }
}