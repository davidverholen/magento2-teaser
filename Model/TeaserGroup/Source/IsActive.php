<?php
/**
 * IsActive.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Model\TeaserGroup\Source;

use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model\Block\Source
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var TeaserGroup
     */
    protected $teaserGroup;

    /**
     * @var array
     */
    protected static $options;

    /**
     * Constructor
     *
     * @param TeaserGroup $teaserGroup
     */
    public function __construct(TeaserGroup $teaserGroup)
    {
        $this->teaserGroup = $teaserGroup;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (null === self::$options) {
            $availableOptions = $this->teaserGroup->getAvailableStatuses();
            self::$options = [];
            foreach ($availableOptions as $key => $value) {
                self::$options[] = [
                    'label' => $value,
                    'value' => $key,
                ];
            }
        }

        return self::$options;
    }
}
