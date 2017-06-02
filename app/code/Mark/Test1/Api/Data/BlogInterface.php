<?php


namespace Mark\Test1\Api\Data;

interface BlogInterface
{

    const CONTENT = 'Content';
    const BLOG_ID = 'id';


    /**
     * Get id
     * @return string|null
     */
    
    public function getId();

    /**
     * Set id
     * @param string $id
     * @return Mark\Test1\Api\Data\BlogInterface
     */
    
    public function setId($blogId);

    /**
     * Get Content
     * @return string|null
     */
    
    public function getContent();

    /**
     * Set Content
     * @param string $Content
     * @return Mark\Test1\Api\Data\BlogInterface
     */
    
    public function setContent($Content);
}
