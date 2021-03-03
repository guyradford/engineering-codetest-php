<?php
namespace Awin\Tools\CoffeeBreak\Tests\Services\Notifier;

use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Services\Notifier\EmailNotifier;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class EmailNotifierTest extends TestCase
{
    public function testStatusOfNotificationIsTrue()
    {
        $staff = new StaffMember();
        $staff->setSlackIdentifier("ABC123");
        $staff->setEmail("test@example.com");
        $preference = new CoffeeBreakPreference("drink", "coffee", $staff);

        $notificationService = new EmailNotifier();
        $status = $notificationService->notifyStaffMember($staff, $preference);

        $this->assertTrue($status);
    }

    public function testThrowsExceptionWhenCannotNotify()
    {
        $staff = new StaffMember();
        $preference = new CoffeeBreakPreference("drink", "tea", $staff);
        $notificationService = new EmailNotifier();

        $this->expectException(RuntimeException::class);
        $status = $notificationService->notifyStaffMember($staff, $preference);
    }
}
