<?php

/*
 * What protocol to use?
 * mail, sendmail, smtp
 */
$config['protocol'] = 'mail';

// If sendmail is enabled on Heroku, it will use that instead.
if (isset($_SERVER['SENDGRID_USERNAME']))
   $config['protocol'] = 'smtp';

/*
 * SMTP server address and port
 */
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = 587;

/*
 * SMTP username and password.
 */
$config['smtp_user'] = $_SERVER['SENDGRID_USERNAME'];
$config['smtp_pass'] = $_SERVER['SENDGRID_PASSWORD'];
