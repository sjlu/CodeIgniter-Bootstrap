##Introduction

CodeIgniter Bootstrap kick starts the development process of the web development process by including Twitter Bootstrap into CodeIgniter. It also includes certain libraries such as AWS and Facebook in-case you are developing applications requiring those SDKs. So stop writing the same code over again and start working on your idea.

##Requirements

You will need a proper web server that can run PHP 5.0 or higher. I will also suggest using a MySQL database, though you also encouraged to use other libraries that support a better database like MongoDB.

##Included Libraries

You can load the several libraries included in CodeIgniter-Bootstrap. These libraries can be worked on an extended on through the directory `application/libraries`. You will also need to edit the configuration files for these SDKs, located at `application/config`.

###Amazon Web Services PHP SDK

    $this->load->library('aws');
    $this->aws->load('s3');
    $this->aws->s3->create_object('bucket', array());
  
More information on the actual SDK can by viewed here:
http://docs.amazonwebservices.com/AWSSDKforPHP/latest/

###Facebook PHP SDK

    $this->load->library('fb');
    $this->fb->sdk->get_user();
    
More information on the Facebook SDK is on:
https://github.com/facebook/php-sdk

###MongoDB Library

    $this->load->library('mongo_db');
    $this->mongo_db->where_gte(); // not a finished code
    
View the MongoDB library for CodeIgniter here:
https://github.com/alexbilbie/codeigniter-mongodb-library/tree/v2

##Styling your CSS and HTML

By convention, you want to write your HTML documents in the views. They are located at `application/views`. In order to load those views, your controller has to then include the view (including the header and footer view).

In order to edit your styles, you should be editing `assets/css/custom.css`. All your images should go into `assets/img/` and your Javascript code should go into `assets/js/custom.js`. By default, `custom.css` and `custom.js` are included in the `view/include/header.php`. You should insert proper lines into this file to include your other resources.