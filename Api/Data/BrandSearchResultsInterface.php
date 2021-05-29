<?php
declare(strict_types=1);

namespace Cap\Brand\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface BrandSearchResultsInterface
 * @api
 */
interface BrandSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Brand list.
     * @return \Cap\Brand\Api\Data\BrandInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \Cap\Brand\Api\Data\BrandInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
