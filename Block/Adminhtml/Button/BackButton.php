<?php
/**
 * BackButton.php
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
 * Class BackButton
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Block\Adminhtml\Edit
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class BackButton extends GenericButton
{
    /**
     * BackButton constructor.
     *
     * @param Context  $context
     * @param Registry $registry
     * @param          $registryIdKey
     * @param array    $backUrl
     * @param array    $buttonData
     * @param bool     $hideOnNew
     */
    public function __construct(
        Context $context,
        Registry $registry,
        $registryIdKey,
        $backUrl,
        array $buttonData = [],
        $hideOnNew = false
    ) {
        parent::__construct(
            $context,
            $registry,
            $registryIdKey,
            $buttonData,
            $hideOnNew
        );

        $this->buttonData['on_click'] = sprintf(
            "location.href = '%s';",
            $backUrl
        );
    }
}
