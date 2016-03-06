<?php
/**
 * TeaserItem.php
 *
 * PHP Version 5
 *
 * @category mage2-dev
 * @package  mage2-dev
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup\Tab;

use DavidVerholen\Teaser\Controller\RegistryConstants;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup as TeaserGroupResource;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\Collection as TeaserItemCollection;
use DavidVerholen\Teaser\Model\TeaserGroup;
use DavidVerholen\Teaser\Model\TeaserItemFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;

/**
 * Class TeaserItem
 *
 * @category mage2-dev
 * @package  DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup\Tab
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserItem extends Extended
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * @var TeaserItemFactory
     */
    protected $teaserItemFactory;

    /**
     * @param Context           $context
     * @param Data              $backendHelper
     * @param TeaserItemFactory $teaserItemFactory
     * @param Registry          $coreRegistry
     * @param array             $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        TeaserItemFactory $teaserItemFactory,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->teaserItemFactory = $teaserItemFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('teaser_teasergroup_items');
        $this->setDefaultSort('teaser_item_id');
        $this->setUseAjax(true);
    }

    /**
     * @return TeaserGroup
     */
    public function getTeaserGroup()
    {
        return $this->coreRegistry->registry(RegistryConstants::CURRENT_TEASER_GROUP);
    }

    /**
     * @param Column $column
     *
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_teaser_group_items') {
            $teaserItemIds = $this->getSelectedTeaserItemIds();
            if (empty($teaserItemIds)) {
                $teaserItemIds = 0;
            }
            if ($column->getFilter()->getData('value')) {
                $this->getCollection()->addFieldToFilter('teaser_item_id',
                    ['in' => $teaserItemIds]);
            } elseif (!empty($teaserItemIds)) {
                $this->getCollection()->addFieldToFilter('teaser_item_id',
                    ['nin' => $teaserItemIds]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        if ($this->getTeaserGroup()->getId()) {
            $this->setDefaultFilter(['in_teaser_group' => 1]);
        }
        /** @var TeaserItemCollection $collection */
        $collection = $this->teaserItemFactory->create()->getCollection();
        $collection->join(
            ['lt' => TeaserGroupResource::ITEM_LINK_TABLE_NAME],
            'main_table.teaser_item_id=lt.teaser_item_id',
            ['main_table.teaser_item_id','main_table.title','position','teaser_group_id']
        );
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn('in_teaser_group', [
            'type'             => 'checkbox',
            'name'             => 'in_teaser_group',
            'values'           => $this->getSelectedTeaserItemIds(),
            'index'            => 'teaser_item_id',
            'header_css_class' => 'col-select col-massaction',
            'column_css_class' => 'col-select col-massaction'
        ]);

        $this->addColumn('teaser_item_id', [
            'header'           => __('ID'),
            'sortable'         => true,
            'index'            => 'teaser_item_id',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
        ]);

        $this->addColumn('title', [
            'header' => __('Title'),
            'index' => 'title'
        ]);

        $this->addColumn('position', [
            'header'   => __('Position'),
            'type'     => 'number',
            'index'    => 'position'
        ]);

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('teaser/*/grid', ['_current' => true]);
    }

    /**
     * @return array
     */
    protected function getSelectedTeaserItemIds()
    {
        $teaserItems = $this->getRequest()->getPost('selected_teaser_items');
        if ($teaserItems === null) {
            $teaserItems = $this->getTeaserGroup()->getTeaserItemsPosition();
            return array_keys($teaserItems);
        }
        return $teaserItems;
    }
}
