<?php

namespace Yoma\FeedFinder\Controller\Adminhtml\Tree;

use  Yoma\FeedFinder\Controller\Adminhtml\Tree;

class NewAction extends Tree
{


    /**
     * Forward to edit
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}