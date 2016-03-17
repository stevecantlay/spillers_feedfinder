<?php
namespace Yoma\FeedFinder\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Symfony\Component\Config\Definition\Exception\Exception;
use Yoma\FeedFinder\Model\Tree;

class FeedFinder extends \Magento\Framework\View\Element\Template
{

    protected $_coreRegistry = null;

    protected $_tree;

    public function __construct(
        Context $context,
        Registry $registry,
        Tree $tree,
        array $data = []
    ) {
        $this->_tree = $tree;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getDecisionTree()
    {

        $tree = $this->_tree->load(3);

        if($tree->getId()){
            try{
                $contentXML = simplexml_load_string($tree->getContent(), null, LIBXML_NOERROR);
                return str_replace('> <','><',preg_replace('/\s+/', ' ', $tree->getContent()));
            }catch(Exception $e){

            }
        }

        return '';
    }
}
?>