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
namespace Lof\ChatSystem\Model\ResourceModel\Chat; 

use \Lof\ChatSystem\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'chat_id';
    /**
     * Define resource model
     *
     * @return void
     */
    
     /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        //$this->performAfterLoad('lof_chatsystem_category_store', 'category_id');
        // $this->getProductsAfterLoad();
        
        return parent::_afterLoad();
    }


    protected function _construct()
    {
        $this->_init('Lof\ChatSystem\Model\Chat', 'Lof\ChatSystem\Model\ResourceModel\Chat');
    }

      /**
     * Returns pairs category_id - title
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('chat_id', 'title');
    }
    /**
     * Add link attribute to filter.
     *
     * @param string $code
     * @param array $condition
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);

        return $this;
    }
}