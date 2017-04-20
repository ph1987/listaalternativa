<html>
<head>
  	<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<title>Lista Alternativa</title>
	<link rel="stylesheet" href="css/style.css">
  	<!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  	<![endif]-->
</head>
<body>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/moment.js"></script>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    //console.log('statusChangeCallback');
    //console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '1699753310267721',
    cookie     : true,  // enable cookies to allow the server to access
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.5' // use graph api version 2.5
  });

  // Now that we've initialized the JavaScript SDK, we call
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Hey, ' + response.name + '! :D';
    });
  }
</script>


<div class="jumbotron">
	<!--<div id="preloader"></div>-->
    <button onclick="javascript:eventos();">=D</button>
    <br/><br/><br/>
    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
    <div id="status"></div>
    <ul id="events" class="list"></ul>
</div>

<script>
function eventos()
{
        var events = "";
        var dateNow = moment().format('YYYY-MM-DD HH:mm:ss'); 
        var list_id_events = [];
        list_id_events.push("/287688837913011/events");    //casa da matriz
        list_id_events.push("/143286195735246/events");   //teatro odisseia
        list_id_events.push("/145492998804017/events");   //College Rock
        var listeventsLen = list_id_events.length;

        for (k=0; k<listeventsLen; k++)
        {
			FB.api(list_id_events[k], 'GET', { "fields": "start_time,cover,name,attending_count, place" },
          	function (response)
          	{
          		var list = [];
                var dateNow = moment().format('YYYY-MM-DD HH:mm:ss'); 
                for(i=0; i<response.data.length; i++)
                {
                      var eventDateRaw = moment(response.data[i].start_time).format('YYYY-MM-DD HH:mm:ss');
                      var eventDateRawTemp = moment(eventDateRaw, "YYYY-MM-DD HH:mm:ss").add(3, 'h');
                      var eventDatePlus3hrs = eventDateRawTemp.format('YYYY-MM-DD HH:mm:ss');
                      if (eventDatePlus3hrs > dateNow)
                      {
                        var obj = {
                          "id": response.data[i].id,
                          "date": eventDateRaw,
                          "name": response.data[i].name,
                          "attending_count": response.data[i].attending_count,
                          "location_name": response.data[i].place.name,
                          "location_city": response.data[i].place.location.city,
                          "street": response.data[i].place.location.street,
                          "cover": response.data[i].cover.source
                        };
                        list.push(obj);
                        console.log(response.data[i].place);
                      }
                }
                for(j=0; j<list.length; j++)
                {
                    //console.log(list[j].name);
                    events = events + 
                    	"<li>" + list[j].date + "<br/>" + 
                    	list[j].name + "<br/>" + 
                    	list[j].location_name + " - " + list[j].attending_count + " - " + list[j].location_city + " - " + list[j].street + "<br/><img src='" + 
                    	list[j].cover + "' style='max-height:268px;' /></li>";
                    document.getElementById("events").innerHTML = events;
                    order();
                }
          	}
          	);
        }          
}
</script>

<script id="jsbin-javascript">
function order() 
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

<!--<script src="js/index.js"></script>-->
</body>
</html>