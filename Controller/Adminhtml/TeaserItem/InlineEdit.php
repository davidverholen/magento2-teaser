<?php
/**
 * InlineEdit.php
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

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem as TeaserItemController;
use DavidVerholen\Teaser\Model\TeaserItem;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class InlineEdit
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class InlineEdit extends TeaserItemController
{
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);

            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $teaserItemId) {
                    /** @var TeaserItem $teaserItem */
                    $teaserItem = $this->teaserItemRepository->getById($teaserItemId);
                    try {
                        $teaserItem->setData(array_merge(
                            $teaserItem->getData(),
                            $postItems[$teaserItemId]
                        ));

                        $this->teaserItemRepository->save($teaserItem);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithTeaserItemId(
                            $teaserItem,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error'    => $error
        ]);
    }

    /**
     * Add block title to error message
     *
     * @param TeaserItemInterface $teaserItem
     * @param string              $errorText
     *
     * @return string
     */
    protected function getErrorWithTeaserItemId(
        TeaserItemInterface $teaserItem,
        $errorText
    ) {
        return '[Teaser Item ID: ' . $teaserItem->getId() . '] ' . $errorText;
    }
}
