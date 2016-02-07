<?php
/**
 * Collection.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Model\ResourceModel\TeaserItem;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;
use DavidVerholen\Teaser\Model\TeaserItem;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model\ResourceModel\TeaserItem
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = TeaserItemInterface::TEASER_ITEM_ID;

    /**
     * _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TeaserItem::class, TeaserItemResource::class);
    }
}
