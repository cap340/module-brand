<?php

namespace Cap\Brand\Api;

/**
 * Command to load the brand data by specified identifier
 * @api
 */
interface GetBrandByIdentifierInterface
{
    /**
     * Load brand data by given block identifier.
     *
     * @param string $identifier
     * @param int $storeId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Cap\Brand\Api\Data\BrandInterface
     */
    public function execute(string $identifier, int $storeId) : \Cap\Brand\Api\Data\BrandInterface;
}
