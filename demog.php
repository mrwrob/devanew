<?php
    session_start();
    if (is_ajax()) {
      $link = sqlConnect();

        if($_POST['email']){
          $address= $_POST['email'];
          $period= $_POST['period'];
          if(!$period) $period=0;
          $result = mysql_query("INSERT INTO emails (address, period) VALUES('$address', $period)");

        } else {
          $years = $_POST["years"];
          $roles = $_POST["roles"];

          if(! $roles) $roles=0;
          if(! $years) $years=0;

          $result = mysql_query("SELECT * FROM participants WHERE session = '".session_id()."'");
          if(mysql_num_rows($result)<=0){   // New user
            $result = mysql_query("INSERT INTO participants (session, roles, years) VALUES('".session_id()."', $roles, $years)");
          }else{
            $row = mysql_fetch_assoc($result);
            $participant=$row['id'];
            error_log("UPDATE participants SET roles=$roles, years=$years WHERE id=$participant");
            $result = mysql_query("UPDATE participants SET roles=$roles, years=$years WHERE id=$participant");
          }
      }
    }

    //Function to check if the request is an AJAX request
    function is_ajax() {
      return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

function sqlConnect()
{
    // Replace HOST, USER, PASS with valid address and credentials of MySQL database server
    $link = mysql_connect(HOST, USER, PASS);

    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db('emorg_survey', $link) or die('Could not select database.');
    return $link;
}
?>
