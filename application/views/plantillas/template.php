<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
    <head>
        <!--Se carga la cabecera-->
        <?php $this->load->view('plantillas/header'); ?>
    </head>
    <body>
        <div id="mensaje_alerta"></div>
        <!-- Este es el cuadro de alertas que se verá con cada acción realizada por la aplicación -->
        <div id="modal_mensaje" class="modal fade" style="z-index:300;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 id="titulo_mensaje" class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <p id="cuerpo_mensaje">&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div class="menu navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <!--Se carga el menú-->
                <?php $this->load->view('plantillas/menu'); ?>
            </div>
        </div>

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <!-- <div class="jumbotron">
        <div class="container">
        <h1>Hello, world!</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a class="btn btn-primary btn-lg">Learn more &raquo;</a></p>
        </div>
        </div> -->

        <div class="container">
            <!-- Example row of columns -->
            <div class="row">
                <!--Se carga el contenido principal-->
                <?php $this->load->view($contenido_principal); ?>
            </div>
            <hr>

            <footer>
                <p>&copy; Balancoop | 2017</p>
            </footer>
        </div> <!-- /container -->
    </body>
</html>