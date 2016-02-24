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
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getParams();
        $generalData = $this->imagePreprocessing($data['general']);

        if (!$generalData) {
            return $resultRedirect->setPath('*/*/');
        }

        $id = $this->getRequest()->getParam('id', null);

        /** @var \DavidVerholen\Teaser\Model\TeaserItem $teaserItem */
        $teaserItem = $this->teaserItemBuilder->build($id);

        if ($id && !$teaserItem->getId()) {
            $this->messageManager->addError(__('This Teaser Item no longer exists.'));
            return $resultRedirect->setPath('*/*/');
        }

        $teaserItem->setData($generalData);

        try {
            $this->teaserItemRepository->save($teaserItem);
            $this->messageManager->addSuccess(__('You saved the Teaser Item.'));
            $this->_session->setFormData(false);
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_session->setFormData($generalData);

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
     * @return array
     */
    public function imagePreprocessing($data)
    {
        if (isset($data['image_group']) && is_array($data['image_group'])) {
            if (isset($data['image_group']['savedImage']['delete'])) {
                $delete = $data['image_group']['savedImage']['delete'];
                $data['image_group']['delete'] = filter_var($delete, FILTER_VALIDATE_BOOLEAN);
            }
            if (isset($_FILES['general']['name']['image_group'])) {
                $imageGroupName = $_FILES['general']['name']['image_group'];
                $data['image_group']['value'] = $imageGroupName['savedImage']['value'];
            }
            $data['image_additional_data'] = $data['image_group'];
            unset($data['image_group']);
        }

        return $data;
    }
}
