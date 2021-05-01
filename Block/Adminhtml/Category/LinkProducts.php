<?php

namespace Cap\Brand\Block\Adminhtml\Category;

use Cap\Brand\Helper\Data;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Model\CategoryLinkRepository;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template;

//todo: remove after test complete

class LinkProducts extends Template
{
    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var CategoryCollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @var Status
     */
    protected $productStatus;

    /**
     * @var Visibility
     */
    protected $productVisibility;

    /**
     * @var CategoryLinkRepository
     */
    protected $categoryLinkRepository;

    /**
     * LinkProducts constructor.
     *
     * @param Template\Context $context
     * @param ProductCollectionFactory $productCollectionFactory
     * @param Data $helper
     * @param Status $productStatus
     * @param Visibility $productVisibility
     * @param CategoryLinkRepository $categoryLinkRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductCollectionFactory $productCollectionFactory,
        Data $helper,
        Status $productStatus,
        Visibility $productVisibility,
        CategoryLinkRepository $categoryLinkRepository,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->helper = $helper;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        $this->categoryLinkRepository = $categoryLinkRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        // Filter product visibility
        $collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
        $collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
        // Filter product with brand attribute
        $collection->addAttributeToFilter($this->getConfigBrandAttributeCode(), ['neq' => '']);
        $collection->setPageSize(100);

        return $collection;
    }

    /**
     * Get config brand attribute code to filter.
     *
     * @return false|string
     */
    public function getConfigBrandAttributeCode()
    {
        return $this->helper->getConfigBrandAttributeCode();
    }

    /**
     * @param Product $product
     *
     * @return \Cap\Brand\Api\Data\BrandInterface|false
     */
    public function getProductBrand(Product $product)
    {
        return $this->helper->getProductBrand($product);
    }

    /**
     * @param Product $product
     * @param $categoryIds
     */
    public function assignProductsToCategory(Product $product, $categoryIds)
    {
        $this->getCategoryLinkManagement()
             ->assignProductToCategories(
                 $product->getSku(),
                 $categoryIds
             );
    }

    /**
     * @return CategoryLinkManagementInterface|CategoryLinkRepository|mixed
     */
    private function getCategoryLinkManagement()
    {
        if (null === $this->categoryLinkRepository) {
            $this->categoryLinkRepository = ObjectManager::getInstance()
                                                         ->get(CategoryLinkManagementInterface::class);
        }

        return $this->categoryLinkRepository;
    }
}
