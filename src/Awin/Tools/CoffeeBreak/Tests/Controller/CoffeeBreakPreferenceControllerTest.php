<?php

use Awin\Tools\CoffeeBreak\Controller\CoffeeBreakPreferenceController;
use Awin\Tools\CoffeeBreak\Model\CoffeeBreakPreferenceModel;
use PHPUnit\Framework\TestCase;

class CoffeeBreakPreferenceControllerTest extends TestCase
{


    public function testTodayActionWithNoPreferencesAndDefaultResponseType()
    {

        // Create a Mock of CoffeeBreakPreferenceModel and mock getPreferencesForToday response.
        $coffeeBreakPreferenceModelMock = $this->createMock(CoffeeBreakPreferenceModel::class);
        $coffeeBreakPreferenceModelMock
            ->expects($this->exactly(1))
            ->method('getPreferencesForToday')
            ->willReturn(
                []
            );

        // Create Controller instance
        $controller = new CoffeeBreakPreferenceController();

        // Call todayAction on controller and get response for assertions.
        $response = $controller->todayAction(
            $coffeeBreakPreferenceModelMock,
            'html'
        );

        $this->assertEquals('text/html', $response->headers->get('Content-Type'));
        $this->assertEquals('<ul></ul>', $response->getContent());
    }
}