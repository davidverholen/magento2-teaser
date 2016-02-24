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

use DavidVerholen\Teaser\Api\TeaserItemRepositoryInterface;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem\Builder;
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
     * @param Filter                        $filter
     */
    public function __construct(
        Action\Context $context,
        TeaserItemRepositoryInterface $teaserItemRepository,
        Builder $teaserItemBuilder,
        TeaserItemCollectionFactory $teaserItemCollectionFactory,
        TeaserItemFactory $teaserItemFactory,
        Filter $filter
    ) {
        parent::__construct($context);
        $this->teaserItemRepository = $teaserItemRepository;
        $this->teaserItemBuilder = $teaserItemBuilder;
        $this->teaserItemCollectionFactory = $teaserItemCollectionFactory;
        $this->teaserItemFactory = $teaserItemFactory;
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
     * @return \Magento\Framework\Data\Collection\AbstractDb
     */
    protected function getFilteredCollection()
    {
        return $this->filter->getCollection($this->teaserItemCollectionFactory->create());
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DavidVerholen_Teaser::teaser_item');
    }
}
