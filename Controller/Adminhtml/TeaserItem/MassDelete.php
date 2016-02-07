<?php
/**
 * MassDelete.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem;

use DavidVerholen\Teaser\Api\TeaserItemRepositoryInterface;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem as TeaserItemController;
use DavidVerholen\Teaser\Controller\ImageUploader;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\Collection;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\CollectionFactory as TeaserItemCollectionFactory;
use DavidVerholen\Teaser\Model\TeaserItem;
use DavidVerholen\Teaser\Model\TeaserItemFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class MassDelete extends TeaserItemController
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * MassDelete constructor.
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
        parent::__construct(
            $context,
            $teaserItemRepository,
            $teaserItemBuilder,
            $teaserItemCollectionFactory,
            $teaserItemFactory,
            $imageUploader
        );

        $this->filter = $filter;
    }


    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var Collection $collection */
        $collection = $this->filter
            ->getCollection($this->teaserItemCollectionFactory->create());

        /** @var TeaserItem $teaserItem */
        foreach ($collection as $teaserItem) {
            $teaserItem->delete();
        }

        $this->messageManager->addSuccess(__(
            'A total of %1 record(s) have been deleted.',
            $collection->getSize()
        ));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
