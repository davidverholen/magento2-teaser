<?php

namespace DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup;

use DavidVerholen\Teaser\Controller\Adminhtml\TeaserGroup;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class TeaserItems extends TeaserGroup
{
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $this->teaserGroupBuilder->build($this->getRequest()->getParam('id', null));
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);

        return $resultLayout;
    }
}
