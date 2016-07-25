<?php

namespace DavidVerholen\Teaser\Block\TeaserItem\Renderer;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Model\TeaserItem;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\View\Element\Template;

class DefaultRenderer extends Template implements RendererInterface
{
    /**
     * @var TeaserItemInterface
     */
    protected $teaserItem;

    /**
     * @var FilterProvider
     */
    protected $filterProvider;

    /**
     * DefaultRenderer constructor.
     *
     * @param Template\Context $context
     * @param FilterProvider   $filterProvider
     * @param array            $data
     */
    public function __construct(
        Template\Context $context,
        FilterProvider $filterProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->filterProvider = $filterProvider;
    }


    /**
     * @param TeaserItemInterface $teaserItem
     *
     * @return RendererInterface
     */
    public function setTeaserItem(TeaserItemInterface $teaserItem)
    {
        $this->teaserItem = $teaserItem;
        return $this;
    }

    /**
     * @return TeaserItemInterface|TeaserItem
     */
    public function getTeaserItem()
    {
        return $this->teaserItem;
    }

    /**
     * @return string
     */
    public function renderCmsBlockHtml()
    {
        $blockModel = $this->getTeaserItem()->getCmsBlockModel();
        return $this->filterProvider->getBlockFilter()
            ->setStoreId($this->_storeManager->getStore()->getId())
            ->filter($blockModel->getContent());
    }
}
