<?php
/**
 * Copyright © landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\ChatSystem\Api\Data;

interface ChatSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Chat list.
     * @return \Lof\ChatSystem\Api\Data\ChatInterface[]
     */
    public function getItems();

    /**
     * Set user_id list.
     * @param \Lof\ChatSystem\Api\Data\ChatInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

