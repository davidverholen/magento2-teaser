<?php

namespace DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserGroup;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup\NewAction;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class NewActionTest
 * @package            DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserGroup
 *
 * @magentoAppArea     adminhtml
 */
class NewActionTest extends AbstractBackendController
{
    protected $uri = 'backend/teaser/teasergroup/new';
    protected $resource = 'DavidVerholen_Teaser::teaser_group';
    protected $action = NewAction::class;

    public function testTheNeededButtonsAreShown()
    {
        $this->dispatch($this->uri);
        $content = $this->getResponse()->getBody();
        $this->assertContains('<span>Save Teaser Group</span>', $content);
        $this->assertContains('<span>Back</span>', $content);
        $this->assertContains('<span>Save and Continue Edit</span>', $content);
        $this->assertContains('<span>Reset</span>', $content);
        $this->assertNotContains('<span>Delete</span>', $content);
    }
}
