<?php
/**
 * Created by PhpStorm.
 * User: davidverholen
 * Date: 08.12.15
 * Time: 12:23
 */

namespace DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Controller\RegistryConstants;
use DavidVerholen\Teaser\Model\TeaserGroup;
use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * @param Context  $context
     * @param Registry $registry
     * @param array    $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = TeaserGroupInterface::TEASER_GROUP_ID;
        $this->_blockGroup = 'DavidVerholen_Teaser';
        $this->_controller = 'adminhtml_teaserGroup';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save Teaser Group'));

        if (false === $this->isNew()) {
            $this->buttonList->add('delete', [
                'label'          => __('Delete'),
                'class'          => 'delete',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event'  => 'delete',
                            'target' => '#edit_form'
                        ]
                    ],
                ]
            ]);
        }

        $this->buttonList->add('saveandcontinue', [
            'label'          => __('Save and Continue Edit'),
            'class'          => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => [
                        'event'  => 'saveAndContinueEdit',
                        'target' => '#edit_form'
                    ]
                ],
            ]
        ], -100);
        $this->_formScripts[]
            = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }
        ";
    }

    /**
     * Get edit form container header text
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->isNew()) {
            return __('New Teaser Group');
        } else {
            return __("Edit Teaser Group '%1'", $this->escapeHtml(
                $this->getTeaserGroup()->getTitle()
            ));
        }
    }

    /**
     * isNew
     *
     * @return bool
     */
    protected function isNew()
    {
        return !(bool)$this->getTeaserGroup()->getId();
    }

    /**
     * getTeaserGroup
     *
     * @return TeaserGroup
     */
    protected function getTeaserGroup()
    {
        return $this->coreRegistry->registry(RegistryConstants::CURRENT_TEASER_GROUP);
    }

    /**
     * Retrieve the save and continue edit Url.
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            'teaser/teaserGroup/save',
            ['_current' => true, 'back' => 'edit', 'tab' => '{{tab_id}}']
        );
    }
}
