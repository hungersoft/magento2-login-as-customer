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
use Magento\Checkout\Model\Session as CheckoutSession;
use HS\LoginAsCustomer\Helper\Data as LoginAsCustomerHelper;

class Index extends Action
{
    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * @var CheckoutSesion
     */
    private $checkoutSession;

    /**
     * @var LoginAsCustomerHelper
     */
    private $helper;

    /**
     * @param Context               $context
     * @param CustomerSession       $customerSession
     * @param CustomerFactory       $customerFactory
     * @param CheckoutSession       $checkoutSession
     * @param LoginAsCustomerHelper $helper
     */
    public function __construct(
        Context $context,
        CustomerSession $customerSession,
        CustomerFactory $customerFactory,
        CheckoutSession $checkoutSession,
        LoginAsCustomerHelper $helper
    ) {
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
        $this->checkoutSession = $checkoutSession;
        $this->helper = $helper;

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

        if ($this->customerSession->getId()) {
            $this->customerSession->logout();
        } else {
            if ($this->helper->isDisabledMergeGuestCartForAdminLogin()) {
                $this->checkoutSession->clearQuote();
            }
        }

        $this->customerSession->loginById($customerId);

        return $resultRedirect->setPath('customer/account');
    }
}
