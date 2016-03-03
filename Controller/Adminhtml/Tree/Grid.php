<?php

namespace Yoma\FeedFinder\Controller\Adminhtml\Tree;

use Yoma\FeedFinder\Controller\Adminhtml\Tree;

class Grid extends Tree
{
    /**
     * @return void
     */
    public function execute()
    {
        return $this->_resultPageFactory->create();
    }
}
