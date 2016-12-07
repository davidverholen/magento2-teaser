<?php
namespace DavidVerholen\Teaser\Api;

use DavidVerholen\Teaser\Api\Data\TeaserGroupItemLinkInterface;

interface TeaserGroupLinkManagementInterface
{
    /**
     * Get Teaser Items assigned to Teaser Group
     *
     * @param int $teaserGroupId
     * @return TeaserGroupItemLinkInterface[]
     */
    public function getAssignedTeaserItems($teaserGroupId);

    /**
     * Assign Teaser Item to given Teaser Groups
     *
     * @param int $teaserItemId
     * @param int[] $teaserGroupIds
     * @return bool
     */
    public function assignTeaserItemToGroups($teaserItemId, array $teaserGroupIds);
}
