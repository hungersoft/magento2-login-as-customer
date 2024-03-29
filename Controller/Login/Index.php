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

use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session as CustomerSession;
use HS\LoginAsCustomer\Helper\Data as LoginAsCustomerHelper;
use HS\LoginAsCustomer\Model\Session as LoginAsCustomerSession;

class Index extends Action
{
    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var LoginAsCustomerSession
     */
    private $loginAsCustomerSession;

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var LoginAsCustomerHelper
     */
    private $helper;

    /**
     * @param Context                $context
     * @param Cart                   $cart
     * @param LoginAsCustomerHelper  $helper
     * @param CustomerSession        $customerSession
     * @param CustomerFactory        $customerFactory
     * @param LoginAsCustomerSession $loginAsCustomerSession
     */
    public function __construct(
        Context $context,
        Cart $cart,
        LoginAsCustomerHelper $helper,
        CustomerSession $customerSession,
        CustomerFactory $customerFactory,
        LoginAsCustomerSession $loginAsCustomerSession
    ) {
        $this->cart = $cart;
        $this->helper = $helper;
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
        $this->loginAsCustomerSession = $loginAsCustomerSession;

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
        $customerId = $this->loginAsCustomerSession->getCustomerId();
        if (!$customerId) {
            return $resultRedirect->setPath('customer/account/login');
        }

        $this->customerSession->logout();
        // if ($this->helper->isDisabledMergeGuestCartForAdminLogin()) {
        $this->cart->truncate()->saveQuote();
        // }

        $this->customerSession->loginById($customerId);
        $this->customerSession->regenerateId();
        $this->customerSession->setIsAdminLogin(true);
        $this->loginAsCustomerSession->setCustomerId(null);

        return $resultRedirect->setPath('customer/account');
    }
}
