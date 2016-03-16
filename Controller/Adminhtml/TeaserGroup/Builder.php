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

namespace DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup;

use DavidVerholen\Teaser\Api\TeaserGroupRepositoryInterface;
use DavidVerholen\Teaser\Controller\RegistryConstants;
use DavidVerholen\Teaser\Model\TeaserGroupFactory;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;

/**
 * Class Builder
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup
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
     * @var TeaserGroupRepositoryInterface
     */
    protected $teaserGroupRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var TeaserGroupFactory
     */
    protected $teaserGroupFactory;

    /**
     * Builder constructor.
     *
     * @param Registry                       $coreRegistry
     * @param TeaserGroupRepositoryInterface $teaserGroupRepository
     * @param LoggerInterface                $logger
     * @param TeaserGroupFactory             $teaserGroupFactory
     */
    public function __construct(
        Registry $coreRegistry,
        TeaserGroupRepositoryInterface $teaserGroupRepository,
        LoggerInterface $logger,
        TeaserGroupFactory $teaserGroupFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->teaserGroupRepository = $teaserGroupRepository;
        $this->logger = $logger;
        $this->teaserGroupFactory = $teaserGroupFactory;
    }

    /**
     * build
     *
     * @param int $teaserGroupId
     *
     * @return \DavidVerholen\Teaser\Api\Data\TeaserGroupInterface
     */
    public function build($teaserGroupId)
    {
        $this->coreRegistry->register(
            RegistryConstants::CURRENT_TEASER_GROUP_ID,
            $teaserGroupId
        );

        if (!$teaserGroupId) {
            return $this->teaserGroupFactory->create();
        }

        $teaserGroup = $this->teaserGroupRepository->getById($teaserGroupId);

        $this->coreRegistry->register(
            RegistryConstants::CURRENT_TEASER_GROUP,
            $teaserGroup
        );

        return $teaserGroup;
    }
}
