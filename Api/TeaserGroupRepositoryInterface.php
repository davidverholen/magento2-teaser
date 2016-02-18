<?php
/**
 * TeaserGroupRepositoryInterface.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Api;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Api\Data\TeaserGroupSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface TeaserGroupRepositoryInterface
{
    /**
     * Save TeaserGroup.
     *
     * @param TeaserGroupInterface $teaserGroup
     *
     * @return TeaserGroupInterface
     */
    public function save(TeaserGroupInterface $teaserGroup);

    /**
     * Retrieve TeaserGroup.
     *
     * @param int $teaserGroupId
     * @return TeaserGroupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($teaserGroupId);

    /**
     * Retrieve TeaserGroups matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return TeaserGroupSearchResultInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete TeaserGroup.
     *
     * @param TeaserGroupInterface $teaserGroup
     *
     * @return bool true on success
     */
    public function delete(TeaserGroupInterface $teaserGroup);
    /**
     * Delete TeaserGroup by ID.
     *
     * @param int $teaserGroupId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($teaserGroupId);
}
