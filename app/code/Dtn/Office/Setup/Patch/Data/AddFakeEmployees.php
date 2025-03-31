<?php

namespace Dtn\Office\Setup\Patch\Data;

use Dtn\Office\Model\EmployeeFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddFakeEmployees implements DataPatchInterface
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
        for ($i = 1; $i <= 100; $i++) {
            $employee = $this->employeeFactory->create();

            $randomNumber = rand(1000, 9999);
            $email = $faker->userName() . $randomNumber . '@' . $faker->freeEmailDomain();
            $phone = $faker->randomElement(['+1', '+44', '+84']) . ' ' . $faker->numerify('##########');

            $employee->setFullName($faker->name())
                ->setImage(null)
                ->setEmail($email)
                ->setAddress($faker->address())
                ->setTelephone($phone)
                ->setDob($faker->dateTime())
                ->setDepartmentId(11); // fix cứng department ID 1

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
