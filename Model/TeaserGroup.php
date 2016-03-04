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
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\Collection as TeaserItemCollection;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup\Collection;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\CollectionFactory as TeaserItemCollectionFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

/**
 * Class TeaserGroup
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 *
 * @method TeaserGroupResource getResource()
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
     * @var TeaserItemCollection
     */
    protected $teaserItemsCollection;

    /**
     * @var TeaserItemCollectionFactory
     */
    protected $teaserItemCollectionFactory;

    /**
     * TeaserGroup constructor.
     *
     * @param Context                     $context
     * @param Registry                    $registry
     * @param TeaserGroupResource         $resource
     * @param Collection                  $resourceCollection
     * @param TeaserItemCollectionFactory $teaserItemCollectionFactory
     * @param array                       $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        TeaserGroupResource $resource,
        Collection $resourceCollection,
        TeaserItemCollectionFactory $teaserItemCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->teaserItemCollectionFactory = $teaserItemCollectionFactory;
    }


    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TeaserGroupResource::class);
    }

    /**
     * Teaser Items collection
     *
     * @return Collection
     */
    public function getTeaserItemsCollection()
    {
        if ($this->teaserItemsCollection === null) {
            $this->teaserItemsCollection = $this->createTeaserItemsCollection()
                ->setTeaserGroupFilter($this)
                ->setDataToAll('teaser_group', $this);
        }

        return $this->teaserItemsCollection;
    }

    /**
     * @return array
     */
    public function getTeaserItemsPosition()
    {
        if (!$this->getId()) {
            return [];
        }

        if (false === $this->hasData('teaser_items_position')) {
            $this->setData('teaser_items_position', $this->getResource()->getTeaserItemsPosition($this));
        }

        return $this->getData('teaser_items_position');
    }

    /**
     * @return TeaserItemCollection
     */
    protected function createTeaserItemsCollection()
    {
        return $this->teaserItemCollectionFactory->create();
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
