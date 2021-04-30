<?php
declare(strict_types=1);

namespace Cap\Brand\Model\Brand;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Url;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Cap\Brand\Model\ResourceModel\Brand\Collection;
use Cap\Brand\Model\ResourceModel\Brand\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var
     */
    protected $loadedData;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var Url
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param Url $urlBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Url $urlBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();

            //todo: fix extra add url on save image

//            // Fix Image Uploader in Edit page
//            if ($model->getSmallImage()) {
//                $m['small_image'][0]['name'] = $model->getSmallImage();
//                $m['small_image'][0]['url'] = $this->urlBuilder->getBaseUrl() . $model->getSmallImage();
//                $fullData = $this->loadedData;
//                $this->loadedData[$model->getId()] = array_merge($fullData[$model->getId()], $m); //phpcs:ignore
//            }
        }
        $data = $this->dataPersistor->get('cap_brand');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('cap_brand');
        }

        return $this->loadedData;
    }
}
