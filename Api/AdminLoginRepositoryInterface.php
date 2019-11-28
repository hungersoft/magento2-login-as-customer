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

namespace HS\LoginAsCustomer\Api;

interface AdminLoginRepositoryInterface
{
    /**
     * Save AdminLogin.
     *
     * @param \HS\LoginAsCustomer\Api\Data\AdminLoginInterface $adminLogin
     *
     * @return \HS\LoginAsCustomer\Api\Data\AdminLoginInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \HS\LoginAsCustomer\Api\Data\AdminLoginInterface $adminLogin
    );

    /**
     * Retrieve AdminLogin.
     *
     * @param string $adminloginId
     *
     * @return \HS\LoginAsCustomer\Api\Data\AdminLoginInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($adminloginId);

    /**
     * Retrieve AdminLogin matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \HS\LoginAsCustomer\Api\Data\AdminLoginSearchResultsInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete AdminLogin.
     *
     * @param \HS\LoginAsCustomer\Api\Data\AdminLoginInterface $adminLogin
     *
     * @return bool true on success
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \HS\LoginAsCustomer\Api\Data\AdminLoginInterface $adminLogin
    );

    /**
     * Delete AdminLogin by ID.
     *
     * @param string $adminloginId
     *
     * @return bool true on success
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($adminloginId);
}
