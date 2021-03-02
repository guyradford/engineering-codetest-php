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
     * @param CoffeeBreakPreferenceRepository $coffeeBreakPreferenceRepository
     * @param string $format
     * @return Response
     */
    public function todayAction(CoffeeBreakPreferenceRepository $coffeeBreakPreferenceRepository, string $format = "html")
    {
        $preferencesForToday = $coffeeBreakPreferenceRepository->getPreferencesForToday();

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
     * @param StaffMemberRepository $staffMemberRepository
     * @param CoffeeBreakPreferenceRepository $coffeeBreakPreferenceRepository
     * @param NotifierInterface $notifier
     * @param int $staffMemberId
     * @return Response
     */
    public function notifyStaffMemberAction(StaffMemberRepository $staffMemberRepository, CoffeeBreakPreferenceRepository $coffeeBreakPreferenceRepository, NotifierInterface $notifier, int $staffMemberId) : Response
    {
        $staffMember = $staffMemberRepository->find($staffMemberId);

        $p = $coffeeBreakPreferenceRepository->getPreferenceFor($staffMemberId, new \DateTime());

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
