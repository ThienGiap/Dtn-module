<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the landofcoder.com license that is
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
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\ChatSystem\Block\Adminhtml\Chat\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('ticket_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Chat Information'));
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareLayout()
    {
        $this->addTab(
                'main_section',
                [
                    'label' => __('General'),
                    'content' => $this->getLayout()->createBlock('Lof\ChatSystem\Block\Adminhtml\Chat\Edit\Tab\Main')->toHtml()
                ]
            );
        $this->addTab(
            'customer_information',
            [
                'label' => __('Customer Information'),
                'content' => $this->getLayout()->createBlock('Lof\ChatSystem\Block\Adminhtml\Chat\Edit\Tab\Customer')->toHtml()
            ]
        );

        $this->addTab(
            'blacklist',
            [
                'label' => __('Blacklist'),
                'content' => $this->getLayout()->createBlock('Lof\ChatSystem\Block\Adminhtml\Chat\Edit\Tab\Blacklist')->toHtml()
            ]
        );
    }
}
