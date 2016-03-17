<?php

namespace DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserGroup;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup\Save;
use DavidVerholen\Teaser\Model\TeaserGroup;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class EditTest
 * @package            DavidVerholen\Teaser\Test\Integration\Controller\Adminhtml\TeaserGroup
 *
 * @magentoAppArea     adminhtml
 */
class SaveTest extends AbstractBackendController
{
    const TEASER_FIXTURE_TITLE = 'fixturetitle';

    protected $uri = 'backend/teaser/teasergroup/save';
    protected $resource = 'DavidVerholen_Teaser::teaser_group';
    protected $action = Save::class;

    /**
     * @magentoDataFixture teaserGroupFixture
     */
    public function testSaveAction()
    {
        /** @var TeaserGroup $teaserGroup */
        $teaserGroup = Bootstrap::getObjectManager()->create(TeaserGroup::class);
        $teaserGroup->load(static::TEASER_FIXTURE_TITLE, 'title');

        $newTitle = 'title';
        $this->getRequest()->setPostValue([
            'title' => $newTitle
        ]);

        $this->dispatch(implode('/', [$this->uri, 'id', $teaserGroup->getId()]));
        $this->assertRedirect($this->stringStartsWith('http://localhost/index.php/backend/teaser/teasergroup/index/'));
        $this->assertSessionMessages(
            $this->contains('You saved the Teaser Group.'),
            \Magento\Framework\Message\MessageInterface::TYPE_SUCCESS
        );

        /** @var TeaserGroup $newTeaserGroup */
        $newTeaserGroup = Bootstrap::getObjectManager()->create(TeaserGroup::class);
        $newTeaserGroup->load($newTitle, 'title');

        $this->assertEquals($newTitle, $newTeaserGroup->getTitle());
    }

    public static function teaserGroupFixture()
    {
        /** @var TeaserGroup $teaserGroup */
        $teaserGroup = Bootstrap::getObjectManager()->create(TeaserGroup::class);
        $teaserGroup->setIsActive(true)->setTitle(static::TEASER_FIXTURE_TITLE);
        $teaserGroup->save();
    }
}
