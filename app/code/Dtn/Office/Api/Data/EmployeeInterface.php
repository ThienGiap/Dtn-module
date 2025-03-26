<?php

namespace Dtn\Office\Api\Data;

interface EmployeeInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get employee full name
     *
     * @return string|null
     */
    public function getFullName();

    /**
     * @param string $fullName
     * @return $this
     */
    public function setFullName($fullName);

    /**
     * Get employee image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * Get employee email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * Get employee address
     *
     * @return string|null
     */
    public function getAddress();

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address);

    /**
     * Get employee telephone
     *
     * @return string|null
     */
    public function getTelephone();

    /**
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone);

    /**
     * Get employee date of birth
     *
     * @return string|null
     */
    public function getDob();

    /**
     * @param string $dob
     * @return $this
     */
    public function setDob($dob);

    /**
     * Get employee department ID
     *
     * @return int|null
     */
    public function getDepartmentId();

    /**
     * @param int $departmentId
     * @return $this
     */
    public function setDepartmentId($departmentId);
}
