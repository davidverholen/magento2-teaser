<?php
namespace DavidVerholen\Teaser\Block\Adminhtml\TeaserItem\Widget;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\Collection;
use DavidVerholen\Teaser\Model\TeaserItemFactory;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\CollectionFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Chooser extends Extended
{
    /**
     * @var TeaserItemFactory
     */
    protected $teaserItemFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Chooser constructor.
     *
     * @param TeaserItemFactory $teaserItemFactory
     * @param CollectionFactory  $collectionFactory
     * @param Context            $context
     * @param Data               $backendHelper
     * @param array              $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        TeaserItemFactory $teaserItemFactory,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $backendHelper, $data);
        $this->teaserItemFactory = $teaserItemFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Block construction, prepare grid params
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setData('use_ajax', true);
        $this->setDefaultFilter(['chooser_is_active' => '1']);
    }

    /**
     * Prepare chooser element HTML
     *
     * @param AbstractElement $element Form Element
     *
     * @return AbstractElement
     */
    public function prepareElementHtml(AbstractElement $element)
    {
        $uniqueId = $this->mathRandom->getUniqueHash($element->getId());
        $sourceUrl = $this->getUrl('teaser/teaseritem_widget/chooser', ['unique_id' => $uniqueId]);

        /** @var \Magento\Widget\Block\Adminhtml\Widget\Chooser $chooser */
        $chooser = $this->getLayout()->createBlock(\Magento\Widget\Block\Adminhtml\Widget\Chooser::class);
        $chooser->setElement($element)
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqueId);

        if ($element->getValue()) {
            /** @var TeaserItemInterface $teaserItem */
            $teaserItem = $this->teaserItemFactory->create()->load((int)$element->getValue());
            if ($teaserItem->getId()) {
                $chooser->setLabel($this->escapeHtml($teaserItem->getTitle()));
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    /**
     * Grid Row JS Callback
     *
     * @return string
     */
    public function getRowClickCallback()
    {
        $chooserJsObject = $this->getId();
        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");
                var teaserItemTitle = trElement.down("td").next().innerHTML;
                var teaserItemId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                ' .
            $chooserJsObject .
            '.setElementValue(teaserItemId);
                ' .
            $chooserJsObject .
            '.setElementLabel(teaserItemTitle);
                ' .
            $chooserJsObject .
            '.close();
            }
        ';
        return $js;
    }

    /**
     * Prepare pages collection
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareCollection()
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns for pages grid
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('chooser_id', [
            'header' => __('ID'),
            'index' => 'teaser_item_id',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id'
        ]);

        $this->addColumn('chooser_title', [
            'header' => __('Title'),
            'index' => 'title',
            'header_css_class' => 'col-title',
            'column_css_class' => 'col-title'
        ]);

        return parent::_prepareColumns();
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('teaser/teaserItem_widget/chooser', ['_current' => true]);
    }
}
