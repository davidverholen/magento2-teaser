<?php

namespace DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserGroup;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup\Edit;
use DavidVerholen\Teaser\Model\TeaserGroup;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class EditTest
 * @package            DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserGroup
 *
 * @magentoAppArea     adminhtml
 */
class EditTest extends AbstractBackendController
{
    const TEASER_FIXTURE_TITLE = 'fixturetitle';

    protected $uri = 'backend/teaser/teasergroup/edit';
    protected $resource = 'DavidVerholen_Teaser::teaser_group';
    protected $action = Edit::class;

    /**
     * @magentoDataFixture teaserGroupFixture
     */
    public function testTheTeaserIsLoadedIntoTheForm()
    {
        /** @var TeaserGroup $teaserGroup */
        $teaserGroup = Bootstrap::getObjectManager()->create(TeaserGroup::class);
        $teaserGroup->load(static::TEASER_FIXTURE_TITLE, 'title');

        $this->dispatch(implode('/', [$this->uri, 'id', $teaserGroup->getId()]));

        $content = $this->getResponse()->getBody();
        $this->assertContains(static::TEASER_FIXTURE_TITLE, $content);
    }

    /**
     * @magentoDataFixture teaserGroupFixture
     */
    public function testAllButtonsArePresent()
    {
        /** @var TeaserGroup $teaserGroup */
        $teaserGroup = Bootstrap::getObjectManager()->create(TeaserGroup::class);
        $teaserGroup->load(static::TEASER_FIXTURE_TITLE, 'title');

        $this->dispatch(implode('/', [$this->uri, 'id', $teaserGroup->getId()]));
        $content = $this->getResponse()->getBody();
        $this->assertContains('<span>Save Teaser Group</span>', $content);
        $this->assertContains('<span>Back</span>', $content);
        $this->assertContains('<span>Save and Continue Edit</span>', $content);
        $this->assertContains('<span>Reset</span>', $content);
        $this->assertContains('<span>Delete</span>', $content);
    }

    public static function teaserGroupFixture()
    {
        /** @var TeaserGroup $teaserGroup */
        $teaserGroup = Bootstrap::getObjectManager()->create(TeaserGroup::class);
        $teaserGroup->setIsActive(true)->setTitle(static::TEASER_FIXTURE_TITLE);
        $teaserGroup->save();
    }
}
