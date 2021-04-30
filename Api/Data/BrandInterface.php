<?php
declare(strict_types=1);

namespace Cap\Brand\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface BrandInterface extends ExtensibleDataInterface
{
    const ID = 'brand_id';
    const TITLE = 'title';
    const CATEGORY_ID = 'category_id';
    const ATTRIBUTE_OPTION = 'attribute_option';
    const IS_ACTIVE = 'is_active';
    const IS_FEATURED = 'is_featured';
    const SMALL_IMAGE = 'small_image';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     *
     * @param string $id
     *
     * @return BrandInterface
     */
    public function setId($id);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     *
     * @param string $title
     *
     * @return BrandInterface
     */
    public function setTitle($title);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return BrandExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param BrandExtensionInterface $extensionAttributes
     *
     * @return $this
     */
    public function setExtensionAttributes(BrandExtensionInterface $extensionAttributes);

    /**
     * Get category_id
     * @return string|null
     */
    public function getCategoryId();

    /**
     * Set category_id
     *
     * @param string $categoryId
     *
     * @return BrandInterface
     */
    public function setCategoryId($categoryId);

    /**
     * Get attribute_option
     * @return string|null
     */
    public function getAttributeOption();

    /**
     * Set attribute_option
     *
     * @param string $attributeOption
     *
     * @return BrandInterface
     */
    public function setAttributeOption($attributeOption);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     *
     * @param string $isActive
     *
     * @return BrandInterface
     */
    public function setIsActive($isActive);

    /**
     * Get is_featured
     * @return string|null
     */
    public function getIsFeatured();

    /**
     * Set is_featured
     *
     * @param string $isFeatured
     *
     * @return BrandInterface
     */
    public function setIsFeatured($isFeatured);

    /**
     * Get creation_time
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Set creation_time
     * @param string $creationTime
     * @return BrandInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Get update_time
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Set update_time
     * @param string $updateTime
     * @return BrandInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Get small_image
     * @return string|null
     */
    public function getSmallImage();

    /**
     * Set small_image
     * @param string $smallImage
     * @return BrandInterface
     */
    public function setSmallImage($smallImage);
}
