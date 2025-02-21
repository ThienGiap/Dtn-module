<?php

namespace Dtn\Office\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\ResourceConnection;

class DepartmentOptions implements OptionSourceInterface
{
    protected $resource;

    public function __construct(ResourceConnection $resource)
    {
        $this->resource = $resource;
    }

    public function toOptionArray()
    {
        $connection = $this->resource->getConnection();
        $tableName = $this->resource->getTableName('dtn_department');

        $select = $connection->select()
            ->from($tableName, ['department_id', 'name']);

        $departments = $connection->fetchAll($select);
        $options = [];

        foreach ($departments as $department) {
            $options[] = [
                'value' => $department['department_id'],
                'label' => $department['name']
            ];
        }

        return $options;
    }
}
