<?php

namespace Cap\Brand\Model\ResourceModel\Brand\Relation\Store;

use Cap\Brand\Model\ResourceModel\Brand;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

class ReadHandler implements ExtensionInterface
{
    /**
     * @var \Cap\Brand\Model\ResourceModel\Brand
     */
    protected $resourceBrand;

    /**
     * @param \Cap\Brand\Model\ResourceModel\Brand $resourceBrand
     */
    public function __construct(
        Brand $resourceBrand
    ) {
        $this->resourceBrand = $resourceBrand;
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return object
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute($entity, $arguments = [])
    {
        if ($entity->getId()) {
            $stores = $this->resourceBrand->lookupStoreIds((int)$entity->getId());
            $entity->setData('store_id', $stores);
            $entity->setData('stores', $stores);
        }
        return $entity;
    }
}
