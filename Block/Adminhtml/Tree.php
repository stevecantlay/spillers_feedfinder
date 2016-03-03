<?php

namespace Yoma\FeedFinder\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Tree extends Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_tree';
        $this->_blockGroup = 'Yoma_FeedFinder';
        $this->_headerText = __('Manage Trees');
        $this->_addButtonLabel = __('Add Tree');
        parent::_construct();
    }
}