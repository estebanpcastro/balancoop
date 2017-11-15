<?php
// Ids
$id_empresa = 3;
$id_oficina = 0;
$identificacion = 36303702;
$anio = 2016;

// Se declaran las variables en cero
$compras_anio_seleccionado = 0;
$compras_anio_actual = 0;
$compras_ultimos_meses = 0;

//Datos
$datos_asociado = $this->transferencia_model->buscar_asociado($identificacion, $id_empresa);
$datos_generales = array("anio" => $anio, "id_oficina" => $id_oficina, "id_empresa" => $id_empresa, "identificacion" => $identificacion);

//
$anio_actual = $this->transferencia_model->compras_anio_actual($id_empresa, $datos_generales);
if (isset($anio_actual->Total_Compras)) {
	$compras_anio_actual = $anio_actual->Total_Compras;
}

//
$anio_seleccionado = $this->transferencia_model->compras_anio_seleccionado($id_empresa, $datos_generales);
if (isset($anio_seleccionado->Total_Compras) == 1) {
	$compras_anio_seleccionado = $anio_seleccionado->Total_Compras;
}

//
$ultimos_meses = $this->transferencia_model->compras_ultimos_meses($id_empresa, $datos_generales);
if (isset($ultimos_meses->Total_Compras) == 1) {
	$compras_ultimos_meses = $ultimos_meses->Total_Compras;
}

//Transferencias por mes
$transferencias = $this->transferencia_model->transferencias_mensuales($id_empresa, $datos_generales);

// Variables globales
$GLOBALS['id_empresa'] = $this->session->userdata('id_empresa');
$GLOBALS['datos_asociado'] = $datos_asociado;

class PDF extends FPDF{
	// Cabecera de página
	function Header()
	{
		// Logo
		$logo = './img/logos/'.$GLOBALS['id_empresa'].'.png';
	    if (file_exists($logo)) {
		    $this->Image($logo,5,5,NULL, 15);
	    }

	    // Logo Balancoop
		$logo_balancoop = './img/logo.png';
	    if (file_exists($logo_balancoop)) {
		    $this->Image($logo_balancoop,170,7,NULL, 10);
	    }

	    // Título
	    $this->setX(50);
	    $this->SetFont('Arial','B',9);
	    $this->Cell(120,5, utf8_decode("Transferencia solidaria de {$GLOBALS['datos_asociado']->Nombre} {$GLOBALS['datos_asociado']->PrimerApellido} {$GLOBALS['datos_asociado']->SegundoApellido}"),0,0,'C');
	
		$this->Ln(15);
	} // Cabecera

	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-10);

		// Arial italic 8
		$this->SetFont('Helvetica','',8);

		// Número de página
		$this->Cell(0,10, utf8_decode('Balancoop - página '.$this->PageNo().' de {nb}'),0,0,'C');
	}
} // PDF

// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');

//Alias para el numero de paginas(numeracion)
$pdf->AliasNbPages();

//Anadir pagina
$pdf->AddPage();

$pdf->SetX(5);

// Mensaje de inicio
$pdf->SetFont('Helvetica','',9);
$pdf->MultiCell(200,5, utf8_decode("Utiliza nuestros servicios y recibe una mayor transferencia solidaria. Somos una Cooperativa con alto beneficio social. Accede a los siguientes enlaces y conoce todo lo que podemos hacer por tí."), 0, 'C', 0);

$pdf->Ln(5);

// Cuadro inicial
$pdf->SetFont('Helvetica','B',9);
$pdf->MultiCell(65,12, utf8_decode("Categorías"), 1, 'C', 0);
$pdf->setXY(75,$pdf->getY()-12);
$pdf->MultiCell(30,12, utf8_decode("Líneas"), 1, 'C', 0);
$pdf->setXY(105,$pdf->getY()-12);
$pdf->MultiCell(20,12, utf8_decode("Asociados"), 1, 'C', 0);
$pdf->SetFont('Helvetica','B',7);
$pdf->setXY(125,$pdf->getY()-12);
$pdf->MultiCell(20,4, utf8_decode("Transferencia como cooperativa"), 1, 'C', 0);
$pdf->setXY(145,$pdf->getY()-12);
$pdf->MultiCell(20,3, utf8_decode("Promedio de transferencia como cooperativa"), 1, 'C', 0);
$pdf->setXY(165,$pdf->getY()-12);
$pdf->MultiCell(20,6, utf8_decode("Su transferencia"), 1, 'C', 0);
$pdf->setXY(185,$pdf->getY()-12);
$pdf->MultiCell(20,3, utf8_decode("Su transferencia comparada con promedio"), 1, 'C', 0);

$transferencia_acumulada = 0	;
$promedio_acumulado = 0	;
$total_promedio_transferencia_asociado = 0	;
$acumulado_transferencia_asociado = 0	;
$acumulado_comparacion = 0	;

// Se recorren las categorías
foreach ($this->listas_model->cargar_productos_categorias($id_empresa) as $categoria) {
	// Cantidad de asociados
	$asociados = $this->transferencia_model->asociados_por_categoria($id_empresa, $id_oficina, $anio, $categoria->intCodigo);

	// Transferencia total
	$transferencia_total = $this->transferencia_model->transferencia_por_categoria($id_empresa, $id_oficina, $anio, $categoria->intCodigo);
	$transferencia_acumulada += $transferencia_total;

	// Promedio de transferencia
	if ($asociados > 0) {
		$promedio_transferencia = $transferencia_total / $asociados;
	} else {
		$promedio_transferencia = 0;
	}

	$promedio_acumulado += $promedio_transferencia;

	// Transferencia asociado
	$transferencia_asociado = $this->transferencia_model->transferencia_por_asociado($id_empresa, $id_oficina, $anio, $categoria->intCodigo, $identificacion);
	$acumulado_transferencia_asociado += $transferencia_asociado;

	// Diferencia en transferencia
	$comparacion_transferencia = $transferencia_asociado - $promedio_transferencia;
	
	// COndición para poner los valores negativos en cero
	$valor_comparacion = ($comparacion_transferencia < 0) ? 0 : $comparacion_transferencia ;
	$valor_comparacion_acumulado = (!$acumulado_comparacion) ? 0 : $acumulado_comparacion ;

	$acumulado_comparacion = $acumulado_comparacion + $valor_comparacion;
	
	// // Color de la comparación
	// $color_comparacion = ($comparacion_transferencia < 0) ? "text-danger" : "" ;
	
	$pdf->SetFont('Helvetica','',6);
	$pdf->Cell(65,6, utf8_decode(substr($categoria->strNombre, 0, 55)), 1, 0, 'L', 0);
	$pdf->Cell(30,6, utf8_decode(''), 1, 0, 'C', 0);
	$pdf->Cell(20,6, number_format($asociados, 0, '', '.'), 1, 0, 'R', 0);
	$pdf->Cell(20,6, "$ ".number_format($transferencia_total, 0, '', '.'), 1, 0, 'R', 0);
	$pdf->Cell(20,6, "$ ".number_format($promedio_transferencia, 0, '', '.'), 1, 0, 'R', 0);
	$pdf->Cell(20,6, "$ ".number_format($transferencia_asociado, 0, '', '.'), 1, 0, 'R', 0);
	$pdf->Cell(20,6, "$".number_format($valor_comparacion, 0, '', '.'), 1, 1, 'R', 0);
} // foreach

$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(65,6, "", 0, 0, 'L', 0);
$pdf->Cell(30,6, "", 0, 0, 'R', 0);
$pdf->Cell(20,6, "Totales", 0, 0, 'R', 0);
$pdf->Cell(20,6, "$ ".number_format($transferencia_acumulada, 0, "", "."), 0, 0, 'R', 0);
$pdf->Cell(20,6, "$ ".number_format($promedio_acumulado, 0, "", "."), 0, 0, 'R', 0);
$pdf->Cell(20,6, "$ ".number_format($acumulado_transferencia_asociado, 0, "", "."), 0, 0, 'R', 0);
$pdf->Cell(20,6, "$ ".number_format($valor_comparacion_acumulado, 0, "", "."), 0, 1, 'R', 0);

$pdf->Ln(5);

// Mensaje de inicio
$pdf->SetFont('Helvetica','',8);
$pdf->MultiCell(195,5, utf8_decode("El resultado de la comparación de su transferencia solidaria en promedio que entregó nuestra entidad por asociado, debe dar un valor negativo o un valor positivo. Si su transferencia es positiva, eso indica que usted está utilizando nuestros servicios adecuadamente y como resultado nuestra entidad le está realizando mayor transferencia solidaria. Esto como resultado monetario en diferencia de tasas de mercado de productos de captación o colocación o la participación activa de las actividades sociales que realiza nuestra entidad. Si el resultado es negativo, es consecuencia de su baja utilización de nuestros servicios o de asistencia a nuestras actividades sociales."), 0, 'J', 0);

$pdf->Ln(5);

// Valores resumen
$pdf->SetFont('Helvetica','B',8);
$pdf->Cell(45,6, utf8_decode("Transferencia en el año {$datos_generales['anio']}"), 0, 0, 'L', 0);
$pdf->Cell(4,6, "", 0, 0, 'C', 0);
$pdf->Cell(45,6, utf8_decode("Transferencia este año ".date('Y')), 0, 0, 'C', 0);
$pdf->Cell(4,6, "", 0, 0, 'C', 0);
$pdf->Cell(45,6, utf8_decode("Últimos 3 meses"), 0, 0, 'C', 0);
$pdf->Cell(5,6, "", 0, 0, 'C', 0);
$pdf->Cell(45,6, utf8_decode("Transferencia acumulada"), 0, 1, 'C', 0);

$pdf->SetFont('Helvetica','',7);
$pdf->Cell(45,6, "$".number_format($compras_anio_seleccionado, 0, '', '.'), 1, 0, 'R', 0);
$pdf->Cell(4,6, "", 0, 0, 'C', 0);
$pdf->Cell(45,6, "$".number_format($compras_anio_actual, 0, '', '.'), 1, 0, 'R', 0);
$pdf->Cell(4,6, "", 0, 0, 'C', 0);
$pdf->Cell(45,6, "$".number_format($compras_ultimos_meses, 0, '', '.'), 1, 0, 'R', 0);
$pdf->Cell(5,6, "", 0, 0, 'C', 0);
$pdf->Cell(45,6, "$".number_format($this->transferencia_model->total_transferencias($id_empresa, $datos_generales['identificacion']), 0, '', '.'), 1, 1, 'R', 0);

$pdf->Ln(5);

/**
 * Detalle
 */
$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(31,6, utf8_decode("Oficina"), 1, 0, 'C', 0);
$pdf->Cell(10,6, utf8_decode("Mes"), 1, 0, 'C', 0);
$pdf->Cell(70,6, utf8_decode("Producto"), 1, 0, 'C', 0);
$pdf->Cell(12,6, utf8_decode("Línea"), 1, 0, 'C', 0);
$pdf->Cell(20,6, utf8_decode("Cantidad"), 1, 0, 'C', 0);
$pdf->Cell(25,6, utf8_decode("Movimiento"), 1, 0, 'C', 0);
$pdf->Cell(25,6, utf8_decode("Transferencia"), 1, 1, 'C', 0);

$total_compras = 0;
$total_transferencias = 0;


// Recorrido de las transferencias
foreach ($transferencias as $transferencia) {
	$pdf->SetFont('Helvetica','',6);
	$pdf->Cell(31,6, utf8_decode($this->listas_model->obtener_nombre_oficina($transferencia->id_agencia)), 1, 0, 'L', 0);
	$pdf->Cell(10,6, utf8_decode($transferencia->Mes), 1, 0, 'R', 0);
	$pdf->Cell(70,6, utf8_decode($transferencia->Producto), 1, 0, 'L', 0);
	$pdf->Cell(12,6, utf8_decode($transferencia->Linea), 1, 0, 'L', 0);
	$pdf->Cell(20,6, utf8_decode($transferencia->Cantidad), 1, 0, 'R', 0);
	$pdf->Cell(25,6, "$".number_format($transferencia->Compras, 0, '', '.'), 1, 0, 'R', 0);
	$pdf->Cell(25,6, "$".number_format($transferencia->Transferencias, 0, '', '.'), 1, 1, 'R', 0);

	$total_compras += $transferencia->Compras;
	$total_transferencias += $transferencia->Transferencias;
} // foreach transferencias

// Totales
$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(143,6, utf8_decode("Total año $anio"), 0, 0, 'R', 0);
$pdf->Cell(25,6, "$".number_format($total_compras, 0, '', '.'), 0, 0, 'R', 0);
$pdf->Cell(25,6, "$".number_format($total_transferencias, 0, '', '.'), 0, 1, 'R', 0);

$pdf->Output("Transferencia solidaria $anio.pdf","I");
?>