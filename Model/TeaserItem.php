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
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;
use Magento\Framework\Model\AbstractModel;

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
     * CMS block cache tag
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
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TeaserItemResource::class);
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
