<?php namespace Yoma\FeedFinder\Model;

use Yoma\FeedFinder\Api\Data\TreeInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Tree  extends \Magento\Framework\Model\AbstractModel implements TreeInterface, IdentityInterface
{
    /**#@+
     * Tree's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'feedfinder_tree';

    /**
     * @var string
     */
    protected $_cacheTag = 'feedfinder_tree';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'feedfinder_tree';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Yoma\FeedFinder\Model\ResourceModel\Tree');
    }


    /**
     * Prepare tree's statuses.
     * Available event feedfinder_tree_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::TREE_ID);
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive()
    {
        return (bool) $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setId($id)
    {
        return $this->setData(self::TREE_ID, $id);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set creation time
     *
     * @param string $creation_time
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setCreationTime($creation_time)
    {
        return $this->setData(self::CREATION_TIME, $creation_time);
    }

    /**
     * Set update time
     *
     * @param string $update_time
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setUpdateTime($update_time)
    {
        return $this->setData(self::UPDATE_TIME, $update_time);
    }

    /**
     * Set is active
     *
     * @param int|bool $is_active
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setIsActive($is_active)
    {
        return $this->setData(self::IS_ACTIVE, $is_active);
    }

}