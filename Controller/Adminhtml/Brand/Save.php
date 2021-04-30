<?php

namespace Cap\Brand\Controller\Adminhtml\Brand;

use Cap\Brand\Api\BrandRepositoryInterface;
use Cap\Brand\Controller\Adminhtml\Brand as BrandController;
use Cap\Brand\Model\Brand;
use Cap\Brand\Model\BrandFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

class Save extends BrandController implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var BrandFactory
     */
    private $brandFactory;

    /**
     * @var BrandRepositoryInterface
     */
    private $brandRepository;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param BrandFactory|null $brandFactory
     * @param BrandRepositoryInterface|null $brandRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        BrandFactory $brandFactory = null,
        BrandRepositoryInterface $brandRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->brandFactory = $brandFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(BrandFactory::class);
        $this->brandRepository = $brandRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(BrandRepositoryInterface::class);
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Brand::STATUS_ENABLED;
            }
            if (empty($data['brand_id'])) {
                $data['brand_id'] = null;
            }

            /** @var \Cap\Brand\Model\Brand $model */
            $model = $this->brandFactory->create();

            $id = $this->getRequest()->getParam('brand_id');
            if ($id) {
                try {
                    $model = $this->brandRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This brand no longer exists.'));

                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->brandRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the brand.'));
                $this->dataPersistor->clear('cap_brand');

                return $this->processBrandReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the brand.'));
            }

            $this->dataPersistor->set('cap_brand', $data);

            return $resultRedirect->setPath('*/*/edit', ['brand_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the brand return
     *
     * @param \Cap\Brand\Model\Brand $model
     * @param array $data
     * @param \Magento\Framework\Controller\ResultInterface $resultRedirect
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function processBrandReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['brand_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $duplicateModel = $this->brandFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $duplicateModel->setIdentifier($data['identifier'] . '-' . uniqid());
            $duplicateModel->setIsActive(Brand::STATUS_DISABLED);
            $this->brandRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the brand.'));
            $this->dataPersistor->set('cap_brand', $data);
            $resultRedirect->setPath('*/*/edit', ['brand_id' => $id]);
        }

        return $resultRedirect;
    }
}
