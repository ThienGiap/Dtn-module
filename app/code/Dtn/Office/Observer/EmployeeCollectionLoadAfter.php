<?php

namespace Dtn\Office\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Dtn\Office\Model\ResourceModel\Employee\CollectionFactory;
use Dtn\Office\Model\DepartmentFactory;
use Psr\Log\LoggerInterface;

class EmployeeCollectionLoadAfter implements ObserverInterface
{
    /**
     * @var CollectionFactory
     */
    protected $employeeCollectionFactory;

    /**
     * @var DepartmentFactory
     */
    protected $departmentFactory;

    protected $_logger;

    /**
     * Constructor.
     *
     * @param CollectionFactory $employeeCollectionFactory
     * @param DepartmentFactory $departmentFactory
     */
    public function __construct(
        CollectionFactory $employeeCollectionFactory,
        DepartmentFactory $departmentFactory,
        LoggerInterface $logger
    ) {
        $this->employeeCollectionFactory = $employeeCollectionFactory;
        $this->departmentFactory = $departmentFactory;
        $this->_logger = $logger;
    }

    /**
     * Execute the observer.
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Dtn\Office\Model\ResourceModel\Employee\Collection $employeeCollection */
        $employeeCollection = $observer->getData('employee_collection');

        if ($employeeCollection) {
            // Lấy tất cả các department IDs từ collection Employee
            $departmentIds = [];
            foreach ($employeeCollection as $employee) {
                $departmentIds[] = $employee->getDepartmentId();
            }

            // Lấy collection Department theo các departmentIds
            $departmentCollection = $this->departmentFactory->create()->getCollection()
                ->addFieldToFilter('department_id', ['in' => array_unique($departmentIds)]);

            // Chuyển các departments thành một array để dễ truy cập theo ID
            $departments = [];
            foreach ($departmentCollection as $department) {
                $departments[$department->getDepartmentId()] = $department->getName();
            }

            // Lặp qua Employee collection và set Department Name bằng magic setter
            foreach ($employeeCollection as $employee) {
                $departmentId = $employee->getDepartmentId();
                $departmentName = isset($departments[$departmentId]) ? $departments[$departmentId] : 'N/A';
                
                // magic setter setDepartmentName()
                $employee->setDepartmentName($departmentName);
                
                // Logging để kiểm tra kết quả
                $this->_logger->info('Department name: ' . $employee->getDepartmentName());
            }
        }
    }
}
