 			</div>
          </div>
        </main>
<footer class="c-footer">
	<div>
		
	</div>
	<div class="ml-auto">
		
	</div>
</footer>

      </div> <!-- c-wrapper end -->
    </div> <!--  c-body end -->
    
<!-- CoreUI and necessary plugins-->
<script src="../../vendor/coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
<!--[if IE]><!-->
<script src="../../vendor/coreui/vendors/@coreui/icons/js/svgxuse.min.js"></script>
<!--<![endif]-->

<!--  below chunk to close the html -->

  </body>
</html>

<script>
var app = new Vue({
    el: '#vueapplogout',
        data: function(){
            return{
                show: true                
            }
        },
        mounted: function () {
        	//console.log('Hello from Micro API MVC!');
        	this.validateLogin(this.getCookie("micro_api_mvc_jwt"));
        },
        methods: {
        	validateLogin: function(cookie){
        		//console.log(cookie);
            	if(cookie == ""){
            		window.location.href="/login";
            	}
                axios.post('api/login/validate', {
                	action:'apivalidate',
                	cookie:cookie
                }).then(function(response){
                	console.log(response.data);
                	if(response.data == ""){
                		window.location.href="/login";
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