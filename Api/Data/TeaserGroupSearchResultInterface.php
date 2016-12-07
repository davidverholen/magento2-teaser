<?php
/**
 * TeaserGroupSearchResultInterface.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TeaserGroupSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get blocks list.
     *
     * @return TeaserGroupInterface[]
     */
    public function getItems();
    /**
     * Set blocks list.
     *
     * @param TeaserGroupInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
