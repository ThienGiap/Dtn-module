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

use Lof\ChatSystem\Helper\Data;

class Ajaxblock extends \Lof\ChatSystem\Controller\Adminhtml\Blacklist
{

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $responseData = [];
        $responseData['error'] = __('Don\'t have data to save.');
        $responseData['status'] = false;
        $responseData['data'] = [];
        // check if data sent
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $model = $this->blacklistFactory->create();
            $email = $this->getRequest()->getParam('email');
            $ip = $this->getRequest()->getParam('ip');
            $customer_id = $this->getRequest()->getParam('customer_id');

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
                // try to save it
                try {
                    $model->setData($data);
                    $model->save();

                    $responseData['status'] = true;
                    $responseData['success'] = __('You saved the blacklist.');
                    $responseData['error'] = "";
                    $responseData['created_time'] = $model->getData('created_time');
                    $responseData['data'] = $model->getData();


                } catch (\Exception $e) {
                    $responseData['error'] = __('Have problem when save the blacklist.');
                    //$responseData['error'] .= (string)$e;
                }
            } else {
                $responseData['error'] = __('The ip or email was added to blocklist.');
            }
        }
        if (isset($responseData['created_time'])) {
            $formatDate = $this->_formatDate->FormatDateFormBuilder($responseData['created_time']);
            $responseData['created_time']=$formatDate;
        }
        $this->getResponse()->representJson(
            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($responseData)
        );
    }
}
