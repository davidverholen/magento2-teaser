<?php
/**
 * Block.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Model\Source\Cms;

use Magento\Cms\Model\ResourceModel\Block\Collection;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class Block
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model\Source\Cms
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Block implements ArrayInterface
{
    /**
     * @var CollectionFactory
     */
    protected $cmsBlockCollectionFactory;

    protected static $options;

    /**
     * Block constructor.
     *
     * @param CollectionFactory $cmsBlockCollectionFactory
     */
    public function __construct(CollectionFactory $cmsBlockCollectionFactory)
    {
        $this->cmsBlockCollectionFactory = $cmsBlockCollectionFactory;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @param bool $addEmptyEntry
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray($addEmptyEntry = true)
    {
        if (null === static::$options) {
            static::$options = [];
            if ($addEmptyEntry) {
                static::$options[] = [
                    'label' => __('No Cms Block ...'),
                    'value' => ''
                ];
            }
            /** @var \Magento\Cms\Model\Block $block */
            foreach ($this->getCmsBlockCollection() as $block) {
                static::$options[] = [
                    'label' => $block->getTitle(),
                    'value' => $block->getIdentifier()
                ];
            }
        }

        return static::$options;
    }

    /**
     * getCmsBlockCollection
     *
     * @return Collection
     */
    protected function getCmsBlockCollection()
    {
        return $this->cmsBlockCollectionFactory->create();
    }
}
