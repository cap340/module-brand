<?php

namespace Cap\Brand\Model;

use Cap\Brand\Api\Data\BrandInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Brand model
 *
 * @method Brand setStoreId(int $storeId)
 * @method int getStoreId()
 */
class Brand extends AbstractModel implements BrandInterface, IdentityInterface
{
    /**
     * Cap brand cache tag
     */
    const CACHE_TAG = 'cap_b';

    /**#@+
     * Brand's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'cap_brand';

    /**
     * Construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Brand::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * Retrieve brand id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::BRAND_ID);
    }

    /**
     * Retrieve brand identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return (string)$this->getData(self::IDENTIFIER);
    }

    /**
     * Retrieve brand title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Retrieve brand category ID
     *
     * @return string
     */
    public function getCategoryId()
    {
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * Retrieve brand attribute option
     *
     * @return string
     */
    public function getAttributeOption()
    {
        return $this->getData(self::ATTRIBUTE_OPTION);
    }

    /**
     * Retrieve brand small image
     *
     * @return string
     */
    public function getSmallImage()
    {
        return $this->getData(self::SMALL_IMAGE);
    }

    /**
     * Retrieve brand creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve brand update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Is featured
     *
     * @return bool
     */
    public function isFeatured()
    {
        return (bool)$this->getData(self::IS_FEATURED);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return BrandInterface
     */
    public function setId($id)
    {
        return $this->setData(self::BRAND_ID, $id);
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return BrandInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BrandInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set category ID
     *
     * @param string $categoryId
     * @return BrandInterface
     */
    public function setCategoryId($categoryId)
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }

    /**
     * Set attribute option
     *
     * @param string $attributeOption
     * @return BrandInterface
     */
    public function setAttributeOption($attributeOption)
    {
        return $this->setData(self::ATTRIBUTE_OPTION, $attributeOption);
    }

    /**
     * Set small image
     *
     * @param string $smallImage
     * @return BrandInterface
     */
    public function setSmallImage($smallImage)
    {
        return $this->setData(self::SMALL_IMAGE, $smallImage);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return BrandInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return BrandInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return BrandInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Set is featured
     *
     * @param bool|int $isFeatured
     * @return BrandInterface
     */
    public function setIsFeatured($isFeatured)
    {
        return $this->setData(self::IS_FEATURED, $isFeatured);
    }

    /**
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : $this->getData('store_id');
    }

    /**
     * Prepare brand's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
