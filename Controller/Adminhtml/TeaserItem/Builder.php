<?php
/**
 * Builder.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem;

use DavidVerholen\Teaser\Api\TeaserItemRepositoryInterface;
use DavidVerholen\Teaser\Controller\RegistryConstants;
use DavidVerholen\Teaser\Model\TeaserItemFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;

/**
 * Class Builder
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller\Adminhtml\TeaserItem
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Builder
{
    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var TeaserItemRepositoryInterface
     */
    protected $teaserItemRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var TeaserItemFactory
     */
    protected $teaserItemFactory;

    /**
     * Builder constructor.
     *
     * @param Registry                      $coreRegistry
     * @param TeaserItemRepositoryInterface $teaserItemRepository
     * @param LoggerInterface               $logger
     * @param TeaserItemFactory             $teaserItemFactory
     */
    public function __construct(
        Registry $coreRegistry,
        TeaserItemRepositoryInterface $teaserItemRepository,
        LoggerInterface $logger,
        TeaserItemFactory $teaserItemFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->teaserItemRepository = $teaserItemRepository;
        $this->logger = $logger;
        $this->teaserItemFactory = $teaserItemFactory;
    }

    /**
     * build
     *
     * @param int $teaserItemId
     *
     * @return \DavidVerholen\Teaser\Api\Data\TeaserItemInterface
     */
    public function build($teaserItemId)
    {
        if (!$teaserItemId) {
            return $this->teaserItemFactory->create();
        }

        $this->coreRegistry->register(
            RegistryConstants::CURRENT_TEASER_ITEM_ID,
            $teaserItemId
        );

        $teaserItem = $this->teaserItemRepository->getById($teaserItemId);

        $this->coreRegistry->register(
            RegistryConstants::CURRENT_TEASER_ITEM,
            $teaserItem
        );

        return $teaserItem;
    }
}
