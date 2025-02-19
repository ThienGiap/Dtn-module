<?php

namespace Dtn\Office\Setup\Patch\Data;

use Dtn\Office\Model\EmployeeFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddTestEmployees implements DataPatchInterface
{
    public function __construct(
        protected EmployeeFactory $employeeFactory
    ) {}

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $faker = \Faker\Factory::create();

        // add 50 employees
        for ($i = 1; $i <= 50; $i++) {
            $employee = $this->employeeFactory->create();
            $employee->setFullName($faker->name())
                ->setImage(null)
                ->setAddress($faker->address())
                ->setTelephone($faker->phoneNumber())
                ->setDob($faker->dateTime())
                ->setDepartmentId(1); // fix cứng department ID 1

            $employee->save();
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
