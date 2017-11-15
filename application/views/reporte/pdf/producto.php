<?php
class PDF extends FPDF{
	// Cabecera de página
	function Header(){
	    // Logo
	    // $this->Image('img/logos/1.png',10,8,33);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    // Movernos a la derecha
	    $this->Cell(80);
	    // Título
	    // $this->Cell(30,10,'Title',1,0,'C');
	    // Salto de línea
	    $this->Ln(20);
	}

	// Pie de página
	function Footer(){
		// Posición: a 1,5 cm del final
		$this->SetY(-10);

		// Arial italic 8
		$this->SetFont('Helvetica','',8);

		// Número de página
		$this->Cell(0,10,utf8_decode('Balancoop - página '.$this->PageNo().' de {nb}'),0,0,'C');
	}
}

// Se consulta los datos a imprimir
$producto = $this->reporte_model->cargar_productos_mes($this->uri->segment('3'));

// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');

//Se definen las margenes
$pdf->SetMargins(5, 5, 5);

//Anadir pagina
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Helvetica','B', '14');
$pdf->MultiCell(200, 10, utf8_decode($producto->strNombre), 1, 'C', false);

$pdf->SetFont('Helvetica','', '13');
$pdf->MultiCell(200, 10, utf8_decode("Nombre: ".$producto->Nombre." ".$producto->PrimerApellido." ".$producto->SegundoApellido), 0, 'L', false);
$pdf->MultiCell(200, 10, utf8_decode("Cédula: ".$producto->id_cliente), 0, 'L', false);
$pdf->MultiCell(200, 10, utf8_decode("Teléfono: ".$producto->TelefonoCasa), 0, 'L', false);
$pdf->MultiCell(200, 10, utf8_decode("Código: ".$producto->intCodigo), 0, 'L', false);
$pdf->MultiCell(200, 10, utf8_decode('_______________________________________________________________'), 0, 'C', false);
$pdf->MultiCell(200, 10, utf8_decode("Valor a pagar: $".number_format($producto->valor, 0, '', '.')), 0, 'L', false);
$pdf->MultiCell(200, 10, utf8_decode("Transferencia: $".number_format($producto->transferencia, 0, '', '.')), 0, 'L', false);
$pdf->MultiCell(200, 10, utf8_decode('_______________________________________________________________'), 0, 'C', false);
$pdf->MultiCell(200, 10, utf8_decode("Nombre del asistente: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _"), 0, 'L', false);
$pdf->MultiCell(200, 10, utf8_decode("Cédula o número de identificación: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _  de  _ __ _ _ _ _ _ _ _  _ _ _ _ _"), 0, 'L', false);
$pdf->MultiCell(200, 10, utf8_decode('_______________________________________________________________'), 0, 'C', false);
$pdf->MultiCell(200, 10, utf8_decode("Número de veces en el mismo mes con el producto: ".number_format($producto->Veces, 0, '', '.')), 0, 'L', false);

// Se imprime el reporte
$pdf->Output('producto.pdf', 'I');
?>