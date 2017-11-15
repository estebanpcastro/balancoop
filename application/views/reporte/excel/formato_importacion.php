<?php
//Inicializar variable PHP excel
$objPHPExcel = new PHPExcel();

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); //Escala

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

/*************************************************************************************
 * 
 *************************************************************************************/

// Se consultan las columnas
$resultado = mysql_query("SHOW FULL COLUMNS FROM {$tabla}");

// Número de columnas
$columnas_a_crear = mysql_num_rows($resultado); 

// Contador
$cont=1; 

// Columna inicial
$columna='A';
$total_columnas = mysql_num_rows($resultado);

// Recorrido de los campos y columnas
while ($fila = mysql_fetch_assoc($resultado)) {
	$objPHPExcel->getActiveSheet()->setCellValue("{$columna}1", $fila['Field']);
	$objPHPExcel->getActiveSheet()->setCellValue("{$columna}2", $fila['Comment']);
	$objPHPExcel->getActiveSheet()->setCellValue("{$columna}3", "Tipo ".$fila['Type']);

	// Definicion de la anchura de las columnas
	$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth(20);

	// Si aún hay más columnas
	if ($cont < $total_columnas) {
		// Aumentamos columna y contador
		$columna++;
		$cont++;
	}
} // while

// Aplicación de estilos
$objPHPExcel->getActiveSheet()->getStyle("A1:{$columna}1")->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle("A1:{$columna}3")->applyFromArray($bordes);

$objPHPExcel->getActiveSheet()->setTitle("Formato para importación");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Plantilla de importación tabla '.$tabla.'.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>