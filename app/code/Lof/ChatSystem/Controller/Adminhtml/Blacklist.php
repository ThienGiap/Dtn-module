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
use Magento\Framework\View\Result\PageFactory;
use Lof\ChatSystem\Model\ResourceModel\Blacklist\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
/**
 * Cms manage blocks controller
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
abstract class Blacklist extends \Magento\Backend\App\Action
{
      /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
     /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    protected $blacklistFactory;

    protected $helper;

    protected $dataPersistor;

    protected $resultForwardFactory;

    /**
     * @param \Magento\Backend\App\Action\Context              $context             
     * @param \Magento\Framework\Registry                      $coreRegistry
     * @param PageFactory $resultPageFactory 
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Lof\ChatSystem\Model\BlacklistFactory $blacklistFactory
     * @param \Lof\ChatSystem\Helper\Data $helperData
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     *
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        PageFactory $resultPageFactory,
        Filter $filter, 
        CollectionFactory $collectionFactory,
        \Lof\ChatSystem\Model\BlacklistFactory $blacklistFactory,
        \Lof\ChatSystem\Helper\Data $helperData,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
        ) {
        $this->_coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->blacklistFactory = $blacklistFactory;
        $this->helper = $helperData;
        $this->dataPersistor = $dataPersistor;
        $this->resultForwardFactory = $resultForwardFactory;
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
            ->addBreadcrumb(__('Blacklist'), __('Blacklist'));
        return $resultPage;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_ChatSystem::blacklist');
    }
}
