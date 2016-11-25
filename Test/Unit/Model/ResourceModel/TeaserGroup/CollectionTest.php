<?php

namespace DavidVerholen\Teaser\Test\Unit\Model\ResourceModel\TeaserGroup;

use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup\Collection;
use DavidVerholen\Teaser\Test\Unit\Model\ResourceModel\AbstractCollectionTest;
use Magento\Framework\DB\Select;

class CollectionTest extends AbstractCollectionTest
{
    /**
     * @var Collection
     */
    protected $collection;

    protected function setUp()
    {
        parent::setUp();

        $this->collection = $this->objectManager->getObject(Collection::class, [
            'resource' => $this->resource,
            'connection' => $this->connection
        ]);
    }

    public function testAddFieldToFilter()
    {
        $field = 'title';
        $value = 'test_filter';
        $searchSql = 'sql query';

        $this->connection->expects($this->any())->method('quoteIdentifier')->willReturn($searchSql);
        $this->connection->expects($this->any())->method('prepareSqlCondition')->willReturn($searchSql);

        $this->select->expects($this->once())
            ->method('where')
            ->with($searchSql, null, Select::TYPE_CONDITION);

        $this->assertSame($this->collection, $this->collection->addFieldToFilter($field, $value));
    }
}
