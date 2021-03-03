<?php
namespace Awin\Tools\CoffeeBreak\Tests\Controller\CoffeeBreakPreferenceController;

use Awin\Tools\CoffeeBreak\Controller\CoffeeBreakPreferenceController;
use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Model\CoffeeBreakPreferenceModel;
use PHPUnit\Framework\TestCase;

class TodayActionTest extends TestCase
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

    public function todayActionWithListOfPreferencesProvider(): array
    {
        return [
            ['html', 'text/html', '<ul><li>Joe Blogs would like a sandwich (flavour : )</li><li>Joe Blogs would like a coffee (number_of_sugars : ,milk : )</li></ul>'],
            ['json', 'application/json', '{"preferences":[{"type":"food","subType":"sandwich","requestedBy":{"name":"Joe Blogs"},"details":{"flavour":false}},{"type":"drink","subType":"coffee","requestedBy":{"name":"Joe Blogs"},"details":{"number_of_sugars":false,"milk":false}}]}'],
            ['xml', 'text/xml', "<?xml version=\"1.0\"?>\n<root><preferences/><<preference type='food' subtype='sandwich'><requestedBy>Joe Blogs</requestedBy><details>Array</details></preference>/><<preference type='drink' subtype='coffee'><requestedBy>Joe Blogs</requestedBy><details>Array</details></preference>/></root>\n"],
        ];
    }

    /**
     * @dataProvider todayActionWithListOfPreferencesProvider
     * @param string $inputType
     * @param string $outputContentType
     * @param string $outputContent
     */
    public function testTodayActionWithListOfPreferences(string $inputType, string $outputContentType, string $outputContent)
    {
        $testStaffMember = new StaffMember();
        $testStaffMember->setName('Joe Blogs');

        // Create a Mock of CoffeeBreakPreferenceModel and mock getPreferencesForToday response.
        $coffeeBreakPreferenceModelMock = $this->createMock(CoffeeBreakPreferenceModel::class);
        $coffeeBreakPreferenceModelMock
            ->expects($this->exactly(1))
            ->method('getPreferencesForToday')
            ->willReturn(
                [
                    new CoffeeBreakPreference('food', 'sandwich', $testStaffMember),
                    new CoffeeBreakPreference('drink', 'coffee', $testStaffMember),
                ]
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