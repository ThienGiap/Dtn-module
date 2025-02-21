<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Dtn\Office\Controller\Adminhtml\Department;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Save CMS page action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Dtn_Office::save';

    protected $dataProcessor;
    protected $dataPersistor;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            // Optimize data
            if (empty($data['department_id'])) {
                $data['department_id'] = null;
            }

            // Init model and load by ID if exists
            $model = $this->_objectManager->create('Dtn\Office\Model\Department');
            $id = $this->getRequest()->getParam('department_id');
            if ($id) {
                $model->load($id);
            }

            // Update model
            $model->setData($data);

            // echo "<pre>";
            // var_dump($model->setData($data));
            // die;
            // echo "</pre>";

            // Save data to database
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the department.'));
                $this->dataPersistor->clear('department');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['department_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the image.'));
            }

            $this->dataPersistor->set('department', $data);
            return $resultRedirect->setPath('*/*/edit', ['department_id' => $this->getRequest()->getParam('department_id')]);
        }

        // Redirect to List page
        return $resultRedirect->setPath('*/*/');
    }
}
