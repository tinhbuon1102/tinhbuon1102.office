<?php

return array (
  'dbHost' => 'localhost',
  'dbPort' => '3306',
  'dbUser' => 'root',
  'dbPassword' => 'thang',
  'dbName' => 'livechat',
  'superUser' => 'admin',
  'superPass' => 'admin',
  'services' => 
  array (
    'mailer' => 
    array (
      'smtp' => '',
      'smtpSecure' => 'ssl',
      'smtpHost' => '',
      'smtpPort' => '465',
      'smtpUser' => '',
      'smtpPass' => '',
    ),
  ),
  'appSettings' => 
  array (
    'contactMail' => 'admin@domain.com',
  ),
);

?>