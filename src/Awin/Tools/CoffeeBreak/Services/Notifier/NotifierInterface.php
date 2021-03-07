<?php
namespace Awin\Tools\CoffeeBreak\Services\Notifier;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;

interface NotifierInterface
{


    /**
     * @param string $toAddress
     * @param string $message
     * @return bool
     */
    public function notifyStaffMember(string $toAddress, string $message) : bool;

}