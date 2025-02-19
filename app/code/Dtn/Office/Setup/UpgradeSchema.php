<?php

namespace Dtn\Office\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $connection = $setup->getConnection();
            $tableName = $setup->getTable('dtn_employee');

            // Kiểm tra nếu cột dob đã tồn tại thì xóa trước khi thêm lại
            if ($connection->tableColumnExists($tableName, 'dob')) {
                $connection->dropColumn($tableName, 'dob');
            }

            // Thêm lại cột dob vào đúng vị trí
            $connection->addColumn(
                $tableName,
                'dob',
                [
                    'type' => Table::TYPE_DATETIME,
                    'nullable' => false,
                    'comment' => 'Birthday',
                    'after' => 'telephone' // Đặt vị trí sau telephone
                ]
            );
        }

        $setup->endSetup();
    }
}
