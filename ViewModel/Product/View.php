<?php

namespace Cap\Brand\ViewModel\Product;

use Cap\Brand\Api\Data\BrandInterface;
use Cap\Brand\Helper\Data;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class View implements ArgumentInterface
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * View constructor.
     *
     * @param Data $helper
     * @param ProductRepository $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CategoryFactory $categoryFactory
     * @param ProductCollectionFactory $productCollectionFactory
     */
    public function __construct(
        Data $helper,
        ProductRepository $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CategoryFactory $categoryFactory,
        ProductCollectionFactory $productCollectionFactory
    ) {
        $this->helper = $helper;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->categoryFactory = $categoryFactory;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * @param Product $product
     *
     * @return false|BrandInterface
     */
    public function getProductBrand(Product $product)
    {
        return $this->helper->getProductBrand($product);
    }

    /**
     * @param BrandInterface $brand
     *
     * @return false|string
     */
    public function getBrandUrl(BrandInterface $brand)
    {
        return $this->helper->getBrandUrl($brand);
    }

    /**
     * @param BrandInterface $brand
     *
     * @return string
     */
    public function getBrandSmallImageUrl(BrandInterface $brand)
    {
        return $this->helper->getBrandSmallImageUrl($brand);
    }

    /**
     * @return bool
     */
    public function canShowBrandImage()
    {
        return $this->helper->canShowBrandImage();
    }

    /**
     * @return mixed
     */
    public function getBrandSmallImageWidth()
    {
        return $this->helper->getConfigSmallImageWidth();
    }

    /**
     * @param Product $product
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductRelatedBrandCollection(Product $product)
    {
        $brand = $this->helper->getProductBrand($product);
        $categoryId = $brand->getCategoryId();
        $category = $this->categoryFactory->create()->load($categoryId);
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoryFilter($category);
        $collection->addAttributeToFilter(
            'visibility',
            \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH
        );
        $collection->addAttributeToFilter(
            'status',
            \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED
        );
        // for random collection
        $collection->getSelect()->orderRand();
        $collection->setPageSize(5);

        return $collection;
    }

    /**
     * Find out if some products can be easy added to cart
     *
     * @return bool
     */
    public function canItemsAddToCart(Product $product)
    {
        foreach ($this->getProductRelatedBrandCollection($product) as $item) {
            if (!$item->isComposite() && $item->isSaleable() && !$item->getRequiredOptions()) {
                return true;
            }
        }
        return false;
    }
}
