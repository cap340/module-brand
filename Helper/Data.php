<?php

namespace Cap\Brand\Helper;

use Cap\Brand\Api\Data\BrandInterface;
use Cap\Brand\Model\BrandRepository;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var Attribute
     */
    protected $eavModel;

    /**
     * @var BrandRepository
     */
    protected $brandRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepositoryInterface;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param CategoryRepository $categoryRepository
     * @param Attribute $eavModel
     * @param BrandRepository $brandRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param AttributeRepositoryInterface $attributeRepositoryInterface
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        CategoryRepository $categoryRepository,
        Attribute $eavModel,
        BrandRepository $brandRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        AttributeRepositoryInterface $attributeRepositoryInterface
    ) {
        $this->storeManager = $storeManager;
        $this->categoryRepository = $categoryRepository;
        $this->eavModel = $eavModel;
        $this->brandRepository = $brandRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->attributeRepositoryInterface = $attributeRepositoryInterface;

        parent::__construct($context);
    }

    /** CONFIG */

    /**
     * Returns Parent brands category ID from config.
     *
     * @return mixed
     */
    public function getConfigBrandParentCategoryId()
    {
        return $this->scopeConfig->getValue(
            'cap_brand/general/parent_category_id',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getConfigBrandAttributeCode()
    {
        $attributeCodeId = $this->scopeConfig->getValue(
            'cap_brand/general/attribute_id',
            ScopeInterface::SCOPE_STORE
        );

        try {
            $attribute = $this->attributeRepositoryInterface->get(4, $attributeCodeId);

            return $attribute->getAttributeCode();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->_logger->error($e->getMessage());

            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getConfigSmallImageWidth()
    {
        return $this->scopeConfig->getValue(
            'cap_brand/product_page_settings/img_width',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getConfigRelatedProductPerRow()
    {
        return $this->scopeConfig->getValue(
            'cap_brand/product_page_settings/product_per_row',
            ScopeInterface::SCOPE_STORE
        );
    }

    /** BRAND HELPERS */

    /**
     * Returns Brand interface using search criteria.
     *
     * @param $attributeOption
     *
     * @return false|BrandInterface
     */
    public function getBrandByAttributeOption($attributeOption)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('attribute_option', $attributeOption)
            ->setPageSize(1)
            ->setCurrentPage(1)
            ->create();
        try {
            $brandList = $this->brandRepository->getList($searchCriteria);

            return current($brandList->getItems());
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->_logger->error($e->getMessage());

            return false;
        }
    }

    /**
     * Returns Brand interface using search criteria.
     *
     * @param $categoryId
     *
     * @return false|BrandInterface
     */
    public function getBrandByCategoryId($categoryId)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('category_id', $categoryId)
            ->setPageSize(1)
            ->setCurrentPage(1)
            ->create();
        try {
            $brandList = $this->brandRepository->getList($searchCriteria);

            // Only return first item as category_id is unique in db
            return current($brandList->getItems());
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->_logger->error($e->getMessage());

            return false;
        }
    }

    /**
     * @param BrandInterface $brand
     *
     * @return false|string
     */
    public function getBrandSmallImageUrl(BrandInterface $brand)
    {
        try {
            $mediaUrl = $this->storeManager->getStore()
                                           ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

            return $mediaUrl . $brand->getSmallImage();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->_logger->error($e->getMessage());

            return false;
        }
    }

    /**
     * Returns corresponding category url for brand.
     *
     * @param BrandInterface $brand
     *
     * @return false|string
     */
    public function getBrandUrl(BrandInterface $brand)
    {
        $categoryId = $brand->getCategoryId();
        try {
            $category = $this->categoryRepository->get(
                $categoryId,
                $this->storeManager->getStore()->getId()
            );

            return $category->getUrl();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->_logger->error($e->getMessage());

            return false;
        }
    }

    /**
     * @return bool
     */
    public function canShowBrandImage()
    {
        $showBrand = $this->scopeConfig->getValue(
            'cap_brand/product_page_settings/show_brand_img',
            ScopeInterface::SCOPE_STORE
        );
        if ($showBrand) {
            return true;
        }

        return false;
    }

    /** PRODUCT HELPERS */

    /**
     * Returns Brand using Product's attribute option.
     *
     * @param Product $product
     *
     * @return false|BrandInterface
     */
    public function getProductBrand(Product $product)
    {
        $attributeCode = $this->getConfigBrandAttributeCode();
        $attributeOption = $product->getData($attributeCode);

        return $this->getBrandByAttributeOption($attributeOption);
    }
}
