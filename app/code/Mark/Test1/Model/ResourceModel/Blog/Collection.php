<?php


namespace Mark\Test1\Model\ResourceModel\Blog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Mark\Test1\Model\Blog',
            'Mark\Test1\Model\ResourceModel\Blog'
        );
    }
}
