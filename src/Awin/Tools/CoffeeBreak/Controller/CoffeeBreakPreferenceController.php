<?php
namespace Awin\Tools\CoffeeBreak\Controller;

use Awin\Tools\CoffeeBreak\Model\CoffeeBreakPreferenceModel;
use Awin\Tools\CoffeeBreak\Model\StaffMemberModel;
use Awin\Tools\CoffeeBreak\Services\Notifier\NotifierInterface;
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
     * @param StaffMemberModel $staffMemberModel
     * @param CoffeeBreakPreferenceModel $coffeeBreakPreferenceModel
     * @param NotifierInterface $notifier
     * @param int $staffMemberId
     * @return Response
     */
    public function notifyStaffMemberAction(StaffMemberModel $staffMemberModel, CoffeeBreakPreferenceModel $coffeeBreakPreferenceModel, NotifierInterface $notifier, int $staffMemberId) : Response
    {
        $staffMember = $staffMemberModel->getById($staffMemberId);

        $coffeeBreakPreference = $coffeeBreakPreferenceModel->getPreferencesFor($staffMember, new \DateTime());

        $notificationSent = $notifier->notifyStaffMember($staffMember, $coffeeBreakPreference);

        return new Response($notificationSent ? "OK" : "NOT OK", 200);
    }

}
