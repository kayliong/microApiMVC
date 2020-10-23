<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.2.0
* @link https://coreui.io
* Copyright (c) 2020 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Login</title>
    <link rel="apple-touch-icon" sizes="57x57" href="../../vendor/coreui/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../../vendor/coreui/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../../vendor/coreui/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../../vendor/coreui/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../../vendor/coreui/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../../vendor/coreui/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../../vendor/coreui/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../../vendor/coreui/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../../vendor/coreui/assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../../vendor/coreui/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../vendor/coreui/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../../vendor/coreui/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../vendor/coreui/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Main styles for this application-->
    <link href="../../vendor/coreui/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  </head>
  <body class="c-app flex-row align-items-center">
    <div class="container" id="vueappregister">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card mx-4">
          <form method="POST" action="register/user">
            <div class="card-body p-4">
              <h1>Register</h1>
              <p class="text-muted">Create your account</p>
              <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text"> Given name &nbsp;
                    <svg class="c-icon">
                      <use xlink:href="../../vendor/coreui/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                    </svg></span></div>
                <input id="given_name" type="text" class="form-control" name="given_name" value="" required autocomplete="name" autofocus>

                                    <span class="invalid-feedback" role="alert" v-if="name_error_show">
                                        <strong>{{ $message }}</strong>
                                    </span>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text"> Surname &nbsp;
                    <svg class="c-icon">
                      <use xlink:href="../../vendor/coreui/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                    </svg></span></div>
                <input id="surname" type="text" class="form-control" name="surname" value="" required autocomplete="name" autofocus>

                                    <span class="invalid-feedback" role="alert" v-if="name_error_show">
                                        <strong>{{ $message }}</strong>
                                    </span>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text"> email &nbsp;
                    <svg class="c-icon">
                      <use xlink:href="../../vendor/coreui/vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                    </svg></span></div>
                <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email">

                                    <span class="invalid-feedback" role="alert" v-if="email_error_show">
                                        <strong>{{ $message }}</strong>
                                    </span>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text"> Password &nbsp;
                    <svg class="c-icon">
                      <use xlink:href="../../vendor/coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                    </svg></span></div>
                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">

                                    <span class="invalid-feedback" role="alert" v-if="password_error_show">
                                        <strong>{{ $message }}</strong>
                                    </span>
              </div>
              <div class="input-group mb-4">
                <div class="input-group-prepend"><span class="input-group-text"> Confirm Password &nbsp;
                    <svg class="c-icon">
                      <use xlink:href="../../vendor/coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                    </svg></span></div>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
              </div>
              <button class="btn btn-block btn-success" type="submit">Create Account</button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="../../vendor/coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <!--[if IE]><!-->
    <script src="../../vendor/coreui/vendors/@coreui/icons/js/svgxuse.min.js"></script>
    <!--<![endif]-->

  </body>
</html>

<script>
var app = new Vue({
    el: '#vueappregister',
        data:function(){
            return{
                name_error_show: false,
            	email_error_show: false,
            	password_error_show: false,
            }
        },
        mounted: function () {
        	if(this.getCookie("micro_api_mvc_jwt") != ""){
        		this.validateLogin(this.getCookie("micro_api_mvc_jwt"));
        	}
        },
        methods: {
        	validateLogin: function(cookie){
            	if(cookie == ""){
            		window.location.href="/login";
            	}
                axios.post('api/login/validate', {
                	action:'apivalidate',
                	cookie:cookie
                }).then(function(response){
                	console.log(response.data);
                	if(response.data == 1){
                		window.location.href="/home";
                	}
                })
                .catch(function (error) {
                    console.log(error);
                });
			}, 
			getCookie: function(cname) {
				var name = cname + "=";
				var decodedCookie = decodeURIComponent(document.cookie);
				var ca = decodedCookie.split(';');
				for(var i = 0; i <ca.length; i++) {
					var c = ca[i];
				    while (c.charAt(0) == ' ') {
				      c = c.substring(1);
				    }
				    if (c.indexOf(name) == 0) {
				      return c.substring(name.length, c.length);
				    }
				}
				return "";
			} 
        }
})    
</script>