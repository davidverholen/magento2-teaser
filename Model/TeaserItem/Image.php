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
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;
use DavidVerholen\Teaser\Model\TeaserItem;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\DataObject;
use Magento\MediaStorage\Model\File\Uploader;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

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
    const TEASER_ITEM_IMAGE_URL_PATH = 'teaser/item';
    const TEASER_ITEM_IMAGE_PATH = 'teaser' . DIRECTORY_SEPARATOR . 'item';

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var UploaderFactory
     */
    protected $fileUploaderFactory;

    /**
     * Image constructor.
     *
     * @param LoggerInterface       $logger
     * @param UploaderFactory       $fileUploaderFactory
     * @param StoreManagerInterface $storeManager
     * @param Filesystem            $filesystem
     */
    public function __construct(
        LoggerInterface $logger,
        UploaderFactory $fileUploaderFactory,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem
    ) {
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        $this->logger = $logger;
        $this->fileUploaderFactory = $fileUploaderFactory;
    }

    /**
     * @param TeaserItemInterface|TeaserItem $teaserItem
     *
     * @return Image
     */
    public function afterSave(TeaserItemInterface $teaserItem)
    {
        $value = $teaserItem->getData('image_additional_data');
        if (empty($value) && empty($_FILES)) {
            return $this;
        }

        if (is_array($value) && !empty($value['delete'])) {
            $teaserItem->setData($this->getImageAttributeName(), '');
            $this->updateImageAttribute($teaserItem);
            return $this;
        }

        if (!isset($_FILES['general']['tmp_name']['image_group']['savedImage']['value'])
            || !isset($_FILES['general']['name']['image_group']['savedImage']['value'])
        ) {
            return $this;
        }

        try {
            /** @var $uploader Uploader */
            $uploader = $this->fileUploaderFactory->create(['fileId' => [
                'tmp_name' => $_FILES['general']['tmp_name']['image_group']['savedImage']['value'],
                'name' => $_FILES['general']['name']['image_group']['savedImage']['value']
            ]]);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $uploader->setAllowRenameFiles(true);
            $result = $uploader->save($this->getImageDirPath());
            $teaserItem->setData($this->getImageAttributeName(), $result['file']);
            $this->updateImageAttribute($teaserItem);
        } catch (\Exception $e) {
            if ($e->getCode() != Uploader::TMP_NAME_EMPTY) {
                $this->logger->critical($e);
            }
        }

        return $this;
    }

    /**
     * @param TeaserItemInterface|TeaserItem $teaserItem
     *
     * @return int
     */
    protected function updateImageAttribute(TeaserItemInterface $teaserItem)
    {
        return $teaserItem->getResource()->getConnection()->update(
            TeaserItemResource::TABLE_NAME,
            [$this->getImageAttributeName() => $teaserItem->getData($this->getImageAttributeName())],
            [TeaserItemInterface::TEASER_ITEM_ID . '=?' => $teaserItem->getId()]
        );
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
        return implode('/', [
            rtrim($this->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA), '/'),
            static::TEASER_ITEM_IMAGE_URL_PATH,
            $teaserItem->getImagePath()
        ]);
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
            $this->getImageDirPath(),
            $teaserItem->getImagePath()
        ]);
    }

    /**
     * @return string
     */
    public function getImageDirPath()
    {
        return implode(DIRECTORY_SEPARATOR, [
            BP,
            $this->filesystem->getUri('media'),
            static::TEASER_ITEM_IMAGE_PATH
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

    /**
     * @return string
     */
    protected function getImageAttributeName()
    {
        return TeaserItemInterface::IMAGE_PATH;
    }
}
