<?php

namespace Yoma\FeedFinder\Controller\Adminhtml\Tree;

use  Yoma\FeedFinder\Controller\Adminhtml\Tree;

class Index extends Tree
{
    /**
     * @return void
     */
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('this.results');
        $resultPage->getConfig()->getTitle()->prepend(__('Tree'));

        return $resultPage;
    }
}