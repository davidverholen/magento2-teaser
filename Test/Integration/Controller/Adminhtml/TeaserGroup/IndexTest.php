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

namespace DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserGroup;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem\Index;
use Magento\Backend\Model\View\Result\Page;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class IndexTest
 *
 * @category           magento2
 * @package            DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserItem
 * @author             David Verholen <david@verholen.com>
 * @license            http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link               http://github.com/davidverholen
 *
 * @magentoAppArea     adminhtml
 * @magentoDbIsolation enabled
 */
class IndexTest extends AbstractBackendController
{
    protected $uri = 'backend/teaser/teasergroup/index';
    protected $resource = 'DavidVerholen_Teaser::teaser_group';
    protected $action = Index::class;

    public function testTheAddNewButtonIsPresent()
    {
        $this->dispatch($this->uri);
        $this->assertContains('Add New Teaser Group', $this->getResponse()->getBody());
    }

    public function testTheActionReturnsAResultPage()
    {
        /** @var Index $indexAction */
        $indexAction = $this->_objectManager->create($this->action);
        $this->assertInstanceOf(Page::class, $indexAction->execute());
    }
}
