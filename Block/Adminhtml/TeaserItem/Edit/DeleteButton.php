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

namespace DavidVerholen\Teaser\Block\Adminhtml\TeaserItem\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Block\Adminhtml\Edit
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $teaserItemId = $this->getTeaserItemId();

        if (!$teaserItemId) {
            return [];
        }

        return [
            'label'          => __('Delete Teaser Item'),
            'class'          => 'delete',
            'id'             => 'teaser-item-delete-button',
            'data_attribute' => [
                'url' => $this->getDeleteUrl()
            ],
            'on_click'       => '',
            'sort_order'     => 20,
        ];
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getTeaserItemId()]);
    }
}
