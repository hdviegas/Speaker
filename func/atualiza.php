<?
require_once($_SERVER['DOCUMENT_ROOT']."/speaker/func/app.php");
$d=$hill->Consulta("select COUNT(id) as qtd from mensagem",false);
$qtd = $d[0]['qtd'];
$e = $hill->Consulta("select valor1 from parametros where id='atualiza'",false);
$att = $e[0]['valor1'];
//$hill->LogErro("erro aqui - ".$att." - ".$qtd);
if($qtd != $att){
	$hill->ExecutaSql("update parametros set valor1='".$qtd."' where id='atualiza'");
	echo "sim";
}
?>
