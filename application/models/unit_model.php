<?php
/*
 * Unit_model
 * An easier way to construct your unit testing
 * and pass it to a really nice looking page.
 *
 * @author sjlu
 */
class Unit_model extends CI_Model {

   public function __construct()
   {
      parent::__construct();
   }

   public function count_failed_tests($tests)
   {
      $count = 0;

      foreach ($tests as $test)
         if ($test['Result'] == 'Failed') $count++;

      return $count;
   }

   /*
    * Write your tests here, it is done this way
    * because you may need to dynamically generate
    * your data from other models, etc.
    */
   public function retrieve_tests()
   {
      $tests = array();

      /*
       * You should build your tests like the one below.
       *
      $tests[] = array(
         'rv' => $this->sendit_model->validate_email('tacticalazn@gmail.com'),
         'ev' => true,
         't' => 'validate_email("tacticalazn@gmail.com")',
         'n' => 'Checking if email validation works.'
      );
      */

      return $tests;
   }

}
