<?php


namespace Mark\Test1\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface BlogRepositoryInterface
{


    /**
     * Save Blog
     * @param \Mark\Test1\Api\Data\BlogInterface $blog
     * @return \Mark\Test1\Api\Data\BlogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(\Mark\Test1\Api\Data\BlogInterface $blog);

    /**
     * Retrieve Blog
     * @param string $blogId
     * @return \Mark\Test1\Api\Data\BlogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($blogId);

    /**
     * Retrieve Blog matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Mark\Test1\Api\Data\BlogSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Blog
     * @param \Mark\Test1\Api\Data\BlogInterface $blog
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(\Mark\Test1\Api\Data\BlogInterface $blog);

    /**
     * Delete Blog by ID
     * @param string $blogId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($blogId);
}
