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
    <div class="container" id="vueapplogin">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <form method="POST" action="login/user">
              <div class="card-body">
                <h1>Login</h1> 
                <p class="text-muted">Sign In to your account</p>
                <div class="input-group mb-3">
                  <div class="input-group-prepend"><span class="input-group-text">
                      <svg class="c-icon">
                        <use xlink:href="../../vendor/coreui/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                      </svg></span></div>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" v-model="email" value="" required autocomplete="email" autofocus>

                        <span class="invalid-feedback" role="alert" v-if="email_error_show">
                            <strong>{{ email_error }}</strong>
                        </span>
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend"><span class="input-group-text">
                      <svg class="c-icon">
                        <use xlink:href="../../vendor/coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                      </svg></span></div>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" v-model="password" required autocomplete="current-password">

                        <span class="invalid-feedback" role="alert" v-if="password_error_show">
                            <strong>{{ password_error }}</strong>
                        </span>
                </div>
                <div class="row">
                  <div class="col-6">
                    <button type="submit" class="btn btn-primary">Login</button>
                  </div>
<!--                   <div class="col-6 text-right"> -->
<!--                     <a class="btn btn-link" href="{{ route('password.request') }}"> -->
<!--                         Forgot Your Password? -->
<!--                     </a> -->
<!--                   </div> -->
                </div>
              </div>
            </form>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                  <h2>Sign up</h2>
                  <p>Do not have an account? <br>Please signup!</p>
                  <a href="/register" class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</a>
                </div>
              </div>
            </div>
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
    el: '#vueapplogin',
        data:function(){
            return{
            	email_error_show: false,
            	password_error_show: false,
            	email: "",
                password: "",
                email_error: "",
                password_error: ""            
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
			}, 
			login: function(){
				// check login info
				if (this.email != '' && this.password != '') {
					this.email_error_show = false;
					this.password_error_show = false;
			    	axios.post('login/user', {
			    		request: "vuelogin",
			        	email: this.email,
			        	password: this.password
			    	})
			       .then(function(response) {
			       		//console.log(response.data);
			        	if (response.data.status === 200) {
// 		        			var d = new Date();
//                             d.setTime(d.getTime() + (60*60*1000));
//                             var expires = "expires="+ d.toUTCString(); console.log(expires);
//                             document.cookie = "micro_api_mvc_jwt" + "=" + response.data[0].token + ";" + expires + ";path=/";
                            window.location.href="/home";
			        	} 
				       	if (response.data.status === 403){
					       	//alert(response.data.message);
			        		if (response.data.flag === "email") {
			        			document.email_error = response.data.message;
			        			document.email_error_show = true;
			        		}
			        		if (response.data.flag === "password") {
			        			this.password_error = response.data.message;
			        			this.password_error_show = true;
			        		}
			        	}
			       })
			       .catch(function(error) {
			        	console.log(error);
			       });
			   	} else {
			   		if (this.email == ''){
			   			this.email_error_show = true;
			   			this.email_error = "Email is empty";
			   		}
			   		if (this.password == ''){
			   			this.password_error_show = true;
			   			this.password_error = "Password is empty";
			   		}
			   	}
			}
        }
})    

</script>