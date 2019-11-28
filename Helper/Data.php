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

namespace HS\LoginAsCustomer\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CONFIG_ENABLED = 'hs_login_as_customer/general/enabled';
    const CONFIG_DISABLE_PAGE_CACHE_FOR_ADMIN = 'hs_login_as_customer/general/disable_page_cache_for_admin';
    const CONFIG_DISABLE_MERGE_GUEST_CART_FOR_ADMIN_LOGIN = 'hs_login_as_customer/general/disable_merge_guest_cart_for_admin_login';
    const CONFIG_ENABLE_MANUAL_STOREVIEW_SELECTION = 'hs_login_as_customer/general/enable_manual_storeview_selection';

    /**
     * Currently selected store ID if applicable.
     *
     * @var int
     */
    protected $_storeId = null;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context               $context
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(Context $context, StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Get config value by path.
     *
     * @param string $path
     *
     * @return mixed
     */
    public function getConfigValue($path, $storeId = null)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Get config flag by path.
     *
     * @param string $path
     *
     * @return bool
     */
    public function getConfigFlag($path)
    {
        return $this->scopeConfig->isSetFlag($path, ScopeInterface::SCOPE_STORE, $this->_storeId);
    }

    /**
     * Return true if active and false otherwise.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getConfigFlag(self::CONFIG_ENABLED);
    }

    /**
     * Return whether page cache is disabled for admin login.
     *
     * @return bool
     */
    public function isDisabledPageCacheForAdmin()
    {
        return $this->getConfigFlag(self::CONFIG_DISABLE_PAGE_CACHE_FOR_ADMIN);
    }

    /**
     * Return whether merge guest cart for admin login is disabled.
     *
     * @return bool
     */
    public function isDisabledMergeGuestCartForAdminLogin()
    {
        return $this->getConfigFlag(self::CONFIG_DISABLE_MERGE_GUEST_CART_FOR_ADMIN_LOGIN);
    }

    /**
     * Return whether manual storeview selection is enabled.
     *
     * @return bool
     */
    public function isEnabledManualStoreviewSelection()
    {
        return $this->getConfigFlag(self::CONFIG_ENABLED_MANUAL_STOREVIEW_SELECTION);
    }
}
