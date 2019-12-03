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

namespace HS\LoginAsCustomer\Ui\Component\Listing\Column;

use Magento\User\Model\UserFactory;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column as UiColumn;

class AdminUserData extends UiColumn
{
    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UserFactory        $userFactory
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UserFactory $userFactory,
        array $components = [],
        array $data = []
    ) {
        $this->userFactory = $userFactory;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare grid data.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $userId = $item['admin_user_id'];
                if ($this->getData('name') === 'admin_user_name') {
                    $user = $this->getUser($userId);
                    $item[$this->getData('name')] = $user->getName();
                } elseif ($this->getData('name') === 'admin_user_email') {
                    $user = $this->getUser($userId);
                    $item[$this->getData('name')] = $user->getEmail();
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get admin user by id.
     *
     * @param int $customerId
     *
     * @return User
     */
    private function getUser($userId)
    {
        return $this->userFactory->create()->load($userId);
    }
}
