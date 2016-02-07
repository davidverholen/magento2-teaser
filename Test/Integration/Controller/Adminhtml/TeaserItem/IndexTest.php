<?php
/**
 * IndexTest.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserItem;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem\Index;
use Magento\Backend\Model\View\Result\Page;
use Magento\TestFramework\ObjectManager;

/**
 * Class IndexTest
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserItem
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class IndexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $action = Index::class;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = ObjectManager::getInstance();
    }

    /**
     * @magentoAppArea adminhtml
     */
    public function testTheActionReturnsAResultPage()
    {
        /** @var Index $indexAction */
        $indexAction = $this->objectManager->create($this->action);
        $this->assertInstanceOf(Page::class, $indexAction->execute());
    }
}
