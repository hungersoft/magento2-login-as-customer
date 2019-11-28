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

namespace HS\LoginAsCustomer\Model\Data;

use HS\LoginAsCustomer\Api\Data\AdminLoginInterface;

class AdminLogin extends \Magento\Framework\Api\AbstractExtensibleObject implements AdminLoginInterface
{
    /**
     * Get adminlogin_id.
     *
     * @return string|null
     */
    public function getAdminloginId()
    {
        return $this->_get(self::ADMINLOGIN_ID);
    }

    /**
     * Set adminlogin_id.
     *
     * @param string $adminloginId
     *
     * @return \HS\LoginAsCustomer\Api\Data\AdminLoginInterface
     */
    public function setAdminloginId($adminloginId)
    {
        return $this->setData(self::ADMINLOGIN_ID, $adminloginId);
    }

    /**
     * Get customer_id.
     *
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id.
     *
     * @param string $customerId
     *
     * @return \HS\LoginAsCustomer\Api\Data\AdminLoginInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \HS\LoginAsCustomer\Api\Data\AdminLoginExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     *
     * @param \HS\LoginAsCustomer\Api\Data\AdminLoginExtensionInterface $extensionAttributes
     *
     * @return $this
     */
    public function setExtensionAttributes(
        \HS\LoginAsCustomer\Api\Data\AdminLoginExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get admin_user_id.
     *
     * @return string|null
     */
    public function getAdminUserId()
    {
        return $this->_get(self::ADMIN_USER_ID);
    }

    /**
     * Set admin_user_id.
     *
     * @param string $adminUserId
     *
     * @return \HS\LoginAsCustomer\Api\Data\AdminLoginInterface
     */
    public function setAdminUserId($adminUserId)
    {
        return $this->setData(self::ADMIN_USER_ID, $adminUserId);
    }

    /**
     * Get created_at.
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at.
     *
     * @param string $createdAt
     *
     * @return \HS\LoginAsCustomer\Api\Data\AdminLoginInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
