<?php

namespace DavidVerholen\Teaser\Test\Unit\Model;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Api\Data\TeaserItemSearchResultInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem as TeaserItemResource;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\Collection;
use DavidVerholen\Teaser\Model\TeaserItem;
use DavidVerholen\Teaser\Model\TeaserItemRepository;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;

class TeaserItemRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TeaserItemRepository
     */
    protected $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TeaserItemResource
     */
    protected $teaserItemResource;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TeaserItem
     */
    protected $teaserItem;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TeaserItemInterface
     */
    protected $teaserItemData;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TeaserItemSearchResultInterface
     */
    protected $teaserItemSearchResult;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|DataObjectHelper
     */
    protected $dataHelper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Collection
     */
    protected $collection;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|StoreManagerInterface
     */
    private $storeManager;

    /**
     * Initialize repository
     */
    public function setUp()
    {
        $this->teaserItemResource = $this->getMockBuilder(TeaserItemResource::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->dataObjectProcessor = $this->getMockBuilder(DataObjectProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teaserItemFactory = $this->getMockBuilder('DavidVerholen\Teaser\Model\TeaserItemFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $teaserItemDataFactory = $this->getMockBuilder('DavidVerholen\Teaser\Api\Data\TeaserItemInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $teaserItemSearchResultFactory = $this->getMockBuilder('DavidVerholen\Teaser\Api\Data\TeaserItemSearchResultInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $collectionFactory = $this->getMockBuilder('DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\CollectionFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->storeManager = $this->getMockBuilder(StoreManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $store = $this->getMockBuilder(StoreInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $store->expects($this->any())->method('getId')->willReturn(0);
        $this->storeManager->expects($this->any())->method('getStore')->willReturn($store);

        $this->teaserItem = $this->getMockBuilder(TeaserItem::class)->disableOriginalConstructor()->getMock();
        $this->teaserItemData = $this->getMockBuilder(TeaserItemInterface::class)
            ->getMock();
        $this->teaserItemSearchResult = $this->getMockBuilder(TeaserItemSearchResultInterface::class)
            ->getMock();
        $this->collection = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['addFieldToFilter', 'getSize', 'setCurPage', 'setPageSize', 'load', 'addOrder'])
            ->getMock();

        $teaserItemFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->teaserItem);
        $teaserItemDataFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->teaserItem);
        $teaserItemSearchResultFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->teaserItemSearchResult);
        $collectionFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->collection);

        $this->dataHelper = $this->getMockBuilder(DataObjectHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = new TeaserItemRepository(
            $this->teaserItemResource,
            $collectionFactory,
            $teaserItemSearchResultFactory,
            $this->dataHelper,
            $this->dataObjectProcessor,
            $teaserItemDataFactory
        );
    }

    /**
     * @test
     */
    public function testSave()
    {
        $this->teaserItemResource->expects($this->once())
            ->method('save')
            ->with($this->teaserItem)
            ->willReturnSelf();
        $this->assertEquals($this->teaserItem, $this->repository->save($this->teaserItem));
    }

    /**
     * @test
     */
    public function testDeleteById()
    {
        $teaserItemId = '123';

        $this->teaserItem->expects($this->once())
            ->method('getId')
            ->willReturn(true);
        $this->teaserItemResource->expects($this->once())
            ->method('load')
            ->with($this->teaserItem, $teaserItemId)
            ->willReturn($this->teaserItem);
        $this->teaserItemResource->expects($this->once())
            ->method('delete')
            ->with($this->teaserItem)
            ->willReturnSelf();

        $this->assertTrue($this->repository->deleteById($teaserItemId));
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotSaveException
     */
    public function testSaveException()
    {
        $this->teaserItemResource->expects($this->once())
            ->method('save')
            ->with($this->teaserItem)
            ->willThrowException(new \Exception());
        $this->repository->save($this->teaserItem);
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function testDeleteException()
    {
        $this->teaserItemResource->expects($this->once())
            ->method('delete')
            ->with($this->teaserItem)
            ->willThrowException(new \Exception());
        $this->repository->delete($this->teaserItem);
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testGetByIdException()
    {
        $teaserItemId = '123';

        $this->teaserItem->expects($this->once())
            ->method('getId')
            ->willReturn(false);
        $this->teaserItemResource->expects($this->once())
            ->method('load')
            ->with($this->teaserItem, $teaserItemId)
            ->willReturn($this->teaserItem);
        $this->repository->getById($teaserItemId);
    }
}
