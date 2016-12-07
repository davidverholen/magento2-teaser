<?php

namespace DavidVerholen\Teaser\Block\TeaserItem\Renderer;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use Magento\Framework\View\Element\BlockInterface;

interface RendererInterface extends BlockInterface
{
    /**
     * @param TeaserItemInterface $teaserItem
     *
     * @return RendererInterface
     */
    public function setTeaserItem(TeaserItemInterface $teaserItem);
}
