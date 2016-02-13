<?php
/**
 * Image.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Model\TeaserItem;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Reflection\Test\Unit\DataObject;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Image
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model\TeaserItem
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Image extends DataObject
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Image constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param Filesystem            $filesystem
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Filesystem $filesystem
    ) {
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
    }

    /**
     * getImageUrl
     *
     * @param TeaserItemInterface $teaserItem
     *
     * @return string
     */
    public function getImageUrl(TeaserItemInterface $teaserItem)
    {
        return $this->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
        . TeaserItemInterface::TEASER_ITEM_IMAGE_PATH
        . '/' . $teaserItem->getImagePath();
    }

    /**
     * getImagePath
     *
     * @param TeaserItemInterface $teaserItem
     *
     * @return string
     */
    public function getImagePath(TeaserItemInterface $teaserItem)
    {
        return implode(DIRECTORY_SEPARATOR, [
            BP,
            $this->filesystem->getUri('media'),
            TeaserItemInterface::TEASER_ITEM_IMAGE_PATH,
            $teaserItem->getImagePath()
        ]);
    }

    /**
     * getStore
     *
     * @return Store
     */
    protected function getStore()
    {
        return $this->storeManager->getStore();
    }
}
