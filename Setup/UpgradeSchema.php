<?php

namespace DavidVerholen\Teaser\Setup;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.2.0') < 0) {
            $this->addTeaserItemHrefField($setup);
        }

        $setup->endSetup();
    }

    private function addTeaserItemHrefField(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable(TeaserItemResource::TABLE_NAME),
            TeaserItemInterface::HREF,
            [
                'type' => Table::TYPE_TEXT,
                'length' => '255',
                'nullable' => true,
                'default' => (string)null,
                'comment' => 'Teaser Item Href',
                'after' => TeaserItemInterface::MOBILE_IMAGE_PATH
            ]
        );
    }
}
