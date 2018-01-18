<?
/****************************************************/
/*	Speaker - Deixe sua mensagem					*/
/*	Data: 12/2010									*/
/*	Autor: Hilthermann Viegas						*/
/*	Universidade Estácio de Sá						*/
/****************************************************/

require_once($_SERVER['DOCUMENT_ROOT']."/speaker/func/app.php");
if($_REQUEST['acao']==0){//pesquisar
	$d = $hill->LimpaQuery($_REQUEST);
	if(is_numeric($d['valor'])){
		$sql ="select * from ".$d['table']." where codigo=".$d['valor'];
	}else{
		$q = strtoupper($d['valor']);
		$sql="select * from ".$d['table']." where ".$d['auto']." like '".$q."%'";
	}
	$dados=$hill->Consulta($sql, true);
	$retorno=$hill->RetornoAjax($dados);
	echo $retorno;
}
if($_REQUEST['acao']==1){//cadastrar
	$d = $hill->LimpaQuery($_REQUEST);
	return $hill->Gravar($d, true);
}
if($_REQUEST['acao']==2){//excluir
	$arr['chave'] = "id";
	$arr['table'] = "mensagem";
	$arr['id'] = $_REQUEST['id'];
	$r = $hill->Excluir($arr);
	if($r==true){
		$d=$hill->Consulta("select COUNT(id) as qtd from mensagem",false);
		$qtd = $d[0]['qtd'];
		$e = $hill->Consulta("select valor1 from parametros where id='atualiza'",false);
		$att = $e[0]['valor1'];
		//$hill->LogErro("erro aqui - ".$att." - ".$qtd);
		if($qtd != $att)$hill->ExecutaSql("update parametros set valor1='".$qtd."' where id='atualiza'");
		echo utf8_encode("Mensagem excluida com sucesso, clique \"Ok\" para atualizar a página");
	}else{
		echo utf8_encode("Erro ao excluir a mensagem, favor entre em contato com o suporte.");
	}
}
?>