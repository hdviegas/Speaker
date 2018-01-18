<?
/****************************************************/
/*	Speaker - Deixe sua mensagem					*/
/*	Data: 12/2010									*/
/*	Autor: Hilthermann Viegas						*/
/*	Universidade Estácio de Sá						*/
/****************************************************/

class Hill{
//--------------------------------------------------------------------------------------------

/*			VARIAVEIS				*/	
	
//--------------------------------------------------------------------------------------------
	public $arquivo;
	public $cod_log;
//--------------------------------------------------------------------------------------------

/*			BANCO MYSQL		*/	
	
//--------------------------------------------------------------------------------------------
	public function Gravar($array, $s) {
		$tabela=$array['table'];
		$chave=$array['chave'];
		$sql="INSERT INTO ".$tabela." (";
		foreach($array as $k=>$v){
			if(($k!='table')&&($k!=$chave)&&($k!='chave')&&($k!='acao')){
				$sql.=$k.',';$valores.="'".$v."',";
			}
		}
		$sql=substr($sql,0,-1);
		$valores=substr($valores,0,-1);
		$sql.=")VALUES(".utf8_decode($valores).")";
		$r = $this->ExecutaSql($sql);
		if($s==true){
			if($r==true){echo "Mensagem gravada com sucesso!";
			}else{
				echo "Não foi possivel efetuar a operação\n".
					   "Favor entrar em contato com o suporte informando o código: ".$this->cod_log."\n\n";					   
			}
		}else{return $r;}
	}    
//--------------------------------------------------------------------------------------------
	public function Excluir($array){
		$tabela=$array['table'];$chave=$array['chave'];
		$where=$chave.' IN('.$array[$chave].')';
		$sql='DELETE FROM '.$tabela.' WHERE '.$where;
		$r = $this->ExecutaSql($sql);
		return $r;
	}    
//--------------------------------------------------------------------------------------------
	public function ExecutaSql($sql) {
		$this->Conectar();
		if(@mysql_query($sql)){return true;}
		else{$this->LogErro(mysql_error()." -- ".$sql);return false;}
		$this->Desconectar();
	}	
//--------------------------------------------------------------------------------------------
	public function Consulta($sql, $s){
		$this->Conectar();
		$re=@mysql_query($sql);$cont=0;
		while($dados=@mysql_fetch_array($re)){$r[$cont]=$dados;$cont++;}		
		if($cont>0){
			$retorno=$r;
		}else{
			$r[$cont]['msg']="Nenhum registro encontrado!\n\n".mysql_error();
			if($s==true){$retorno=$r;}else{$retorno=false;}
		}
		$this->Desconectar();
		return $retorno;
	}
//--------------------------------------------------------------------------------------------
	public function Conectar(){
		$conexao=@mysql_connect(servidor,usuario,senha);
		if(!$conexao){
			$this->LogErro(ibase_errmsg());
			echo"<script>alert('Falha ao tentar se conectar ao servidor de dados | ".$this->cod_log."\n\n".ibase_errmsg()."');</script>";
		}else{
			$database = mysql_select_db(db);
			if(!$database){
				$this->LogErro(ibase_errmsg());
				echo"<script>alert('Falha ao tentar se conectar ao banco de dados | ".$this->cod_log."\n\n".ibase_errmsg()."');</script>";
			}
		}
	}
//--------------------------------------------------------------------------------------------
	public function Desconectar(){
		@mysql_close();
	}
//--------------------------------------------------------------------------------------------
	
/*			UTILITARIOS			*/		

//--------------------------------------------------------------------------------------------
	public function RetornoAjax($arr){
		$r = json_encode($arr);
		$r = utf8_encode($r);
		return $r;
	}
//--------------------------------------------------------------------------------------------
	public function LimpaQuery($string,$len='',$ini=0){ 
		if(is_array($string)){
			foreach($string as $key=>$val){
				if($key!="PHPSESSID"){
					$val=urldecode($val);
					$val=addslashes(strip_tags(trim($val)));
					$l=$len;
					if($l==''){$l=strlen($val);};
					$dt[$key]=trim(substr($val,$ini,$l));
				}
			}
			return $dt;
		}else{
			$string = urldecode($string);			
			$string=addslashes(strip_tags(trim($string)));
			if($len==''){$len=strlen($string);};
			return  trim(substr($string,$ini,$len));
		}
	}
//--------------------------------------------------------------------------------------------
	public function LogErro($msg){
/*		$sql="SELECT VALOR1 FROM PARAMETROS WHERE CODIGO='LOG_ERRO'";
		$d = $this->Consulta($sql, false);
		$this->cod_log = $d['0']['VALOR1'] + 1;
		$sql = "UPDATE PARAMETROS SET VALOR1=".$this->cod_log." WHERE CODIGO='LOG_ERRO'";
		$d = $this->ExecutaSql($sql);	
*/		$txt = "\n\nCodigo:".$this->cod_log."\n".
				"Arquivo: ".$this->arquivo."\n".
				"Erro: ".$msg."\n".
				"Data/Hora: ".date("d/m/Y H:i:s")."\n\n".
				"|---------------------------------------------------------------|";
		file_put_contents(logs."erros.txt", $txt, FILE_APPEND);
	}
//--------------------------------------------------------------------------------------------
}?>