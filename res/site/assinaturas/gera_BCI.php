<div id="principal">
<table  style="border:0px solid black; width:672px; height:120px; background-image:url('images/AssGrupoBCI.png'); position:absolute; top: 100px; left: 230px;"  cellpadding="0" cellspacing="0" align="left" valign="baseline">
<tr>
	<td rowspan="6" align="left" valign="bottom" ></td>
	<td height="26" colspan="5">
		<?php 
			echo ("<b><span style='font-family: verdana,arial, helvetica,uni-sans;font-size:16px;color:#FFFFFF;font-weight:bold;position:absolute;top:10px;left:20px;'>".$NomeFun."</span></b>");
			echo ("<br>");
			echo ("<span style='font-family: verdana,arial, helvetica,uni-sans;font-size:12px;color:#FFFFFF;font-weight:bold;position:absolute;top:29px;left:20px;'>".$setor_select["NOME_SETOR"]."</span>");

			if ($Telefone<>""){
				echo ("<span style='font-family:verdana,arial, helvetica,uni-sans-book;font-size:10px;color:#FFFFFF;position:absolute;top:47px;left:20px;'>".$Telefone."</span>");
			}
			
			if ($Ramal<>""){ echo "<span style='font-family:verdana,arial, helvetica,uni-sans;font-size:10px;color:#FFFFFF;position:absolute;top:47px;left:110px;'>R. ".$Ramal."</span>";	
			}
			echo("<br>");
			if ($Celular<>""){
				$ddd = substr($Celular, 0,4);
				$digito = substr($Celular, 5,1);
				$numero = substr($Celular, 6, 10);
				echo ("<span style='font-family:verdana,arial, helvetica,uni-sans;font-size:10px;color:#FFFFFF;position:absolute;top:60px;left:20px;'>");
				echo $ddd." ".$digito." ".$numero;
				echo ("</span>");
			}
			echo ("<span style='font-family:verdana,arial, helvetica,uni-sans;font-size:10px;color:#FFFFFF;position:absolute;top:78px;left:20px;'>".$unidade_select["ENDERECO"]."</span>");
			echo ("<span style='font-family:verdana,arial, helvetica,uni-sans;font-size:10px;color:#FFFFFF;position:absolute;top:91px;left:20px;'>".$unidade_select["BAIRRO"].", ".$unidade_select["CIDADE"].", CEP ".$unidade_select["CEP"]."</span>");
			echo "</div>";
			?>
	</td>
</tr>		
</table>
</div>
