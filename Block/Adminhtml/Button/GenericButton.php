<?php
/**
 * GenericButton.php
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
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class GenericButton
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Block\Adminhtml\Edit
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class GenericButton implements ButtonProviderInterface
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Registry
     *
     * @var Registry
     */
    protected $registry;

    /**
     * @var array
     */
    protected $buttonData;

    /**
     * @var
     */
    protected $registryIdKey;

    /**
     * @var bool
     */
    protected $hideOnNew;

    /**
     * Constructor
     *
     * @param Context  $context
     * @param Registry $registry
     * @param          $registryIdKey
     * @param array    $buttonData
     * @param bool     $hideOnNew
     */
    public function __construct(
        Context $context,
        Registry $registry,
        $registryIdKey,
        $buttonData = [],
        $hideOnNew = false
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
        $this->buttonData = $buttonData;
        $this->registryIdKey = $registryIdKey;
        $this->hideOnNew = $hideOnNew;
    }

    /**
     * Return the Id.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->registry->registry($this->registryIdKey);
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array  $params
     *
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    /**
     * getButtonData
     *
     * @return array
     */
    public function getButtonData()
    {
        if ($this->hideOnNew && !$this->getId()) {
            return [];
        }

        return $this->buttonData;
    }
}
