<html>
 <head>
  <title>Bienvenido a Cinema</title>
  <?= $this->tag->stylesheetLink('css/bootstrap.min.css') ?>
  <?= $this->tag->javascriptInclude('js/bootstrap.min.js') ?>
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
                 <li><a href="<?= $this->url->get('peliculas') ?>">Peliculas</a></li>
		 <li><a href="<?= $this->url->get('actores') ?>">Actores</a></li>
		 <li><a href="<?= $this->url->get('directores') ?>">Directores</a></li>
		 <li><a href="<?= $this->url->get('generos') ?>">Generos</a></li>
		 <li><a href="<?= $this->url->get('idiomas') ?>">Idiomas</a></li>
		 <li><a href="<?= $this->url->get('nationality') ?>">Nacionalidad</a></li>
             </ul>
         </div>
         <!-- Collect the nav links, forms, and other content for toggling -->
         <div class="collapse navbar-collapse" id="navbarCollapse">
             
         </div>
     </div>
 </nav>
  
  

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
