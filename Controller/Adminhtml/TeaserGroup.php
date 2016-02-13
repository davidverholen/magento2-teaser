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

use DavidVerholen\Teaser\Api\TeaserGroupRepositoryInterface;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup\Builder;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup\CollectionFactory as TeaserGroupCollectionFactory;
use DavidVerholen\Teaser\Model\TeaserGroupFactory;
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
abstract class TeaserGroup extends Action
{
    /**
     * @var TeaserGroupRepositoryInterface
     */
    protected $teaserItemRepository;

    /**
     * @var Builder
     */
    protected $teaserItemBuilder;

    /**
     * @var TeaserGroupCollectionFactory
     */
    protected $teaserItemCollectionFactory;

    /**
     * @var TeaserGroupFactory
     */
    protected $teaserItemFactory;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * TeaserGroup constructor.
     *
     * @param Action\Context                $context
     * @param TeaserGroupRepositoryInterface $teaserItemRepository
     * @param Builder                       $teaserItemBuilder
     * @param TeaserGroupCollectionFactory   $teaserItemCollectionFactory
     * @param TeaserGroupFactory             $teaserItemFactory
     * @param Filter                        $filter
     */
    public function __construct(
        Action\Context $context,
        TeaserGroupRepositoryInterface $teaserItemRepository,
        Builder $teaserItemBuilder,
        TeaserGroupCollectionFactory $teaserItemCollectionFactory,
        TeaserGroupFactory $teaserItemFactory,
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
        $resultPage->setActiveMenu('DavidVerholen_Teaser::teaser_group')
            ->addBreadcrumb(__('Teaser'), __('Teaser'))
            ->addBreadcrumb(__('Groups'), __('Groups'));

        return $resultPage;
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb
     */
    protected function getFilteredCollection()
    {
        return $this->filter->getCollection($this->teaserItemCollectionFactory->create());
    }
}
