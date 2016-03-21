<?php

namespace Yoma\FeedFinder\Controller\Adminhtml\Tree;

use Yoma\FeedFinder\Controller\Adminhtml\Tree;

class Grid extends Tree
{
    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->_resultPageFactory->create();
    }
}
