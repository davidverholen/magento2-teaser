<?php
/**
 * TeaserGroupRepository.php
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
use DavidVerholen\Teaser\Api\TeaserGroupRepositoryInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup as TeaserGroupResource;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup\CollectionFactory as TeaserGroupCollectionFactory;
use DavidVerholen\Teaser\Model\TeaserGroupFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Reflection\DataObjectProcessor;

/**
 * Class TeaserGroupRepository
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Model
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserGroupRepository implements TeaserGroupRepositoryInterface
{
    /**
     * @var TeaserGroupResource
     */
    protected $resource;

    /**
     * @var TeaserGroupCollectionFactory
     */
    protected $teaserGroupCollectionFactory;

    /**
     * @var Data\TeaserGroupSearchResultInterfaceFactory
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
     * @var Data\TeaserGroupInterfaceFactory
     */
    protected $teaserGroupFactory;

    /**
     * @var Data\TeaserGroupInterface[]
     */
    protected $instances;

    /**
     * TeaserGroupRepository constructor.
     *
     * @param TeaserGroupResource                          $resource
     * @param TeaserGroupCollectionFactory                 $teaserGroupCollectionFactory
     * @param Data\TeaserGroupSearchResultInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper                             $dataObjectHelper
     * @param DataObjectProcessor                          $dataObjectProcessor
     * @param Data\TeaserGroupInterfaceFactory             $teaserGroupFactory
     */
    public function __construct(
        TeaserGroupResource $resource,
        TeaserGroupCollectionFactory $teaserGroupCollectionFactory,
        Data\TeaserGroupSearchResultInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        Data\TeaserGroupInterfaceFactory $teaserGroupFactory
    ) {
        $this->resource = $resource;
        $this->teaserGroupCollectionFactory = $teaserGroupCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->teaserGroupFactory = $teaserGroupFactory;
    }

    /**
     * Save teaserGroup.
     *
     * @param Data\TeaserGroupInterface $teaserGroup
     *
     * @return Data\TeaserGroupInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(Data\TeaserGroupInterface $teaserGroup)
    {
        if (false === ($teaserGroup instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('Invalid Model'));
        }

        /** @var AbstractModel $teaserGroup */
        try {
            $this->resource->save($teaserGroup);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $teaserGroup;
    }

    /**
     * Retrieve teaserGroup.
     *
     * @param int $teaserGroupId
     *
     * @return Data\TeaserGroupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($teaserGroupId)
    {
        if (false === array_key_exists($teaserGroupId, $this->instances)) {
            /** @var TeaserGroup $teaserGroup */
            $teaserGroup = $this->teaserGroupFactory->create();
            $this->resource->load($teaserGroup, $teaserGroupId);
            if (!$teaserGroup->getId()) {
                throw new NoSuchEntityException(__('Teaser Group with id "%1" does not exist.', $teaserGroupId));
            }

            $this->instances[$teaserGroupId] = $teaserGroup;
        }

        return $this->instances[$teaserGroupId];
    }

    /**
     * Retrieve teaserGroups matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return Data\TeaserGroupSearchResultInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Data\TeaserGroupSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var TeaserGroupResource\Collection $collection */
        $collection = $this->teaserGroupCollectionFactory->create();

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
        $teaserGroups = [];
        /** @var TeaserGroup $teaserGroupModel */
        foreach ($collection as $teaserGroupModel) {
            $teaserGroupData = $this->teaserGroupFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $teaserGroupData,
                $teaserGroupModel->getData(),
                Data\TeaserGroupInterface::class
            );

            $teaserGroups[] = $this->dataObjectProcessor->buildOutputDataArray(
                $teaserGroupData,
                Data\TeaserGroupInterface::class
            );
        }

        $searchResults->setItems($teaserGroups);

        return $searchResults;
    }

    /**
     * Delete teaserGroup.
     *
     * @param Data\TeaserGroupInterface $teaserGroup
     *
     * @return bool true on success
     *
     * @throws CouldNotDeleteException
     */
    public function delete(Data\TeaserGroupInterface $teaserGroup)
    {
        if (false === ($teaserGroup instanceof AbstractModel)) {
            throw new CouldNotDeleteException(__('Invalid Model'));
        }

        /** @var AbstractModel $teaserGroup */
        try {
            $this->resource->delete($teaserGroup);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete teaserGroup by ID.
     *
     * @param int $teaserGroupId
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($teaserGroupId)
    {
        return $this->delete($this->getById($teaserGroupId));
    }
}
