<?php
/**
 * Save.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Save
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Save extends TeaserItem
{
    const GENERAL_DATA_KEY = 'general';
    const DISPLAY_DATA_KEY = 'display';

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $post = $this->getRequest()->getParams();

        if (false === isset($post[static::GENERAL_DATA_KEY]) || false === isset($post[static::DISPLAY_DATA_KEY])) {
            return $resultRedirect->setPath('*/*/');
        }

        $data = $this->imagePreprocessing($post[static::GENERAL_DATA_KEY], 'image_group');
        $data = $this->imagePreprocessing($data, 'mobile_image_group');
        $data = array_merge($data, $post[static::DISPLAY_DATA_KEY]);

        $id = $this->getRequest()->getParam('id', null);

        /** @var \DavidVerholen\Teaser\Model\TeaserItem $teaserItem */
        $teaserItem = $this->teaserItemBuilder->build($id);

        if ($id && !$teaserItem->getId()) {
            $this->messageManager->addError(__('This Teaser Item no longer exists.'));
            return $resultRedirect->setPath('*/*/');
        }

        $teaserItem->setData($data);

        try {
            $this->teaserItemRepository->save($teaserItem);
            $this->messageManager->addSuccess(__('You saved the Teaser Item.'));
            $this->_session->setFormData(false);
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_session->setFormData($data);

            return $resultRedirect->setPath(
                '*/*/edit',
                ['id' => $this->getRequest()->getParam('id')]
            );
        }

        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath(
                '*/*/edit',
                ['id' => $teaserItem->getId()]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Image data preprocessing
     *
     * @param array $data
     *
     * @param       $imageFieldName
     *
     * @return array
     */
    public function imagePreprocessing($data, $imageFieldName)
    {
        if (isset($data[$imageFieldName]) && is_array($data[$imageFieldName])) {
            if (isset($data[$imageFieldName]['savedImage']['delete'])) {
                $delete = $data[$imageFieldName]['savedImage']['delete'];
                $data[$imageFieldName]['delete'] = filter_var($delete, FILTER_VALIDATE_BOOLEAN);
            }
            if (isset($_FILES[static::GENERAL_DATA_KEY]['name'][$imageFieldName])) {
                $imageGroupName = $_FILES[static::GENERAL_DATA_KEY]['name'][$imageFieldName];
                $data[$imageFieldName]['value'] = $imageGroupName['savedImage']['value'];
            }
            $data['image_additional_data'][$imageFieldName] = $data[$imageFieldName];
            unset($data[$imageFieldName]);
        }

        return $data;
    }
}
