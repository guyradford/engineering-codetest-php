<?php


namespace Awin\Tools\CoffeeBreak\Tests\Services\CoffeeBreakPreferenceListRenderer;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer\CoffeeBreakPreferenceListRendererInterface;
use Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer\HtmlCoffeeBreakPreferenceListRenderer;
use Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer\JsonCoffeeBreakPreferenceListRenderer;
use Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer\XmlCoffeeBreakPreferenceListRenderer;
use PHPUnit\Framework\TestCase;

class CoffeeBreakPreferenceListRendererTest extends TestCase
{

    public function renderDataProvider(){
        $testStaffMember = new StaffMember();
        $testStaffMember->setName('Joe Blogs');

        $listOfCoffeeBreakPreference = [
            new CoffeeBreakPreference('food', 'sandwich', $testStaffMember),
            new CoffeeBreakPreference('drink', 'coffee', $testStaffMember),
        ];

        return [
            //empty list
            [[], new HtmlCoffeeBreakPreferenceListRenderer(), '<ul></ul>'],
            [[], new JsonCoffeeBreakPreferenceListRenderer(), '{"preferences":[]}'],
            [[], new XmlCoffeeBreakPreferenceListRenderer(), "<?xml version=\"1.0\"?>\n<root><preferences/></root>\n"],

            //list with CoffeeBreakPreferences
            [$listOfCoffeeBreakPreference, new HtmlCoffeeBreakPreferenceListRenderer(), '<ul><li>Joe Blogs would like a sandwich (flavour : )</li><li>Joe Blogs would like a coffee (number_of_sugars : ,milk : )</li></ul>'],
            [$listOfCoffeeBreakPreference, new JsonCoffeeBreakPreferenceListRenderer(), '{"preferences":[{"type":"food","subType":"sandwich","requestedBy":{"name":"Joe Blogs"},"details":{"flavour":false}},{"type":"drink","subType":"coffee","requestedBy":{"name":"Joe Blogs"},"details":{"number_of_sugars":false,"milk":false}}]}'],
            [$listOfCoffeeBreakPreference, new XmlCoffeeBreakPreferenceListRenderer(), "<?xml version=\"1.0\"?>\n<root><preferences/><<preference type='food' subtype='sandwich'><requestedBy>Joe Blogs</requestedBy><details>Array</details></preference>/><<preference type='drink' subtype='coffee'><requestedBy>Joe Blogs</requestedBy><details>Array</details></preference>/></root>\n"],
        ];
    }


    /**
     * @dataProvider renderDataProvider
     * @param array $listOfCoffeeBreakPreference
     * @param CoffeeBreakPreferenceListRendererInterface $renderer
     * @param string $expectedOutput
     */
    public function testRender(array $listOfCoffeeBreakPreference, CoffeeBreakPreferenceListRendererInterface $renderer, string $expectedOutput)
    {
        $output = $renderer->render($listOfCoffeeBreakPreference);

        $this->assertEquals($expectedOutput, $output);
    }
}