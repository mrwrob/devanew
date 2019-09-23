<?php
    session_start();
    if (is_ajax()) {

        $word = $_POST["word"];
        $skip = $_POST["skip"];
        $valence = $_POST["v"];
        $arousal = $_POST["a"];
        $dominance = $_POST["d"];

        $link = sqlConnect();
        $result = mysql_query("SELECT * FROM participants WHERE session = '".session_id()."'");
        if(mysql_num_rows($result)<=0){   // New user
          $result = mysql_query("INSERT INTO participants (session) VALUES('".session_id()."')");
          $participant=mysql_insert_id($link);
        }else{
          $row = mysql_fetch_assoc($result);
          $participant=$row['id'];
        }

        if($word != ""){
          $result = mysql_query("SELECT * FROM words WHERE name = '$word'");
          $row = mysql_fetch_assoc($result);
          $wordId=$row['id'];

          if($skip!=1){
            $result = mysql_query("INSERT INTO evaluations (v,a,d,word,participant) VALUES($valence,$arousal,$dominance,$wordId,$participant)");
            $result = mysql_query("UPDATE words SET evals=evals+1 WHERE id = $wordId");
          }else $result = mysql_query("INSERT INTO evaluations (word,participant) VALUES($wordId,$participant)");        
        }

        $result = mysql_query("SELECT * FROM words WHERE id NOT IN (SELECT word FROM evaluations WHERE participant='$participant') ORDER BY evals ASC, RAND() LIMIT 1");

        if(mysql_num_rows($result)>0){
          $row = mysql_fetch_assoc($result);
          print $row['name'];
        } else {
          if($word == ""){
            print "#new#";
          } else {
            print "#done#";
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
