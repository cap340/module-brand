<?php

namespace Cap\Brand\Block\Adminhtml\Brand\Edit;

use Cap\Brand\Api\BrandRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var BrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        Context $context,
        BrandRepositoryInterface $brandRepository
    ) {
        $this->context = $context;
        $this->brandRepository = $brandRepository;
    }

    /**
     * Return brand ID
     *
     * @return int|null
     */
    public function getBrandId()
    {
        try {
            return $this->brandRepository->getById(
                $this->context->getRequest()->getParam('brand_id')
            )->getId();
        } catch (NoSuchEntityException | LocalizedException $e) {
            $this->context->getLogger()->error($e->getMessage());
        }

        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
