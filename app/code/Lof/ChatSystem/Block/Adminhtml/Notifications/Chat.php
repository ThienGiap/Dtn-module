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
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\ChatSystem\Block\Adminhtml\Notifications;

use Lof\ChatSystem\Model\Config;

class Chat extends \Magento\Framework\View\Element\Template
{


    /**
     * @var \Lof\ChatSystem\Model\ChatMessage
     */
    protected $message;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Lof\ChatSystem\Model\ChatMessage $message
    ) {
        $this->message = $message;
        parent::__construct($context);
    }

    public function countUnread() {

        $message = $this->message->getCollection()->addFieldToFilter('user_id',array('null' => true))->addFieldToFilter('is_read',1);
        return count($message);
    }

}
