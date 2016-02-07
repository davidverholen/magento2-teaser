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
use Magento\Framework\App\ResponseInterface;
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
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $generalData = $this->getRequest()->getParam('general');

        if ($generalData) {
            $id = $this->getRequest()->getParam('id', false);
            $teaserItem = $this->teaserItemFactory->create();

            if (false !== $id) {
                $teaserItem->load($id);

                if (!$teaserItem->getId()) {
                    $this->messageManager->addError(__('This Teaser Item no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $teaserItem->setData($generalData);
            try {
                $this->teaserItemRepository->save($this->uploadTeaserItemImage($teaserItem));
                $this->messageManager->addSuccess(__('You saved the Teaser Item.'));
                $this->_session->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['id' => $teaserItem->getId()]
                    );
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_session->setFormData($generalData);

                return $resultRedirect->setPath(
                    '*/*/edit',
                    ['id' => $this->getRequest()->getParam('id')]
                );
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
