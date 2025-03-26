<?php

namespace Dtn\Office\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface EmployeeRepositoryInterface
{
    /**
     * @param \Dtn\Office\Api\Data\EmployeeInterface $employee
     * @return \Dtn\Office\Api\Data\EmployeeInterface
     */
    public function save(\Dtn\Office\Api\Data\EmployeeInterface $employee);

    /**
     * @param int $employeeId
     * @return \Dtn\Office\Api\Data\EmployeeInterface
     */
    public function getById($employeeId);

    /**
     * @param \Dtn\Office\Api\Data\EmployeeInterface $employee
     * @return bool
     */
    public function delete(\Dtn\Office\Api\Data\EmployeeInterface $employee);

    /**
     * @param int $employeeId
     * @return bool
     */
    public function deleteById($employeeId);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Get employee by email
     *
     * @param string $email
     * @return \Dtn\Office\Api\Data\EmployeeInterface
     */
    public function getByEmail($email);
}
