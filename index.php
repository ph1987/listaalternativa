<?php
$servername = "br-cdbr-azure-south-b.cloudapp.net";
$username = "b3e430f8dfef1e";
$password = "95df8e51";
$dbname = "acsm_5fe05832cd7250c";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}

$url = $_SERVER['SERVER_NAME'];

/*
$tipo = $_GET["tipo"];
if (isset($tipo)) 
{
    $query = "SELECT * FROM events WHERE type LIKE '%" . $tipo . "%'";
}
*/

$local = "rio-de-janeiro";  //default place

if(isset($_COOKIE['lacity']))
{
    $local = $_COOKIE['lacity'];
}

if(isset($_GET['local'])) 
{
    $local = $_GET["local"];
    setcookie('lacity', $local, (time() + (30 * 24 * 3600)));
}


$query = "SELECT * FROM events WHERE status = 1 AND city LIKE '%" . $local . "%'";


$dados = mysqli_query($conn, $query);
$linha = mysqli_fetch_assoc($dados); // transforma os dados em um array
$total = mysqli_num_rows($dados); //calcula quantos dados retornaram $total = mysql_num_rows($dados)


?>



<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Lista Alternativa - Festas alternativas pelo Brasil">
    <meta name="author" content="Philipe Tavares">
    <meta name="keywords" content="lista, alternativa, la, amiga, festa, balada, rio de janeiro, rj, rio, sp, brasilia, df, sampa, sao paulo, brasil, rock, indie, metal, poprock, teatro odisseia, casa da matriz, bagaceira, pop">
    
    <link rel="icon" href="favicon.ico">
    
    <title>Lista Alternativa</title>

    <!-- Bootstrap core CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- <link href="dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet" type="text/css">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <!--<body style="background-image: url(http://www.planwallpaper.com/static/images/6790904-free-background-wallpaper.jpg);">-->
  <body style="background-color:#eee; font-family: 'Roboto Condensed', sans-serif;">
    
    <script src="js/moment.js"></script>
    <script>

      // Load the SDK asynchronously
      (function(d, s, id) 
      {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }
      (document, 'script', 'facebook-jssdk'));
    
      function statusChangeCallback(response) 
      {
        console.log("function statusChangeCallback(response) ");
        if (response.status === 'connected') 
        {
          $("#loading").show();
          $("#loginbutton").hide();
          testAPI();
        } 
        else if (response.status === 'not_authorized') 
        {
          // The person is logged into Facebook, but not your app.
          $("#loginbutton").show();
          //document.getElementById('status').innerHTML = 'Loga no facebook ae! :)';
        } 
        else 
        {
          $("#loginbutton").show();
          //document.getElementById('status').innerHTML = 'Loga no facebook ae! :)';
        }
      }

      function checkLoginState() {
        FB.getLoginStatus(function(response) 
        {
          statusChangeCallback(response);
        });
      }

      window.fbAsyncInit = function() {
      FB.init({
        appId      : '1699753310267721',
        cookie     : true,  // enable cookies to allow the server to access
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.8' // use graph api version 2.5
      });

      FB.getLoginStatus(function(response) 
      {
        statusChangeCallback(response);
      });

      };



      // Here we run a very simple test of the Graph API after login is
      // successful.  See statusChangeCallback() for when this call is made.
      function testAPI() 
      {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) 
        {
          console.log('Successful login for: ' + response.name);
          //document.getElementById('status').innerHTML = 'E aí, ' + response.name + '! :D';
          show_events_onpage();
        });
      }
    </script>
    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation">
              <!--<button id="clickEv" name="clickEv" class="clickEv" onclick="javascript:eventos();">=D</button>-->
              <!--<fb:login-button scope="public_profile,email" id="loginbutton" onlogin="checkLoginState();"></fb:login-button>-->
              
            </li>
          </ul>
        </nav>
        
        <!--
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="#">Home</a></li>
            <li role="presentation"><a href="#">About</a></li>
            <li role="presentation"><a href="#">Contact</a></li>
          </ul>
        </nav>
        -->
        <h3 class="text-muted" style="font-weight:bold; font-size:25px;"><img src="imgs/icon.png" style="width:40px;" />lista alternativa</h3>
        <!--<div id="status"></div>-->
      </div>
      
      <div id="loginbutton" style="display:none;">
        <br/>
        <div class="fb-login-button" autologoutlink="true" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false" data-scope="public_profile,user_events,user_friends,rsvp_event" onlogin="checkLoginState();"></div>
        <p style="font-size:16px; margin-top:5px;">faça login com facebook pra saber as boas da semana :D</p>
        <br/>
      </div>

      <img src="imgs/loading.gif" id="loading" style="display:none; margin-bottom: 25px; margin-top:10px;" />

      <div id="filters" class="filters" style="margin-top:10px; margin-bottom:10px; display: none;">
        <form method="get" action="" name="filters">
          <select id="local" name="local" class="selectpicker" onchange="javascript:form.submit();">
            <option data-icon="glyphicon glyphicon-globe" value="brasilia" <?= ($local == 'brasilia') ? 'selected="selected"':'';  ?>>&nbsp;Brasília - DF</option>
            <option data-icon="glyphicon glyphicon-globe" value="rio-de-janeiro" <?= ($local == 'rio-de-janeiro') ? 'selected="selected"':''; ?>>&nbsp;Rio de Janeiro - RJ</option>
            <option data-icon="glyphicon glyphicon-globe" value="sao-paulo" <?= ($local == 'sao-paulo') ? 'selected="selected"':'';  ?>>&nbsp;São Paulo - SP</option>
          </select>
        </form>
      </div>

      <ul id="events" class="list"></ul>
      <br/>

      <footer class="footer">
        <p>&copy; 2016 lista alternativa \,,/</p>
      </footer>

    </div> <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    <!-- faz a ordenação -->
    <script id="jsbin-javascript">
    function order()                                           //função que ordena os eventos pela data de forma crescente
    {
      $(".list li").sort(asc_sort).appendTo('.list');
      function asc_sort(a, b)
      {
        return ($(b).text()) < ($(a).text()) ? 1 : -1;    
      }
      function dec_sort(a, b)
      {
        return ($(b).text()) > ($(a).text()) ? 1 : -1;    
      }
    }
    </script>

    <script>
    function show_events_onpage()
    {
      setTimeout( function()
      { 
        var vmonths = [" ", "JAN", "FEV", "MAR", "ABRIL", "MAIO", "JUNHO", "JULHO", "AGO", "SET", "OUT", "NOV", "DEZ"];
        var vdays = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"];
        var events = "";

        var dateNow = moment().format('YYYY-MM-DD HH:mm:ss'); 

        var dateLimitRawTemp = moment(dateNow, "YYYY-MM-DD HH:mm:ss").add(7, 'd');
        var dateLimit = dateLimitRawTemp.format('YYYY-MM-DD HH:mm:ss');

        var list_id_events = [];
        var list_events_added = [];

        //adicionando ids das páginas que criam eventos

        <?php 
            if($total > 0)
            {
              do 
              {
            ?>
            var id_event = "<?php echo $linha['id']; ?>";
            list_id_events.push(id_event);
            <?php
              }
                while($linha = mysqli_fetch_assoc($dados));
            }
        ?>


        var listeventsLen = list_id_events.length;
        for (k=0; k<listeventsLen; k++)
        {
            FB.api(list_id_events[k] + "/events?fields=start_time,cover,name,attending_count,place,maybe_count&limit=50&pretty=0", function (response)
            {
                var list = [];
                for(i=0; i<response.data.length; i++)
                {
                  //verify if there is the same event already added in the list
                  var found = 0;
                  for (e=0; e<list_events_added.length; e++)
                  {
                    if (list_events_added[e] == response.data[i].id)
                    {
                      found = 1;
                      //console.log("evento repetido: " + response.data[i].id);
                      break;
                    }
                  }

                  if (found == 0)
                  {
                    var diffindays = -10;
                    var eventDateRaw = moment(response.data[i].start_time).format('YYYY-MM-DD HH:mm:ss');    //data no formato cru 
                    var eventDateRawBR = moment(response.data[i].start_time).format('DD-MM-YYYY HH:mm:ss');  //data no formato BR e cru
                    var eventDateRawTemp = moment(eventDateRaw, "YYYY-MM-DD HH:mm:ss").add(3, 'h');          //data no formato cru adicionando 3h
                    var eventDatePlus3hrs = eventDateRawTemp.format('YYYY-MM-DD HH:mm:ss');                  
                    if (eventDatePlus3hrs > dateNow && eventDatePlus3hrs <= dateLimit)
                    {
                      var day = moment(eventDateRaw).format('DD');
                      var month = moment(eventDateRaw).format('M');
                      var year = moment(eventDateRaw).format('YYYY');

                      var dayToday = moment(dateNow).format('DD');
                      var monthToday = moment(dateNow).format('M');
                      var yearToday = moment(dateNow).format('YYYY');

                      var dayofweek = moment(eventDateRaw).format('d');
                      var hourNminutes = moment(eventDateRaw).format('HH:mm');

                      //var a = moment([year, month, day]);
                      //var b = moment([yearToday, monthToday, dayToday]);

                      //var a = moment([2016, 12, 27]);
                      //var b = moment([yearToday, monthToday, dayToday]);

                      //diffindays = a.diff(b, 'days');   // =1

                      //console.log(diffindays);

                      var date1 = new Date(monthToday + "/" + dayToday + "/" + yearToday);
                      var date2 = new Date(month + "/" + day + "/" + year);
                      var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                      var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
                      diffindays = diffDays;

                      var cityoftheEvent = "";
                      var streetoftheEvent = "";
                      try 
                      {
                          cityoftheEvent = response.data[i].place.location.city;
                      }
                      catch(err) 
                      {
                          cityoftheEvent = "";
                      }

                      try 
                      {
                          streetoftheEvent = response.data[i].place.location.street;
                      }
                      catch(err) 
                      {
                          streetoftheEvent = "";
                      }

                      var obj = {
                        "id": response.data[i].id,
                        "diffindays": diffindays,
                        "day": day,
                        "month": month,
                        "dayofweek": dayofweek,
                        "hourNminutes": hourNminutes,
                        "date": eventDateRaw,
                        "dateBR": eventDateRawBR,
                        "name": response.data[i].name,
                        "attending_count": response.data[i].attending_count,
                        "maybe_count": response.data[i].maybe_count,
                        "location_name": response.data[i].place.name,
                        "location_city": cityoftheEvent,
                        "street": streetoftheEvent,
                        "cover": response.data[i].cover.source,
                        "urlevent": '"' + "https://www.facebook.com/events/" + response.data[i].id + '"'
                      };
                      list.push(obj);
                      list_events_added.push(response.data[i].id);
                    }
                  }
                }
                for(j=0; j<list.length; j++)
                {
                    //console.log(list[j].urlevent);
                    var dateFloatingButton = "";
                    if (list[j].diffindays == 0)
                    {
                      dateFloatingButton = "<p class='dateEvent'>HOJE!</p><div class='clear'></div>";

                    }
                    else if (list[j].diffindays == 1)
                    {
                      dateFloatingButton = "<p class='dateEvent'>AMANHÃ!</p><div class='clear'></div>";
                    }
                    else
                    {
                      dateFloatingButton = "<p class='dateEvent'>" + list[j].day + "/" + vmonths[list[j].month] + "</p><div class='clear'></div>";
                    }

                    events = events + 
                    "<li title='Clique para ir até a página do evento' onClick='window.open(" + list[j].urlevent + ")'><span style='display:none;'>" + list[j].date + "</span>" + 

                    "<img src='" + list[j].cover + "' style='max-height:268px;margin-bottom:5px;' class='img-responsive' />" +
                    dateFloatingButton + 
                    
                    "<strong>" + list[j].name + "</strong><br/>" +
                    "<span class='dayofweek'><span style='color:#e34e60;'>" + vdays[list[j].dayofweek] + "</span> · " + list[j].hourNminutes + " · " + list[j].location_name + "</span><br/>" +

                    "<span class='street'><img src='imgs/mapa.png' style='width:12px;' />&nbsp;" + 
                    list[j].street + " - " + list[j].location_city + "</span><br/>" + 
                    "<span class='confirmed'>" + list[j].attending_count + " confirmaram presença</span> · " +
                    "<span class='confirmed'>" + list[j].maybe_count + " tem interesse</span>" +
                    "</li>";
                    document.getElementById("events").innerHTML = events;
                }
                order();
            }
            );
          } 
      },1000);

      setTimeout( function()
      { 
        $("#loading").hide();
        $("#events").show();
        $("#filters").show();
      },5500);
    }
    </script>

    <div id="fb-root"></div>

  </body>
</html>
