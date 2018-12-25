<html>
 <head>
  <title>Bienvenido a Cinema</title>
  {{ stylesheet_link('css/bootstrap.min.css') }}
  {{ javascript_include('js/bootstrap.min.js') }}
 </head>
 <body>
 <nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation" >
     <!-- Brand and toggle get grouped for better mobile display -->
     <div class="container-fluid">
         <div class="navbar-header">
             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                 <span class="sr-only">Toggle navigation</span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
             </button>
	     <h1>Bienvenido a Cinema</h1>
    	     <p>Cinema te permite llevar un registro de tus peliculas, los actores y directores asociados a estasy mucho mas!</p>
             <ul class="nav navbar-nav">
                 <li><a href="{{ url('peliculas') }}">Peliculas</a></li>
		 <li><a href="{{ url('actores') }}">Actores</a></li>
		 <li><a href="{{ url('directores') }}">Directores</a></li>
		 <li><a href="{{ url('generos') }}">Generos</a></li>
		 <li><a href="{{ url('idiomas') }}">Idiomas</a></li>
		 <li><a href="{{ url('nationality') }}">Nacionalidad</a></li>
             </ul>
         </div>
         <!-- Collect the nav links, forms, and other content for toggling -->
         <div class="collapse navbar-collapse" id="navbarCollapse">
             
         </div>
     </div>
 </nav>
  {% block content %}
  {% endblock %}

    <hr>
    <div class="row">
        <div class="col-xs-12">
            <footer>
                <p>&copy; Cinema te permite llevar un registro de tus peliculas, los actores y directores asociados a estasy mucho mas! </p>
            </footer>
        </div>
    </div>
</div>
 </body>
</html>
 
<span style="font-family: Times New Roman;"><span style="white-space: normal;">
</span></span>
