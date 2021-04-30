<?php

namespace Cap\Brand\Model\Brand\Source;

use Magento\Framework\Data\OptionSourceInterface;

class IsActive implements OptionSourceInterface
{
    /**
     * @var \Cap\Brand\Model\Brand
     */
    protected $brand;

    /**
     * Constructor
     *
     * @param \Cap\Brand\Model\Brand $brand
     */
    public function __construct(\Cap\Brand\Model\Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->brand->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
