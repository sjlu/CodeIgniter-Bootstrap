##Introduction

CodeIgniter Bootstrap kick starts the development process of the web development process by including Twitter Bootstrap into CodeIgniter. It also includes certain libraries such as AWS and Facebook in-case you are developing applications requiring those SDKs. So stop writing the same code over again and start working on your idea.

##Requirements

You will need a proper web server that can run PHP 5.0 or higher. I will also suggest using a MySQL database, though you also encouraged to use other libraries that support a better database like MongoDB.

##Included Libraries

You can load the several libraries included in CodeIgniter-Bootstrap.

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