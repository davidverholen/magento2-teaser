<?php

namespace DavidVerholen\Teaser\Model\TeaserItem\Source;

use DavidVerholen\Teaser\Block\TeaserItem\Renderer\RendererFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Renderer implements OptionSourceInterface
{
    /**
     * @var RendererFactory
     */
    protected $rendererFactory;

    /**
     * @var array
     */
    protected static $options = [];

    /**
     * Renderer constructor.
     *
     * @param RendererFactory $rendererFactory
     */
    public function __construct(RendererFactory $rendererFactory)
    {
        $this->rendererFactory = $rendererFactory;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        if (0 === count(static::$options)) {
            foreach ($this->rendererFactory->getAvailableRenderer() as $renderer) {
                static::$options[] = [
                    'value' => $renderer,
                    'label' => $renderer
                ];
            }
        }

        return static::$options;
    }
}
