<?php
namespace DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup\Widget;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup\Collection;
use DavidVerholen\Teaser\Model\TeaserGroupFactory;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup\CollectionFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Chooser extends Extended
{
    /**
     * @var TeaserGroupFactory
     */
    protected $teaserGroupFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Chooser constructor.
     *
     * @param TeaserGroupFactory $teaserGroupFactory
     * @param CollectionFactory  $collectionFactory
     * @param Context            $context
     * @param Data               $backendHelper
     * @param array              $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        TeaserGroupFactory $teaserGroupFactory,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $backendHelper, $data);
        $this->teaserGroupFactory = $teaserGroupFactory;
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
        $sourceUrl = $this->getUrl('teaser/teasergroup_widget/chooser', ['unique_id' => $uniqueId]);

        /** @var \Magento\Widget\Block\Adminhtml\Widget\Chooser $chooser */
        $chooser = $this->getLayout()->createBlock(\Magento\Widget\Block\Adminhtml\Widget\Chooser::class);
        $chooser->setElement($element)
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqueId);

        if ($element->getValue()) {
            /** @var TeaserGroupInterface $teaserGroup */
            $teaserGroup = $this->teaserGroupFactory->create()->load((int)$element->getValue());
            if ($teaserGroup->getId()) {
                $chooser->setLabel($this->escapeHtml($teaserGroup->getTitle()));
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
                var teaserGroupTitle = trElement.down("td").next().innerHTML;
                var teaserGroupId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                ' .
            $chooserJsObject .
            '.setElementValue(teaserGroupId);
                ' .
            $chooserJsObject .
            '.setElementLabel(teaserGroupTitle);
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
            'index' => 'teaser_group_id',
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
        return $this->getUrl('teaser/teaserGroup_widget/chooser', ['_current' => true]);
    }
}