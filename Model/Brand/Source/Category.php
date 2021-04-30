<?php

namespace Cap\Brand\Model\Brand\Source;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Data\OptionSourceInterface;
use Cap\Brand\Helper\Data;

class Category implements OptionSourceInterface
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * Category constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param Data $helper
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        Data $helper
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->helper = $helper;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function toOptionArray()
    {
//        $parentCategoryId = $this->helper->getConfigBrandParentCategoryId();
        $parentCategoryId = 711;
        $categoryObj = $this->categoryRepository->get($parentCategoryId);
        $availableOptions = $categoryObj->getChildrenCategories();

        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value->getName(),
                'value' => $key,
            ];
        }

        return $options;
    }
}
