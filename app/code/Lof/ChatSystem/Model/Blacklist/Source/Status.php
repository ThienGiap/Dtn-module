<?php
/**
 * Copyright © landofcoder.com All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\ChatSystem\Model\Blacklist\Source;
use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface {

    protected $_blacklist;

    public function __construct(
        \Lof\ChatSystem\Model\Blacklist $_blacklist
        ) {
        $this->_blacklist = $_blacklist;
    }

    public function toOptionArray()     {
        $availableOptions = $this->_blacklist->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                "label" => $value,
                "value" => $key
            ];
        }
        return $options;
    }

}