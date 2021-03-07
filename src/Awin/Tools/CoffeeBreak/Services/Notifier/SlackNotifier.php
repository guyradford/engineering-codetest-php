<?php
namespace Awin\Tools\CoffeeBreak\Services\Notifier;

use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Services\Notifier\NotifierInterface;
use PHPUnit\Framework\MockObject\RuntimeException;

class SlackNotifier implements NotifierInterface
{
    /**
     * @var mixed
     */
    private $config;

    /**
     * EmailNotifier constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param string $toAddress
     * @param string $message
     * @return bool
     */
    public function notifyStaffMember(string $toAddress, string $message) : bool
    {
        /**
         * Imagine that this function:
         * Sends a notification to the user on Slack that their coffee break refreshment today will be $preference
         * returns true of false status of notification sent
         */

        return true;
    }
}