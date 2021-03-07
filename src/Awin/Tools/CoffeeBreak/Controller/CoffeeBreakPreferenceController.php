<?php
namespace Awin\Tools\CoffeeBreak\Controller;

use Awin\Tools\CoffeeBreak\Model\CoffeeBreakPreferenceModel;
use Awin\Tools\CoffeeBreak\Model\StaffMemberModel;
use Awin\Tools\CoffeeBreak\Services\Notifier\NotifierInterface;
use Awin\Tools\CoffeeBreak\Services\NotifyStaffMember;
use Awin\Tools\CoffeeBreak\Services\Renderer\PreferencesForTodayRenderer;
use Symfony\Component\HttpFoundation\Response;

class CoffeeBreakPreferenceController extends ControllerAbstract
{

    /**
     * Publishes the list of preferences in the requested format
     * @param CoffeeBreakPreferenceModel $coffeeBreakPreferenceModel
     * @param string $format
     * @return Response
     */
    public function todayAction(CoffeeBreakPreferenceModel $coffeeBreakPreferenceModel, string $format = "html")
    {
        $preferencesForToday = $coffeeBreakPreferenceModel->getPreferencesForToday();

        $renderer = new PreferencesForTodayRenderer();

        return $this->createResponse($format, $renderer, $preferencesForToday);
    }

    /**
     * @param NotifyStaffMember $notifyStaffMember
     * @param int $staffMemberId
     * @return Response
     * @throws \Exception
     */
    public function notifyStaffMemberAction(NotifyStaffMember $notifyStaffMember, int $staffMemberId) : Response
    {
        $notificationSent = $notifyStaffMember->notify($staffMemberId);

        return new Response($notificationSent ? "OK" : "NOT OK", 200);
    }

}
