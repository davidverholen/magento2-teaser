<?php
/**
 * TeaserItemRepositoryInterface.php
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

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Api\Data\TeaserItemSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface TeaserItemRepositoryInterface
{
    /**
     * Save teaserItem.
     *
     * @param TeaserItemInterface $teaserItem
     *
     * @return TeaserItemInterface
     */
    public function save(TeaserItemInterface $teaserItem);

    /**
     * Retrieve teaserItem.
     *
     * @param int $teaserItemId
     * @return TeaserItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($teaserItemId);

    /**
     * Retrieve teaserItems matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return TeaserItemSearchResultInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete teaserItem.
     *
     * @param TeaserItemInterface $teaserItem
     *
     * @return bool true on success
     */
    public function delete(TeaserItemInterface $teaserItem);
    /**
     * Delete teaserItem by ID.
     *
     * @param int $teaserItemId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($teaserItemId);
}
