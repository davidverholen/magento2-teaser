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

namespace DavidVerholen\Teaser\Test\Integration\Model;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Model\TeaserItem;
use Magento\TestFramework\ObjectManager;

/**
 * Class TeaserItemTest
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Test\Integration\Model
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $apiInterface = TeaserItemInterface::class;

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
    }

    public function testThePreferenceIsAnInstanceOfTheTeaserItemModel()
    {
        $this->assertInstanceOf($this->model, $this->objectManager->create($this->apiInterface));
    }
}
