<?php

namespace Cap\Brand\Model\Brand\Source;

use Magento\Eav\Model\Config;
use Magento\Framework\Data\OptionSourceInterface;
use Cap\Brand\Helper\Data;

class AttributeOption implements OptionSourceInterface
{
    /**
     * @var Config
     */
    protected $eavConfig;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * AttributeOptions constructor.
     *
     * @param Config $eavConfig
     * @param Data $helper
     */
    public function __construct(
        Config $eavConfig,
        Data $helper
    ) {
        $this->eavConfig = $eavConfig;
        $this->helper = $helper;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
//        $attributeCode = $this->helper->getConfigBrandAttributeCode();
        $attributeCode = 375;
        try {
            $attribute = $this->eavConfig->getAttribute('catalog_product', $attributeCode);

            return $attribute->getSource()->getAllOptions();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return false;
        }
    }
}
