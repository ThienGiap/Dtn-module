<?php
namespace Valley\Banner\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();
        $tableName = $setup->getTable('dtn_employee');

        $connection->addIndex(
            $tableName,
            'search',
            [
                'image',
            ],
            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
        );

        $setup->endSetup();
    }
}