<?php

namespace Dtn\Office\Model;

use Magento\Framework\Model\AbstractModel;
use Dtn\Office\Api\Data\EmployeeInterface;

class Employee extends AbstractModel implements EmployeeInterface
{
    protected $_eventPrefix = 'dtn_office_employee';

    protected function _construct()
    {
        $this->_init('Dtn\Office\Model\ResourceModel\Employee');
    }
}