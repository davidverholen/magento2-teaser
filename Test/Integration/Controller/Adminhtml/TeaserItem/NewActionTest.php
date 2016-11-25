<?php

namespace DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserItem;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem\NewAction;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class NewActionTest
 * @package            DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserItem
 *
 * @magentoAppArea     adminhtml
 */
class NewActionTest extends AbstractBackendController
{
    protected $uri = 'backend/teaser/teaseritem/new';
    protected $resource = 'DavidVerholen_Teaser::teaser_item';
    protected $action = NewAction::class;

    public function testTheNeededButtonsAreShown()
    {
        $this->dispatch($this->uri);
        $content = $this->getResponse()->getBody();
        $this->assertContains('<span>Save Teaser Item</span>', $content);
        $this->assertContains('<span>Back</span>', $content);
        $this->assertContains('<span>Save and Continue Edit</span>', $content);
        $this->assertNotContains('<span>Reset</span>', $content);
        $this->assertNotContains('<span>Delete</span>', $content);
    }
}
