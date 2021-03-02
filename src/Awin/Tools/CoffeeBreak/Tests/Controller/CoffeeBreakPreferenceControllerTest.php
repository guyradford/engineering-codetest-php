<?php

use Awin\Tools\CoffeeBreak\Controller\CoffeeBreakPreferenceController;
use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Repository\CoffeeBreakPreferenceRepository;
use PHPUnit\Framework\TestCase;

class CoffeeBreakPreferenceControllerTest extends TestCase
{
    public function testTodayActionWithNoConentDefault()
    {

        $coffeeBreakPreferenceRepository = new CoffeeBreakPreferenceRepository(
            $this->createMock(ObjectManager::class),

        );
        $controller = new CoffeeBreakPreferenceController();
        $response = $controller->todayAction(
            $coffeeBreakPreferenceRepository
        );

//        $notificationService = new \Awin\Tools\CoffeeBreak\Services\SlackNotifier();
//        $status = $notificationService->notifyStaffMember($staff, $preference);

        var_dump($response);
        $this->assertEquals('text/html', $response->headers->get('Content-Type'));
    }
}