<div id="principal">
<table  style="border:0px solid black; width:591px; height:102px; background-image:url('images/AssShineray2020.png'); position:absolute; top: 100px; left: 230px;"  cellpadding="0" cellspacing="0" align="left" valign="baseline">
<tr>
	<td rowspan="6" align="left" valign="bottom" ></td>
	<td height="26" colspan="5">
		<?php 
			echo ("<span class='nomeSHI'>".$NomeFun."</span>");
			echo ("<br>");
			echo ("<span class='setorSHI' >&nbsp&nbsp".$setor_select["NOME_SETOR"]."</span>");
			echo "<div class='FoneSHI'>";
			if ($Telefone<>""){
				echo ("<span>&nbspTelefone:</span><span class='nomeTel'> +55 ".$Telefone."</span>");
			}
			
			if ($Ramal<>""){ echo "<span>&nbspRamal:</span><span class='nomeTel'>&nbsp".$Ramal."</span>";	
			}
			echo("<br>");
			if ($Celular<>""){
				echo ("<span>&nbsp&nbsp&nbspCelular:</span><span class='nomeTel'> +55 ".$Celular."</span>");
			}
			echo "</div>";
			echo ("<span class='TituloSHI' >&nbspShineray do Brasil</span>");
			echo ("<span class='EndSHI' >".$unidade_select["BAIRRO"]." ".$unidade_select["CIDADE"]." - Brasil</span>");
			echo ("<span class='SiteSHI' >&nbspwww.shineray.com.br</span>");
			?>
	</td>
</tr>		
</table>
</div>