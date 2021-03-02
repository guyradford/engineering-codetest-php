<?php
namespace Awin\Tools\CoffeeBreak\Controller;

use Awin\Tools\CoffeeBreak\Repository\CoffeeBreakPreferenceRepository;
use Awin\Tools\CoffeeBreak\Repository\StaffMemberRepository;
use Awin\Tools\CoffeeBreak\Services\Notifier\NotifierInterface;
use Symfony\Component\HttpFoundation\Response;

class CoffeeBreakPreferenceController
{
    public function __construct()
    {
    }

    /**
     * Publishes the list of preferences in the requested format
     */
    public function todayAction($format = "html")
    {
        $repository = new CoffeeBreakPreferenceRepository();
        $t = $repository->getPreferencesForToday();

        $formattedPreferences = [];
        $contentType = "text/html";

        switch ($format) {
            case "json":
                $responseContent = $this->getJsonForResponse($t);
                $contentType = "application/json";
                break;

            case "xml":
                $responseContent = $this->getXmlForResponse($t);
                $contentType = "text/xml";
                break;

            default:
                $formattedPreferences[] = $this->getHtmlForResponse($t);
        }

        return new Response($responseContent, 200, ['Content-Type' => $contentType]);
    }

    /**
     * @param NotifierInterface $notifier
     * @param int $staffMemberId
     * @return Response
     */
    public function notifyStaffMemberAction(NotifierInterface $notifier, int $staffMemberId) : Response
    {
        $staffMemberRepository = new StaffMemberRepository();
        $staffMember = $staffMemberRepository->find($staffMemberId);

        $repository = new CoffeeBreakPreferenceRepository();
        $p = $repository->getPreferenceFor($staffMemberId, new \DateTime());

        $notificationSent = $notifier->notifyStaffMember($staffMember, $p);

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
