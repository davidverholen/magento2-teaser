<?php
namespace DavidVerholen\Teaser\Ui\Component\Listing\Column;

use DavidVerholen\Teaser\Api\Data\TeaserItemInterface;
use Magento\Framework\DataObject;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Thumbnail
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Ui\Component\Listing\Columns
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class TeaserItemThumbnail extends Column
{
    const NAME = 'thumbnail';

    const ALT_FIELD = 'name';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param ContextInterface      $context
     * @param UiComponentFactory    $uiComponentFactory
     * @param UrlInterface          $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param array                 $components
     * @param array                 $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $teaserItem = new DataObject($item);
                $item[$fieldName . '_src']
                    = $this->getTeaserItemUrl($teaserItem);
                $item[$fieldName . '_orig_src']
                    = $this->getTeaserItemUrl($teaserItem);
                $item[$fieldName . '_alt']
                    = $teaserItem->getData(TeaserItemInterface::TITLE);
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'teaser/teaseritem/edit',
                    ['id' => $teaserItem->getData(TeaserItemInterface::TEASER_ITEM_ID)]
                );
            }
        }

        return $dataSource;
    }

    /**
     * getTeaserItemUrl
     *
     * @param DataObject $teaserItem
     *
     * @return string
     */
    protected function getTeaserItemUrl(DataObject $teaserItem)
    {
        return implode('/', [
            rtrim($this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA), '/'),
            TeaserItemInterface::TEASER_ITEM_IMAGE_PATH,
            $teaserItem->getData(TeaserItemInterface::IMAGE_PATH)
        ]);
    }
}
