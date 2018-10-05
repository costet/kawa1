<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	{{HTML::style("bootstrap/dist/css/bootstrap.min.css", array("type" => "text/css"))}}
	{{HTML::style("bootstrap/dist/css/sweetalert.css", array("type" => "text/css"))}}
	<style type="text/css">
		html 
		{
	        height:100%;
	        width:100%;
	    }
	    body{
        	background:#8ba987 url({{ URL::asset('img/fondo.jpg')  }}) no-repeat center center;
	        background-size:100% 100%;
    	}
    	html,
body {
  height: 100%;
}

body {
  display: -ms-flexbox;
  display: -webkit-box;
  display: flex;
  -ms-flex-align: center;
  -ms-flex-pack: center;
  -webkit-box-align: center;
  align-items: center;
  -webkit-box-pack: center;
  justify-content: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
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
.card{
                    background-color: rgba(000,000,000,0.8);
                    /*opacity: rgba (000,000,000, .5);*/
                }
	</style>
</head>
<body class="text-center">
	{{-- <body class="text-center"> --}}
    <div class="container">
        <div class="row">
            <div class="offset-md-4 col-md-5 col-sm-5">
                <div class="card">
                    <div class="card-body">
                         <form class="form-signin" action="{{ URL::asset('iniciosesion') }}" method="post">
                            <h1 class="h3 mb-3 font-weight-normal" style="color: #fff">Inicio de sesión</h1>
                            <label for="" class="sr-only">Usuario</label>
                            <input type="text" id="" class="form-control" placeholder="Ingrese el Usuario" name='user' required autofocus>

                            <label for="" class="sr-only">Contraseña</label>
                            <input type="password" id="" class="form-control" placeholder="Contraseña" name="pass" required>

                            <button type="submit" class="btn btn-danger btn-block">Iniciar Sesión</button>
                        </form>
                        @if (Session::get('mensaje'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('mensaje') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
   
</body>
</html>
