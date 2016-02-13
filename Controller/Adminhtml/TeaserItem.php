<?php
/**
 * Teaser.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Controller\Adminhtml;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Api\TeaserItemRepositoryInterface;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem\Builder;
use DavidVerholen\Teaser\Controller\ImageUploader;
use DavidVerholen\Teaser\Model\TeaserItem as TeaserItemModel;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\CollectionFactory as TeaserItemCollectionFactory;
use DavidVerholen\Teaser\Model\TeaserItemFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class Teaser
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\etc\Adminhtml
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
abstract class TeaserItem extends Action
{
    /**
     * @var TeaserItemRepositoryInterface
     */
    protected $teaserItemRepository;

    /**
     * @var Builder
     */
    protected $teaserItemBuilder;

    /**
     * @var TeaserItemCollectionFactory
     */
    protected $teaserItemCollectionFactory;

    /**
     * @var TeaserItemFactory
     */
    protected $teaserItemFactory;

    /**
     * @var ImageUploader
     */
    private $imageUploader;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * TeaserItem constructor.
     *
     * @param Action\Context                $context
     * @param TeaserItemRepositoryInterface $teaserItemRepository
     * @param Builder                       $teaserItemBuilder
     * @param TeaserItemCollectionFactory   $teaserItemCollectionFactory
     * @param TeaserItemFactory             $teaserItemFactory
     * @param ImageUploader                 $imageUploader
     * @param Filter                        $filter
     */
    public function __construct(
        Action\Context $context,
        TeaserItemRepositoryInterface $teaserItemRepository,
        Builder $teaserItemBuilder,
        TeaserItemCollectionFactory $teaserItemCollectionFactory,
        TeaserItemFactory $teaserItemFactory,
        ImageUploader $imageUploader,
        Filter $filter
    ) {
        parent::__construct($context);
        $this->teaserItemRepository = $teaserItemRepository;
        $this->teaserItemBuilder = $teaserItemBuilder;
        $this->teaserItemCollectionFactory = $teaserItemCollectionFactory;
        $this->teaserItemFactory = $teaserItemFactory;
        $this->imageUploader = $imageUploader;
        $this->filter = $filter;
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    protected function initPage(Page $resultPage)
    {
        $resultPage->setActiveMenu('DavidVerholen_Teaser::teaser_item')
            ->addBreadcrumb(__('Teaser'), __('Teaser'))
            ->addBreadcrumb(__('Items'), __('Items'));

        return $resultPage;
    }

    /**
     * uploadTeaserItemImage
     *
     * @param TeaserItemModel $teaserItem
     *
     * @return TeaserItemModel
     */
    protected function uploadTeaserItemImage(TeaserItemModel $teaserItem)
    {
        return $this->imageUploader->upload(
            $teaserItem,
            'general',
            TeaserItemInterface::IMAGE_PATH,
            TeaserItemInterface::TEASER_ITEM_IMAGE_PATH
        );
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb
     */
    protected function getFilteredCollection()
    {
        return $this->filter->getCollection($this->teaserItemCollectionFactory->create());
    }
}
