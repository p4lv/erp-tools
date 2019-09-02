# ERP tools.


!! Important: Xdebug must be installed to run all test cases.

## please check before pushing with this:
Phpunit: ``./vendor/bin/phpunit -c phpunit.xml ``

Phpstan: ``./vendor/bin/phpstan analyse src tests``

Infection: ``./vendor/bin/infection  --initial-tests-php-options="-d zend_extension=xdebug.so"``


## Goal
- make coverage 100%


