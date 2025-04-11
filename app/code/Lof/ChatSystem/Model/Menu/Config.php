<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\ChatSystem\Model\Menu;


class Config extends \Magento\Backend\Model\Menu\Config
{
    const CACHE_ID = 'chatsystem_menu_config';
    const CACHE_MENU_OBJECT = 'chatsystem_menu_object';

    protected $_menu = null;

    protected $_director;

    protected $_configCacheType;

    /**
     * Initialize menu object
     *
     * @return void
     */
    protected function _initMenu()
    {
        if (!$this->_menu) {
            $this->_menu = $this->_menuFactory->create();

            $cache = $this->_configCacheType->load(self::CACHE_MENU_OBJECT);
            if ($cache) {
                $this->_menu->unserialize($cache);
                return;
            }
    
            $this->_director->direct(
                $this->_configReader->read($this->_appState->getAreaCode()),
                $this->_menuBuilder,
                $this->_logger
            );
            $this->_menu = $this->_menuBuilder->getResult($this->_menu);
    
            $this->_configCacheType->save($this->_menu->serialize(), self::CACHE_MENU_OBJECT);
        }
    }
}
