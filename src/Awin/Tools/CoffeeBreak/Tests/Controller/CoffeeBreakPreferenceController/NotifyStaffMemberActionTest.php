<?php
namespace Awin\Tools\CoffeeBreak\Tests\Controller\CoffeeBreakPreferenceController;

use Awin\Tools\CoffeeBreak\Controller\CoffeeBreakPreferenceController;
use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Model\CoffeeBreakPreferenceModel;
use Awin\Tools\CoffeeBreak\Model\StaffMemberModel;
use Awin\Tools\CoffeeBreak\Services\Notifier\SlackNotifier;
use mysql_xdevapi\Exception;
use PHPUnit\Framework\TestCase;

class NotifyStaffMemberActionTest extends TestCase
{

    public function testNotifyStaffMemberActionWithSlackWithNoSlackIdExpectException() :void
    {
        $staffId = 1;
        $testStaffMember = new StaffMember();
        $testStaffMember->setName('Joe Blogs');
        $testStaffMember->setId($staffId);

        // Create a Mock of StaffMemberModel and mock getById response.
        $staffMemberModelMock = $this->createMock(StaffMemberModel::class);
        $staffMemberModelMock
            ->expects($this->exactly(1))
            ->method('getById')
            ->willReturn($testStaffMember);


        // Create a Mock of CoffeeBreakPreferenceModel and mock getPreferencesFor response.
        $coffeeBreakPreferenceModelMock = $this->createMock(CoffeeBreakPreferenceModel::class);
        $coffeeBreakPreferenceModelMock
            ->expects($this->exactly(1))
            ->method('getPreferencesFor')
            ->with($this->equalTo($testStaffMember), $this->isInstanceOf(\DateTime::class))
            ->willReturn(
                new CoffeeBreakPreference('drink', 'coffee', $testStaffMember)
            );

        // Create Controller instance
        $controller = new CoffeeBreakPreferenceController();

        //set up expected exception
        $this->expectExceptionObject(new \Exception('Cannot send notification - no SlackIdentifier'));

        // Call notifyStaffMemberAction on controller .
        $controller->notifyStaffMemberAction(
            $staffMemberModelMock,
            $coffeeBreakPreferenceModelMock,
            new SlackNotifier(),
            $staffId
        );

    }

    public function testNotifyStaffMemberActionWithSlackWithNoSlackIdExpectTrue() :void
    {
        $staffId = 1;
        $testStaffMember = new StaffMember();
        $testStaffMember->setName('Joe Blogs');
        $testStaffMember->setId($staffId);
        $testStaffMember->setSlackIdentifier('jb123');


        // Create a Mock of StaffMemberModel and mock getById response.
        $staffMemberModelMock = $this->createMock(StaffMemberModel::class);
        $staffMemberModelMock
            ->expects($this->exactly(1))
            ->method('getById')
            ->willReturn($testStaffMember);


        // Create a Mock of CoffeeBreakPreferenceModel and mock getPreferencesFor response.
        $coffeeBreakPreferenceModelMock = $this->createMock(CoffeeBreakPreferenceModel::class);
        $coffeeBreakPreferenceModelMock
            ->expects($this->exactly(1))
            ->method('getPreferencesFor')
            ->with($this->equalTo($testStaffMember), $this->isInstanceOf(\DateTime::class))
            ->willReturn(
                new CoffeeBreakPreference('drink', 'coffee', $testStaffMember)
            );

        // Create Controller instance
        $controller = new CoffeeBreakPreferenceController();

        // Call notifyStaffMemberAction on controller .
        $response =$controller->notifyStaffMemberAction(
            $staffMemberModelMock,
            $coffeeBreakPreferenceModelMock,
            new SlackNotifier(),
            $staffId
        );
        //To be implemented int he Controller
//        $this->assertEquals($outputContentType, $response->headers->get('Content-Type'));
        $this->assertEquals('OK', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());

    }

}