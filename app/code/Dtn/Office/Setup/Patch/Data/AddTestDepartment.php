<?php

namespace Dtn\Office\Setup\Patch\Data;

use Dtn\Office\Model\DepartmentFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddTestDepartment implements DataPatchInterface
{
    public function __construct(
        protected DepartmentFactory $departmentFactory
    ) {
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $faker = \Faker\Factory::create();

        // add 50 employees
        for ($i = 1; $i <= 10; $i++) {
            $department = $this->departmentFactory->create();
            $department->setName($faker->name());

            $department->save();
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}