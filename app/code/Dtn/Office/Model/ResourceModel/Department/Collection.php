<?php

namespace Dtn\Office\Model\ResourceModel\Department;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Dtn\Office\Model\Department', 'Dtn\Office\Model\ResourceModel\Department');
    }
}