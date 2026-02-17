<div id="principal">
<table  style="border:0px solid black; width:600px; height:153px; background-image:url('images/AssGrupoBCI.png'); position:absolute; top: 100px; left: 230px;"  cellpadding="0" cellspacing="0" align="left" valign="baseline">
<tr>
	<td rowspan="6" align="left" valign="bottom" ></td>
	<td height="26" colspan="5">
		<?php 
			echo ("<span style='font-family:arial;font-size:18px;color:#000000;font-weight:bold;position:absolute;top:3px;left:230px;'>".$NomeFun."</span>");
			echo ("<br>");
			echo ("<span style='font-family:verdana,arial, helvetica,sans-serif;font-size:12px;color:#787270;font-weight:bold;position:absolute;top:23px;left:260px;'>".$setor_select["NOME_SETOR"]."</span>");

			echo "<div style='font-family:verdana,arial,helvetica,sans-serif;font-size: 10px;color: #000000;font-weight: normal;position:absolute;top: 50px;left: 290px;border: 0px solid;border-color:black;'>";
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
			echo ("<span style='font-family:verdana,arial,helvetica,sans-serif;font-size:10px;color:#787270;font-weight:normal;position:absolute;top:80px;left:320px;' >&nbsp".$unidade_select["ENDERECO"]." - ".$unidade_select["BAIRRO"]."</span>");
			echo ("<span style='font-family:verdana,arial,helvetica,sans-serif;font-size:10px;color:#787270;font-weight:normal;position:absolute;top:90px;left:330px;' >CEP&nbsp".$unidade_select["CEP"]." - ".$unidade_select["CIDADE"]." - ".$unidade_select["UF"]."</span>");
			?>
	</td>
</tr>		
</table>
</div>