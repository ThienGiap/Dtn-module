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

namespace Lof\ChatSystem\Model;

/**
 * @SuppressWarnings(ExcessivePublicCount)
 */
class Config
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Model\Context
     */
    protected $context;

    protected $configAdminCustom;

    /**
     * @param \Magento\Config\Model\Config\Backend\Admin\Custom  $configAdminCustom
     * @param \Magento\Framework\Module\Manager                  $moduleManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Model\Context                   $context
     */
    public function __construct(
        \Magento\Config\Model\Config\Backend\Admin\Custom $configAdminCustom,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Model\Context $context
    ) {
        $this->configAdminCustom = $configAdminCustom;
        $this->moduleManager = $moduleManager;
        $this->scopeConfig = $scopeConfig;
        $this->context = $context;
    }

    const NOTIFICATION_TYPE_NEW_TICKET = 'new_ticket';
    const NOTIFICATION_TYPE_NEW_MESSAGE = 'new_message';
    const NOTIFICATION_TYPE_NEW_ASSIGN = 'reassign';

    const FOLDER_INBOX = 1;
    const FOLDER_ARCHIVE = 2;
    const FOLDER_SPAM = 3;

    const FOLLOWUPPERIOD_MINUTES = 'minutes';
    const FOLLOWUPPERIOD_HOURS = 'hours';
    const FOLLOWUPPERIOD_DAYS = 'days';
    const FOLLOWUPPERIOD_WEEKS = 'weeks';
    const FOLLOWUPPERIOD_MONTHS = 'months';
    const FOLLOWUPPERIOD_CUSTOM = 'custom';
    const PROTOCOL_POP3 = 'pop3';
    const PROTOCOL_IMAP = 'imap';
    const ENCRYPTION_NONE = 'none';
    const ENCRYPTION_SSL = 'ssl';
    const SCOPE_HEADERS = 'headers';
    const SCOPE_SUBJECT = 'subject';
    const SCOPE_BODY = 'body';
    const FIELD_TYPE_TEXT = 'text';
    const FIELD_TYPE_TEXTAREA = 'textarea';
    const FIELD_TYPE_DATE = 'date';
    const FIELD_TYPE_CHECKBOX = 'checkbox';
    const FIELD_TYPE_SELECT = 'select';
    const RATE_3 = 3;
    const RATE_2 = 2;
    const RATE_1 = 1;
    const RULE_EVENT_NEW_TICKET = 'new_ticket';
    const RULE_EVENT_NEW_CUSTOMER_REPLY = 'new_customer_reply';
    const RULE_EVENT_NEW_STAFF_REPLY = 'new_staff_reply';
    const RULE_EVENT_NEW_THIRD_REPLY = 'new_third_reply';
    const RULE_EVENT_TICKET_ASSIGNED = 'ticket_assigned';
    const RULE_EVENT_TICKET_UPDATED = 'ticket_updated';
    const RULE_EVENT_CRON_EVERY_HOUR = 'cron_every_hour';
    const IS_ARCHIVE_TO_ARCHIVE = 1;
    const IS_ARCHIVE_FROM_ARCHIVE = 2;
    const TICKET_GRID_COLUMNS_CODE = 'code';
    const TICKET_GRID_COLUMNS_NAME = 'name';
    const TICKET_GRID_COLUMNS_CUSTOMER_NAME = 'customer_name';
    const TICKET_GRID_COLUMNS_LAST_REPLY_NAME = 'last_reply_name';
    const TICKET_GRID_COLUMNS_USER_ID = 'user_id';
    const TICKET_GRID_COLUMNS_DEPARTMENT_ID = 'department_id';
    const TICKET_GRID_COLUMNS_STORE_ID = 'store_id';
    const TICKET_GRID_COLUMNS_STATUS_ID = 'status_id';
    const TICKET_GRID_COLUMNS_PRIORITY_ID = 'priority_id';
    const TICKET_GRID_COLUMNS_REPLY_CNT = 'reply_cnt';
    const TICKET_GRID_COLUMNS_CREATED_AT = 'created_at';
    const TICKET_GRID_COLUMNS_UPDATED_AT = 'updated_at';
    const TICKET_GRID_COLUMNS_LAST_REPLY_AT = 'last_reply_at';
    const TICKET_GRID_COLUMNS_LAST_ACTIVITY = 'last_activity';
    const TICKET_GRID_COLUMNS_ACTION = 'action';
    const SIGN_TICKET_BY_DEPARTMENT = 'department';
    const SIGN_TICKET_BY_USER = 'user';
    const ACCEPT_FOREIGN_TICKETS_DISABLE = 'disable';
    const ACCEPT_FOREIGN_TICKETS_AW = 'aw';
    const ACCEPT_FOREIGN_TICKETS_MW = 'mw';
    const ATTACHMENT_STORAGE_FS = 'fs';
    const ATTACHMENT_STORAGE_DB = 'db';

    const POSITION_LEFT = 'left';
    const POSITION_RIGHT = 'right';
    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'closed';
    const FORMAT_PLAIN = 1;
    const FORMAT_HTML = 2;

    const CHANNEL_FEEDBACK_TAB = 'feedback_tab';
    const CHANNEL_CONTACT_FORM = 'contact_form';
    const CHANNEL_CUSTOMER_ACCOUNT = 'customer_account';
    const CHANNEL_EMAIL = 'email';
    const CHANNEL_BACKEND = 'backend';

    const MESSAGE_PUBLIC = 'public';
    const MESSAGE_INTERNAL = 'internal';
    const MESSAGE_PUBLIC_THIRD = 'public_third';
    const MESSAGE_INTERNAL_THIRD = 'internal_third';

    const CUSTOMER = 'customer';
    const USER = 'user';
    const THIRD = 'third';
    const RULE = 'rule';

    const SCHEDULE_TYPE_ALWAYS = 'always';
    const SCHEDULE_TYPE_CUSTOM = 'custom';
    const SCHEDULE_TYPE_CLOSED = 'closed';
    const SCHEDULE_LEFT_HOUR_TO_OPEN_PLACEHOLDER = '[time_left_to_open]';
    const SCHEDULE_STATUS_BLOCK_CACHE_LIFETIME = 30;
    const SCHEDULE_BLOCK_CACHE_LIFETIME = 60;

    const DEFAULT_SORT_ORDER = \Magento\Framework\Data\Collection::SORT_ORDER_ASC;

}
