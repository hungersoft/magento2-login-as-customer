<?php
/**
 * Copyright 2019 Hungersoft (http://www.hungersoft.com).
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace HS\LoginAsCustomer\Api\Data;

interface AdminLoginSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get AdminLogin list.
     *
     * @return \HS\LoginAsCustomer\Api\Data\AdminLoginInterface[]
     */
    public function getItems();

    /**
     * Set customer_id list.
     *
     * @param \HS\LoginAsCustomer\Api\Data\AdminLoginInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
