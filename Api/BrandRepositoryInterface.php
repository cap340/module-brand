<?php

namespace Cap\Brand\Api;

/**
 * Brand CRUD interface.
 * @api
 */
interface BrandRepositoryInterface
{
    /**
     * Save brand.
     *
     * @param \Cap\Brand\Api\Data\BrandInterface $brand
     * @return \Cap\Brand\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\BrandInterface $brand);

    /**
     * Retrieve brand.
     *
     * @param string $brandId
     * @return \Cap\Brand\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($brandId);

    /**
     * Retrieve brands matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Cap\Brand\Api\Data\BrandSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete brand.
     *
     * @param \Cap\Brand\Api\Data\BrandInterface $brand
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\BrandInterface $brand);

    /**
     * Delete brand by ID.
     *
     * @param string $brandId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($brandId);
}
