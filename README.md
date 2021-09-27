# leaderboard-api
 
Project Name: Leaderboard using REST API

Language: PHP 7.4.9, Mysql (Support PHP version 7.2.5 and above),  phpunit 9.5, guzzle 7.3

Requirements:<br><br>
•	PHP version 7.2.5 and above<br>
•	PHP Unit 9.5<br>
•	Guzzle 7.3<br>
•	Editor: Visual Studio 1.60.2 <br>
•	For Debugging: XDebug (Download URL: https://xdebug.org/) <br>

Installation:

1.	Download Xampp: https://www.apachefriends.org/download.html
2.	For development, download Visual Studio Code: https://code.visualstudio.com/download
3.	Create a project inside xampp/htdocs/project-name.
4.	For Unit testing we require PHPUnit and Guzzle is a library that helps us make requests to the API. You can download using the below urls.<br>
    a.	https://phpunit.de/  <br>
    b.	https://guzzle.readthedocs.org/en/latest/overview.html#installation

5.	You can also download through composer using below command <br>
    a.	$ composer require phpunit/phpunit  <br>
    b.	$ composer require guzzlehttp/guzzle  <br>
    c.	$ composer update  <br>

6.	Create phpunit.xml file inside root directory and add code from URL: https://blog.cloudflare.com/using-guzzle-and-phpunit-for-rest-api-testing/.<br>
   
7.	Create diretory called 'tests' inside root diretory.

9.	Check PHPUnit through command  ./vendor/bin/phpunit

9.	Add below code in composer.json file<br>
    "scripts": { <br>
       "test": "./vendor/bin/phpunit" <br>
      }

10. Create a Test php file for a unit code tesing inside 'tests' directory.
