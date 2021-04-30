<?php

namespace Cap\Brand\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for brand search results.
 * @api
 */
interface BrandSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get brand list.
     *
     * @return \Cap\Brand\Api\Data\BrandInterface[]
     */
    public function getItems();

    /**
     * Set brand list.
     *
     * @param \Cap\Brand\Api\Data\BrandInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
