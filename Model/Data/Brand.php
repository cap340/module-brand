<?php
declare(strict_types=1);

namespace Cap\Brand\Model\Data;

use Cap\Brand\Api\Data\BrandInterface;

//todo: Fix deprecated
class Brand extends \Magento\Framework\Api\AbstractExtensibleObject implements BrandInterface
{
    /**
     * Get id
     * @return string|null
     */
    public function getId()
    {
        return $this->_get(self::ID);
    }

    /**
     * Set id
     *
     * @param string $id
     *
     * @return BrandInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get title
     * @return string|null
     */
    public function getTitle()
    {
        return $this->_get(self::TITLE);
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return BrandInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Cap\Brand\Api\Data\BrandExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Cap\Brand\Api\Data\BrandExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Cap\Brand\Api\Data\BrandExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get category_id
     * @return string|null
     */
    public function getCategoryId()
    {
        return $this->_get(self::CATEGORY_ID);
    }

    /**
     * Set category_id
     *
     * @param string $categoryId
     *
     * @return BrandInterface
     */
    public function setCategoryId($categoryId)
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }

    /**
     * Get attribute_option
     * @return string|null
     */
    public function getAttributeOption()
    {
        return $this->_get(self::ATTRIBUTE_OPTION);
    }

    /**
     * Set attribute_option
     *
     * @param string $attributeOption
     *
     * @return BrandInterface
     */
    public function setAttributeOption($attributeOption)
    {
        return $this->setData(self::ATTRIBUTE_OPTION, $attributeOption);
    }

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive()
    {
        return $this->_get(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     *
     * @param string $isActive
     *
     * @return BrandInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get is_featured
     * @return string|null
     */
    public function getIsFeatured()
    {
        return $this->_get(self::IS_FEATURED);
    }

    /**
     * Set is_featured
     *
     * @param string $isFeatured
     *
     * @return BrandInterface
     */
    public function setIsFeatured($isFeatured)
    {
        return $this->setData(self::IS_FEATURED, $isFeatured);
    }

    /**
     * Get creation_time
     * @return string|null
     */
    public function getCreationTime()
    {
        return $this->_get(self::CREATION_TIME);
    }

    /**
     * Set creation_time
     * @param string $creationTime
     * @return BrandInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Get update_time
     * @return string|null
     */
    public function getUpdateTime()
    {
        return $this->_get(self::UPDATE_TIME);
    }

    /**
     * Set update_time
     * @param string $updateTime
     * @return BrandInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Get small_image
     * @return string|null
     */
    public function getSmallImage()
    {
        return $this->_get(self::SMALL_IMAGE);
    }

    /**
     * Set small_image
     * @param string $smallImage
     * @return BrandInterface
     */
    public function setSmallImage($smallImage)
    {
        return $this->setData(self::SMALL_IMAGE, $smallImage);
    }
}
