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

namespace HS\LoginAsCustomer\Controller\Login;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session as CustomerSession;

class Index extends Action
{
    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @param Context         $context
     * @param CustomerSession $customerSession
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        Context $context,
        CustomerSession $customerSession,
        CustomerFactory $customerFactory
    ) {
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;

        parent::__construct($context);
    }

    /**
     * Execute view action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $customerId = $this->customerSession->getAdminLoginCustomerId();
        if (!$customerId) {
            return $resultRedirect->setPath('customer/account/login');
        }

        $customer = $this->customerFactory->create()->load($customerId);
        if (!$customer) {
            return $resultRedirect->setPath('customer/account/login');
        }

        $this->customerSession->setCustomerDataAsLoggedIn($customer->getDataModel());

        return $resultRedirect->setPath('customer/account');
    }
}
