<?php

namespace Cap\Brand\Block\Footer;

use Cap\Brand\Helper\Data;
use Magento\Framework\App\DefaultPathInterface;
use Magento\Framework\View\Element\Template\Context;

class Links extends \Magento\Framework\View\Element\Html\Link\Current
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * Links constructor.
     *
     * @param Context $context
     * @param DefaultPathInterface $defaultPath
     * @param Data $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        DefaultPathInterface $defaultPath,
        Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $defaultPath, $data);
    }

    //todo: if current link
    protected function _toHtml()
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }

        $brands = $this->helper->getFeaturedBrands();

        $html = [];
        /** @var \Cap\Brand\Api\Data\BrandInterface $brand */
        foreach ($brands as $brand) {
            $html[] = '<li class="nav item">' . '<a href="' . $this->helper->getBrandUrl($brand)
                      . '" title="' . $brand->getTitle() . '">' . $brand->getTitle() . '</a></li>';
        }

        return implode('', $html);
    }
}
