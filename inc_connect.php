<?php

/*Connect to the server, in this case home.*/
$db = mysql_connect( "localhost","root","root" );

if (!$db)
  exit("Error - Could not connect to MySQL");
  $er = mysql_select_db("iplatform");

if (!$er)
  exit("Error - Could not select the iPlatform system database.");
