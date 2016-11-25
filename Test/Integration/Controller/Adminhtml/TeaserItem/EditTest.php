<?php

namespace DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserItem;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem\Edit;
use DavidVerholen\Teaser\Model\TeaserItem;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class EditTest
 * @package            DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserItem
 *
 * @magentoAppArea     adminhtml
 */
class EditTest extends AbstractBackendController
{
    const TEASER_FIXTURE_TITLE = 'fixturetitle';

    protected $uri = 'backend/teaser/teaseritem/edit';
    protected $resource = 'DavidVerholen_Teaser::teaser_item';
    protected $action = Edit::class;

    /**
     * @magentoDataFixture teaserItemFixture
     */
    public function testTheTeaserIsLoadedIntoTheForm()
    {
        /** @var TeaserItem $teaserItem */
        $teaserItem = Bootstrap::getObjectManager()->create(TeaserItem::class);
        $teaserItem->load(static::TEASER_FIXTURE_TITLE, 'title');

        $this->dispatch(implode('/', [$this->uri, 'id', $teaserItem->getId()]));

        $content = $this->getResponse()->getBody();
        $this->assertContains(static::TEASER_FIXTURE_TITLE, $content);
    }

    /**
     * @magentoDataFixture teaserItemFixture
     */
    public function testAllButtonsArePresent()
    {
        /** @var TeaserItem $teaserItem */
        $teaserItem = Bootstrap::getObjectManager()->create(TeaserItem::class);
        $teaserItem->load(static::TEASER_FIXTURE_TITLE, 'title');

        $this->dispatch(implode('/', [$this->uri, 'id', $teaserItem->getId()]));
        $content = $this->getResponse()->getBody();
        $this->assertContains('<span>Save Teaser Item</span>', $content);
        $this->assertContains('<span>Back</span>', $content);
        $this->assertContains('<span>Save and Continue Edit</span>', $content);
        $this->assertContains('<span>Reset</span>', $content);
        $this->assertContains('<span>Delete</span>', $content);
    }

    public static function teaserItemFixture()
    {
        /** @var TeaserItem $teaserItem */
        $teaserItem = Bootstrap::getObjectManager()->create(TeaserItem::class);
        $teaserItem->setCmsBlockIdentifier('fixture_cms_block')
            ->setImagePath('fixtureImage.png')
            ->setIsActive(true)
            ->setTitle(static::TEASER_FIXTURE_TITLE);

        $teaserItem->save();
    }
}
