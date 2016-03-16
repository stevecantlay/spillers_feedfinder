<?php

namespace Yoma\FeedFinder\Controller\Adminhtml\Tree;

use  Yoma\FeedFinder\Controller\Adminhtml\Tree;

class Save extends Tree
{


    /**
     * Save Tree
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Yoma\FeedFinder\Model\Tree $model */
            $model = $this->_objectManager->create('Yoma\FeedFinder\Model\Tree');

            $id = $this->getRequest()->getParam('tree_id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'feedfinder_tree_prepare_save',
                ['post' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this Tree.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['tree_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the tree.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['tree_id' => $this->getRequest()->getParam('tree_id')]);

        }

        return $resultRedirect->setPath('*/*/');
    }
}