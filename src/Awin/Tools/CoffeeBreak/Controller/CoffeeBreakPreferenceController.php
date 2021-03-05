<?php
namespace Awin\Tools\CoffeeBreak\Controller;

use Awin\Tools\CoffeeBreak\Model\CoffeeBreakPreferenceModel;
use Awin\Tools\CoffeeBreak\Model\StaffMemberModel;
use Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer\HtmlCoffeeBreakPreferenceListRenderer;
use Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer\JsonCoffeeBreakPreferenceListRenderer;
use Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer\XmlCoffeeBreakPreferenceListRenderer;
use Awin\Tools\CoffeeBreak\Services\Notifier\NotifierInterface;
use Awin\Tools\CoffeeBreak\Services\Renderer\PreferencesForTodayRenderer;
use Symfony\Component\HttpFoundation\Response;

class CoffeeBreakPreferenceController
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

        switch ($format) {
            case "json":
                $responseContent = $renderer->renderJson($preferencesForToday);
                $contentType = "application/json";
                break;

            case "xml":
                $responseContent = $renderer->renderXml($preferencesForToday);
                $contentType = "text/xml";
                break;

            default:
                $responseContent = $renderer->renderHtml($preferencesForToday);
                $contentType = "text/html";
        }

        return new Response($responseContent, 200, ['Content-Type' => $contentType]);
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
