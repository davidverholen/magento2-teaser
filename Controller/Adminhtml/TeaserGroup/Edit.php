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

namespace DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Edit
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Edit extends TeaserGroup
{
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $teaserGroupId = $this->getRequest()->getParam('id', false);

        /** @var \DavidVerholen\Teaser\Model\TeaserGroup $teaserGroup */
        $teaserGroup = $this->teaserGroupBuilder->build((int)$teaserGroupId);

        if (false !== $teaserGroupId && !$teaserGroup->getId()) {
            $this->messageManager->addError(__('This Teaser Group no longer exists.'));
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

            return $resultRedirect->setPath('*/*/');
        }

        $data = $this->_session->getData('form_data', true);
        if (!empty($data)) {
            $teaserGroup->setData($data);
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $this->initPage($resultPage)->addBreadcrumb(
            $teaserGroup->getId() ? __('Edit Teaser Group') : __('New Teaser Group'),
            $teaserGroup->getId() ? __('Edit Teaser Group') : __('New Teaser Group')
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Teaser Groups'));
        $resultPage->getConfig()->getTitle()->prepend(
            $teaserGroup->getId() ? $teaserGroup->getTitle() : __('New Teaser Group')
        );

        return $resultPage;
    }
}
