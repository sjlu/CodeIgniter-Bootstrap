<?php

/*
 * dir2list
 * Directory to list will allow you to
 * create a menu list or any type of list
 * from a directory, allowing you to create
 * a dynamic menu from semi-static content.
 *
 * @author: sjlu
 */

function dir2list($dir)
{
   $return = array();
   $dir_listing = directory_map($dir, 1);
   
   sort($dir_listing);
   foreach($dir_listing as $dir_name)
   {
      $temp = array();

      $temp['path'] = $dir_name;

      $dir_name = str_replace(array('_'), " ", $dir_name);
      $dir_name = ucwords($dir_name);
      $temp['title'] = $dir_name;

      $return[] = $temp;
   }

   return $return;
}

?>
