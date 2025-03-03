<?php

namespace Dtn\Office\Model;

use Magento\Framework\Model\AbstractModel;

class Employee extends AbstractModel
{
    protected $_eventPrefix = 'dtn_office_employee';

    protected function _construct()
    {
        $this->_init('Dtn\Office\Model\ResourceModel\Employee');
    }
}