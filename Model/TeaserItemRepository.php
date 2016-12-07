<?php
/**
 * TeaserItemRepository.php
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

use DavidVerholen\Teaser\Api\Data;
use DavidVerholen\Teaser\Api\TeaserItemRepositoryInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\CollectionFactory as TeaserItemCollectionFactory;
use DavidVerholen\Teaser\Model\TeaserItemFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Reflection\DataObjectProcessor;

/**
 * Class TeaserItemRepository
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserItemRepository implements TeaserItemRepositoryInterface
{
    /**
     * @var TeaserItemResource
     */
    protected $resource;

    /**
     * @var TeaserItemCollectionFactory
     */
    protected $teaserItemCollectionFactory;

    /**
     * @var Data\TeaserItemSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var Data\TeaserItemInterfaceFactory
     */
    protected $teaserItemFactory;

    /**
     * @var Data\TeaserItemInterface[]
     */
    protected $instances = [];

    /**
     * TeaserItemRepository constructor.
     *
     * @param TeaserItemResource                          $resource
     * @param TeaserItemCollectionFactory                 $teaserItemCollectionFactory
     * @param Data\TeaserItemSearchResultInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper                            $dataObjectHelper
     * @param DataObjectProcessor                         $dataObjectProcessor
     * @param Data\TeaserItemInterfaceFactory             $teaserItemFactory
     */
    public function __construct(
        TeaserItemResource $resource,
        TeaserItemCollectionFactory $teaserItemCollectionFactory,
        Data\TeaserItemSearchResultInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        Data\TeaserItemInterfaceFactory $teaserItemFactory
    ) {
        $this->resource = $resource;
        $this->teaserItemCollectionFactory = $teaserItemCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->teaserItemFactory = $teaserItemFactory;
    }

    /**
     * Save teaserItem.
     *
     * @param Data\TeaserItemInterface $teaserItem
     *
     * @return Data\TeaserItemInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(Data\TeaserItemInterface $teaserItem)
    {
        if (false === ($teaserItem instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('Invalid Model'));
        }

        /** @var AbstractModel $teaserItem */
        try {
            $this->resource->save($teaserItem);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $teaserItem;
    }

    /**
     * Retrieve teaserItem.
     *
     * @param int $teaserItemId
     *
     * @return Data\TeaserItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($teaserItemId)
    {
        if (false === array_key_exists($teaserItemId, $this->instances)) {
            /** @var TeaserItem $teaserItem */
            $teaserItem = $this->teaserItemFactory->create();
            $this->resource->load($teaserItem, $teaserItemId);
            if (!$teaserItem->getId()) {
                throw new NoSuchEntityException(__('Teaser Item with id "%1" does not exist.', $teaserItemId));
            }

            $this->instances[$teaserItemId] = $teaserItem;
        }


        return $this->instances[$teaserItemId];
    }

    /**
     * Retrieve teaserItems matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return Data\TeaserItemSearchResultInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Data\TeaserItemSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var TeaserItemResource\Collection $collection */
        $collection = $this->teaserItemCollectionFactory->create();

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();

        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $teaserItems = [];
        /** @var TeaserItem $teaserItemModel */
        foreach ($collection as $teaserItemModel) {
            $teaserItemData = $this->teaserItemFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $teaserItemData,
                $teaserItemModel->getData(),
                Data\TeaserItemInterface::class
            );

            $teaserItems[] = $this->dataObjectProcessor->buildOutputDataArray(
                $teaserItemData,
                Data\TeaserItemInterface::class
            );
        }

        $searchResults->setItems($teaserItems);

        return $searchResults;
    }

    /**
     * Delete teaserItem.
     *
     * @param Data\TeaserItemInterface $teaserItem
     *
     * @return bool true on success
     *
     * @throws CouldNotDeleteException
     */
    public function delete(Data\TeaserItemInterface $teaserItem)
    {
        if (false === ($teaserItem instanceof AbstractModel)) {
            throw new CouldNotDeleteException(__('Invalid Model'));
        }

        /** @var AbstractModel $teaserItem */
        try {
            $this->resource->delete($teaserItem);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete teaserItem by ID.
     *
     * @param int $teaserItemId
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($teaserItemId)
    {
        return $this->delete($this->getById($teaserItemId));
    }
}
