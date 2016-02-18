<?php
/**
 * TeaserGroup.php
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

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup as TeaserGroupResource;
use Magento\Framework\Model\AbstractModel;

/**
 * Class TeaserGroup
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserGroup extends AbstractModel implements TeaserGroupInterface
{
    /**
     * cache tag
     */
    const CACHE_TAG = 'teaser_group';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'teaser_group';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TeaserGroupResource::class);
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
     * @return TeaserGroupInterface
     */
    public function setTitle($title)
    {
        return $this->setData(static::TITLE, $title);
    }

    /**
     * setIsActive
     *
     * @param boolean $isActive
     *
     * @return TeaserGroupInterface
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
     * @return TeaserGroupInterface
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
     * @return TeaserGroupInterface
     */
    public function setCreationDate($creationDate)
    {
        return $this->setData(static::CREATION_DATE, $creationDate);
    }
}
