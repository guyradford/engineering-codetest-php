

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



###### Composer install

```docker run --dns 192.168.1.254 -it -v $PWD:/opt/project --entrypoint ash php7.4-symfony-dev```
