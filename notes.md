

### Observations

* Old version of Symfony (v3.4)
* Move output formatters to service?
* ~~Get tests running~~
* ~~Composer Install~~
* Create Docker Runner container
* notifyStaffMemberAction does not support output formatting
* ~~TODO: Add Email notifier~~
  * ~~Add interface/abstract~~
* Add tests
  * Controllers
    * CoffeeBreakPreferenceController.php
      * ~~todayAction~~
      * ~~notifyStaffMemberAction~~
    * Services
      * ~~Notifier~~
        * ~~Email~~
        * ~~Slack~~
* output format as http request header... lookup standard... Accept
* output Response as abstract
* ~~New folder structure for test folder~~
* constants/Enums
* validation
* Linting
* phpStan
* Unsupported Accept type Exception tidy up.
* ~~Tests dont have Namespace~~
* Tests at wrong folder level? move to root?
* notifyStaffMemberAction is not standard
* Test mocks not returning correct object type as expected... to investigate.
* notifyStaffMemberAction return 200 when an error occurred.
* notifyStaffMemberAction needs content type setting for response.
* getPreferenceFor could be replaced by getPreferenceForToday()
* I dont like the output split between Repository and Controller
* I dont like the hand cranked XML in the XML Item Renderer
* I dont like the hand cranked HTML in the HTML Renderer

### Actions Taken

1. Build Docker image for php7.4 for dev and ran `composer install` 
1. Added email notifier/ notifier interface and tests. Passed in Notifier to controller action.
1. Refactored Controller Actions to pass in dependencies to allow testing of controller
1. Creation of models as Mocking Repositories for unit testing as it is not recommended (https://symfony.com/doc/3.4/testing/doctrine.html)
1. Completed initial tests for TodayAction in CoffeeBreakPreferenceController and added Data Providers 
   * Fixed wrong function names and invalid xml etc.
1. Added Namespaces to tests
1. Add tests for notifyStaffMemberAction
1. Output Formatting


###### Composer install

```docker run --dns 192.168.1.254 -it -v $PWD:/opt/project --entrypoint ash php7.4-symfony-dev```

###### Run Tests

```docker run -it -v $PWD:/opt/project php7.4-symfony-dev /opt/project/vendor/phpunit/phpunit/phpunit /opt/project/src/Awin/Tools/CoffeeBreak/Tests```