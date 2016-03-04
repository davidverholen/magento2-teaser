<?php
namespace DavidVerholen\Teaser\Api;

use DavidVerholen\Teaser\Api\Data\TeaserGroupItemLinkInterface;

interface TeaserGroupLinkRepositoryInterface
{
    /**
     * Assign a TeaserItem to the required TeaserGroup
     *
     * @param TeaserGroupItemLinkInterface $teaserItemLink
     * @return bool will returned True if assigned
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function save(TeaserGroupItemLinkInterface $teaserItemLink);

    /**
     * Remove the TeaserItem assignment from the TeaserGroup
     *
     * @param TeaserGroupItemLinkInterface $teaserItemLink
     * @return bool will returned True if TeaserItems successfully deleted
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(TeaserGroupItemLinkInterface $teaserItemLink);

    /**
     * Remove the TeaserItem assignment from the TeaserGroup by TeaserGroup id and sku
     *
     * @param string $teaserGroupId
     * @param string $teaserItemId
     * @return bool will returned True if TeaserItems successfully deleted
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteByIds($teaserGroupId, $teaserItemId);
}
