<?php

namespace Dtn\Office\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Dtn\Office\Api\Data\EmployeeInterface;
use Dtn\Office\Api\EmployeeRepositoryInterface;
use Dtn\Office\Model\ResourceModel\Employee as EmployeeResource;
use Dtn\Office\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @var EmployeeResource
     */
    private $resource;

    /**
     * @var EmployeeFactory
     */
    private $employeeFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    private $searchResultsFactory;

    private $collectionProcessor;

    /**
     * @param EmployeeResource $resource
     * @param EmployeeFactory $employeeFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        EmployeeResource $resource,
        EmployeeFactory $employeeFactory,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->employeeFactory = $employeeFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save employee
     *
     * @param EmployeeInterface $employee
     * @return EmployeeInterface
     * @throws CouldNotSaveException
     */
    public function save(EmployeeInterface $employee)
    {
        try {
            $this->resource->save($employee);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the employee: %1', $exception->getMessage()),
                $exception
            );
        }
        return $employee;
    }

    /**
     * Get employee by ID
     *
     * @param int $employeeId
     * @return EmployeeInterface
     * @throws NoSuchEntityException
     */
    public function getById($employeeId)
    {
        $employee = $this->employeeFactory->create();
        $this->resource->load($employee, $employeeId);
        
        if (!$employee->getId()) {
            throw new NoSuchEntityException(__('Employee with id "%1" does not exist.', $employeeId));
        }
        
        return $employee;
    }

    /**
     * Delete employee
     *
     * @param EmployeeInterface $employee
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(EmployeeInterface $employee)
    {
        try {
            $this->resource->delete($employee);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the employee: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    /**
     * Delete employee by ID
     *
     * @param int $employeeId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById($employeeId)
    {
        return $this->delete($this->getById($employeeId));
    }

    /**
     * Get employee list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Dtn\Office\Model\ResourceModel\Employee\Collection $collection */
        $collection = $this->collectionFactory->create();

        // Xử lý search criteria (filters, sorting, pagination)
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var \Magento\Framework\Api\SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}