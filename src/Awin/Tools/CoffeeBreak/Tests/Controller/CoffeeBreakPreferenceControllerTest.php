<?php

use Awin\Tools\CoffeeBreak\Controller\CoffeeBreakPreferenceController;
use Awin\Tools\CoffeeBreak\Model\CoffeeBreakPreferenceModel;
use PHPUnit\Framework\TestCase;

class CoffeeBreakPreferenceControllerTest extends TestCase
{

    public function todayActionWithNoPreferencesProvider(): array
    {
        return [
            ['html', 'text/html', '<ul></ul>'],
            ['json', 'application/json', '{"preferences":[]}'],
            ['xml', 'text/xml', "<?xml version=\"1.0\"?>\n<root><preferences/></root>\n"],
        ];
    }

    /**
     * @dataProvider todayActionWithNoPreferencesProvider
     * @param string $inputType
     * @param string $outputContentType
     * @param string $outputContent
     */
    public function testTodayActionWithNoPreferences(string $inputType, string $outputContentType, string $outputContent)
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
            $inputType
        );

        $this->assertEquals($outputContentType, $response->headers->get('Content-Type'));
        $this->assertEquals($outputContent, $response->getContent());
    }
}