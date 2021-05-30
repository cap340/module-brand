<?php
declare(strict_types=1);

namespace Cap\Brand\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Cap\Brand\Api\Data\BrandInterface;

/**
 * @api
 * @since 104.0.2
 */
interface BrandRepositoryInterface
{
    /**
     * Save Brand
     *
     * @param BrandInterface $brand
     *
     * @return BrandInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(BrandInterface $brand);

    /**
     * Retrieve Brand
     *
     * @param string $brandId
     *
     * @return BrandInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($brandId);

    /**
     * Retrieve Brand matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return \Cap\Brand\Api\Data\BrandSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Brand
     *
     * @param BrandInterface $brand
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(BrandInterface $brand);

    /**
     * Delete Brand by ID
     *
     * @param string $brandId
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($brandId);
}
