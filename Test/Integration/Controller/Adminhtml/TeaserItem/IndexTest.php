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
 */
class IndexTest extends AbstractBackendController
{
    protected $uri = 'backend/teaser/teaseritem/index';
    protected $resource = 'DavidVerholen_Teaser::teaser_item';
    protected $action = Index::class;

    public function testTheAddNewButtonIsPresent()
    {
        $this->dispatch($this->uri);
        $content = $this->getResponse()->getBody();
        $this->assertContains('Add New Teaser Item', $content);
    }

    public function testTheActionReturnsAResultPage()
    {
        /** @var Index $indexAction */
        $indexAction = $this->_objectManager->create($this->action);
        $this->assertInstanceOf(Page::class, $indexAction->execute());
    }
}
