<?
header('Content-type: text/html; charset=utf-8');//CARREGA CHARSET
define(url, $_SERVER['DOCUMENT_ROOT'], true);//URL RAIZ DO SISTEMA
define(app, url."/speaker/", true);//APLICAÇÃO
define(logs , app."logs/", true);//LOGS
define(func, app."func/", true);//PASTA DE FUNÇÕES DO SISTEMA
require_once(func."config.php");//CONFIGURAÇÕES
require_once(func."hill.php");//CLASSE COM TODAS AS FUNÇÕES DO SISTEMA
$hill = new Hill();
$hill->arquivo = $_SERVER['REQUEST_URI'];
$hill->Conectar();//TESTANDO CONEXAO COM O BANCO
$hill->Desconectar();
?>
