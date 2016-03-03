<?php
namespace Yoma\FeedFinder\Api\Data;


interface TreeInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const TREE_ID       = 'tree_id';
    const TITLE         = 'title';
    const CONTENT       = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const IS_ACTIVE     = 'is_active';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param string $title
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setTitle($title);

    /**
     * Set content
     *
     * @param string $content
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setContent($content);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \Yoma\FeedFinder\Api\Data\TreeInterface
     */
    public function setIsActive($isActive);
}
