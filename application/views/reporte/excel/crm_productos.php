<?php
//Inicializar variable PHP excel
$objPHPExcel = new PHPExcel();

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(7); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); //Escala

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Balancoop - Generado el "./*$this->auditoria_model->formato_fecha(date('Y-m-d')).*/"-".date('h:i A'))
	->setSubject("johnarleycano@hotmail.com")
	->setDescription("Reporte de productos CRM por asociado")
	->setKeywords("reporte informe productos asociado crm balancoop")
    ->setCategory("Reporte");

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(2);

//Se establecen las margenes
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0,90); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0,70); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0,70); //Izquierda
// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0,500); //Abajo

//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered();

/**
 * Estilos
 */
//Estilo de los titulos
$titulo_centrado_negrita = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

$titulo_centrado = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

$titulo_derecho = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
	)
);

//Estilo de los bordes
$bordes = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'argb' => '000000'
            )
        ),
    ),
);

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(9);

/**
 * Definición de altura de las filas
 */
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(15);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:P1');

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ASOCIADOS QUE HAN COMPRADO '.$producto);
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'No.');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Cédula');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Nombres');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Apellidos');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Celular');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Email');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Teléfono fijo');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Teléfono celular');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Agencia');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Línea');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Categoría');
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Valor');
$objPHPExcel->getActiveSheet()->setCellValue('M2', 'Transferencia');
$objPHPExcel->getActiveSheet()->setCellValue('N2', 'Año');
$objPHPExcel->getActiveSheet()->setCellValue('O2', 'Mes');
$objPHPExcel->getActiveSheet()->setCellValue('P2', 'Género');

//Fila para iniciar el contenido
$fila = 3;

//Contador
$cont = 1;

//Recorrido de los asociados
foreach ($asociados as $asociado) {
	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", $cont);
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $asociado->id_cliente);
	$objPHPExcel->getActiveSheet()->setCellValue("C{$fila}", $asociado->Nombre);
	$objPHPExcel->getActiveSheet()->setCellValue("D{$fila}", $asociado->PrimerApellido." ".$asociado->SegundoApellido);
	$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", $asociado->Celular_cliente);
	$objPHPExcel->getActiveSheet()->setCellValue("F{$fila}", $asociado->CorreoElectronico);
	$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", $asociado->TelefonoCasa);
	$objPHPExcel->getActiveSheet()->setCellValue("H{$fila}", $asociado->TelefonoOficina);
	$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", $asociado->Oficina);
	$objPHPExcel->getActiveSheet()->setCellValue("J{$fila}", $asociado->Linea);
	$objPHPExcel->getActiveSheet()->setCellValue("K{$fila}", $asociado->Categoria);
	$objPHPExcel->getActiveSheet()->setCellValue("L{$fila}", $asociado->valor);
	$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", $asociado->transferencia);
	$objPHPExcel->getActiveSheet()->setCellValue("N{$fila}", $asociado->ano);
	$objPHPExcel->getActiveSheet()->setCellValue("O{$fila}", $asociado->mes);

	//Aumentamos la fila y contador
	$fila++;
	$cont++;
}// foreach

// Disminuimos una fila
$fila--;

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1:P2')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('A1:P'.$fila)->applyFromArray($bordes);

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

//Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Asociados");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.count($asociados).'.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>