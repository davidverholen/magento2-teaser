<?php
/**
 * Created by PhpStorm.
 * User: davidverholen
 * Date: 08.12.15
 * Time: 17:43
 */

namespace DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup\Edit\Tab;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Controller\RegistryConstants;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup as TeaserGroupResource;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\Collection;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\CollectionFactory;
use DavidVerholen\Teaser\Model\TeaserGroup;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Column\Extended as ExtendedGridWidget;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;

class TeaserItems extends Extended
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var  CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context           $context
     * @param Data              $backendHelper
     * @param CollectionFactory $collectionFactory
     * @param Registry          $coreRegistry
     * @param array             $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $collectionFactory,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('teasergroup_item_grid');
        $this->setDefaultSort(TeaserItemInterface::TEASER_ITEM_ID, 'desc');
        $this->setUseAjax(true);

        if ($this->getTeaserGroup() && $this->getTeaserGroup()->getId() && 0 < count($this->getSelectedItems())) {
            $this->setDefaultFilter(['in_teaser_group' => 1]);
        }
    }

    /**
     * Apply various selection filters to prepare the sales order grid collection.
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $collection->getSelect()->joinLeft(
            ['link_table' => $collection->getTable(TeaserGroupResource::ITEM_LINK_TABLE_NAME)],
            'main_table.teaser_item_id=link_table.teaser_item_id',
            ['main_table.teaser_item_id', 'position']
        );

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareColumns()
    {
        $this->addColumn('in_teaser_group', [
            'type' => 'checkbox',
            'name' => 'in_teaser_group',
            'values' => $this->getSelectedItems(),
            'index' => 'teaser_item_id',
            'filter_index' => 'link_table.teaser_item_id',
            'header_css_class' => 'col-select col-massaction',
            'column_css_class' => 'col-select col-massaction'
        ]);

        $this->addColumn(TeaserItemInterface::TEASER_ITEM_ID, [
            'header' => __('Item Id'),
            'index' => TeaserItemInterface::TEASER_ITEM_ID,
            'filter_index' => 'main_table.teaser_item_id',
        ]);

        $this->addColumn('teaser_item_title', [
            'header' => __('Title'),
            'index' => TeaserItemInterface::TITLE,
            'name' => 'test'
        ]);

        $this->addColumn('position', [
            'header' => __('Position'),
            'type' => 'number',
            'index' => 'position',
            'editable' => true
        ]);

        $this->addColumn('position', [
            'header' => __('Position'),
            'name' => 'position',
            'type' => 'number',
            'validate_class' => 'validate-number',
            'index' => 'position',
            'editable' => true,
            'edit_only' => !$this->getTeaserGroup()->getId(),
            'header_css_class' => 'col-position',
            'column_css_class' => 'col-position',
            'filter_condition_callback' => [$this, 'filterItemsPosition']
        ]);

        return parent::_prepareColumns();
    }

    /**
     * Add filter
     *
     * @param Column $column
     *
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_teaser_group') {
            $teaserItemIds = $this->getSelectedItems();
            if (empty($teaserItemIds)) {
                $teaserItemIds = 0;
            }
            if ($column->getFilter()->getData('value')) {
                $this->getCollection()->addFieldToFilter('main_table.teaser_item_id', ['in' => $teaserItemIds]);
            } else {
                if ($teaserItemIds) {
                    $this->getCollection()->addFieldToFilter('main_table.teaser_item_id', ['nin' => $teaserItemIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    /**
     * Retrieve selected slides
     *
     * @return array
     */
    protected function getSelectedItems()
    {
        return array_keys($this->getSelectedItemPositions());
    }

    /**
     * @return array
     */
    public function getSelectedItemPositions()
    {
        if (false === $this->hasData('selected_item_positions')) {
            $teaserItems = [];
            $teaserItemsPositions = $this->coreRegistry
                ->registry(RegistryConstants::CURRENT_TEASER_GROUP)
                ->getTeaserItemsPosition();

            foreach ($teaserItemsPositions as $teaserItemId => $teaseritemPosition) {
                $teaserItems[$teaserItemId] = ['position' => $teaseritemPosition];
            }

            $this->setData('selected_item_positions', $teaserItems);
        }

        return $this->getData('selected_item_positions');
    }


    /**
     * @return TeaserGroup
     */
    public function getTeaserGroup()
    {
        return $this->coreRegistry->registry(RegistryConstants::CURRENT_TEASER_GROUP);
    }

    /**
     * @param Collection         $collection $collection
     * @param ExtendedGridWidget $column
     *
     * @return $this
     */
    public function filterItemsPosition(Collection $collection, ExtendedGridWidget $column)
    {
        $collection->addFieldToFilter($column->getIndex(), $column->getFilter()->getCondition());
        return $this;
    }
}
