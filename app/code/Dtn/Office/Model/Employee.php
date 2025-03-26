<?php

namespace Dtn\Office\Model;

use Magento\Framework\Model\AbstractModel;
use Dtn\Office\Api\Data\EmployeeInterface;

class Employee extends AbstractModel implements EmployeeInterface
{
    protected $_eventPrefix = 'dtn_office_employee';

    protected function _construct()
    {
        $this->_init('Dtn\Office\Model\ResourceModel\Employee');
    }

    public function getFullName()
    {
        return $this->getData('full_name');
    }

    public function setFullName($fullName)
    {
        return $this->setData('full_name', $fullName);
    }

    public function getImage()
    {
        return $this->getData('image');
    }

    public function setImage($image)
    {
        return $this->setData('image', $image);
    }

    public function getEmail()
    {
        return $this->getData('email');
    }

    public function setEmail($email)
    {
        return $this->setData('email', $email);
    }

    public function getAddress()
    {
        return $this->getData('address');
    }

    public function setAddress($address)
    {
        return $this->setData('address', $address);
    }

    public function getTelephone()
    {
        return $this->getData('telephone');
    }

    public function setTelephone($telephone)
    {
        return $this->setData('telephone', $telephone);
    }

    public function getDob()
    {
        return $this->getData('dob');
    }

    public function setDob($dob)
    {
        return $this->setData('dob', $dob);
    }

    public function getDepartmentId()
    {
        return $this->getData('department_id');
    }

    public function setDepartmentId($departmentId)
    {
        return $this->setData('department_id', $departmentId);
    }
}
