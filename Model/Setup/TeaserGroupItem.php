<?php
/**
 * TeaserGroupItem.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Model\Setup;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup as TeaserGroupResource;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;

/**
 * Class TeaserGroupItem
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model\Setup
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserGroupItem implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $table = $setup->getConnection()->newTable(
            $setup->getTable(TeaserGroupResource::ITEM_LINK_TABLE_NAME)
        )->addColumn(
            TeaserGroupInterface::TEASER_GROUP_ID,
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Teaser Group ID'
        )->addColumn(
            TeaserItemInterface::TEASER_ITEM_ID,
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Teaser Item ID'
        )->addColumn(
            'position',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => true, 'primary' => false],
            'Teaser Item Position'
        )->addForeignKey(
            $setup->getFkName(
                TeaserGroupResource::ITEM_LINK_TABLE_NAME,
                TeaserGroupInterface::TEASER_GROUP_ID,
                TeaserGroupResource::TABLE_NAME,
                TeaserGroupInterface::TEASER_GROUP_ID
            ),
            TeaserGroupInterface::TEASER_GROUP_ID,
            $setup->getTable(TeaserGroupResource::TABLE_NAME),
            TeaserGroupInterface::TEASER_GROUP_ID,
            Table::ACTION_CASCADE
        )->addForeignKey(
            $setup->getFkName(
                TeaserGroupResource::ITEM_LINK_TABLE_NAME,
                TeaserItemInterface::TEASER_ITEM_ID,
                TeaserItemResource::TABLE_NAME,
                TeaserItemInterface::TEASER_ITEM_ID
            ),
            TeaserItemInterface::TEASER_ITEM_ID,
            $setup->getTable(TeaserItemResource::TABLE_NAME),
            TeaserItemInterface::TEASER_ITEM_ID,
            Table::ACTION_CASCADE
        )->setComment(
            'Teaser Group to Teaser Item Linkage Table'
        );
        $setup->getConnection()->createTable($table);
    }
}
