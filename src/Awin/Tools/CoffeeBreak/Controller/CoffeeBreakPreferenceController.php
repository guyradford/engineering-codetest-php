<?php
namespace Awin\Tools\CoffeeBreak\Controller;

use Awin\Tools\CoffeeBreak\Model\CoffeeBreakPreferenceModel;
use Awin\Tools\CoffeeBreak\Model\StaffMemberModel;
use Awin\Tools\CoffeeBreak\Repository\CoffeeBreakPreferenceRepository;
use Awin\Tools\CoffeeBreak\Repository\StaffMemberRepository;
use Awin\Tools\CoffeeBreak\Services\Notifier\NotifierInterface;
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

        switch ($format) {
            case "json":
                $responseContent = $this->getJsonForResponse($preferencesForToday);
                $contentType = "application/json";
                break;

            case "xml":
                $responseContent = $this->getXmlForResponse($preferencesForToday);
                $contentType = "text/xml";
                break;

            default:
                $responseContent = $this->getHtmlForResponse($preferencesForToday);
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

        $staffMemberPreference = $coffeeBreakPreferenceModel->getPreferenceFor($staffMember, new \DateTime());

        $notificationSent = $notifier->notifyStaffMember($staffMember, $staffMemberPreference);

        return new Response($notificationSent ? "OK" : "NOT OK", 200);
    }

    private function getJsonForResponse(array $preferences)
    {
        return json_encode([
            "preferences" => array_map(
                function ($preference) {
                    return $preference->getAsArray();
                },
                $preferences
            )
        ]);
    }

    private function getXmlForResponse(array $preferences)
    {
        $preferencesNode = new \SimpleXMLElement("preferences");
        foreach ($preferences as $preference) {
            $preferencesNode->addChild($preference->getAsXmlNode());
        }

        return $preferencesNode->asXML();
    }

    private function getHtmlForResponse(array $preferences)
    {
        $html = "<ul>";
        foreach ($preferences as $preference) {
            $html .= $preference->getAsListElement();
        }
        $html .= "</ul>";
        return $html;
    }
}
