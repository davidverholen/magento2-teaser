<?php

namespace DavidVerholen\Teaser\Block;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Api\TeaserGroupRepositoryInterface;
use DavidVerholen\Teaser\Block\TeaserItem\Renderer\RendererFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\View\Element\Template;

class TeaserGroup extends Template
{
    /**
     * @var TeaserGroupRepositoryInterface
     */
    private $teaserGroupRepository;

    /**
     * @var TeaserGroupInterface|AbstractModel
     */
    private $teaserGroup;

    /**
     * @var RendererFactory
     */
    private $teaserItemRendererFactory;

    /**
     * TeaserGroup constructor.
     *
     * @param Template\Context               $context
     * @param TeaserGroupRepositoryInterface $teaserGroupRepository
     * @param RendererFactory                $teaserItemRendererFactory
     * @param array                          $data
     */
    public function __construct(
        Template\Context $context,
        TeaserGroupRepositoryInterface $teaserGroupRepository,
        RendererFactory $teaserItemRendererFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->teaserGroupRepository = $teaserGroupRepository;
        $this->teaserItemRendererFactory = $teaserItemRendererFactory;
    }

    /**
     * @return TeaserGroupInterface|\DavidVerholen\Teaser\Model\TeaserGroup
     */
    public function getTeaserGroup()
    {
        if (null === $this->teaserGroup) {
            $id = $this->getData(TeaserGroupInterface::TEASER_GROUP_ID);
            $this->teaserGroup = $this->teaserGroupRepository->getById($id);
        }

        return $this->teaserGroup;
    }

    /**
     * @param TeaserItemInterface $teaserItem
     *
     * @return string
     */
    public function renderItem(TeaserItemInterface $teaserItem)
    {
        return $this->teaserItemRendererFactory->get($teaserItem->getRenderer())
            ->setTeaserItem($teaserItem)
            ->toHtml();
    }
}
