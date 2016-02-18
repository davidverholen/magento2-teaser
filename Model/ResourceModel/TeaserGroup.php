<?php
/**
 * TeaserGroup.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Model\ResourceModel;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class TeaserGroup
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model\ResourceModel
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserGroup extends AbstractDb
{
    const TABLE_NAME = 'davidverholen_teaser_group';
    const ITEM_LINK_TABLE_NAME = 'davidverholen_teaser_group_item';

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(static::TABLE_NAME, TeaserGroupInterface::TEASER_GROUP_ID);
    }

    /**
     * getAvailableStatuses
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [
            static::STATUS_ENABLED => __('Enabled'),
            static::STATUS_DISABLED => __('Disabled')
        ];
    }
}
