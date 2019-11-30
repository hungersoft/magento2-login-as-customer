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

namespace HS\LoginAsCustomer\Plugin\Backend\Magento\Sales\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Sales\Ui\Component\Listing\Column\ViewAction as ActionColumn;

class ViewAction
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor.
     *
     * @param UrlInterface $urlBuilder
     */
    public function __construct(UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Add login as customer button to sales grid actions column.
     *
     * @param ActionColumn $subject
     * @param array        $dataSource
     *
     * @return array
     */
    public function afterPrepareDataSource(ActionColumn $subject, $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['customer_id'])) {
                    $item[$subject->getData('name')]['hs_login_as_customer'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'hs_login_as_customer/adminlogin/login',
                            [
                                'customer_id' => $item['customer_id'],
                            ]
                        ),
                        'target' => '_blank',
                        'label' => __('Login as customer'),
                    ];
                }
            }
        }

        return $dataSource;
    }
}
