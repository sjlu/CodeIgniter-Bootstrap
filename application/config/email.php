<?php

/*
 * What protocol to use?
 * mail, sendmail, smtp
 */
$config['protocol'] = 'mail';

/*
 * SMTP server address and port
 */
$config['smtp_host'] = '';
$config['smtp_port'] = '';

/*
 * SMTP username and password.
 */
$config['smtp_user'] = '';
$config['smtp_pass'] = '';

/*
 * Heroku Sendgrid information.
 */
/*
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = 587;
$config['smtp_user'] = $_SERVER['SENDGRID_USERNAME'];
$config['smtp_pass'] = $_SERVER['SENDGRID_PASSWORD'];
*/
