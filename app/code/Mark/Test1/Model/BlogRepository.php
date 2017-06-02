<?php


namespace Mark\Test1\Model;

use Mark\Test1\Api\BlogRepositoryInterface;
use Mark\Test1\Api\Data\BlogSearchResultsInterfaceFactory;
use Mark\Test1\Api\Data\BlogInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Mark\Test1\Model\ResourceModel\Blog as ResourceBlog;
use Mark\Test1\Model\ResourceModel\Blog\CollectionFactory as BlogCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class BlogRepository implements BlogRepositoryInterface
{

    protected $resource;

    protected $BlogFactory;

    protected $BlogCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataBlogFactory;

    private $storeManager;


    /**
     * @param ResourceBlog $resource
     * @param BlogFactory $blogFactory
     * @param BlogInterfaceFactory $dataBlogFactory
     * @param BlogCollectionFactory $blogCollectionFactory
     * @param BlogSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceBlog $resource,
        BlogFactory $blogFactory,
        BlogInterfaceFactory $dataBlogFactory,
        BlogCollectionFactory $blogCollectionFactory,
        BlogSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->blogFactory = $blogFactory;
        $this->blogCollectionFactory = $blogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataBlogFactory = $dataBlogFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Mark\Test1\Api\Data\BlogInterface $blog)
    {
        /* if (empty($blog->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $blog->setStoreId($storeId);
        } */
        try {
            $this->resource->save($blog);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the blog: %1',
                $exception->getMessage()
            ));
        }
        return $blog;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($blogId)
    {
        $blog = $this->blogFactory->create();
        $blog->load($blogId);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(__('Blog with id "%1" does not exist.', $blogId));
        }
        return $blog;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $collection = $this->blogCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $items = [];
        
        foreach ($collection as $blogModel) {
            $blogData = $this->dataBlogFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $blogData,
                $blogModel->getData(),
                'Mark\Test1\Api\Data\BlogInterface'
            );
            $items[] = $this->dataObjectProcessor->buildOutputDataArray(
                $blogData,
                'Mark\Test1\Api\Data\BlogInterface'
            );
        }
        $searchResults->setItems($items);
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\Mark\Test1\Api\Data\BlogInterface $blog)
    {
        try {
            $this->resource->delete($blog);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Blog: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($blogId)
    {
        return $this->delete($this->getById($blogId));
    }
}
