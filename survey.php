<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        a: <?php print session_id() ?>
        <div id='word'><span>Happy</span></div>
        <table>
            <tr>
                <td><img src="pic/valence1.png"></td>
                <td><img src="pic/valence3.png"></td>
                <td><img src="pic/valence5.png"></td>
                <td><img src="pic/valence7.png"></td>
                <td><img src="pic/valence9.png"></td>
            </tr>
            <tr>
                <td colspan="5">
                    <div class='emo_eval' id='valence'>
                        <div id='v1'></div>
                        <div id='v2'></div>
                        <div id='v3'></div>
                        <div id='v4'></div>
                        <div id='v5'></div>
                        <div id='v6'></div>
                        <div id='v7'></div>
                        <div id='v8'></div>
                        <div id='v9'></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td><img src="pic/arousal1.png"></td>
                <td><img src="pic/arousal3.png"></td>
                <td><img src="pic/arousal5.png"></td>
                <td><img src="pic/arousal7.png"></td>
                <td><img src="pic/arousal9.png"></td>
            </tr>
            <tr>
                <td colspan="5">
                    <div class='emo_eval' id='arousal'>
                        <div id='a1'></div>
                        <div id='a2'></div>
                        <div id='a3'></div>
                        <div id='a4'></div>
                        <div id='a5'></div>
                        <div id='a6'></div>
                        <div id='a7'></div>
                        <div id='a8'></div>
                        <div id='a9'></div>
                    </div>
                </td>
            </tr>

            <tr>
                <td><img src="pic/dominance1.png"></td>
                <td><img src="pic/dominance3.png"></td>
                <td><img src="pic/dominance5.png"></td>
                <td><img src="pic/dominance7.png"></td>
                <td><img src="pic/dominance9.png"></td>
            </tr>
            <tr>
                <td colspan="5">
                    <div class='emo_eval' id='dominance'>
                        <div id='d1'></div>
                        <div id='d2'></div>
                        <div id='d3'></div>
                        <div id='d4'></div>
                        <div id='d5'></div>
                        <div id='d6'></div>
                        <div id='d7'></div>
                        <div id='d8'></div>
                        <div id='d9'></div>
                    </div>
                </td>
            </tr>
        </table>
        <button id='send_button'>Send</button>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type='text/javascript'>
            $(document).ready(function(){
                var arousal=0;
                var valence=0;
                var dominance=0;
                $("#send_button").prop("disabled",true);
                $('.emo_eval').on("click","div", function (event) {
                    $(this).siblings().css("background-color","lightgray");
                    $(this).css("background-color","green");
                    var el_id = $(this).attr('id');
                    if(el_id[0] === "v") valence = el_id[1];
                    else if(el_id[0] === "d") dominance = el_id[1];
                    else if(el_id[0] === "a") arousal = el_id[1];
                    if(valence*dominance*arousal !== 0 ) $("#send_button").prop("disabled",false);
                });
                $("#send_button").click(function (event){
                    $("#send_button").prop("disabled",true);
                    $.ajax({
                        type: "POST",
                        dataType: "text",
                        url: "update.php",
                        data: {'v':valence, 'a':arousal, 'd':dominance, },
                        success: function(data) {
                            arousal=0;
                            valence=0;
                            dominance=0;
                            $('#word span').fadeOut(500, function (){
                                $('#word span').text(data);
                                $('#word span').fadeIn(500);
                                $('.emo_eval').children().css("background-color","lightgray");

                            });
                        }
                      });

                });

            });
        </script>
    </body>
</html>
