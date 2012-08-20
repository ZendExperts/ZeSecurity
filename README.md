ZeSecurity
==========

ZeSecurity is a Zend Framework 2 module that integrates a security layer in your
applications. It includes various components to manage security threats:

IDS - Powered by [PHP IDS (Intrusion Detection System)](https://phpids.org/):
-----------------------------------------------------------------------------

This component scans any user input, be it sent via POST, GET or COOKIE and tries to see if the
user input can be considered a threat. Any number of threat levels can be defined with various
actions for each one via the configuration file.

Using this component you can define multiple threat levels, what actions should be taken for each
level and also register new plugins for handling attacks.

Installation / Usage
====================

ZeSecurity can be installed using Composer by simply adding the following lines to your composer.json file:

    "require": {
        "zendexperts/ze-security": "dev-master"
    }
    
Then run `php composer.phar update`.

After the module is installed copy the "zesecurity.ids.global.php" file from "ZeSecurity/config/" in the "/config/autoload/" folder and 
modify the paths to temp, log or cache files:

	// define used paths by ZeSecurity IDS
	$ids = array(
		'log'=> __DIR__ . '/../../data/log/ze_security.ids.log',
		'tmp'=> __DIR__ . '/../../data/tmp/',
		'cache'=> __DIR__ . '/../../data/cache/ze_security.ids.cache'
	);

In the same configuration file a default range of attack levels is defined with various actions for each one.

Feel free to change them per your needs or define new actions in the actions array. By default the following actions are defined:
- ignore: Do nothing with the attack report
- log: Save a log message in a stream, email, db, etc. depending on the writter factory param. Currently only stream/file and email are defined.
- notify: Send an email with the report using the options defined in the actions array for this action.
- redirect: Redirect to a specific URL.
- clean_session: Destroy the session to log out any users. When used along with redirect you can log out any users and redirect them to a specic page.

Documentation
=============
Comming soon. 

In the meanwhile please be sure to check out the [PHP IDS (Intrusion Detection System)](https://phpids.org/) documentation.