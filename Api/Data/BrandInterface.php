<?php

namespace Cap\Brand\Api\Data;

/**
 * Cap Brand interface.
 * @api
 */
interface BrandInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const BRAND_ID = 'brand_id';
    const IDENTIFIER = 'identifier';
    const TITLE = 'title';
    const CATEGORY_ID = 'category_id';
    const ATTRIBUTE_OPTION = 'attribute_option';
    const SMALL_IMAGE = 'small_image';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_ACTIVE = 'is_active';
    const IS_FEATURED = 'is_featured';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get category id
     *
     * @return string|null
     */
    public function getCategoryId();

    /**
     * Get attribute option
     *
     * @return string|null
     */
    public function getAttributeOption();

    /**
     * Get small image
     *
     * @return string|null
     */
    public function getSmallImage();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Is featured
     *
     * @return bool|null
     */
    public function isFeatured();

    /**
     * Set ID
     *
     * @param int $id
     * @return BrandInterface
     */
    public function setId($id);

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return BrandInterface
     */
    public function setIdentifier($identifier);

    /**
     * Set title
     *
     * @param string $title
     * @return BrandInterface
     */
    public function setTitle($title);

    /**
     * Set category ID
     *
     * @param string $categoryId
     * @return BrandInterface
     */
    public function setCategoryId($categoryId);

    /**
     * Set attribute option ID
     *
     * @param string $attributeOption
     * @return BrandInterface
     */
    public function setAttributeOption($attributeOption);

    /**
     * Set small image
     *
     * @param string $smallImage
     * @return BrandInterface
     */
    public function setSmallImage($smallImage);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return BrandInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return BrandInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return BrandInterface
     */
    public function setIsActive($isActive);

    /**
     * Set is featured
     *
     * @param bool|int $isFeatured
     * @return BrandInterface
     */
    public function setIsFeatured($isFeatured);
}
