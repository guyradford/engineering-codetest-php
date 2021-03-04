# Awin CoffeeBreak Handover

Original [readme.md](readme-old.md)

This project is clearly just a small standalone section of what would be a much more complete project. 
For example there is no config, auto-wiring, no entrypoint for Http requests ect. I have kept all my changes
within that spirit.

As was stated this exercise is the proverbial 'piece of string'. Therefore, have completed some of the
more important refactoring, but this is by no means all the refactoring required. I have included a list
of actions taken, a list of project observations, and a ToDo list of what I would do next... I doubt any of these
lists are complete either.   


I have broken this document into sections:

**Observations** - This is a simple list of things I spotted, things todo, questions etc. 
The list was updated continuously throughout the project. I have crossed off items I completed.

**Actions Taken** - This list is the order I did changes to the project, it will vaguely match the 
commit history, however the commit history is not quite such a linear path.

**ToDo** - This is a list of known items that still need to be address, questions to answer 
and future improvements.


### Observations

* Old version of Symfony (v3.4)
* ~~Move output formatters to service?~~
* ~~Get tests running~~
* ~~Composer Install~~
* ~~Create Docker dev container~~
* notifyStaffMemberAction does not support output content type
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
* get content type format from http request header... lookup standard... "Accept"
* output Response as abstract
* ~~New folder structure for test folder~~
* constants/Enums
* Input validation
* Linting
* phpStan
* Unsupported Accept type Exception tidy up.
* ~~Tests dont have Namespace~~
* Tests at wrong folder level? move to root?
* Test mocks not returning correct object type as expected... to investigate.
* notifyStaffMemberAction returns 200 when an error occurred.
* notifyStaffMemberAction needs content type setting for response.
* getPreferenceFor could be replaced by new getPreferenceForToday() method
* ~~I dont like the output split between Repository and Controller~~
* I dont like the hand coded XML in the XML Item Renderer, generate with code
* I dont like the hand coded HTML in the HTML Renderer, generate with code
* Missing test case for default Accept type.
* No logging

### Actions Taken

1. Build a Docker image for php7.4 for dev and ran `composer install` and got the tests to run.
1. Added email notifier,  notifier interface and tests. Passed in Notifier to controller action.
1. Refactored Controller Actions to pass in dependencies to allow better testing of controller methods.
1. Creation of models as Mocking Repositories for unit testing as it is not recommended 
(https://symfony.com/doc/3.4/testing/doctrine.html). This allows models to be easily mocked.
1. Completed initial tests for TodayAction in CoffeeBreakPreferenceController and added Data Providers 
   * Fixed wrong function names and invalid xml etc.
1. Added Namespaces to tests.
1. Add tests for notifyStaffMemberAction.
1. Output Formatting - Create List Render and update Controller to us new renderers.

### ToDo

This ToDo list is in no particular order:

1. Make all action support the same Accept Type and return correct error responses.
1. The renderer has been improved from the original, but is NOT where I would like it to be, it is too 
specific. With more time a better more generic solution would be achievable. I am starting to think 
along the following lines.
    ```
    interface Renderer:
       renderHtml($mixed) : string;
       renderXML($mixed) : string;
       renderJson($mixed) : string;
    ```
   or 
   ```
   interface Renderer:
      render($contentType, $mixed) : string;
   ```
   One to discuss, it difficult to know exactly where to draw the line as there are a few options.

1. Tests required for the business logic in the CoffeeBreakPreference Entity
1. Add Logging
1. Input validation
1. Implement a better way for Enum/constants to make accessible to the whole project
1. Complete unit testing and add functional testing.
1. Add pipelines to run and enforce:
    * Unit test
    * Linting (standard to be selected/created)
    * phpStan
    * Build a container (Docker) image.
    * Test image.
    * Release on Tag

### Installation and execution of tests

For Mac without PHP 7.4 installed locally:

1. Build Docker file, run `./built-docker.sh`
1. Run Composer install, see below
1. Execute Tests, see below


###### Composer install

```docker run --dns 192.168.1.254 -it -v $PWD:/opt/project --entrypoint ash php7.4-symfony-dev```
```php composer.phar install```

\* Some machines need the DNS option set, use your default gateway IP or you can use `8.8.8.8`.


###### Run Tests

```docker run -it -v $PWD:/opt/project php7.4-symfony-dev /opt/project/vendor/phpunit/phpunit/phpunit /opt/project/src/Awin/Tools/CoffeeBreak/Tests```