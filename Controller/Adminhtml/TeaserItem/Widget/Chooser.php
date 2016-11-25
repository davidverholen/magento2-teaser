<?php
namespace DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem\Widget;

use DavidVerholen\Teaser\Block\Adminhtml\TeaserItem\Widget\Chooser as ChooserBlock;
use DavidVerholen\Teaser\Api\TeaserItemRepositoryInterface;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem\Builder;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserItem\CollectionFactory as TeaserItemCollectionFactory;
use DavidVerholen\Teaser\Api\Data\TeaserItemInterfaceFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\LayoutFactory;
use Magento\Ui\Component\MassAction\Filter;

class Chooser extends TeaserItem
{
    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;

    public function __construct(
        Action\Context $context,
        TeaserItemRepositoryInterface $teaserItemRepository,
        Builder $teaserItemBuilder,
        TeaserItemCollectionFactory $teaserItemCollectionFactory,
        TeaserItemInterfaceFactory $teaserItemFactory,
        Filter $filter,
        LayoutFactory $layoutFactory
    ) {
        parent::__construct(
            $context,
            $teaserItemRepository,
            $teaserItemBuilder,
            $teaserItemCollectionFactory,
            $teaserItemFactory,
            $filter
        );
        $this->layoutFactory = $layoutFactory;
    }


    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $uniqueId = $this->getRequest()->getParam('unique_id');

        $html = $this->layoutFactory->create()
            ->createBlock(ChooserBlock::class, '', ['data' => ['id' => $uniqueId]])
            ->toHtml();

        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultFactory->create(ResultFactory::TYPE_RAW);

        return $resultRaw->setContents($html);
    }
}
