<?php
namespace Awin\Tools\CoffeeBreak\Tests\Controller\CoffeeBreakPreferenceController;

use Awin\Tools\CoffeeBreak\Controller\CoffeeBreakPreferenceController;
use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Model\CoffeeBreakPreferenceModel;
use Awin\Tools\CoffeeBreak\Model\StaffMemberModel;
use Awin\Tools\CoffeeBreak\Services\Notifier\EmailNotifier;
use Awin\Tools\CoffeeBreak\Services\Notifier\NotifierInterface;
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
        $staffMemberModelMock = $this->getStaffMemberModelMock($testStaffMember);

        // Create a Mock of CoffeeBreakPreferenceModel and mock getPreferencesFor response.
        $coffeeBreakPreferenceModelMock = $this->getCoffeeBreakPreferenceModelMock($testStaffMember);

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

    public function testNotifyStaffMemberActionWithSlackWithSlackIdExpectTrue() :void
    {
        $staffId = 1;
        $testStaffMember = new StaffMember();
        $testStaffMember->setName('Joe Blogs');
        $testStaffMember->setId($staffId);
        $testStaffMember->setSlackIdentifier('jb123');

        // Create a Mock of StaffMemberModel and mock getById response.
        $staffMemberModelMock = $this->getStaffMemberModelMock($testStaffMember);


        // Create a Mock of CoffeeBreakPreferenceModel and mock getPreferencesFor response.
        $coffeeBreakPreferenceModelMock = $this->getCoffeeBreakPreferenceModelMock($testStaffMember);

        // Create Controller instance
        $controller = new CoffeeBreakPreferenceController();

        // Call notifyStaffMemberAction on controller .
        $response =$controller->notifyStaffMemberAction(
            $staffMemberModelMock,
            $coffeeBreakPreferenceModelMock,
            new SlackNotifier(),
            $staffId
        );

        $this->assertEquals('', $response->headers->get('Content-Type'));
        $this->assertEquals('OK', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());

    }


    public function testNotifyStaffMemberActionWithEmailWithNoEmailAddressExpectException() :void
    {
        $staffId = 1;
        $testStaffMember = new StaffMember();
        $testStaffMember->setName('Joe Blogs');
        $testStaffMember->setId($staffId);

        // Create a Mock of StaffMemberModel and mock getById response.
        $staffMemberModelMock = $this->getStaffMemberModelMock($testStaffMember);

        // Create a Mock of CoffeeBreakPreferenceModel and mock getPreferencesFor response.
        $coffeeBreakPreferenceModelMock = $this->getCoffeeBreakPreferenceModelMock($testStaffMember);

        // Create Controller instance
        $controller = new CoffeeBreakPreferenceController();

        //set up expected exception
        $this->expectExceptionObject(new \Exception('Cannot send notification - no email address.'));

        // Call notifyStaffMemberAction on controller .
        $controller->notifyStaffMemberAction(
            $staffMemberModelMock,
            $coffeeBreakPreferenceModelMock,
            new EmailNotifier(),
            $staffId
        );

    }

    public function testNotifyStaffMemberActionWithEmailWithEmailExpectTrue() :void
    {
        $staffId = 1;
        $testStaffMember = new StaffMember();
        $testStaffMember->setName('Joe Blogs');
        $testStaffMember->setId($staffId);
        $testStaffMember->setEmail('jb@example.com');

        // Create a Mock of StaffMemberModel and mock getById response.
        $staffMemberModelMock = $this->getStaffMemberModelMock($testStaffMember);

        // Create a Mock of CoffeeBreakPreferenceModel and mock getPreferencesFor response.
        $coffeeBreakPreferenceModelMock = $this->getCoffeeBreakPreferenceModelMock($testStaffMember);

        // Create Controller instance
        $controller = new CoffeeBreakPreferenceController();

        // Call notifyStaffMemberAction on controller .
        $response =$controller->notifyStaffMemberAction(
            $staffMemberModelMock,
            $coffeeBreakPreferenceModelMock,
            new EmailNotifier(),
            $staffId
        );

        $this->assertEquals('', $response->headers->get('Content-Type'));
        $this->assertEquals('OK', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());

    }

    public function testNotifyStaffMemberActionWithEmailNotifyThatFailsReturnsTrue() :void
    {
        $staffId = 1;
        $testStaffMember = new StaffMember();
        $testStaffMember->setName('Joe Blogs');
        $testStaffMember->setId($staffId);
        $testStaffMember->setEmail('jb@example.com');

        // Create a Mock of StaffMemberModel and mock getById response.
        $staffMemberModelMock = $this->getStaffMemberModelMock($testStaffMember);

        // Create a Mock of CoffeeBreakPreferenceModel and mock getPreferencesFor response.
        $coffeeBreakPreferenceModelMock = $this->getCoffeeBreakPreferenceModelMock($testStaffMember);

        // Create a Mock of NotifierInterface and mock notifyStaffMember response.
        $notifierMock = $this->createMock(NotifierInterface::class);
        $notifierMock
            ->expects($this->exactly(1))
            ->method('notifyStaffMember')
            ->willReturn(false);

        // Create Controller instance
        $controller = new CoffeeBreakPreferenceController();

        // Call notifyStaffMemberAction on controller .
        $response =$controller->notifyStaffMemberAction(
            $staffMemberModelMock,
            $coffeeBreakPreferenceModelMock,
            $notifierMock,
            $staffId
        );

        $this->assertEquals('', $response->headers->get('Content-Type'));
        $this->assertEquals('NOT OK', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());

    }


    protected function getStaffMemberModelMock(StaffMember $testStaffMember): StaffMemberModel
    {
        // Create a Mock of StaffMemberModel and mock getById response.
        $staffMemberModelMock = $this->createMock(StaffMemberModel::class);
        $staffMemberModelMock
            ->expects($this->exactly(1))
            ->method('getById')
            ->willReturn($testStaffMember);
        return $staffMemberModelMock;
    }

    protected function getCoffeeBreakPreferenceModelMock(StaffMember $testStaffMember) : CoffeeBreakPreferenceModel
    {
        $coffeeBreakPreferenceModelMock = $this->createMock(CoffeeBreakPreferenceModel::class);
        $coffeeBreakPreferenceModelMock
            ->expects($this->exactly(1))
            ->method('getPreferencesFor')
            ->with($this->equalTo($testStaffMember), $this->isInstanceOf(\DateTime::class))
            ->willReturn(
                new CoffeeBreakPreference('drink', 'coffee', $testStaffMember)
            );
        return $coffeeBreakPreferenceModelMock;
    }
}