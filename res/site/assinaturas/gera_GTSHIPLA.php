<link rel='stylesheet' type='text/css' href='css/estilo.css'>
<div id="principal">
<table  style="border:0px solid black; width:660px; height:118px; background-image:url('images/AssGTShineray.png'); position:absolute; top: 100px; left: 230px;"  cellpadding="0" cellspacing="0" align="left" valign="baseline">
<tr>
	<td rowspan="6" align="left" valign="bottom" ></td>
	<td height="26" colspan="5">
		<?php 
			echo ("<span class='GTSHI'>".$NomeFun."</span>");
			echo ("<br>");
			echo ("<span class='GTSHI' >&nbsp&nbsp".$setor_select["NOME_SETOR"]."</span>");
			echo "<div class='FoneGT'>";
			if ($Telefone<>""){
				echo ("<span>&nbspTelefone:</span><span class='nomeTelGT'> +55 ".$Telefone."</span>");
			}
			
			if ($Ramal<>""){ echo "<span>&nbspRamal:</span><span class='nomeTelGT'>&nbsp".$Ramal."</span>";	
			}
			echo("<br>");
			if ($Celular<>""){
				echo ("<span>&nbsp&nbsp&nbspCelular:</span><span class='nomeTelGT'> +55 ".$Celular."</span>");
			}
			echo "</div>";
			echo ("<span class='EndGT' >&nbsp".$unidade_select["ENDERECO"]." - ".$unidade_select["BAIRRO"]."</span>");
			echo ("<span class='CEPGT' >CEP&nbsp".$unidade_select["CEP"]." - ".$unidade_select["CIDADE"]." - ".$unidade_select["UF"]."</span>");
			?>
	</td>
</tr>		
</table>
</div>