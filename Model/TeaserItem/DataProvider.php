<?php
/**
 * DataProvider.php
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

use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\CollectionFactory as TeaserItemCollectionFactory;
use DavidVerholen\Teaser\Model\TeaserItem;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProviderInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model\TeaserItem
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class DataProvider extends AbstractDataProvider implements DataProviderInterface
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var Image
     */
    protected $imageModel;

    /**
     * DataProvider constructor.
     *
     * @param string                      $name
     * @param string                      $primaryFieldName
     * @param string                      $requestFieldName
     * @param TeaserItemCollectionFactory $teaserItemCollectionFactory
     * @param Image                       $imageModel
     * @param array                       $meta
     * @param array                       $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        TeaserItemCollectionFactory $teaserItemCollectionFactory,
        Image $imageModel,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );

        $this->collection = $teaserItemCollectionFactory->create();
        $this->imageModel = $imageModel;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var TeaserItem $teaserItem */
        foreach ($items as $teaserItem) {
            $result['general'] = $teaserItem->getData();
            $result['general']['image_url'] = $this->imageModel->getImageUrl($teaserItem);
            $result['general']['image_path_abs'] = $this->imageModel->getImagePath($teaserItem);
            $this->loadedData[$teaserItem->getId()] = $result;
        }

        return $this->loadedData;
    }
}
