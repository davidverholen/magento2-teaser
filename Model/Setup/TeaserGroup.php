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

namespace DavidVerholen\Teaser\Model\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup as TeaserGroupResource;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class TeaserGroup
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model\Setup
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserGroup implements InstallSchemaInterface
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
            $setup->getTable(TeaserGroupResource::TABLE_NAME)
        )->addColumn(
            TeaserGroupInterface::TEASER_GROUP_ID,
            Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Teaser Group ID'
        )->addColumn(
            TeaserGroupInterface::TITLE,
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Teaser Group Title'
        )->addColumn(
            TeaserGroupInterface::CSS_CLASS,
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Teaser Group Css Class'
        )->addColumn(
            TeaserGroupInterface::CREATION_DATE,
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Teaser Group Creation Time'
        )->addColumn(
            TeaserGroupInterface::MODIFIED_DATE,
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Teaser Group Modification Time'
        )->addColumn(
            TeaserGroupInterface::IS_ACTIVE,
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Teaser Group Active'
        )->setComment(
            'Teaser Group Table'
        );

        $setup->getConnection()->createTable($table);
    }
}
