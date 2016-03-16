<?php
/**
 * Created by PhpStorm.
 * User: davidverholen
 * Date: 08.12.15
 * Time: 17:57
 */

namespace DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup\Edit;

use DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup\Edit\Tab\Main;
use DavidVerholen\Teaser\Controller\RegistryConstants;
use DavidVerholen\Teaser\Model\TeaserGroup;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Tabs as WidgetTabs;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Registry;
use Magento\Framework\Translate\InlineInterface;

class Tabs extends WidgetTabs
{
    /**
     * @var InlineInterface
     */
    protected $translateInline;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Tabs constructor.
     *
     * @param Context          $context
     * @param EncoderInterface $jsonEncoder
     * @param Session          $authSession
     * @param InlineInterface  $translateInline
     * @param Registry         $registry
     * @param array            $data
     */
    public function __construct(
        Context $context,
        EncoderInterface $jsonEncoder,
        Session $authSession,
        InlineInterface $translateInline,
        Registry $registry,
        array $data
    ) {
        parent::__construct($context, $jsonEncoder, $authSession, $data);
        $this->translateInline = $translateInline;
        $this->registry = $registry;
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('teaser_group_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Teaser Group'));
    }

    /**
     * @return $this
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        $this->addTab('main', [
            'label' => __('General Information'),
            'content' => $this->_translateHtml($this->getLayout()->createBlock(Main::class)->toHtml())
        ]);

        $this->addTab('teaser_items', [
            'label' => __('Teaser Items'),
            'url' => $this->getUrl('*/*/teaserItems', ['_current' => true]),
            'class' => 'ajax'
        ]);

        return parent::_prepareLayout();
    }

    /**
     * Translate html content
     *
     * @param string $html
     * @return string
     */
    protected function _translateHtml($html)
    {
        $this->translateInline->processResponseBody($html);
        return $html;
    }

    /**
     * @return TeaserGroup
     */
    protected function getTeaserGroup()
    {
        return $this->registry->registry(RegistryConstants::CURRENT_TEASER_GROUP);
    }
}
