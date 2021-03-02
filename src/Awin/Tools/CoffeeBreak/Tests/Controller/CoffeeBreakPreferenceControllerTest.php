<?php

use Awin\Tools\CoffeeBreak\Controller\CoffeeBreakPreferenceController;
use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use PHPUnit\Framework\TestCase;

class CoffeeBreakPreferenceControllerTest extends TestCase
{
    public function testTodayActionWithNoConentDefault()
    {
//        $staff = new StaffMember();
//        $staff->setSlackIdentifier("ABC123");
        $controller = new CoffeeBreakPreferenceController();
        $response = $controller->todayAction();

//        $notificationService = new \Awin\Tools\CoffeeBreak\Services\SlackNotifier();
//        $status = $notificationService->notifyStaffMember($staff, $preference);

        var_dump($response);
        $this->assertEquals('text/html', $response->headers->get('Content-Type'));
    }
}