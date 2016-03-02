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
     *
     * @internal param array $renderer
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
     * @return TeaserGroupInterface
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
     * @param string              $rendererType
     *
     * @return string
     */
    public function renderItem(TeaserItemInterface $teaserItem, $rendererType = 'default')
    {
        return $this->teaserItemRendererFactory->get($rendererType)
            ->setTeaserItem($teaserItem)
            ->toHtml();
    }
}
