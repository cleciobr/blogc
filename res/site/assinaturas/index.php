<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="iso-8859-2">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Gerador de Assinaturas</title>

    <!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
    <link href="css/jasny-bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- Custom CSS -->
    <style>
       
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    
    .glyphicon {
    	margin-right: 5px;
    }    

    </style>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>	
	<script src="js/jasny-bootstrap.min.js"></script>
    <script src="js/jqBootstrapValidation.js"></script>	
    <script src="js/bootstrap-datepicker.js'"></script>	

</head>

<body>
	
<?php
////////// ABRE CONEXÃO BANCO DE DADOS //////////
$con = @mysqli_connect('localhost', 'shi', '', 'tb_ramais');
if (!$con) {
    echo "Error: " . mysqli_connect_error();
	exit();
}
mysqli_set_charset($con,'utf8');
	
	$listasetor_sql = "SELECT * FROM tb_departaments ORDER BY NOME";
	$listaunidade_sql = "SELECT * FROM unidades ORDER BY NOME_UNIDADE";
	
	$resultsetor 	= mysqli_query($con, $listasetor_sql);
	$resultunidade 	= mysqli_query($con, $listaunidade_sql);
	
?>

    <!-- Page Content -->
    <div  style="margin:auto;width:50%;border:0px;padding:10px;">
	<form role="form" id="frmAssinatura" action="gera_assinatura.php" method="POST">
		<div >
			<table border="0" cellspacing="1">
				<tr>
				<td>&nbsp;&nbsp;<img src='http://glpi/pics/login_logo_glpi.png'/></td>
				<td><h4 color='#FFFFFF' valing='bottom'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gerador de Assinaturas</h4></td>
				</tr>
				<tr>
				<td colspan="2"><p>&nbsp;&nbsp;</td>
				</tr>
				<tr>
				<td colspan="2"><p>&nbsp;&nbsp;&nbsp;&nbsp;Favor preencher os dados abaixo para prosseguir.</p></td>
				</tr>
				<tr>
				<td colspan="2"><p>&nbsp;&nbsp;</td>
				</tr>
				<tr>
				<td colspan="2">Nome e sobrenome:<input type="text" class="form-control" size="60" name="iptNome" ID="iptNome" required></td>
				</tr>
				<tr>
				<td colspan="2">Setor:
					<select class="form-control" name="iptDepto" ID="iptDepto" required>
						<?php while($setores = mysqli_fetch_array($resultsetor)) {
									echo("<OPTION value=".$setores["ID_departament"].">".$setores["NOME"]."</OPTION>");
						}?>
					</select>
				</td>
				</tr>
				<td colspan="2">Unidade:					<select class="form-control" name="iptUND" ID="iptUND" required>
						<?php while($unidades = mysqli_fetch_array($resultunidade)) {
							echo("<OPTION value=".$unidades["ID_UNIDADE"].">".$unidades["NOME"]."</OPTION>");
						}?>
						</select>
				</td>
				</tr>
				<tr>
				<td colspan="2">Telefone:<input type="text" class="form-control" size="60" name="iptTelefone" ID="iptTelefone" data-mask="(99) 9999-9999"></td>
				</tr>
				<tr>
				<td colspan="2">Ramal:<input type="text" class="form-control" size="10" name="iptRamal" ID="iptRamal" data-mask="9999"></td>
				</tr>
				<tr>
				<td colspan="2">Celular:<input type="text" class="form-control" size="60" name="iptcelular" ID="iptcelular" data-mask="(99) 99999-9999"></td>
				</tr>
				<tr>
				<td align="right">&nbsp;</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td colspan="2" style="text-align:center;">
							<div class="col-sm-offset-2 col-sm-10">
							  <input type="submit" name="button" id="button" value="Gerar" class="btn btn-default" />
							  <input type="reset"  name="button" id="button" value="Limpar" class="btn btn-default" />
							</div>
				</td>
				</tr>
				<tr>
				<td align="right">&nbsp;</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td colspan="2" style="text-align:right;">Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o.
				</td>
				</tr>



			</table>
			</div>
	
					</form>
				</div><!-- fim div formulario -->
		  </div>
<!--    
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
	    <img src="images\Hertape_Logo.png"></img>
	  </div>
	</nav>
-->	
<?php
////////// FECHA CONEXÃO BANCO DE DADOS //////////
	mysqli_close($conecta);
?>
</body>

</html>