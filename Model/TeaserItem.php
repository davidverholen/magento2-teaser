<?php
/**
 * TeaserItem.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Model;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\Collection;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;
use DavidVerholen\Teaser\Model\TeaserItem\Image;
use Magento\Cms\Model\Block;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

/**
 * Class TeaserItem
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserItem extends AbstractModel implements TeaserItemInterface
{
    /**
     * cache tag
     */
    const CACHE_TAG = 'teaser_item';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'teaser_item';

    /**
     * @var Image
     */
    protected $imageAttributeModel;

    /**
     * @var BlockFactory
     */
    protected $cmsBlockFactory;

    /**
     * TeaserItem constructor.
     *
     * @param Context            $context
     * @param Registry           $registry
     * @param TeaserItemResource $resource
     * @param Collection         $resourceCollection
     * @param Image              $imageAttributeModel
     * @param BlockFactory       $cmsBlockFactory
     * @param array              $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ResourceModel\TeaserItem $resource,
        Collection $resourceCollection,
        Image $imageAttributeModel,
        BlockFactory $cmsBlockFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->imageAttributeModel = $imageAttributeModel;
        $this->cmsBlockFactory = $cmsBlockFactory;
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TeaserItemResource::class);
    }

    /**
     * @return Block
     */
    public function getCmsBlockModel()
    {
        if (false === $this->hasData('cms_block_model') && false === empty($this->getCmsBlockIdentifier())) {
            /** @var Block $model */
            $model = $this->cmsBlockFactory->create();

            if ($this->getCmsBlockIdentifier()) {
                $model->load($this->getCmsBlockIdentifier(), 'identifier');
            }

            $this->setData('cms_block_model', $model);
        }

        return $this->getData('cms_block_model');
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageAttributeModel->getImageUrl($this, TeaserItemInterface::IMAGE_PATH);
    }

    /**
     * @return string
     */
    public function getMobileImageUrl()
    {
        return $this->imageAttributeModel->getImageUrl($this, TeaserItemInterface::MOBILE_IMAGE_PATH);
    }

    /**
     * @return $this
     */
    public function afterSave()
    {
        parent::afterSave();
        $this->imageAttributeModel->afterSave($this, 'image_group', TeaserItemInterface::IMAGE_PATH);
        $this->imageAttributeModel->afterSave($this, 'mobile_image_group', TeaserItemInterface::MOBILE_IMAGE_PATH);

        return $this;
    }


    /**
     * getTitle
     *
     * @return string
     */
    public function getTitle()
    {
        return (string)$this->getData(static::TITLE);
    }

    /**
     * getCssClass
     *
     * @return string
     */
    public function getCssClass()
    {
        return (string)$this->getData(static::CSS_CLASS);
    }

    /**
     * getCmsBlockIdentifier
     *
     * @return string
     */
    public function getCmsBlockIdentifier()
    {
        return (string)$this->getData(static::CMS_BLOCK_IDENTIFIER);
    }

    /**
     * getImagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return (string)$this->getData(static::IMAGE_PATH);
    }

    /**
     * getMobileImagePath
     *
     * @return string
     */
    public function getMobileImagePath()
    {
        return (string)$this->getData(static::MOBILE_IMAGE_PATH);
    }

    /**
     * getRenderer
     *
     * @return string
     */
    public function getRenderer()
    {
        return (string)$this->getData(static::RENDERER);
    }

    /**
     * getIsActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return (boolean)$this->getData(static::IS_ACTIVE);
    }

    /**
     * getModifiedDate
     *
     * @return string
     */
    public function getModifiedDate()
    {
        return (string)$this->getData(static::MODIFIED_DATE);
    }

    /**
     * getCreationDate
     *
     * @return string
     */
    public function getCreationDate()
    {
        return (string)$this->getData(static::CREATION_DATE);
    }

    /**
     * setTitle
     *
     * @param string $title
     *
     * @return TeaserItemInterface
     */
    public function setTitle($title)
    {
        return $this->setData(static::TITLE, $title);
    }

    /**
     * setCssClass
     *
     * @param string $cssClass
     *
     * @return TeaserItemInterface
     */
    public function setCssClass($cssClass)
    {
        return $this->setData(static::CSS_CLASS, $cssClass);
    }

    /**
     * setCmsBlockIdentifier
     *
     * @param string $cmsBlockIdentifier
     *
     * @return TeaserItemInterface
     */
    public function setCmsBlockIdentifier($cmsBlockIdentifier)
    {
        return $this->setData(static::CMS_BLOCK_IDENTIFIER, $cmsBlockIdentifier);
    }

    /**
     * setImagePath
     *
     * @param string $imagePath
     *
     * @return TeaserItemInterface
     */
    public function setImagePath($imagePath)
    {
        return $this->setData(static::IMAGE_PATH, $imagePath);
    }

    /**
     * setMobileImagePath
     *
     * @param string $mobileImagePath
     *
     * @return TeaserItemInterface
     */
    public function setMobileImagePath($mobileImagePath)
    {
        return $this->setData(static::MOBILE_IMAGE_PATH, $mobileImagePath);
    }

    /**
     * setRenderer
     *
     * @param string $renderer
     *
     * @return TeaserItemInterface
     */
    public function setRenderer($renderer)
    {
        return $this->setData(static::RENDERER, $renderer);
    }

    /**
     * setIsActive
     *
     * @param boolean $isActive
     *
     * @return TeaserItemInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(static::IS_ACTIVE, $isActive);
    }

    /**
     * setModifiedDate
     *
     * @param string $modifiedDate
     *
     * @return TeaserItemInterface
     */
    public function setModifiedDate($modifiedDate)
    {
        return $this->setData(static::MODIFIED_DATE, $modifiedDate);
    }

    /**
     * setCreationDate
     *
     * @param string $creationDate
     *
     * @return TeaserItemInterface
     */
    public function setCreationDate($creationDate)
    {
        return $this->setData(static::CREATION_DATE, $creationDate);
    }
}
