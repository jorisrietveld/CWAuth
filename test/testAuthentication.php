<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 28-10-15 - 11:12
 */
require( "header.php" );
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <style>
body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
#result{
	width: 800px;
	margin: 0 auto;
}
</style>
</head>
HTML;
echo <<<HTML
<body>
    <h1 style="width: 100%; text-align:center;">Campuswerk Authentication test page</h1>

	<div class="container" style="background-color: #eee;; width: 400px; height: 300px; border-radius:20px;;">

	<form class="form-signin" id="loginForm">
		<h2 class="form-signin-heading"></h2>

		<label for="inputEmail" class="sr-only">username</label>
		<input type="text" id="username" class="form-control" placeholder="username" autofocus required>

		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="password" class="form-control" placeholder="password" required>

		<div class="checkbox">
		<label>
			<input id="remember" type="checkbox" value="remember-me"> Remember me
		</label>

		</div>

		<button class="btn btn-lg btn-primary btn-block" id="loginSubmit" type="submit">Sign in</button>

	</form>
	</div>
</body>
<div id="result"></div>
</html>
<script>
    	$( "#loginForm" ).submit(function( event ) {
		event.preventDefault();

		var dataObject = {
			username : $("#username").val(),
			password : $("#password").val(),
			remember : $("#remember").is(":checked")
		};

	    var posting = $.post( "processAuthentication.php", dataObject );
      	posting.done(function( data ) {
    		$( "#result" ).empty().append( data );
  		});
    });
    </script>

HTML;
