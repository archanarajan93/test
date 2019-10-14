<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

       class DBDriver
       {
           private $CI, $Data, $mysqli, $ResultSet;

           /**
            * The constructor
            */

           function __construct()
           {
               $this->CI =& get_instance();
               $this->ResultSet = array();
               $this->mysqli = $this->CI->db->conn_id;
           }

           public function GetMultiResults($SqlCommand)
           {
               $this->Data = array();
               /* execute multi query */
               if (mysqli_multi_query($this->mysqli, $SqlCommand)) {
                   $i=0;
                   do
                   {
                       if ($result = $this->mysqli->store_result())
                       {
                           if(0 == $result->num_rows)
                           {
                               $this->Data[$i][] = null;
                           }else{
                               while ($row = $result->fetch_assoc())
                               {
                                   $this->Data[$i][] = $row;
                               }
                           }
                           mysqli_free_result($result);
                       }
                       $i++;
                   }
                   while ($this->mysqli->more_results() && $this->mysqli->next_result());
               }
               return $this->Data;

           }
       }
?>