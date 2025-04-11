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

class Edit extends \Lof\ChatSystem\Controller\Adminhtml\Blacklist
{
    /**
     * Edit Chat Blacklist
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('blacklist_id');
        $model = $this->blacklistFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This blacklist no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        // 4. Register model to use later in forms
        $this->dataPersistor->set('lofchatsystem_blacklist', $model->getData());
        $this->_coreRegistry->register('lofchatsystem_blacklist', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        // 5. Build edit form
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Blacklist') : __('New Blacklist'),
            $id ? __('Edit Blacklist') : __('New Blacklist')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Blacklist'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Blacklist'));
        return $resultPage;
    }
}
