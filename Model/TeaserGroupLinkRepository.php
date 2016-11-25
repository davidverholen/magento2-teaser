<?php

namespace DavidVerholen\Teaser\Model;

use DavidVerholen\Teaser\Api\Data\TeaserGroupItemLinkInterface;
use DavidVerholen\Teaser\Api\TeaserGroupLinkRepositoryInterface;
use DavidVerholen\Teaser\Api\TeaserGroupRepositoryInterface;
use DavidVerholen\Teaser\Api\TeaserItemRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;

class TeaserGroupLinkRepository implements TeaserGroupLinkRepositoryInterface
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
     * @param TeaserGroupRepositoryInterface $teaserGroupRepository
     * @param TeaserItemRepositoryInterface  $teaserItemRepository
     */
    public function __construct(
        TeaserGroupRepositoryInterface $teaserGroupRepository,
        TeaserItemRepositoryInterface $teaserItemRepository
    ) {
        $this->teaserGroupRepository = $teaserGroupRepository;
        $this->teaserItemRepository = $teaserItemRepository;
    }

    /**
     * Assign a TeaserItem to the required TeaserGroup
     *
     * @param TeaserGroupItemLinkInterface $teaserItemLink
     *
     * @return bool will returned True if assigned
     *
     * @throws CouldNotSaveException
     */
    public function save(TeaserGroupItemLinkInterface $teaserItemLink)
    {
        /** @var TeaserGroup $teaserGroup */
        $teaserGroup = $this->teaserGroupRepository->getById($teaserItemLink->getTeaserGroupId());

        /** @var TeaserItem $teaserItem */
        $teaserItem = $this->teaserItemRepository->getById($teaserItemLink->getTeaserItemId());

        $teaserItemPositions = $teaserGroup->getTeaserItemsPosition();
        $teaserItemPositions[$teaserItem->getId()] = $teaserItemLink->getPosition();
        $teaserGroup->setData('posted_teaser_items', $teaserItemPositions);
        try {
            $teaserGroup->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__(
                'Could not save Teaser Item "%1" with position %2 to Teaser Group %3',
                $teaserItem->getId(),
                $teaserItemLink->getPosition(),
                $teaserGroup->getId()
            ), $e);
        }

        return true;
    }

    /**
     * Remove the TeaserItem assignment from the TeaserGroup
     *
     * @param TeaserGroupItemLinkInterface $teaserItemLink
     *
     * @return bool will returned True if TeaserItems successfully deleted
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(TeaserGroupItemLinkInterface $teaserItemLink)
    {
        return $this->deleteByIds($teaserItemLink->getTeaserGroupId(), $teaserItemLink->getTeaserItemId());
    }

    /**
     * Remove the TeaserItem assignment from the TeaserGroup by TeaserGroup id and sku
     *
     * @param string $teaserGroupId
     * @param string $teaserItemId
     *
     * @return bool will returned True if TeaserItems successfully deleted
     *
     * @throws CouldNotSaveException
     * @throws InputException
     */
    public function deleteByIds($teaserGroupId, $teaserItemId)
    {
        /** @var TeaserGroup $teaserGroup */
        $teaserGroup = $this->teaserGroupRepository->getById($teaserGroupId);

        /** @var TeaserItem $teaserItem */
        $teaserItem = $this->teaserItemRepository->getById($teaserItemId);

        $teaserItemPositions = $teaserGroup->getTeaserItemsPosition();
        if (!isset($teaserItemPositions[$teaserItemId])) {
            throw new InputException(__('TeaserGroup does not contain specified TeaserItem'));
        }

        $backupPosition = $teaserItemPositions[$teaserItemId];
        unset($teaserItemPositions[$teaserItemId]);
        $teaserGroup->setData('posted_teaser_items', $teaserItemPositions);

        try {
            $teaserGroup->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__(
                'Could not save product "%product" with position %position to category %category',
                [
                    "product" => $teaserItem->getId(),
                    "position" => $backupPosition,
                    "category" => $teaserGroup->getId()
                ]
            ), $e);
        }

        return true;
    }
}
