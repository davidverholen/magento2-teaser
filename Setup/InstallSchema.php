<?php
/**
 * InstallSchema.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Setup;

use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;
use DavidVerholen\Teaser\Model\Setup\TeaserGroup;
use DavidVerholen\Teaser\Model\Setup\TeaserGroupItem;
use DavidVerholen\Teaser\Model\Setup\TeaserItem;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Setup
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var TeaserItem
     */
    protected $teaserItemSetup;

    /**
     * @var TeaserGroup
     */
    protected $teaserGroupSetup;

    /**
     * @var TeaserGroupItem
     */
    protected $teaserGroupItemSetup;

    /**
     * InstallSchema constructor.
     *
     * @param TeaserItem      $teaserItemSetup
     * @param TeaserGroup     $teaserGroupSetup
     * @param TeaserGroupItem $teaserGroupItemSetup
     */
    public function __construct(
        TeaserItem $teaserItemSetup,
        TeaserGroup $teaserGroupSetup,
        TeaserGroupItem $teaserGroupItemSetup
    ) {
        $this->teaserItemSetup = $teaserItemSetup;
        $this->teaserGroupSetup = $teaserGroupSetup;
        $this->teaserGroupItemSetup = $teaserGroupItemSetup;
    }

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
        $setup->startSetup();
        $this->teaserItemSetup->install($setup, $context);
        $this->teaserGroupSetup->install($setup, $context);
        $this->teaserGroupItemSetup->install($setup, $context);
        $setup->endSetup();
    }
}
