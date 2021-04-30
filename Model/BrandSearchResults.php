<?php

declare(strict_types=1);

namespace Cap\Brand\Model;

use Cap\Brand\Api\Data\BrandSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class BrandSearchResults extends SearchResults implements BrandSearchResultsInterface
{
}
