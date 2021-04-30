<?php

namespace Cap\Brand\Model\Config\Source;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection;
use Magento\Framework\Data\OptionSourceInterface;

class Attributes implements OptionSourceInterface
{
    /**
     * @var Collection
     */
    protected $eavCollection;

    /**
     * Attributes constructor.
     *
     * @param Collection $eavCollection
     */
    public function __construct(
        Collection $eavCollection
    ) {
        $this->eavCollection = $eavCollection;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->eavCollection->addFieldToFilter(
            \Magento\Eav\Model\Entity\Attribute\Set::KEY_ENTITY_TYPE_ID,
            4
        )->getItems();

        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value->getData('attribute_code'),
                'value' => $key,
            ];
        }

        return $options;
    }
}
