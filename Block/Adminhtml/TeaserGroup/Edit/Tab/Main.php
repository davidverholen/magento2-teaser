<?php

namespace DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup\Edit\Tab;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Controller\RegistryConstants;
use DavidVerholen\Teaser\Model\TeaserGroup;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab;
use Magento\Backend\Block\Widget\Form;

class Main extends Generic
{
    /**
     * @return Form
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /** @var TeaserGroup $model */
        $model = $this->_coreRegistry->registry(RegistryConstants::CURRENT_TEASER_GROUP);

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setData('html_id_prefix', 'teasergroup_');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('General Information')
        ]);

        if ($model->getId()) {
            $fieldset->addField(TeaserGroupInterface::TEASER_GROUP_ID, 'hidden', [
                'name' => TeaserGroupInterface::TEASER_GROUP_ID
            ]);
        }

        $fieldset->addField(TeaserGroupInterface::TITLE, 'text', [
            'name' => TeaserGroupInterface::TITLE,
            'label' => __('Title'),
            'title' => __('Title'),
            'required' => true
        ]);

        $fieldset->addField(TeaserGroupInterface::CSS_CLASS, 'text', [
            'name' => TeaserGroupInterface::CSS_CLASS,
            'label' => __('Css Class'),
            'title' => __('Css Class'),
            'required' => false
        ]);

        $fieldset->addField(TeaserGroupInterface::IS_ACTIVE, 'select', [
            'label' => __('Status'),
            'title' => __('Status'),
            'name' => TeaserGroupInterface::IS_ACTIVE,
            'required' => true,
            'options' => $model->getResource()->getAvailableStatuses()
        ]);

        if (!$model->getId()) {
            $model->setData(TeaserGroupInterface::IS_ACTIVE, '1');
        }

        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
