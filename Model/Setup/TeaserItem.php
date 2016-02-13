<?php
/**
 * TeaserItem.php
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

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class TeaserItem
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model\Setup
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserItem implements InstallSchemaInterface
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
            $setup->getTable(TeaserItemResource::TABLE_NAME)
        )->addColumn(
            TeaserItemInterface::TEASER_ITEM_ID,
            Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Teaser Item ID'
        )->addColumn(
            TeaserItemInterface::TITLE,
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Teaser Item Title'
        )->addColumn(
            TeaserItemInterface::CMS_BLOCK_IDENTIFIER,
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'CMS Block Identifier'
        )->addColumn(
            TeaserItemInterface::IMAGE_PATH,
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Teaser Item Image Path'
        )->addColumn(
            TeaserItemInterface::CREATION_DATE,
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Teaser Item Creation Time'
        )->addColumn(
            TeaserItemInterface::MODIFIED_DATE,
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Teaser Item Modification Time'
        )->addColumn(
            TeaserItemInterface::IS_ACTIVE,
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Teaser Item Active'
        )->setComment(
            'Teaser Item Table'
        );

        $setup->getConnection()->createTable($table);
    }
}
