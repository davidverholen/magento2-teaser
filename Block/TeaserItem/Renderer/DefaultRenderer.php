<?php

namespace DavidVerholen\Teaser\Block\TeaserItem\Renderer;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use Magento\Framework\View\Element\Template;

class DefaultRenderer extends Template implements RendererInterface
{
    /**
     * @var TeaserItemInterface
     */
    protected $teaserItem;

    /**
     * @param TeaserItemInterface $teaserItem
     *
     * @return RendererInterface
     */
    public function setTeaserItem(TeaserItemInterface $teaserItem)
    {
        $this->teaserItem = $teaserItem;
    }

    /**
     * @return TeaserItemInterface
     */
    public function getTeaserItem()
    {
        return $this->teaserItem;
    }
}
