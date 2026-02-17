<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerador de Assinaturas</title>
    <link rel='stylesheet' type='text/css' href='css/estilo.css'>
</head>
<?php
	$NomeFun = isset($_POST["iptNome"]) ? $_POST["iptNome"] : "";
	$SetorFun = isset($_POST["iptDepto"]) ? $_POST["iptDepto"] : "";
	$UnidadeFun = isset($_POST["iptUND"]) ? $_POST["iptUND"] : "";
	$Telefone = isset($_POST["iptTelefone"]) ? $_POST["iptTelefone"] : "";
	$Ramal = isset($_POST["iptRamal"]) ? $_POST["iptRamal"] : "";
	$Celular = isset($_POST["iptcelular"]) ? $_POST["iptcelular"] : "";
	$Email = isset($_POST["iptEMail"]) ? $_POST["iptEMail"] : "";
	
	////////// ABRE CONEXÃO BANCO DE DADOS //////////
	$con = @mysqli_connect('localhost', 'shi', '', 'tb_ramais');
	if (!$con) {
		echo "Error: " . mysqli_connect_error();
		exit();
	}
	mysqli_set_charset($con,'utf8');
	
	$setor_sql = "SELECT * FROM setor_sala WHERE ID_SETOR = ".$SetorFun;
	$unidade_sql = "SELECT * FROM unidades WHERE ID_UNIDADE = ".$UnidadeFun;
	
	
	$resultsetor = mysqli_query($con,$setor_sql);
	$resultunidade = mysqli_query($con,$unidade_sql); 
	$setor_select = mysqli_fetch_array($resultsetor);
	$unidade_select = mysqli_fetch_array($resultunidade);
	
echo "<body>";
	echo("<h1>Use a Ferramenta de Captura para copia e depois colar.</h1><br>");
	echo("C&oacute;digo: ET0".$unidade_select["ETIQUETA"]);
	if ($unidade_select["ETIQUETA"]==1){
		include "gera_BCI.php";}
		elseif($unidade_select["ETIQUETA"]==2){
			include "gera_SHI.php";}
			elseif($unidade_select["ETIQUETA"]==3){
			include "gera_SHI2021.php";}

		
echo("<br>");
echo("<input type='button' value='Voltar' onClick='history.go(-1)' aling='center'>");
echo "</body></html>";