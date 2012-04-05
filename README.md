##Introduction

CodeIgniter Bootstrap kick starts the development process of the web development process by including Twitter Bootstrap into CodeIgniter. It also includes certain libraries such as AWS and Facebook in-case you are developing applications requiring those SDKs. So stop writing the same code over again and start working on your idea.

CodeIgniter Bootstrap follows the path where it lazy loads libraries. Though the project footprint may be large, the memory footprint will still be extremely light. Try not to autoload libraries as it does not follow the CodeIgniter convention (though some libraries do make sense to autoload).

##Requirements

You will need a proper web server that can run PHP 5.0 or higher. I will also suggest using a MySQL database, though you also encouraged to use other libraries that support a better database like MongoDB.

###Recommendations

* You should consider using the Migration Class that CodeIgniter includes. This will allow you to easy migrate your database to different environments.

* Remember to change the environment variable located in the `index.php` file. Changing the environment type will change the behavior or your application from a rapid-agile development environment to a fast-cached production environment.

###Built Around Heroku

Everyone likes free hosting, especially one that easily scales. By design, a LAMP stack has a much higher scalability and availability than most technologies. There are some things that have been added to detect Heroku environments.

####Sendgrid

Heroku has a Sendgrid addon. By default, there is no sendmail on Heroku LAMP stacks so you will need to use a cloud email service. Heroku is a cloud service by design, it makes sense to use another cloud service to host email delivery.

To add the Sendgrid service, simply run `heroku addons:add sendgrid:starter` and CodeIgniter Bootstrap will automatically take its configuration and use it for any calls you use with the Email Class that CodeIgniter provides.

####ClearDB

Heroku also has a MySQL addon. We will auto-input this into the configuration if we detect it.

To add a ClearDB MySQL service, simply run `heroku addons:add cleardb:ignite`.

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

###CodeIgniter REST Library

When writing a REST API, you will need to write a different type of controller. Typically you create your controller and extend the `CI_Controller`, you should instead extend the `REST_Controller`.

    class Api extends REST_Controller
    {
        function user_post()
        function user_get()
    }
    
You should note the `post` and `get` at the end of the functions, denoting the type of request. For more information, you should consult the CodeIgniter-RestServer repository here:
https://github.com/philsturgeon/codeigniter-restserver/

##Extended Helper Functions

###URL Helper

The URL Helper extends the current CodeIgniter URL helper. This helper is also auto-loaded.
http://codeigniter.com/user_guide/helpers/url_helper.html

####is_active($uri)

is_active will return true or false based on if the inputted URI is contained in the current URI. The inputted URI does not need to be full. For example `/api/func/` will match `/api/func/1`. This function is useful when needing to call `class="active"` on elements of HTML.

####get_controller(), get_function(), get_parameters()

These functions will split up the URI and output them in a readable format for you. For exmaple, CI URLs are typically made in a way such as `/controller/function/param1/param2/`. These functions will split these up for you so that for example, all you want is the current paramenters, you would not need to parse the entire URL by yourself.

###Directory Helper

The Directory Helper extends the current CodeIgniter Directory helper, this is auto-loaded.
http://codeigniter.com/user_guide/helpers/directory_helper.html

####dir2list($dir)

dir2list gives your a directory as a list element, auto-languaging files into a nice title including the directory name. For example, if you create a directory named `some_directory`, it will be renamed to `Some Directory` for you to use. This function is not recursive. This is formatted as `array(title => "Some Directory", dir => "some_directory")`.

##Styling your CSS and HTML

By convention, you want to write your HTML documents in the views. They are located at `application/views`. In order to load those views, your controller has to then include the view (including the header and footer view).

In order to edit your styles, you should be editing `assets/css/custom.css`. All your images should go into `assets/img/` and your Javascript code should go into `assets/js/custom.js`. By default, `custom.css` and `custom.js` are included in the `view/include/header.php`. You should insert proper lines into this file to include your other resources.
