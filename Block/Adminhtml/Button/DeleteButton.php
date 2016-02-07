<?php
/**
 * DeleteButton.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Block\Adminhtml\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

/**
 * Class DeleteButton
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Block\Adminhtml\Edit
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class DeleteButton extends GenericButton
{
    /**
     * DeleteButton constructor.
     *
     * @param Context  $context
     * @param Registry $registry
     * @param          $registryIdKey
     * @param string   $requestIdParam
     * @param string   $deleteAction
     * @param array    $buttonData
     */
    public function __construct(
        Context $context,
        Registry $registry,
        $registryIdKey,
        $requestIdParam = 'id',
        $deleteAction = '*/*/delete',
        array $buttonData = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $registryIdKey,
            $buttonData
        );

        $this->buttonData['data_attribute'] = [
            'url' => $this->getDeleteUrl($deleteAction, $requestIdParam)
        ];
    }

    /**
     * @param $deleteAction
     * @param $requestIdParam
     *
     * @return string
     */
    public function getDeleteUrl($deleteAction, $requestIdParam)
    {
        return $this->getUrl($deleteAction, [$requestIdParam => $this->getId()]);
    }
}
