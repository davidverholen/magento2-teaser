<?php
namespace DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup\Widget;

use DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup\Widget\Chooser as ChooserBlock;
use DavidVerholen\Teaser\Api\TeaserGroupRepositoryInterface;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup\Builder;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup\CollectionFactory as TeaserGroupCollectionFactory;
use DavidVerholen\Teaser\Model\TeaserGroupFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\LayoutFactory;
use Magento\Ui\Component\MassAction\Filter;

class Chooser extends TeaserGroup
{
    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;

    public function __construct(
        Action\Context $context,
        TeaserGroupRepositoryInterface $teaserGroupRepository,
        Builder $teaserGroupBuilder,
        TeaserGroupCollectionFactory $teaserGroupCollectionFactory,
        TeaserGroupFactory $teaserGroupFactory,
        Filter $filter,
        LayoutFactory $layoutFactory
    ) {
        parent::__construct(
            $context,
            $teaserGroupRepository,
            $teaserGroupBuilder,
            $teaserGroupCollectionFactory,
            $teaserGroupFactory,
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
