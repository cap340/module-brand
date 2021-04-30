<?php

namespace Cap\Brand\ViewModel\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Cap\Brand\Api\Data\BrandInterface;
use Cap\Brand\Helper\Data;

class View implements ArgumentInterface
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * View constructor.
     *
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
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
}
