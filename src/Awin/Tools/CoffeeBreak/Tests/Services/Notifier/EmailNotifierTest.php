<?php

use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use PHPUnit\Framework\TestCase;

class EmailNotifierTest extends TestCase
{
    public function testStatusOfNotificationIsTrue()
    {
        $staff = new StaffMember();
        $staff->setSlackIdentifier("ABC123");
        $staff->setEmail("test@example.com");
        $preference = new CoffeeBreakPreference("drink", "coffee", $staff);

        $notificationService = new \Awin\Tools\CoffeeBreak\Services\Notifier\EmailNotifier();
        $status = $notificationService->notifyStaffMember($staff, $preference);

        $this->assertTrue($status);
    }

    public function testThrowsExceptionWhenCannotNotify()
    {
        $staff = new StaffMember();
        $preference = new CoffeeBreakPreference("drink", "tea", $staff);
        $notificationService = new \Awin\Tools\CoffeeBreak\Services\Notifier\EmailNotifier();

        $this->expectException(\RuntimeException::class);
        $status = $notificationService->notifyStaffMember($staff, $preference);
    }
}
