<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_ChatSystem
 *
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\ChatSystem\Controller\Adminhtml\Blacklist;

class Save extends \Lof\ChatSystem\Controller\Adminhtml\Blacklist
{
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if data sent
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('blacklist_id');
            $customer_id = $this->getRequest()->getParam('customer_id');
            $email = $this->getRequest()->getParam('email');
            $ip = $this->getRequest()->getParam('ip');
            if (!$email && !$ip) {
                $this->messageManager->addError(__('Missing email or ip. You should input one of them.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model = $this->blacklistFactory->create()->load($id);
            $model_blacklist = $this->blacklistFactory->create()->getCollection();
            $check_blacklist = $model_blacklist->addFieldToFilter(['email','ip'], [$email,$ip])->getData();
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This blacklist no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            if (!$id) {
                if ($email) {
                    $model->loadByEmail($email);
                }
                if ($ip && !$model->getId()) {
                    $model->loadByIp($ip);
                }
                if ($customer_id && !$model->getId()) {
                    $model->loadByCustomerId($customer_id);
                }
                if (!$model->getId()) {
                    // init model and set data
                    $model->setData($data);
                }
                if (count($check_blacklist)>0) {
                    $this->getMessageManager()->addErrorMessage('Error: The ip or email was added to blocklist');
                    return $resultRedirect->setPath('*/blacklist/new');
                }
            } else {
                // init model and set data
                $model->setData($data);
            }


            // try to save it
            try {
                // save the data
                $model->save();
                // display success blacklist
                $this->messageManager->addSuccess(__('You saved the blacklist.'));
                // clear previously saved data from session
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['blacklist_id' => $model->getId()]);
                }
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error blacklist
                $this->messageManager->addError($e->getMessage());
                // save data in session
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                // redirect to edit form
                return $resultRedirect->setPath('*/*/edit', ['blacklist_id' => $this->getRequest()->getParam('blacklist_id')]);
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
