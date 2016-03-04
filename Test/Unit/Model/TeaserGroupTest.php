<?php
/**
 * TeaserGroupTest.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Test\Unit\Model;

use DavidVerholen\Teaser\Model\TeaserGroup;
use Magento\TestFramework\ObjectManager;

/**
 * Class TeaserGroupTest
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Test\Unit\Model
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserGroupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TeaserGroup
     */
    protected $subject;

    /**
     * @var string
     */
    protected $model = TeaserGroup::class;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = ObjectManager::getInstance();
        $this->subject = $this->objectManager->create($this->model);
    }

    public function testTheIsActiveCanBeSetAndGet()
    {
        $isActive = true;
        $this->subject->setIsActive($isActive);
        $this->assertEquals($isActive, $this->subject->getIsActive());
    }

    public function testTheModifiedDateCanBeSetAndGet()
    {
        $modifiedDate = 'modified_date';
        $this->subject->setModifiedDate($modifiedDate);
        $this->assertEquals($modifiedDate, $this->subject->getModifiedDate());
    }

    public function testTheCreationDateCanBeSetAndGet()
    {
        $creationDate = 'creation_date';
        $this->subject->setCreationDate($creationDate);
        $this->assertEquals($creationDate, $this->subject->getCreationDate());
    }
}
