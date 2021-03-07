<?php


namespace Awin\Tools\CoffeeBreak\Services;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Model\CoffeeBreakPreferenceModel;
use Awin\Tools\CoffeeBreak\Model\StaffMemberModel;
use Awin\Tools\CoffeeBreak\Services\Notifier\EmailNotifier;
use Awin\Tools\CoffeeBreak\Services\Notifier\SlackNotifier;
use Exception;

class NotifyStaffMember
{
    /**
     * @var StaffMemberModel
     */
    private StaffMemberModel $staffMemberModel;
    /**
     * @var CoffeeBreakPreferenceModel
     */
    private CoffeeBreakPreferenceModel $coffeeBreakPreferenceModel;


    /**
     * NotifyStaffMember constructor.
     * @param StaffMemberModel $staffMemberModel
     * @param CoffeeBreakPreferenceModel $coffeeBreakPreferenceModel
     */
    public function __construct(StaffMemberModel $staffMemberModel, CoffeeBreakPreferenceModel $coffeeBreakPreferenceModel)
    {
        $this->staffMemberModel = $staffMemberModel;
        $this->coffeeBreakPreferenceModel = $coffeeBreakPreferenceModel;
    }

    /**
     * @param int $staffMemberId
     * @return bool
     * @throws Exception
     */
    public function notify(int $staffMemberId) : bool
    {
        $staffMember = $this->staffMemberModel->getById($staffMemberId);

        $coffeeBreakPreferences = $this->coffeeBreakPreferenceModel->getPreferencesFor($staffMember, new \DateTime());

        if (!empty($staffMember->getSlackIdentifier())) {
            $notifier = new SlackNotifier([]); // use factory
            $response = $notifier->notifyStaffMember($staffMember->getSlackIdentifier(), $this->getMessage($staffMember, $coffeeBreakPreferences));
        }else{
            if (!empty($staffMember->getEmail())) {
                $notifier = new EmailNotifier([]);// use factory
                $response = $notifier->notifyStaffMember($staffMember->getEmail(), $this->getMessage($staffMember, $coffeeBreakPreferences));
            }else{
                throw new Exception('No notification method available.');
            }
        }
        return $response;
    }

    protected function getMessage(StaffMember $staffMember, CoffeeBreakPreference $coffeeBreakPreferences) : string
    {
        return "Message to sent...";
    }
}