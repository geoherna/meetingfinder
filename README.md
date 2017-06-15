# MeetingFinder 
1. [Installation / Requirements](#installation)
2. [Usage](#usage)
3. [Testing](#testing)

## Installation
You will need [composer](https://getcomposer.org) in order to install the required packages (PHPUnit, PHPDoc) and their respective dependencies.

Download the project source files into your server document root. For example, in nginx on most linux distros, this would be `/usr/share/nginx/html`
Once files are downloaded you will need to install composer dependencies as mentioned above by running:

    composer install
    
   which will not only install dependencies, but generate auto-load files. Once composer finished installing dependencies,  the API can be ran in two ways, CLI or via the browser. To view markup output, simply navigate to `index.php` via the browser.

If you prefer to execute via php cli, you can cd into the root directory within your terminal and run:

    php -f index.php
  the `export()` method, which outputs the end result, queries the `PHP_SAPI` constant to ensure mark up is not displayed in the command line, only in browser requests.
  
## Usage

You can add as many more Cards as you would like to expand the transportation mediums available for a trip. In order to achieve compatibility, simply make sure new Card class extends BaseCard and implements the `CardInterface`:

    class TaxiCard extends BaseCard implements CardInterface{
	    public function __construct($startLocation, $endLocation, $seat = null){
	        //code
	    }
		
	    //required by CardsInterface
	    public function readableString(){
	        return "Readable String";
	    }
    }
   As you can see above, adding additional methods of transport via new Cards is very simple.

## Testing
All tests can be found in the `tests` directory. Individual tests have been written for the creation of each type of card class, and a `TripTest.php` which will run a test for the entire functionality, including export.

All tests can be run by simply running the following command from the document root:

    phpunit