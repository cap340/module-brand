<?php

namespace Cap\Brand\Block\Adminhtml\Category\Tab;

use Cap\Brand\Helper\Data;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;

// todo: get attribute code instead of id in grid
// todo: use select form to filter
// todo: remove deprecated

class Product extends \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * Product constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param Data $helper
     * @param array $data
     * @param Visibility|null $visibility
     * @param Status|null $status
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Registry $coreRegistry,
        Data $helper,
        array $data = [],
        Visibility $visibility = null,
        Status $status = null
    ) {
        $this->helper = $helper;
        parent::__construct(
            $context,
            $backendHelper,
            $productFactory,
            $coreRegistry,
            $data,
            $visibility,
            $status
        );
    }

    /**
     * Set collection object
     *
     * @param \Magento\Framework\Data\Collection $collection
     *
     * @return void
     */
    public function setCollection($collection)
    {
        $collection->addAttributeToSelect($this->getConfigBrandAttributeCode());
        parent::setCollection($collection);
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        parent::_prepareColumns();
        $brandAttribute = $this->getConfigBrandAttributeCode();
        $this->addColumnAfter($brandAttribute, [
            'header' => __('Brand'),
            'index' => $brandAttribute,
        ], 'sku');

        $this->sortColumnsByOrder();

        return $this;
    }

    /**
     * @return false|string
     */
    private function getConfigBrandAttributeCode()
    {
        return $this->helper->getConfigBrandAttributeCode();
    }
}
