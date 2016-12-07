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
use DavidVerholen\Teaser\Model\TeaserGroup as TeaserGroupModel;
use Magento\Framework\Model\AbstractModel;
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
     * @param AbstractModel|TeaserGroupModel|TeaserGroupInterface $object
     *
     * @return $this
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->saveTeaserGroupItems($object);
        return parent::_afterSave($object);
    }


    /**
     * @param TeaserGroupInterface|TeaserGroupModel $teaserGroupObject
     *
     * @return TeaserGroup
     */
    public function getTeaserItemsPosition(TeaserGroupInterface $teaserGroupObject)
    {
        $select = $this->getConnection()->select()->from(
            static::ITEM_LINK_TABLE_NAME,
            ['teaser_item_id', 'position']
        )->where('teaser_group_id = :teaser_group_id');

        return $this->getConnection()->fetchPairs($select, [
            'teaser_group_id' => (int)$teaserGroupObject->getId()
        ]);
    }

    /**
     * @param TeaserGroupInterface|TeaserGroupModel $teaserGroupObject
     *
     * @return $this
     */
    protected function saveTeaserGroupItems(TeaserGroupInterface $teaserGroupObject)
    {
        $teaserGroupObject->setData('is_changed_teaser_items_list', false);
        $id = $teaserGroupObject->getId();

        $postedTeaserItems = $teaserGroupObject->getData('posted_teaser_items');

        if ($postedTeaserItems === null) {
            return $this;
        }

        $oldTeaserItems = $teaserGroupObject->getTeaserItemsPosition();
        $insert = array_diff_key($postedTeaserItems, $oldTeaserItems);
        $delete = array_diff_key($oldTeaserItems, $postedTeaserItems);
        $update = array_intersect_key($postedTeaserItems, $oldTeaserItems);
        $update = array_diff_assoc($update, $oldTeaserItems);

        $connection = $this->getConnection();

        if (!empty($delete)) {
            $cond = ['teaser_item_id IN(?)' => array_keys($delete), 'teaser_group_id=?' => $id];
            $connection->delete(static::ITEM_LINK_TABLE_NAME, $cond);
        }

        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $productId => $position) {
                $data[] = [
                    'teaser_group_id' => (int)$id,
                    'teaser_item_id' => (int)$productId,
                    'position' => (int)$position,
                ];
            }
            $connection->insertMultiple(static::ITEM_LINK_TABLE_NAME, $data);
        }

        if (!empty($update)) {
            foreach ($update as $productId => $position) {
                $where = ['teaser_group_id = ?' => (int)$id, 'teaser_item_id = ?' => (int)$productId];
                $bind = ['position' => (int)$position];
                $connection->update(static::ITEM_LINK_TABLE_NAME, $bind, $where);
            }
        }

        if (!empty($insert) || !empty($update) || !empty($delete)) {
            $teaserGroupObject->setData('is_changed_teaser_items_list', true);
            $productIds = array_keys($insert + $delete + $update);
            $teaserGroupObject->setData('affected_teaser_item_ids', $productIds);
        }

        return $this;
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
