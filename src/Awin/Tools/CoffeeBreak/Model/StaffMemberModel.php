<?php


namespace Awin\Tools\CoffeeBreak\Model;


use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Awin\Tools\CoffeeBreak\Repository\StaffMemberRepository;

class StaffMemberModel
{
    /**
     * @var StaffMemberRepository
     */
    private StaffMemberRepository $staffMemberRepository;

    /**
     * StaffMemberModel constructor.
     * @param StaffMemberRepository $staffMemberRepository
     */
    public function __construct(StaffMemberRepository $staffMemberRepository)
    {
        $this->staffMemberRepository = $staffMemberRepository;
    }

    public function getById(int $staffMemberId): StaffMember
    {
        $this->staffMemberRepository->find($staffMemberId);
    }
}