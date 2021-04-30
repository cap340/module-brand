<?php

namespace Cap\Brand\Model\ResourceModel\Brand;

use Cap\Brand\Api\Data\BrandInterface;
use Cap\Brand\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'brand_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'cap_brand_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'brand_collection';

    /**
     * Perform operations after collection load
     *
     * @return $this
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Exception
     */
    protected function _afterLoad()
    {
        $entityMetadata = $this->metadataPool->getMetadata(BrandInterface::class);

        $this->performAfterLoad('cap_brand_store', $entityMetadata->getLinkField());

        return parent::_afterLoad();
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Cap\Brand\Model\Brand::class, \Cap\Brand\Model\ResourceModel\Brand::class);
        $this->_map['fields']['store'] = 'store_table.store_id';
        $this->_map['fields']['brand_id'] = 'main_table.brand_id';
    }

    /**
     * Returns pairs brand_id - title
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('brand_id', 'title');
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);

        return $this;
    }

    /**
     * Join store relation table if there is store filter
     *
     * @return void
     * @throws \Exception
     */
    protected function _renderFiltersBefore()
    {
        $entityMetadata = $this->metadataPool->getMetadata(BrandInterface::class);
        $this->joinStoreRelationTable('cap_brand_store', $entityMetadata->getLinkField());
    }
}
