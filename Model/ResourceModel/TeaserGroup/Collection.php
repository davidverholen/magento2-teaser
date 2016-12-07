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

namespace DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup as TeaserGroupResource;
use DavidVerholen\Teaser\Model\TeaserGroup;
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
    protected $_idFieldName = TeaserGroupInterface::TEASER_GROUP_ID;

    /**
     * _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TeaserGroup::class, TeaserGroupResource::class);
    }
}
