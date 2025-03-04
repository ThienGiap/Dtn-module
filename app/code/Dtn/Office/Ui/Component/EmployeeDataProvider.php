<?php

namespace Dtn\Office\Ui\Component;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Dtn\Office\Model\ResourceModel\Employee\CollectionFactory as EmployeeCollectionFactory;
use Magento\Framework\App\RequestInterface;

class EmployeeDataProvider extends AbstractDataProvider
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var EmployeeCollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        EmployeeCollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collectionFactory = $collectionFactory;
        $this->request = $request;
        $this->collection = $this->collectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $collection = $this->getCollection();

        $this->applyFilters($collection);

        if (!$collection->isLoaded()) {
            $collection->load();
        }

        $items = $collection->getItems();
        $data = [];
        foreach ($items as $employee) {
            $data[$employee->getId()] = $employee->getData();
        }

        return [
            'totalRecords' => $collection->getSize(),
            'items' => array_values($data),
        ];
    }

    /**
     * Apply filters from request to collection
     *
     * @param \Dtn\Office\Model\ResourceModel\Employee\Collection $collection
     * @return void
     */
    protected function applyFilters($collection)
    {
        $filters = $this->request->getParam('filters', []);
        if ($filters) {
            foreach ($filters as $field => $value) {
                if ($field === 'placeholder') {
                    continue;
                }

                // Xử lý $value để đảm bảo là chuỗi
                $filterValue = is_array($value) ? implode(' ', $value) : (string) $value;

                \Magento\Framework\App\ObjectManager::getInstance()
                    ->get(\Psr\Log\LoggerInterface::class)
                    ->debug("Filter - Field: $field, Value: $filterValue");

                $collection->addFieldToFilter($field, ['like' => '%' . $filterValue . '%']);
            }
        }
    }
}
