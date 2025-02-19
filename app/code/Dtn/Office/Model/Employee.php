<?php

namespace Dtn\Office\Model;

use Magento\Framework\Model\AbstractModel;

class Employee extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Dtn\Office\Model\ResourceModel\Employee::class);
    }
}