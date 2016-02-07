<?php
/**
 * TeaserItemTest.php
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

use DavidVerholen\Teaser\Model\TeaserItem;
use Magento\TestFramework\ObjectManager;

/**
 * Class TeaserItemTest
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Test\Unit\Model
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TeaserItem
     */
    protected $subject;

    /**
     * @var string
     */
    protected $model = TeaserItem::class;

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


    public function testTheCmsBlockIdentifierCanBeSetAndGet()
    {
        $cmsBlockIdentifier = 'cms_block_identifier';
        $this->subject->setCmsBlockIdentifier($cmsBlockIdentifier);
        $this->assertEquals($cmsBlockIdentifier, $this->subject->getCmsBlockIdentifier());
    }

    public function testTheImagePathCanBeSetAndGet()
    {
        $imagePath = 'image_path';
        $this->subject->setImagePath($imagePath);
        $this->assertEquals($imagePath, $this->subject->getImagePath());
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
