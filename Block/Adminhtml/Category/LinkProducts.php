<?php

namespace Cap\Brand\Block\Adminhtml\Category;

use Cap\Brand\Helper\Data;
use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;

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
     * LinkProducts constructor.
     *
     * @param Template\Context $context
     * @param ProductCollectionFactory $productCollectionFactory
     * @param Data $helper
     * @param Status $productStatus
     * @param Visibility $productVisibility
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductCollectionFactory $productCollectionFactory,
        Data $helper,
        Status $productStatus,
        Visibility $productVisibility,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->helper = $helper;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
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
        $collection->setPageSize(30);

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
}
