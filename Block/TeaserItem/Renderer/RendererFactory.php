<?php

namespace DavidVerholen\Teaser\Block\TeaserItem\Renderer;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;

class RendererFactory
{
    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface
     */
    protected $objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $renderer = null;

    /**
     * @var array
     */
    protected $sharedInstances = [];

    /**
     * RendererFactory constructor.
     *
     * @param ObjectManagerInterface $objectManager
     * @param array                  $renderer
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        $renderer = []
    ) {
        $this->objectManager = $objectManager;
        $this->renderer = $renderer;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param string $type
     * @param array  $data
     *
     * @return RendererInterface
     * @throws LocalizedException
     */
    public function create($type, array $data = [])
    {
        if (false === array_key_exists($type, $this->renderer)) {
            throw new LocalizedException(__(sprintf('TeaserItem Renderer with Type "%s" not registered'), $type));
        }

        $rendererInstance = $this->objectManager->create($this->renderer[$type], $data);

        if (false === $rendererInstance instanceof RendererInterface) {
            throw new LocalizedException(__(sprintf('invalid Renderer Class "%s" registered'), $this->renderer[$type]));
        }

        if (false === array_key_exists($type, $this->sharedInstances)) {
            $this->sharedInstances[$type] = $rendererInstance;
        }

        return $rendererInstance;
    }

    /**
     * @param string $type
     * @param array  $data
     *
     * @return RendererInterface
     * @throws LocalizedException
     */
    public function get($type, array $data = [])
    {
        if (false === array_key_exists($type, $this->sharedInstances)) {
            return $this->create($type, $data);
        }

        return $this->sharedInstances[$type];
    }
}
