<?php

namespace Dtn\Office\Model\Employee;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Dtn\Office\Model\ResourceModel\Employee\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $employeeCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->collection = $employeeCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     */
    public function getData()
    {
        // Get items
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();


        foreach ($items as $employee) {
            $data = $employee->getData();
            $image = $data['image'];
            if ($image && is_string($image)) {
                $data['images'][0]['name'] = $image;
                $data['images'][0]['url'] = $this->storeManager->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                    . 'dtn/employee/images/' . $image;
            }

            $this->loadedData[$employee->getId()] = $data;
        }

        $data = $this->dataPersistor->get('employee');
        if (!empty($data)) {
            $employee = $this->collection->getNewEmptyItem();
            $employee->setData($data);
            $this->loadedData[$employee->getId()] = $employee->getData();
            $this->dataPersistor->clear('employee');
        }

        return $this->loadedData;
    }
}