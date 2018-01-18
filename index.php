<?
/****************************************************/
/*	Speaker - Deixe sua mensagem					*/
/*	Data: 12/2010									*/
/*	Autor: Hilthermann Viegas						*/
/*	Universidade Estácio de Sá						*/
/****************************************************/

require("func/app.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Speaker - Deixe sua mensagem!</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
<link rel="shortcut icon" type="text/css" href="imgs/icone.ico"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/geral.js"></script>
</head>
<body marginwidth="0" marginheight="0" onload="ChecaAtualizacao();">
<div id="topo">
<img src="imgs/spk1.png" style="margin-left:15px;" border="0" height="90" /><br />
</div>
<div id="atualiza" onclick="window.location.reload();">Existem novas atualiza��es, clique aqui para atualizar a página.</div>
<div id="lateral">
    <div id="cadastro">
    	<form id="cadastro_msg" name="cadastro_msg" action="">
        <input type="hidden" id="table" name="table" value="mensagem" />
        <input type="hidden" id="acao" name="acao" value="1" />
        Nome:<br /><input type="text" name="nome" id="nome" /><br />
        Email:<br /><input type="text" name="email" id="email" /><br />
        Mensagem:<br /><textarea name="texto" id="texto" onkeyup="Contador(this);"></textarea><br />
		<span id="cont" style="font:12px normal;"></span><br />
        <input type="button" id="botao" value="Enviar" onclick="GravarMsg();"/>
        </form>
        <img src="imgs/loading.gif" id="loading" border="0" style="display:none;" /><br />
    </div>
    <img src="imgs/aba.png" height="210px" style="margin-top:20px; cursor:pointer;" border="0" onclick="SlideOut();" />
</div>
<div id="aba"><img src="imgs/aba.png" border="0" height="210px" style="cursor:pointer;" onclick="SlideIn();" /></div>

<div id="meio">
<?
$qq = $hill->Consulta("select count(*) as qtd from mensagem", false);
$qtd = $qq[0]['qtd'];
$row = $hill->Consulta("SELECT * FROM  mensagem ORDER BY DATA DESC ", true);
$bg = "#FFFFFF";
if(isset($_GET['pg']))$x=$_GET['pg'];else $x=0;
if(isset($_GET['mpp']))$y=$_GET['mpp'];else $y=15;
$i = $x*$y;
$f = $i + $y;
if($f>$qtd)$f=$qtd;
for($i;$i<$f;$i++){
	echo'
		<div class="msg" style="background:'.$bg.';">
			<span class="titulo">'.utf8_encode(ucwords(strtolower($row[$i]["nome"]))).' disse:</span><img align="right" src="imgs/excluir.png" height="15px" style="margin:5px 5px 0 0;cursor:pointer;" onclick="ExcluirMsg('.$row[$i]["id"].');">
			<p class="texto">
				"'.utf8_encode($row[$i]["texto"]).'"
			</p>
			<div class="comple">'.utf8_encode(strtolower($row[$i]['email'])).'  -  '.date("d/m/Y h:i", strtotime($row[$i]['data'])).'</div>
		</div>';
	if($bg=="#FFFFFF")$bg="#F0F0F0";else $bg="#FFFFFF";
}
?>
		<div id="barra_inf">
		<br />
        	Itens por página: <select id="qtd">
            	<option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="30">30</option>
            </select>  | 
        	<?	
				if($qtd==$f)$antigas=""; else $antigas = 'href="index.php?pg='.($x+1).'&mpp='.$y.'"';
				if($x==0)$recentes=""; else $recentes='href="index.php?pg='.($x-1).'&mpp='.$y.'"';
				echo'<a '.$recentes.'>Mais recentes</a> | <a '.$antigas.'>Mais antigas</a> ';
			?>
        </div>
</div>
<div id="rodape">
    <div><img src="imgs/spk.png" border="0" height="80" style="margin-left:20px;" /></div>
    <div style="margin:-70px 0 0 120px;">
    Universidade Estácio de Sá - Unidade Câmara Cascudo<br />
    Autor: Hilthermann Viegas<br />
	Curso: Análise e Desenvolvimento de Sistemas<br />
	Período: 4º	
    </div>
</div>
</body>
</html>
