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

namespace HS\LoginAsCustomer\Plugin\Frontend\Magento\PageCache\Model;

use Magento\PageCache\Model\Config as PageCacheConfig;
use HS\LoginAsCustomer\Helper\Data as LoginAsCustomerHelper;
use Magento\Customer\Model\Session as CustomerSession;

class Config
{
    /**
     * @var LoginAsCustomerHelper
     */
    private $helper;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * Constructor.
     *
     * @param LoginAsCustomerHelper $helper
     * @param CustomerSession       $customerSession
     */
    public function __construct(LoginAsCustomerHelper $helper, CustomerSession $customerSession)
    {
        $this->helper = $helper;
        $this->customerSession = $customerSession;
    }

    /**
     * Disable page cache when login as customer config set to disable.
     *
     * @param PageCacheConfig $subject
     * @param bool            $result
     *
     * @return bool
     */
    public function afterIsEnabled(PageCacheConfig $subject, $result)
    {
        return $result || ($this->customerSession->getIsAdminLogin() && !$this->helper->isDisabledPageCacheForAdmin());
    }
}
