<?php


namespace Mark\Test1\Api\Data;

interface BlogSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Blog list.
     * @return \Mark\Test1\Api\Data\BlogInterface[]
     */
    
    public function getItems();

    /**
     * Set Content list.
     * @param \Mark\Test1\Api\Data\BlogInterface[] $items
     * @return $this
     */
    
    public function setItems(array $items);
}
