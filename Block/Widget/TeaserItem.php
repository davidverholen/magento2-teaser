<?php

namespace DavidVerholen\Teaser\Block\Widget;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Api\TeaserGroupRepositoryInterface;
use DavidVerholen\Teaser\Api\TeaserItemRepositoryInterface;
use DavidVerholen\Teaser\Block\TeaserGroup as TeaserGroupBlock;
use DavidVerholen\Teaser\Block\TeaserItem\Renderer\RendererFactory;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class TeaserItem extends TeaserGroupBlock implements BlockInterface
{
    /**
     * @var TeaserItemInterface|\DavidVerholen\Teaser\Model\TeaserItem
     */
    protected $teaserItem;

    /**
     * @var TeaserItemRepositoryInterface
     */
    protected $teaserItemRepository;

    /**
     * TeaserItem constructor.
     *
     * @param Template\Context               $context
     * @param TeaserGroupRepositoryInterface $teaserGroupRepository
     * @param TeaserItemRepositoryInterface  $teaserItemRepository
     * @param RendererFactory                $teaserItemRendererFactory
     * @param array                          $data
     */
    public function __construct(
        Template\Context $context,
        TeaserGroupRepositoryInterface $teaserGroupRepository,
        TeaserItemRepositoryInterface $teaserItemRepository,
        RendererFactory $teaserItemRendererFactory,
        array $data = []
    ) {
        parent::__construct($context, $teaserGroupRepository, $teaserItemRendererFactory, $data);
        $this->teaserItemRepository = $teaserItemRepository;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        return $this->renderItem($this->getTeaserItem(), $this->getData('renderer'));
    }

    /**
     * @return TeaserItemInterface
     */
    public function getTeaserItem()
    {
        if (null === $this->teaserItem) {
            $id = $this->getData(TeaserItemInterface::TEASER_ITEM_ID);
            $this->teaserItem = $this->teaserItemRepository->getById($id);
        }

        return $this->teaserItem;
    }
}
