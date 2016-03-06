<?php
/**
 * AssignTeaserItems.php
 *
 * PHP Version 5
 *
 * @category mage2-dev
 * @package  mage2-dev
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup;

use DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup\Tab\TeaserItem;
use DavidVerholen\Teaser\Controller\RegistryConstants;
use DavidVerholen\Teaser\Model\TeaserGroup;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Registry;

/**
 * Class AssignTeaserItems
 *
 * @category mage2-dev
 * @package  DavidVerholen\Teaser\Block\Adminhtml\TeaserGroup
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class AssignTeaserItems extends Template
{
    const BLOCK_GRID_NAME = 'teasergroup.teaseritem.grid';

    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'teasergroup/edit/assign_teaser_items.phtml';

    /**
     * @var TeaserItem
     */
    protected $blockGrid;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * AssignTeaserItems constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param EncoderInterface $jsonEncoder
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        EncoderInterface $jsonEncoder,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->jsonEncoder = $jsonEncoder;
        parent::__construct($context, $data);
    }
    /**
     * Retrieve instance of grid block
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                TeaserItem::class,
                static::BLOCK_GRID_NAME
            );
        }
        return $this->blockGrid;
    }

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBlockGrid()->toHtml();
    }

    /**
     * @return string
     */
    public function getTeaserItemsJson()
    {
        $teaserItemsPosition = $this->getTeaserGroup()->getTeaserItemsPosition();
        if (!empty($teaserItemsPosition)) {
            return $this->jsonEncoder->encode($teaserItemsPosition);
        }

        return $this->jsonEncoder->encode([]);
    }

    /**
     * Retrieve current category instance
     *
     * @return TeaserGroup
     */
    public function getTeaserGroup()
    {
        return $this->registry->registry(RegistryConstants::CURRENT_TEASER_GROUP);
    }
}
