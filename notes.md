

##### Initial Observations

* Old version of Symfony (v3.4)
* Move output formatters to service
* ~~Get tests running~~
* ~~Composer Install~~
* Create Docker Runner container
* notifyStaffMemberAction does not support output formatting
* TODO: Add Email notifier
 * Add interface/abstract
* Add tests
* output format as header... lookup standard
* output Response as abstract
* New folder structure
* constants
* Linting
* phpStan
* Unsupported Accept type Exception tidy up.
* Tests dont have Namespace
* Tests at wrong level?
* notifyStaffMemberAction is not standard
* Test mocks not returning object type as expected... to investigate.


###### Composer install

```docker run --dns 192.168.1.254 -it -v $PWD:/opt/project --entrypoint ash php7.4-symfony-dev```

Run Tests

```docker run -it -v $PWD:/opt/project php7.4-symfony-dev /opt/project/vendor/phpunit/phpunit/phpunit /opt/project/src/Awin/Tools/CoffeeBreak/Tests```