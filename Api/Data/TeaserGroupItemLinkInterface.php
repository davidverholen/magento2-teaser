<?php
namespace DavidVerholen\Teaser\Api\Data;

interface TeaserGroupItemLinkInterface
{
    /**
     * @return string|null
     */
    public function getTeaserItemId();

    /**
     * @param string $teaserItemId
     * @return $this
     */
    public function setTeaserItemId($teaserItemId);

    /**
     * @return int|null
     */
    public function getPosition();

    /**
     * @param int $position
     * @return $this
     */
    public function setPosition($position);

    /**
     * Get teaserGroup id
     *
     * @return string
     */
    public function getTeaserGroupId();

    /**
     * Set teaserGroup id
     *
     * @param string $teaserGroupId
     * @return $this
     */
    public function setTeaserGroupId($teaserGroupId);
}
