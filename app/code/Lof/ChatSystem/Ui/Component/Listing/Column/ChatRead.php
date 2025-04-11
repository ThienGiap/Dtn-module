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
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\ChatSystem\Ui\Component\Listing\Column;

class ChatRead extends \Magento\Ui\Component\Listing\Columns\Column
{

    protected $helper;
    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context             
     * @param \Magento\Framework\View\Element\UiComponentFactory           $uiComponentFactory  
     * @param \Lof\ChatSystem\Helper\Balance\Spend                       $rewardsBalanceSpend 
     * @param array                                                        $components          
     * @param array                                                        $data                
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Lof\ChatSystem\Helper\Data $helper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->helper = $helper;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $fieldName = $this->getData('name');
                if (isset($item['chat_id'])) {
                    $status =  $item['is_read'];
                    
                    if($status == 1) {
                        $item['is_read'] =  __('Unread');
                    } else {
                       $item['is_read'] =  __('Read'); 
                    }
                }

            }

        }
        return $dataSource;
    }
}
