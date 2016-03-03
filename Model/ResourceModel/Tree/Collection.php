<?php
namespace Yoma\FeedFinder\Model\ResourceModel\Tree;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'tree_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Yoma\FeedFinder\Model\Tree', 'Yoma\FeedFinder\Model\ResourceModel\Tree');
    }

}