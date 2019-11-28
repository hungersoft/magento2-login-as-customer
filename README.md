![Hungersoft.com](https://www.hungersoft.com/skin/front/custom/images/logo.png)

# Login as Customer [M2]
**hs/module-login-as-customer**

Hungersoft's [Login as Customer](https://www.hungersoft.com/p/magento2-login-as-customer) extension allows you as an admin to login as customer from the admin side your store.

## Installation

```sh
composer config repositories.hs-module-all vcs https://github.com/hungersoft/module-all.git
composer config repositories.hs-module-login-as-customer vcs https://github.com/hungersoft/magento2-login-as-customer.git
composer require hs/module-login-as-customer:dev-master

php bin/magento module:enable HS_All HS_LoginAsCustomer
php bin/magento setup:upgrade
```

## Support

Feel free to contact Hungersoft at [support@hungersoft.com](mailto:support@hungersoft.com) if you are facing any issues with this extension. Reviews, suggestions and feedback will be greatly appreciated.
