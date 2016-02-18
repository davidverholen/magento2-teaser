<?php

namespace DavidVerholen\Teaser\Block;

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterface;
use DavidVerholen\Teaser\Api\TeaserGroupRepositoryInterface;
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
     * TeaserGroup constructor.
     *
     * @param Template\Context               $context
     * @param TeaserGroupRepositoryInterface $teaserGroupRepository
     * @param array                          $data
     */
    public function __construct(
        Template\Context $context,
        TeaserGroupRepositoryInterface $teaserGroupRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->teaserGroupRepository = $teaserGroupRepository;
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
}
