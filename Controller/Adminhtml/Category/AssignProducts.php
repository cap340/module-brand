<?php

namespace Cap\Brand\Controller\Adminhtml\Category;

use Cap\Brand\Helper\Data;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

//todo: add loader & warning could be long to execute

class AssignProducts extends Action
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
     * @var CategoryLinkManagementInterface
     */
    protected $categoryLinkManagement;

    /**
     * AssignProducts constructor.
     *
     * @param Context $context
     * @param ProductCollectionFactory $productCollectionFactory
     * @param Data $helper
     * @param Status $productStatus
     * @param Visibility $productVisibility
     * @param CategoryLinkManagementInterface $categoryLinkManagement
     */
    public function __construct(
        Context $context,
        ProductCollectionFactory $productCollectionFactory,
        Data $helper,
        Status $productStatus,
        Visibility $productVisibility,
        CategoryLinkManagementInterface $categoryLinkManagement
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->helper = $helper;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        $this->categoryLinkManagement = $categoryLinkManagement;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $collection = $this->getProductCollection();
        $i = 0;
        // check if collection has data
        if ($collection->getSize()) {
            /** @var Product $product */
            foreach ($collection as $product) {
                // check if the product has a brand attribute
                if ($this->helper->getProductBrand($product)) {
                    $brand = $this->helper->getProductBrand($product);
                    $categoryIds = $product->getCategoryIds();
                    // check if the product is already assigned to is corresponding brand category
                    if (! in_array($brand->getCategoryId(), $categoryIds)) {
                        $categoryIds = array_merge($categoryIds, [$brand->getCategoryId()]); //phpcs:ignore
                        $this->assignProductToCategories(
                            $product->getSku(),
                            $categoryIds
                        );
                        $i++;
                    }
                }
            }
            switch ($i) {
                case 0:
                    $successMessage = __('All products are already associated.');
                    break;
                case 1:
                    $successMessage = __('1 product has been successfully associated.');
                    break;
                default:
                    $successMessage = __('%1 product(s) have been successfully associated', $i);
            }
            $this->messageManager->addSuccessMessage($successMessage);
        } else {
            // if collection is empty
            $this->messageManager->addErrorMessage('Sorry, no products have brand to assign.');
        }

        return $resultRedirect->setPath('cap_brand/brand/');
    }

    /**
     * Assigned Product to single/multiple Category
     *
     * @param string $productSku
     * @param int[] $categoryIds
     *
     * @return bool
     */
    public function assignProductToCategories(string $productSku, array $categoryIds)
    {
        return $this->categoryLinkManagement->assignProductToCategories($productSku, $categoryIds);
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    private function getProductCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        // Filter product visibility
        $collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
        $collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
        // Filter product with brand attribute
        $collection->addAttributeToFilter(
            $this->helper->getConfigBrandAttributeCode(),
            ['neq' => '']
        );

        return $collection;
    }
}
