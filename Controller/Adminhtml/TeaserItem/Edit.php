<?php
/**
 * Edit.php
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
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Edit
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Edit extends TeaserItem
{
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $teaserItemId = $this->getRequest()->getParam('id', false);

        /** @var \DavidVerholen\Teaser\Model\TeaserItem $teaserItem */
        $teaserItem = $this->teaserItemBuilder->build((int)$teaserItemId);

        if (false !== $teaserItemId && !$teaserItem->getId()) {
            $this->messageManager->addError(__('This Teaser Item no longer exists.'));
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

            return $resultRedirect->setPath('*/*/');
        }

        $data = $this->_session->getData('form_data', true);
        if(!empty($data)) {
            $teaserItem->setData($data);
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $this->initPage($resultPage)->addBreadcrumb(
            $teaserItem->getId() ? __('Edit Teaser Item') : __('New Teaser Item'),
            $teaserItem->getId() ? __('Edit Teaser Item') : __('New Teaser Item')
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Teaser Items'));
        $resultPage->getConfig()->getTitle()->prepend(
            $teaserItem->getId() ? $teaserItem->getTitle() : __('New Teaser Item')
        );

        return $resultPage;
    }
}
