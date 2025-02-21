<?php

namespace Dtn\Office\Model\ResourceModel\Employee\Grid;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    protected function _initSelect()
    {
        parent::_initSelect();
        
        // Join bảng dtn_department để lấy name thay vì department_id
        $this->getSelect()->joinLeft(
            ['department' => $this->getTable('dtn_department')],
            'main_table.department_id = department.department_id',
            ['department_name' => 'department.name']
        );

        return $this;
    }
}
