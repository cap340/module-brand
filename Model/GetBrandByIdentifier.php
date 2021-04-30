<?php

namespace Cap\Brand\Model;

use Cap\Brand\Api\GetBrandByIdentifierInterface;
use Cap\Brand\Api\Data\BrandInterface;
use Cap\Brand\Model\ResourceModel\Brand;

class GetBrandByIdentifier implements GetBrandByIdentifierInterface
{
    /**
     * @var BrandFactory
     */
    private $brandFactory;

    /**
     * @var ResourceModel\Brand
     */
    private $brandResource;

    /**
     * @param BrandFactory $brandFactory
     * @param ResourceModel\Brand $brandResource
     */
    public function __construct(
        BrandFactory $brandFactory,
        Brand $brandResource
    ) {
        $this->brandFactory = $brandFactory;
        $this->brandResource = $brandResource;
    }

    /**
     * @inheritdoc
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(string $identifier, int $storeId) : BrandInterface
    {
        $brand = $this->brandFactory->create();
        $brand->setStoreId($storeId);
        $this->brandResource->load($brand, $identifier, BrandInterface::IDENTIFIER);

        if (!$brand->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('The brand with the "%1" ID doesn\'t exist.', $identifier)
            );
        }

        return $brand;
    }
}
