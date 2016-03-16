<?php
/**
 * Save.php
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

use DavidVerholen\Teaser\Api\Data\TeaserGroupInterfaceFactory;
use DavidVerholen\Teaser\Api\TeaserGroupRepositoryInterface;
use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup;
use DavidVerholen\Teaser\Model\ResourceModel\TeaserGroup\CollectionFactory as TeaserGroupCollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\Helper\Js;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class Save
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Save extends TeaserGroup
{
    /**
     * @var Js
     */
    private $jsHelper;

    public function __construct(
        Action\Context $context,
        TeaserGroupRepositoryInterface $teaserGroupRepository,
        Builder $teaserGroupBuilder,
        TeaserGroupCollectionFactory $teaserGroupCollectionFactory,
        TeaserGroupInterfaceFactory $teaserGroupFactory,
        Filter $filter,
        Js $jsHelper
    ) {
        parent::__construct(
            $context,
            $teaserGroupRepository,
            $teaserGroupBuilder,
            $teaserGroupCollectionFactory,
            $teaserGroupFactory,
            $filter
        );

        $this->jsHelper = $jsHelper;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getParams();

        if (!$data) {
            return $this->prepareRedirect($resultRedirect);
        }

        $id = isset($data['teaser_group_id']) ? $data['teaser_group_id'] : null;

        /** @var \DavidVerholen\Teaser\Model\TeaserGroup $teaserGroup */
        $teaserGroup = $this->teaserGroupBuilder->build($id);

        if ($id && !$teaserGroup->getId()) {
            $this->messageManager->addError(__('This Teaser Group no longer exists.'));

            return $this->prepareRedirect($resultRedirect);
        }

        $teaserGroup->setData($data);
        $teaserGroup = $this->decodeTeaserItemLinks($teaserGroup);

        try {
            $this->teaserGroupRepository->save($teaserGroup);
            $this->messageManager->addSuccess(__('You saved the Teaser Group.'));
            $this->_session->setFormData(false);
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_session->setFormData($data);

            return $this->prepareRedirect(
                $resultRedirect,
                $this->getRequest()->getParam('id'),
                'edit'
            );
        }

        return $this->prepareRedirect($resultRedirect, $teaserGroup->getId());
    }

    /**
     * @param Redirect $redirect
     * @param null     $id
     *
     * @param null     $forceBack
     *
     * @return $this
     */
    protected function prepareRedirect(Redirect $redirect, $id = null, $forceBack = null)
    {
        $back = $this->getRequest()->getParam('back', 'index');

        if (null !== $forceBack) {
            $back = $forceBack;
        }

        if ($back === 'edit') {
            return $redirect->setPath('*/*/' . $back, [
                'id' => $id
            ]);
        }

        return $redirect->setPath('*/*/' . $back);
    }

    /**
     * @param AbstractModel $object
     *
     * @return AbstractModel
     */
    public function decodeTeaserItemLinks(AbstractModel $object)
    {
        if (false === $object->hasData('links')
            || false === array_key_exists('teaser_items', $object->getData('links'))
            || !$object->getData('links')['teaser_items']
        ) {
            return $object;
        }

        $postedTeaserItems = $this->jsHelper->decodeGridSerializedInput($object->getData('links')['teaser_items']);

        array_walk($postedTeaserItems, function (&$item) {
            $item = $item['position'];
        });

        return $object->setData('posted_teaser_items', $postedTeaserItems);
    }
}
