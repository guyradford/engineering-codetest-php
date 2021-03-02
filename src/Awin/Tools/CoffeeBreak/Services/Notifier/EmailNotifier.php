<?php
namespace Awin\Tools\CoffeeBreak\Services\Notifier;

use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Services\Notifier\NotifierInterface;
use PHPUnit\Framework\MockObject\RuntimeException;

class EmailNotifier implements NotifierInterface
{
    /**
     * @param StaffMember $staffMember
     * @param CoffeeBreakPreference $preference
     * @return bool
     */
    public function notifyStaffMember(StaffMember $staffMember, CoffeeBreakPreference $preference) :bool
    {
        /**
         * Imagine that this function:
         * Sends an email to the user  that their coffee break refreshment today will be $preference
         * returns true or false status of notification sent
         */

        if (empty($staffMember->getEmail())) {
            throw new RuntimeException("Cannot send notification - no email address.");
        }

        return true;
    }
}