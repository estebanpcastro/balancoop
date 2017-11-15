/**
 * Función que realiza una petición ajax al servidor
 * y sirve  la vista con un resultado
 * 
 * @param  {string} url              URL del controlador donde se encuentra la petición
 * @param  {JSON}   datos            Array JSON con los datos que se recibirán por POST
 * @param  {string} tipo_respuesta   Respuesta que se enviará. Puede ser HTML o JSON
 * @return {string} respuesta        Datos en HTML o JSON
 */
function ajax(url, datos, tipo_respuesta, asincrono = false){
    //Variable de exito
    exito = "inicialización";

    // Esta es la petición ajax que llevará 
    // a la interfaz los datos pedidos
    $.ajax({
        url: url,
        data: datos,
        type: "POST",
        dataType: tipo_respuesta,
        async: asincrono,
        success: function(respuesta){
            //Si la respuesta no es error
            if(respuesta != "error"){
                //Se almacena la respuesta como variable de éxito
                exito = respuesta;
            } else {
                //La variable de éxito será un mensaje de error
                exito = 'error en la respuesta';
            } //If
        },//Success
        error: function(respuesta){
            //Variable de exito será mensaje de error de ajax
            exito = respuesta;
        }//Error
    });//Ajax

    //Se retorna la respuesta
    return exito;
}// ajax

function cargando(elemento){
    //Se resetea el elemento
    elemento.html('');

    //Se carga la imagen
    elemento.append('<div>Cargando, por favor espere. Esta operación puede tardar...</div>')
    elemento.append('<div><img src="http://localhost/balancoop/img/cargando.gif"/></div>')
    // elemento.append('<div><img src="<?php echo base_url()."img/cargando.gif"; ?>"/></div>')
}

/**
 * Pone un valor por defecto a un checkbox
 * @param  {string} elemento Nombre del check
 * @param  {string} valor    Valor del option
 */
function check_por_defecto(elemento, valor)
{
    // Si el valor es igual a 1
    if (valor == "1") { 
            $("#" + elemento).prop("checked", true);
        }else{
            $("#" + elemento).prop("checked", false);
        };
} // check_por_defecto

/**
 * Permite desplazarse hacia un elemento
 * 
 * @param  {element} elemento     [Elemento hacia el cuál se realizará el desplazamiento]
 * @param  {miliseconds} milisegundos [tiempo de desplazamiento]
 */
function desplazarse(elemento, milisegundos){
    //Se produce el desplazamiento mediante el método ScrollTo
    elemento.ScrollTo({
        duration: milisegundos,
        durationMode: 'all'
    });
}//Desplazarse

/**
 * [es_email description]
 * @param  {[type]} email [description]
 * @return {[type]}       [description]
 */
function es_email(email) {
    //Variable de email a verificar
    var sintaxis = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    
    //Retorno de respuesta
    return sintaxis.test(email);
}

function eliminar(elemento, elementoeliminado){
    //Se contrae o expande el elemento
    $("#" + elemento).slideUp('slow');
    //se verifica que la variable elementoeliminado traiga un valor
    if(elementoeliminado!=''){
        //Se cambia el estado a eliminado
        $("#" + elementoeliminado).val('false');
    }        
}

/**
 * Expande o contrae un contenedor con el fin de 
 * ahorrar espacio
 * 
 * @param  {DOM} elemento [description]
 * @return {[type]}          [description]
 */
function expandir_contraer(elemento){
    //Se contrae o expande el elemento
    $("#" + elemento + ">div").slideToggle('slow');
}

/**
 * Inicializa el calendario para cada campo que lo requiera
 */
/* 
function fecha(){
	//inicialización de los calendarios en toda la aplicación
	$("[id^='fecha_']").datepicker({
        autoclose: true,
        todayBtn: true,
        todayHighlight: true,
        startView: "decade"
    });
}//Fecha
*/

/**
 * Imprime en consola un mensaje
 * 
 * @param  {string} mensaje [Mensaje a imprimir]
 * @return {string}         [Mensaje impreso]
 */
function imprimir(mensaje){
	//Se imprime el mensaje
 	console.log(mensaje);
}//Imprimir

/**
 * [limpiar description]
 * @param  {[type]} formulario [description]
 * @return {[type]}            [description]
 */
function limpiar(formulario){
    //Limpia
    $(formulario)[0].reset();
}



/**
 * [mostrar_elemento description]
 * @param  {[type]} elemento [description]
 * @return {[type]}          [description]
 */
function mostrar_elemento(elemento){
    elemento.slideDown("slow");
}

/**
 * Muestra un mensaje
 * @return {[type]} [description]
 */
function mostrar_mensaje(titulo, mensaje){
    $('#titulo_mensaje').html(titulo);
    $('#cuerpo_mensaje').html(mensaje);

	$('#modal_mensaje').modal('show');

    //Comando para que la ventana aparezca sobre otras
    $("#modal_mensaje").css("z-index", "1500");
}//mostrar_mensaje

/**
 * [mostrar_elemento description]
 * @param  {[type]} elemento [description]
 * @return {[type]}          [description]
 */
function ocultar_elemento(elemento){
    elemento.slideUp("slow");
}

function redireccionar(url){
    //Se redirecciona
    location.href = url;
}

/**
 * Pone un valor por defecto a un select
 * @param  {string} elemento Nombre del select
 * @param  {string} valor    Valor del option
 */
function select_por_defecto(elemento, valor)
{
    // Se pone el valor por defecto al elemento seleccionado
    $('#' + elemento + ' option[value="' + valor + '"]').attr("selected", true);
} // select_por_defecto

/**
 * Valida que los campos que se le manden tengan información
 * 
 * @param  {[type]} campos [description]
 * @return {[type]}        [description]
 */
function validar_campos_vacios(campos){
    //Variable contadora
    validacion = 0;

    //Recorrido para validar cada campo
    for (var i = 0; i < campos.length; i++){
        //validacion campo a campo
        if($.trim(campos[i]) != "") {
            validacion++;
        }
    };

    //Si todos los campos superan la validación
    if (validacion == campos.length) {
        //Retorna ok
        return true;
    } else {
        //Retorna falso
        return false;
    }

    //Se resetea la variable contadora
    validacion = 0;
}//validar_campos_vacios

