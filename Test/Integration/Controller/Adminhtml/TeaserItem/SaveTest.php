<?php

namespace DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserItem;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem\Save;
use DavidVerholen\Teaser\Model\TeaserItem;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class EditTest
 * @package            DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserItem
 *
 * @magentoAppArea     adminhtml
 */
class SaveTest extends AbstractBackendController
{
    const TEASER_FIXTURE_TITLE = 'fixturetitle';

    protected $uri = 'backend/teaser/teaseritem/save';
    protected $resource = 'DavidVerholen_Teaser::teaser_item';
    protected $action = Save::class;

    /**
     * @magentoDataFixture teaserItemFixture
     */
    public function testSaveAction()
    {
        /** @var TeaserItem $teaserItem */
        $teaserItem = Bootstrap::getObjectManager()->create(TeaserItem::class);
        $teaserItem->load(static::TEASER_FIXTURE_TITLE, 'title');

        $newTitle = 'title';
        $this->getRequest()->setPostValue(['general' => [
            'title' => $newTitle
        ]]);

        $this->dispatch(implode('/', [$this->uri, 'id', $teaserItem->getId()]));
        $this->assertRedirect($this->stringStartsWith('http://localhost/index.php/backend/teaser/teaseritem/index/'));
        $this->assertSessionMessages(
            $this->contains('You saved the Teaser Item.'),
            \Magento\Framework\Message\MessageInterface::TYPE_SUCCESS
        );

        /** @var TeaserItem $newTeaserItem */
        $newTeaserItem = Bootstrap::getObjectManager()->create(TeaserItem::class);
        $newTeaserItem->load($newTitle, 'title');

        $this->assertEquals($newTitle, $newTeaserItem->getTitle());
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
