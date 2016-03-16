<!-- Static navbar -->
<nav class="navbar navbar-default navbar-static-top">
  <div class="container_header">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">
        <span class="logo_text"><b>COMUNICACI&OacuteN INTERNA</b> 2016</span>
      </a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li <?php echo ($sectionId == 1)? 'class="active_section"': '' ; ?>>
          <a href="index.php?s=1">LO M&AacuteS NUEVO</a>
        </li>
        <li <?php echo ($sectionId == 2)? 'class="active_section"': '' ; ?>>
          <a href="index.php?s=2"><span>LO M&AacuteS DESTACADO</span></a>
        </li>
        <li <?php echo ($sectionId == 3)? 'class="active_section"': '' ; ?>>
          <a href="index.php?s=3"><span>CALENDARIO DE CIERRE DE MES</span></a>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div><!-- termina container -->
</nav>
<!-- Static nav header FIN -->

<div class="container">

  <div class="sub_header_noticia">
    <div class="title_secccion">
      <?php echo getNameSection($sectionId);  ?>
    </div>
    <div class="buscador_noticias">
    	<form class="navbar-form navbar-right" action="search.php?s=0" method="GET">
    	<button type="submit" class="btn btn-default buscador_btn"></button>
        <div class="form-group">
          <input type="text" name="q" placeholder="" class="form-control  buscador_text">
        </div>
      </form>
    </div>
  </div>
