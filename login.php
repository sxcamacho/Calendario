<html xmlns="http://www.w3.org/1999/xhtml">
  
  <head>  
    <link rel="apple-touch-icon" sizes="72x72" href="touch-icon-ipad.png" /> 
    <link rel="apple-touch-icon" sizes="114x114" href="touch-icon-iphone4.png" />
    <link rel="icon" type="image/png" href="favicon.png" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="es" />
    <script type="text/javascript" src="jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="jquery.animate-shadow-min.js"></script>
    <script type='text/javascript' src='bootstrap/js/bootstrap.min.js'></script>
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.css' />
    <style>
	
		@media only screen and (max-width: 1024px) {
			body{
				background-image: url("images/estetica-ipad.jpg");
			}
		}
	  
	  body{
		
		background-image: url("images/estetica.jpg");
		background-color:#fff;
		background-size:100%;
	    background-repeat:no-repeat;
		background-attachment:fixed;
		background-position:center bottom; 
		
	  }
	
      #login img{
        width: 200px;
		
      }

      #login{
        width: 400px;
        height: 200px;
        margin: 0px auto;
        padding:20px;
        background-color: #eee;
        border-radius: 5px;
        border: 1px solir #000;
		box-shadow: 0px 0px 10px 2px #000; 
      }

      #divmensaje{
        width: 440px;
        margin: 50px auto 0px auto; 
      }
      
      .control-label{ color: #000; font-weight: normal; }
      
    </style>
    <script type="text/javascript" charset="utf-8">    
	
	  
	  
      $(document).ready(function(){
	  
		//$(".alert").alert('close');

        $("#btnEnviar").click(function(){
          login();
        });
        
        $("#inputEmail").keypress(function(e){
          submitenter($(this), e);
        });
        
        $("#inputPassword").keypress(function(e){
          submitenter($(this), e);
        });

      });
      
      function login(){

          $("#btnEnviar").attr('disabled', 'disabled');
          $("#btnEnviar").val('Espere...');
        
          var miusuario = $("#inputEmail").val();
          var miclave = $("#inputPassword").val();
        
          $.ajax({
            type : "POST",
            data : { accion : 'login', usuario : miusuario,  clave : miclave },
            url : "servicios.php",
            cache: false, // No queremos usar la caché del navegador
            success: function( respuesta){
              
              $("#btnEnviar").attr("disabled","");
              $("#btnEnviar").val('Ingresar');
              
              if(respuesta == "true"){
                $("#mensaje").html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Usuario y clave <strong>correctos</strong>");
                $("#mensaje").removeClass("alert-danger");
                $("#mensaje").addClass("alert-success");    

				$("#login").stop().animate({boxShadow: '0 0 20px #00d800'});
				
				setTimeout(function() {
				      $("#login").animate({boxShadow: '0 0 10px #000'});
					  $("#btnEnviar").val('Ingresar');
					  $("#btnEnviar").removeAttr("disabled");
					  
					  $(location).attr('href','index.php');
					  
				}, 1000);
				
                
              }
              else{
                
				$("#mensaje").html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Usuario o clave son <strong>incorrectos!</strong>");
                $("#mensaje").removeClass("alert-success");
                $("#mensaje").addClass("alert-danger");
				
				$("#login").stop().animate({boxShadow: '0 0 20px #ff0000'});
				
				setTimeout(function() {
				      $("#login").animate({boxShadow: '0 0 10px #000'});
					  $("#btnEnviar").val('Ingresar');
					  $("#btnEnviar").removeAttr("disabled");
				}, 1000);

				
              }
              
            }  
          });
        }
  
        function submitenter(myfield, e)
        {
          
          var keycode;

          if (e) keycode = e.keyCode;
          else if (e) keycode = e.which;
          else return true;

          if (keycode == 13)
          {
            login();
            return false;
          }
          else
             return true;
        }
    </script>
  </head>
    
  <body onload="document.getElementById('usuario').focus();">
  
      <center>
        <img src="header.png" />
      </center>
      
      <div id="content">
        
        <div id="divmensaje">  
          <div id="mensaje" name="mensaje" class="alert">
		  </div>
        </div>
        
        <div id="login">
          <!--
          <div  style="float:left">
            <img src="images/login.jpeg"/>
          </div>
          <div  style="float:right">
            <form id="formulario">    
              <label>Usuario</label>
              <input type="text" id="usuario" name="usuario" class="input_title_invoice span4" onKeyPress="return submitenter(this,event)"/>
              <label>Clave</label>
              <input type="password" id="clave" name="clave" class="input_title_invoice span4" onKeyPress="return submitenter(this,event)"/>
              <br>
              <input type="button" value="Entrar" id="enviar" name="enviar" class="btn" onClick="xajax_autenticar(xajax.getFormValues('formulario'));"/>
            </form>
          </div>
          -->      
          
          <form class="form-horizontal" role="form" id="formulario">
            <div class="form-group">
            <label for="inputEmail1" class="col-lg-2 control-label" style="text-align:left;">Usuario</label>
            <div class="col-lg-10" style="width:395px">
              <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="ingrese nombre de usuario"/>
            </div>
            </div>
            <div class="form-group">
            <label for="inputPassword1" class="col-lg-2 control-label" style="text-align:left;">Clave</label>
            <div class="col-lg-10" style="width:395px">
              <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="ingrese clave de usuario"/>
            </div>
            </div>
            <!--
            <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
              <div class="checkbox">
              <label>
                <input type="checkbox"> Recordarme
              </label>
              </div>
            </div>
            </div>
            -->
            <div class="form-group">
            <div class="col-lg-10" style="margin-top: 10px">
              <input type="button" class="btn btn-default" id="btnEnviar" name="btnEnviar" value="Ingresar"/>
            </div>
            </div>
          </form>

        </div>
        
        

        
        
        
        
        
      </div>          
    
  </body>
  
</html>
