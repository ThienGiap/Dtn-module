<?php

namespace Dtn\Office\Model\ResourceModel\Employee;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'employee_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'dtn_office_employee_collection';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'employee_collection';

    protected function _construct()
    {
        $this->_init('Dtn\Office\Model\Employee', 'Dtn\Office\Model\ResourceModel\Employee');
    }
}
