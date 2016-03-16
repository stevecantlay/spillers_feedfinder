<?php

namespace Yoma\FeedFinder\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Yoma\FeedFinder\Model\TreeFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;

abstract class Tree extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * News model factory
     *
     * @var \Yoma\FeedFinder\Model\TreeFactory
     */
    protected $_treeFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\Forward
     */
    protected $resultForwardFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param TreeFactory $treeFactory
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        TreeFactory $treeFactory,
        ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_treeFactory = $treeFactory;
        $this->resultForwardFactory = $resultForwardFactory;

    }

    /**
     * News access rights checking
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Yoma_FeedFinder::decision_trees');
    }
}
