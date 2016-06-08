<?php

namespace DavidVerholen\Teaser\Model;

use DavidVerholen\Teaser\Api\Data\TeaserGroupItemLinkInterface;
use DavidVerholen\Teaser\Api\Data\TeaserGroupItemLinkInterfaceFactory;
use DavidVerholen\Teaser\Api\TeaserGroupLinkManagementInterface;
use DavidVerholen\Teaser\Api\TeaserGroupLinkRepositoryInterface;
use DavidVerholen\Teaser\Api\TeaserGroupRepositoryInterface;
use DavidVerholen\Teaser\Api\TeaserItemRepositoryInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;

class TeaserGroupLinkManagement implements TeaserGroupLinkManagementInterface
{
    /**
     * @var TeaserGroupRepositoryInterface
     */
    protected $teaserGroupRepository;

    /**
     * @var TeaserItemRepositoryInterface
     */
    protected $teaserItemRepository;

    /**
     * @var TeaserItemResource
     */
    protected $teaserItemResource;

    /**
     * @var TeaserGroupLinkRepositoryInterface
     */
    protected $teaserGroupLinkRepository;

    /**
     * @var TeaserGroupItemLinkInterfaceFactory
     */
    protected $teaserItemLinkFactory;

    /**
     * TeaserGroupLinkManagement constructor.
     *
     * @param TeaserGroupRepositoryInterface      $teaserGroupRepository
     * @param TeaserItemRepositoryInterface       $teaserItemRepository
     * @param TeaserItemResource                  $teaserItemResource
     * @param TeaserGroupLinkRepositoryInterface  $teaserGroupLinkRepository
     * @param TeaserGroupItemLinkInterfaceFactory $teaserItemLinkFactory
     */
    public function __construct(
        TeaserGroupRepositoryInterface $teaserGroupRepository,
        TeaserItemRepositoryInterface $teaserItemRepository,
        TeaserItemResource $teaserItemResource,
        TeaserGroupLinkRepositoryInterface $teaserGroupLinkRepository,
        TeaserGroupItemLinkInterfaceFactory $teaserItemLinkFactory
    ) {
        $this->teaserGroupRepository = $teaserGroupRepository;
        $this->teaserItemRepository = $teaserItemRepository;
        $this->teaserItemResource = $teaserItemResource;
        $this->teaserGroupLinkRepository = $teaserGroupLinkRepository;
        $this->teaserItemLinkFactory = $teaserItemLinkFactory;
    }

    /**
     * Get Teaser Items assigned to Teaser Group
     *
     * @param int $teaserGroupId
     *
     * @return TeaserGroupItemLinkInterface[]
     */
    public function getAssignedTeaserItems($teaserGroupId)
    {
        /** @var TeaserGroup $teaserGroup */
        $teaserGroup = $this->teaserGroupRepository->getById($teaserGroupId);
        /** @var \DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\Collection $teaserItems */
        $teaserItems = $teaserGroup->getTeaserItemsCollection();
        $teaserItems->addFieldToSelect('position');

        /** @var TeaserGroupItemLinkInterface[] $links */
        $links = [];
        /** @var \DavidVerholen\Teaser\Model\TeaserItem $teaserItem */
        foreach ($teaserItems->getItems() as $teaserItem) {
            /** @var TeaserGroupItemLinkInterface $link */
            $link = $this->teaserItemLinkFactory->create();
            $link->setTeaserItemId($teaserItem->getId())
                ->setPosition($teaserItem->getData('group_index_position'))
                ->setTeaserGroupId($teaserGroup->getId());
            $links[] = $link;
        }

        return $links;
    }

    /**
     * Assign Teaser Item to given Teaser Groups
     *
     * @param int   $teaserItemId
     * @param int[] $teaserGroupIds
     *
     * @return bool
     */
    public function assignTeaserItemToGroups($teaserItemId, array $teaserGroupIds)
    {
        $teaserItem = $this->teaserItemRepository->getById($teaserItemId);
        $assignedTeaserGroups = $this->teaserItemResource->getTeaserGroupIds($teaserItem);

        foreach (array_diff($assignedTeaserGroups, $teaserGroupIds) as $teaserGroupId) {
            $this->teaserGroupLinkRepository->deleteByIds($teaserGroupId, $teaserItemId);
        }

        foreach (array_diff($teaserGroupIds, $assignedTeaserGroups) as $teaserGroupId) {
            /** @var TeaserGroupItemLinkInterface $teaserGroupItemLink */
            $teaserGroupItemLink = $this->teaserItemLinkFactory->create();
            $teaserGroupItemLink->setTeaserItemId($teaserItemId);
            $teaserGroupItemLink->setTeaserGroupId($teaserGroupId);
            $teaserGroupItemLink->setPosition(0);
            $this->teaserGroupLinkRepository->save($teaserGroupItemLink);
        }

        return true;
    }
}
