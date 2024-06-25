<?php
require_once 'fpdf/fpdf.php';
require_once 'classes/conexaoBanco.php';
$conexao = new Conexao("projeto_funag","localhost","root","");	

?>
<?php
$conexao->conectar();
$pessoasEEnderecos = $conexao->queryBd($conexao->getPdo());
$pdf = new FPDF();
$pdf->addPage();
$pdf->setFont('Arial','B', 16 );
$pdf->Cell(190,10,utf8_decode('Relatório de pessoas e endereços'),0,"C");
$pdf->Ln(15);

$contadorCadastros = 0;
$pdf->setFont('Arial','B', 12 );

foreach ($pessoasEEnderecos as $pessoa) {
	$pdf->setFont('Arial','B', 12 );
	$contadorCadastros++;
	$contador = 0;
	$pdf->Cell(50,7,utf8_decode($pessoa->getNomeCompleto()),0,"C");
	$pdf->Ln();
	foreach ($pessoa->getEnderecos() as $endereços) {
		$pdf->setFont('Arial','B', 10 );
		$contador++;
		if($contador > 1){
			$pdf->setFont('Arial','i', 10 );
		}
	$enderecoString = implode(",",$endereços);
	$pdf->Cell(180,7,utf8_decode($enderecoString),1,0);
	$pdf->Ln();
	}
	$pdf->Ln();
}
$pdf->setFont('Arial','B', 12 );
$pdf->Cell(180,7,utf8_decode("Quantidade de pessoas cadastradas  ".$contadorCadastros),1,0);
$pdf->Output();
?>
