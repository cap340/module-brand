<?php

namespace Cap\Brand\Controller\Adminhtml\Brand;

use Cap\Brand\Api\BrandRepositoryInterface as BrandRepository;
use Cap\Brand\Api\Data\BrandInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Cap_Brand::brand';

    /**
     * @var \Cap\Brand\Api\BrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param BrandRepository $brandRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        BrandRepository $brandRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->brandRepository = $brandRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (! count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $brandId) {
                    /** @var \Magento\Cms\Model\Brand $brand */
                    $brand = $this->brandRepository->getById($brandId);
                    try {
                        $brand->setData(array_merge($brand->getData(), $postItems[$brandId]));
                        $this->brandRepository->save($brand);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithBrandId(
                            $brand,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add brand title to error message
     *
     * @param BrandInterface $brand
     * @param string $errorText
     *
     * @return string
     */
    protected function getErrorWithBrandId(BrandInterface $brand, $errorText)
    {
        return '[Brand ID: ' . $brand->getId() . '] ' . $errorText;
    }
}
