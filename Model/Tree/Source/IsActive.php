<?php
namespace Yoma\FeedFinder\Model\Tree\Source;

class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Yoma\FeedFinder\Model\Tree
     */
    protected $tree;

    /**
     * Constructor
     *
     * @param \Yoma\FeedFinder\Model\Tree $tree
     */
    public function __construct(\Yoma\FeedFinder\Model\Tree $tree)
    {
        $this->tree = $tree;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->tree->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}