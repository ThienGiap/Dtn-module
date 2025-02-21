<?php

namespace Dtn\Office\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Psr\Log\LoggerInterface;

class Employee extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dtn_employee', 'employee_id');
    }

    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        // Get image data before and after save
        $oldImage = $object->getOrigData('image');
        $newImage = $object->getData('image');

        // Check when new image uploaded
        if ($newImage != null && $newImage != $oldImage) {
            try {
                $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                    ->get('Dtn\Office\EmployeeImageUpload');
                $imageUploader->moveFileFromTmp($newImage, 'dtn/employee/images');
            } catch (\Exception $e) {
                $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(LoggerInterface::class);
                $logger->error('Error moving file from tmp: ' . $e->getMessage());
                throw new \Magento\Framework\Exception\LocalizedException(__('Could not import media assets for files: %1', $newImage));
            }
        }

        return $this;
    }
}