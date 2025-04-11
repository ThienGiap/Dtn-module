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
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\ChatSystem\Controller\Adminhtml;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;

/**
 * Cms manage blocks controller
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
abstract class Chat extends \Magento\Backend\App\Action
{
      /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    /**
     * @param \Magento\Backend\App\Action\Context              $context             
     * @param \Magento\Framework\Registry                      $coreRegistry        

     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
        ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }
    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Lof_ChatSystem::lofchatsystem_chat')
            ->addBreadcrumb(__('ChatSystem'), __('ChatSystem'))
            ->addBreadcrumb(__('Chat'), __('Chat'));
        return $resultPage;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_ChatSystem::chat');
    }
}
