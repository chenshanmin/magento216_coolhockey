<?php


namespace Mark\Test1\Model;

use Mark\Test1\Api\Data\BlogInterface;

class Blog extends \Magento\Framework\Model\AbstractModel implements BlogInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mark\Test1\Model\ResourceModel\Blog');
    }

    /**
     * Get id
     * @return string
     */
    public function getId()
    {
        return $this->getData(self::BLOG_ID);
    }

    /**
     * Set id
     * @param string $blogId
     * @return Mark\Test1\Api\Data\BlogInterface
     */
    public function setId($blogId)
    {
        return $this->setData(self::BLOG_ID, $blogId);
    }

    /**
     * Get Content
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Set Content
     * @param string $Content
     * @return Mark\Test1\Api\Data\BlogInterface
     */
    public function setContent($Content)
    {
        return $this->setData(self::CONTENT, $Content);
    }
}
