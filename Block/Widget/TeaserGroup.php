<?php

namespace DavidVerholen\Teaser\Block\Widget;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use DavidVerholen\Teaser\Block\TeaserGroup as TeaserGroupBlock;
use Magento\Widget\Block\BlockInterface;

class TeaserGroup extends TeaserGroupBlock implements BlockInterface
{
    /**
     * @param TeaserItemInterface $teaserItem
     * @param string              $rendererType
     *
     * @return string
     */
    public function renderItem(TeaserItemInterface $teaserItem, $rendererType = 'default')
    {
        return parent::renderItem($teaserItem, $this->getData('teaser_item_renderer'));
    }
}
