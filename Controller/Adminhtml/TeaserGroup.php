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
use DavidVerholen\Teaser\Api\Data\TeaserGroupInterfaceFactory;
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
    protected $teaserGroupRepository;

    /**
     * @var Builder
     */
    protected $teaserGroupBuilder;

    /**
     * @var TeaserGroupCollectionFactory
     */
    protected $teaserGroupCollectionFactory;

    /**
     * @var TeaserGroupInterfaceFactory
     */
    protected $teaserGroupFactory;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * TeaserGroup constructor.
     *
     * @param Action\Context                 $context
     * @param TeaserGroupRepositoryInterface $teaserGroupRepository
     * @param Builder                        $teaserGroupBuilder
     * @param TeaserGroupCollectionFactory   $teaserGroupCollectionFactory
     * @param TeaserGroupInterfaceFactory    $teaserGroupFactory
     * @param Filter                         $filter
     */
    public function __construct(
        Action\Context $context,
        TeaserGroupRepositoryInterface $teaserGroupRepository,
        Builder $teaserGroupBuilder,
        TeaserGroupCollectionFactory $teaserGroupCollectionFactory,
        TeaserGroupInterfaceFactory $teaserGroupFactory,
        Filter $filter
    ) {
        parent::__construct($context);
        $this->teaserGroupRepository = $teaserGroupRepository;
        $this->teaserGroupBuilder = $teaserGroupBuilder;
        $this->teaserGroupCollectionFactory = $teaserGroupCollectionFactory;
        $this->teaserGroupFactory = $teaserGroupFactory;
        $this->filter = $filter;
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     *
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
        return $this->filter->getCollection($this->teaserGroupCollectionFactory->create());
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DavidVerholen_Teaser::teaser_group');
    }
}
