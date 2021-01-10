unit-tests:
	vendor/bin/phpunit --testsuite unit

integration-tests:
	vendor/bin/phpunit --testsuite integration

run-tests:
	vendor/bin/phpunit
