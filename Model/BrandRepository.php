<?php
declare(strict_types=1);

namespace Cap\Brand\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Cap\Brand\Api\BrandRepositoryInterface;
use Cap\Brand\Api\Data\BrandInterfaceFactory;
use Cap\Brand\Api\Data\BrandSearchResultsInterfaceFactory;
use Cap\Brand\Model\ResourceModel\Brand as ResourceBrand;
use Cap\Brand\Model\ResourceModel\Brand\CollectionFactory as BrandCollectionFactory;

class BrandRepository implements BrandRepositoryInterface
{
    /**
     * @var BrandInterfaceFactory
     */
    protected $dataBrandFactory;

    /**
     * @var BrandFactory
     */
    protected $brandFactory;

    /**
     * @var ResourceBrand
     */
    protected $resource;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var BrandSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var BrandCollectionFactory
     */
    protected $brandCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceBrand $resource
     * @param BrandFactory $brandFactory
     * @param BrandInterfaceFactory $dataBrandFactory
     * @param BrandCollectionFactory $brandCollectionFactory
     * @param BrandSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceBrand $resource,
        BrandFactory $brandFactory,
        BrandInterfaceFactory $dataBrandFactory,
        BrandCollectionFactory $brandCollectionFactory,
        BrandSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->brandFactory = $brandFactory;
        $this->brandCollectionFactory = $brandCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataBrandFactory = $dataBrandFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Cap\Brand\Api\Data\BrandInterface $brand
    ) {
        /* if (empty($brand->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $brand->setStoreId($storeId);
        } */

        $brandData = $this->extensibleDataObjectConverter->toNestedArray(
            $brand,
            [],
            \Cap\Brand\Api\Data\BrandInterface::class
        );

        $brandModel = $this->brandFactory->create()->setData($brandData);

        try {
            $this->resource->save($brandModel);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__(
                'Could not save the brand: %1',
                $exception->getMessage()
            ));
        }
        return $brandModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($brandId)
    {
        $brand = $this->brandFactory->create();
        $this->resource->load($brand, $brandId);
        if (!$brand->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Brand with id "%1" does not exist.', $brandId)
            );
        }
        return $brand->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->brandCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Cap\Brand\Api\Data\BrandInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Cap\Brand\Api\Data\BrandInterface $brand
    ) {
        try {
            $brandModel = $this->brandFactory->create();
            $this->resource->load($brandModel, $brand->getBrandId());
            $this->resource->delete($brandModel);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__(
                'Could not delete the Brand: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($brandId)
    {
        return $this->delete($this->get($brandId));
    }
}
