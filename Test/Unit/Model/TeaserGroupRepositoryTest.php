<?php

namespace DavidVerholen\Teaser\Test\Unit\Model;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Api\Data\TeaserGroupSearchResultInterface;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup as TeaserGroupResource;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup\Collection;
use DavidVerholen\Teaser\Model\TeaserGroup;
use DavidVerholen\Teaser\Model\TeaserGroupRepository;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;

class TeaserGroupRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TeaserGroupRepository
     */
    protected $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TeaserGroupResource
     */
    protected $teaserGroupResource;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TeaserGroup
     */
    protected $teaserGroup;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TeaserGroupInterface
     */
    protected $teaserGroupData;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TeaserGroupSearchResultInterface
     */
    protected $teaserGroupSearchResult;

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
        $this->teaserGroupResource = $this->getMockBuilder(TeaserGroupResource::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->dataObjectProcessor = $this->getMockBuilder(DataObjectProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();
        $teaserGroupFactory = $this->getMockBuilder('DavidVerholen\Teaser\Model\TeaserGroupFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $teaserGroupDataFactory = $this->getMockBuilder('DavidVerholen\Teaser\Api\Data\TeaserGroupInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $teaserGroupSearchResultFactory = $this->getMockBuilder('DavidVerholen\Teaser\Api\Data\TeaserGroupSearchResultInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $collectionFactory = $this->getMockBuilder('DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup\CollectionFactory')
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

        $this->teaserGroup = $this->getMockBuilder(TeaserGroup::class)->disableOriginalConstructor()->getMock();
        $this->teaserGroupData = $this->getMockBuilder(TeaserGroupInterface::class)
            ->getMock();
        $this->teaserGroupSearchResult = $this->getMockBuilder(TeaserGroupSearchResultInterface::class)
            ->getMock();
        $this->collection = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['addFieldToFilter', 'getSize', 'setCurPage', 'setPageSize', 'load', 'addOrder'])
            ->getMock();

        $teaserGroupFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->teaserGroup);
        $teaserGroupDataFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->teaserGroup);
        $teaserGroupSearchResultFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->teaserGroupSearchResult);
        $collectionFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->collection);

        $this->dataHelper = $this->getMockBuilder(DataObjectHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = new TeaserGroupRepository(
            $this->teaserGroupResource,
            $collectionFactory,
            $teaserGroupSearchResultFactory,
            $this->dataHelper,
            $this->dataObjectProcessor,
            $teaserGroupDataFactory
        );
    }

    /**
     * @test
     */
    public function testSave()
    {
        $this->teaserGroupResource->expects($this->once())
            ->method('save')
            ->with($this->teaserGroup)
            ->willReturnSelf();
        $this->assertEquals($this->teaserGroup, $this->repository->save($this->teaserGroup));
    }

    /**
     * @test
     */
    public function testDeleteById()
    {
        $teaserGroupId = '123';

        $this->teaserGroup->expects($this->once())
            ->method('getId')
            ->willReturn(true);
        $this->teaserGroupResource->expects($this->once())
            ->method('load')
            ->with($this->teaserGroup, $teaserGroupId)
            ->willReturn($this->teaserGroup);
        $this->teaserGroupResource->expects($this->once())
            ->method('delete')
            ->with($this->teaserGroup)
            ->willReturnSelf();

        $this->assertTrue($this->repository->deleteById($teaserGroupId));
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotSaveException
     */
    public function testSaveException()
    {
        $this->teaserGroupResource->expects($this->once())
            ->method('save')
            ->with($this->teaserGroup)
            ->willThrowException(new \Exception());
        $this->repository->save($this->teaserGroup);
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function testDeleteException()
    {
        $this->teaserGroupResource->expects($this->once())
            ->method('delete')
            ->with($this->teaserGroup)
            ->willThrowException(new \Exception());
        $this->repository->delete($this->teaserGroup);
    }

    /**
     * @test
     *
     * @expectedException \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testGetByIdException()
    {
        $teaserGroupId = '123';

        $this->teaserGroup->expects($this->once())
            ->method('getId')
            ->willReturn(false);
        $this->teaserGroupResource->expects($this->once())
            ->method('load')
            ->with($this->teaserGroup, $teaserGroupId)
            ->willReturn($this->teaserGroup);
        $this->repository->getById($teaserGroupId);
    }
}
