<?php
declare(strict_types=1);

namespace Cap\Brand\Model\ResourceModel\Brand;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'brand_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Cap\Brand\Model\Brand::class,
            \Cap\Brand\Model\ResourceModel\Brand::class
        );
    }
}
