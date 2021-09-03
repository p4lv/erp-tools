# ERP tools.

[![Code Coverage](https://scrutinizer-ci.com/g/p4lv/erp-tools/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/p4lv/erp-tools/?branch=main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/p4lv/erp-tools/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/p4lv/erp-tools/?branch=main)

!! Important: Xdebug must be installed to run all test cases.

## please check before pushing with this:
Phpunit: ``./vendor/bin/phpunit -c phpunit.xml ``

Phpstan: ``./vendor/bin/phpstan analyse src tests``

Infection: ``./vendor/bin/infection  --initial-tests-php-options="-d zend_extension=xdebug.so"``


## Goal
- make coverage 100%


