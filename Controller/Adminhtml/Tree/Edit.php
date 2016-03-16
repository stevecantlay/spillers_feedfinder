<?php

namespace Yoma\FeedFinder\Controller\Adminhtml\Tree;

use  Yoma\FeedFinder\Controller\Adminhtml\Tree;

class Edit extends Tree
{


    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Yoma_FeedFinder::tree')
            ->addBreadcrumb(__('Tree Finder'), __('Tree Finder'))
            ->addBreadcrumb(__('Manage Trees'), __('Manage Trees'));
        return $resultPage;
    }

    /**
     * Edit Tree
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('tree_id');
        $model = $this->_objectManager->create('Yoma\FeedFinder\Model\Tree');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This tree no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('feedfinder_tree', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Decision Tree') : __('New Decision Tree'),
            $id ? __('Edit Decision Tree') : __('New Decision Tree')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('FeedFinder Tree'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Decision Tree'));

        return $resultPage;
    }
}