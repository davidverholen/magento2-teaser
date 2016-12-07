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

namespace DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup as TeaserGroupController;
use DavidVerholen\Teaser\Model\TeaserGroup;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class InlineEdit
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class InlineEdit extends TeaserGroupController
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
                foreach (array_keys($postItems) as $teaserGroupId) {
                    /** @var TeaserGroup $teaserGroup */
                    $teaserGroup = $this->teaserGroupRepository->getById($teaserGroupId);
                    try {
                        if (!isset($postItems[$teaserGroupId]['cms_block_identifier'])) {
                            $postItems[$teaserGroupId]['cms_block_identifier'] = null;
                        }
                        $teaserGroup->setData(array_merge(
                            $teaserGroup->getData(),
                            $postItems[$teaserGroupId]
                        ));

                        $this->teaserGroupRepository->save($teaserGroup);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithTeaserGroupId(
                            $teaserGroup,
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
     * @param TeaserGroupInterface $teaserGroup
     * @param string              $errorText
     *
     * @return string
     */
    protected function getErrorWithTeaserGroupId(
        TeaserGroupInterface $teaserGroup,
        $errorText
    ) {
        return '[Teaser Group ID: ' . $teaserGroup->getId() . '] ' . $errorText;
    }
}
