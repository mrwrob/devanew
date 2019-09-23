<?php
  session_start();
  $sessionName = session_name();
  $sessionCookie = session_get_cookie_params();
  session_destroy();
  setcookie($sessionName, false, $sessionCookie['lifetime'], $sessionCookie['path'], $sessionCookie['domain'], $sessionCookie['secure']);
?>
<!DOCTYPE html>
<html>
  <head>
      <title>Developers Affective Annotated Dictionary</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <div id='content'>
      <h2>Thank you for your time!!!</h2>
      <div id='contact'>
      <p>If you want to participate in the study on the role of emotions in the software development process in the future, leave your e-mail address:</p>
      <label> <div>E-mail:</div> <input id='email' name='email'></label><br />
      <label><div>How often we can contact you:</div>
        <select id='period' name='period'>
          <option value=1>Once a year</option>
          <option value=2 selected>Twice a year</option>
          <option value=3>Three times a year</option>
          <option value=4>Four times a year</option>
          <option value=6>Six times a year</option>
        </select></label>
        <p><button id='send_button'>Send</button>
      </div>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function(){
            $("#send_button").click(function (event){
              var email= $("#email").val();
              var period= $("#period").val();
              $.ajax({
                    type: "POST",
                    dataType: "text",
                    data: {'email':email, 'period':period},
                    url: "demog.php",
                    success: function(data) {
                      $("#contact").html("<p>Results of this study will be published on the <a href='http://www.emorg.eu/'>EmoRG website</a>.</p>");
                    }
              });

            });

        });
    </script>

  </body>
</html>
