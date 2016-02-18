<?php
/**
 * MassDelete.php
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

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup as TeaserGroupController;
use DavidVerholen\Teaser\Model\TeaserGroup;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassDelete
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class MassDelete extends TeaserGroupController
{
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $collection = $this->getFilteredCollection();

        /** @var \DavidVerholen\Teaser\Model\TeaserGroup $teaserGroup */
        foreach ($collection as $teaserGroup) {
            $teaserGroup->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
