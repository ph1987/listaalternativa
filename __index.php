<html>
<head>
	<title>Lista Alternativa</title>
</head>
<body>

<script src="js/moment.js"></script>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
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

  function eventos()
  {

  		var text = "";
  		var element = {}, list = [];
  		//list.push({ date: '12/01/2011', name: 'parabéns chapa cu', id: 20055 });
  		//list.push({ date: '26/02/2015', name: 'bye gustavo flores', id: 66666 });
  		//console.log(list[0].date + " / " + list[0].name + " / " + list[0].id);
  		//console.log(list[1].date + " / " + list[1].name + " / " + list[1].id);

  		//casa da matriz RJ  
        FB.api('/287688837913011/events', 'GET', { "fields": "start_time,cover,name,attending_count, place" },
        function (response)
        {
   			  var dateNow = moment().format('YYYY-MM-DD HH:mm:ss');	
          	  for(i=0; i<response.data.length; i++)
          	  {
          	  	  	var eventDateRaw = moment(response.data[i].start_time).format('YYYY-MM-DD HH:mm:ss');
          	  	  	var eventDateRawTemp = moment(eventDateRaw, "YYYY-MM-DD HH:mm:ss").add(3, 'h');
			  		var eventDatePlus3hrs = eventDateRawTemp.format('YYYY-MM-DD HH:mm:ss');
          	  	  	if (eventDatePlus3hrs > dateNow)
          	  	  	{
          	  	  		element.id = response.data[i].id;
          	  	  		element.date = eventDateRaw;
          	  	  		element.name = response.data[i].name;
          	  	  		element.attending_count = response.data[i].attending_count;
          	  	  		element.location_name = response.data[i].place.name;
          	  	  		element.location_city = response.data[i].place.city;
          	  	  		element.cover = response.data[i].cover.source;
          	  	  		list.push(element);
          	  	  		text = text + response.data[i].name + "[ " + moment(response.data[i].start_time).format('YYYY/MM/DD HH:mm:ss') + "]<br/><br/>";
          	  	  		document.getElementById("demo").innerHTML = text;
          	  	  	}
          	  }
          	  console.log(list);
        }
        );

        //Bar do B RJ
        FB.api('/381656911885092/events', 'GET', { "fields": "start_time,cover,name,attending_count, place" },
        function (response)
        {
   			  var dateNow = moment().format('YYYY-MM-DD HH:mm:ss');	
          	  for(i=0; i<response.data.length; i++)
          	  {
          	  	  	var eventDateRaw = moment(response.data[i].start_time).format('YYYY-MM-DD HH:mm:ss');
          	  	  	var eventDateRawTemp = moment(eventDateRaw, "YYYY-MM-DD HH:mm:ss").add(3, 'h');
			  		var eventDatePlus3hrs = eventDateRawTemp.format('YYYY-MM-DD HH:mm:ss');
          	  	  	if (eventDatePlus3hrs > dateNow)
          	  	  	{
          	  	  		text = text + response.data[i].name + "[ " + moment(response.data[i].start_time).format('YYYY/MM/DD HH:mm:ss') + "]<br/><br/>";
          	  	  		document.getElementById("demo").innerHTML = text;
          	  	  	}
          	  }
        }
        );

        //Teatro Odisséia
        FB.api('/143286195735246/events', 'GET', { "fields": "start_time,cover,name,attending_count, place" },
        function (response)
        {
   			  var dateNow = moment().format('YYYY-MM-DD HH:mm:ss');	
          	  for(i=0; i<response.data.length; i++)
          	  {
          	  	  	var eventDateRaw = moment(response.data[i].start_time).format('YYYY-MM-DD HH:mm:ss');
          	  	  	var eventDateRawTemp = moment(eventDateRaw, "YYYY-MM-DD HH:mm:ss").add(3, 'h');
			  		var eventDatePlus3hrs = eventDateRawTemp.format('YYYY-MM-DD HH:mm:ss');
          	  	  	if (eventDatePlus3hrs > dateNow)
          	  	  	{
          	  	  		text = text + response.data[i].name + "[ " + moment(response.data[i].start_time).format('YYYY/MM/DD HH:mm:ss') + "]<br/><br/>";
          	  	  		document.getElementById("demo").innerHTML = text;
          	  	  	}
          	  }
          	  
        }
        );


  }


    /*
    $request = new FacebookRequest(
	  $session,
	  'GET',
	  '/287688837913011',
	  array(
	    'fields' => 'events{attending_count,name,place,start_time},press_contact'
	  )
	);

	$response = $request->execute();
	$graphObject = $response->getGraphObject();
	handle the result */



</script>

<div class="jumbotron">
	<!--
    <h1>ASP.NET</h1>
    <p class="lead">ASP.NET is a free web framework for building great Web sites and Web applications using HTML, CSS and JavaScript.</p>
    <p><a href="http://asp.net" class="btn btn-primary btn-lg">Learn more &raquo;</a></p>

    <h1>ASP.NET + Facebook</h1>
    <p class="lead">ASP.NET is a free web framework for building great Web sites and Web applications using HTML, CSS and JavaScript.</p>
    <p><a href="@ViewBag.UrlFb" class="btn btn-primary btn-large">Login Facebook</a></p>
	-->
	
    <button onclick="javascript:eventos();">=D</button>
    <br/><br/><br/>

    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
    </fb:login-button>

    <div id="status">
    </div>






    <p id="demo"></p>
</div>


<!--
<div class="row">
    <div class="col-md-4">
        <h2>Getting started</h2>
        <p>
            ASP.NET MVC gives you a powerful, patterns-based way to build dynamic websites that
            enables a clean separation of concerns and gives you full control over markup
            for enjoyable, agile development.
        </p>
        <p><a class="btn btn-default" href="http://go.microsoft.com/fwlink/?LinkId=301865">Learn more &raquo;</a></p>
    </div>
    <div class="col-md-4">
        <h2>Get more libraries</h2>
        <p>NuGet is a free Visual Studio extension that makes it easy to add, remove, and update libraries and tools in Visual Studio projects.</p>
        <p><a class="btn btn-default" href="http://go.microsoft.com/fwlink/?LinkId=301866">Learn more &raquo;</a></p>
    </div>
    <div class="col-md-4">
        <h2>Web Hosting</h2>
        <p>You can easily find a web hosting company that offers the right mix of features and price for your applications.</p>
        <p><a class="btn btn-default" href="http://go.microsoft.com/fwlink/?LinkId=301867">Learn more &raquo;</a></p>
    </div>
</div>
-->



</body>
</html>