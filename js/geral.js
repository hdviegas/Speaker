/****************************************************/
/*	Speaker - Deixe sua mensagem					*/
/*	Data: 12/2010									*/
/*	Autor: Hilthermann Viegas						*/
/*	Universidade Estácio de Sá						*/
/****************************************************/
$(function(){
	$("#lateral").hide(); 
	$("#atualiza").hide();
	$("#qtd").prepend("<option selected='selected'></option>");
	$("#qtd").change(function () {
		var str = "";
		$("#qtd option:selected").each(function () {
				str = $(this).val();
			});
		window.open("index.php?mpp="+str, "_self");
	});
});
function SlideIn(){
	$("#aba").hide();
	$("#lateral").toggle("slide", {}, 700);
}
function SlideOut(){
	
	$("#lateral").toggle("slide", {}, 700, function(){$("#aba").show("slide", {}, 0);});
}
function GravarMsg(){
	if(($("#nome").val()=="") || ($("#email").val()=="") ||	($("#texto").val()=="")){
		alert("Por favor preencha todos os campos corretamente!");
	}else{
		var dados = $("#cadastro_msg").serialize();
		$("#botao").css("display", "none");
		$("#loading").css("display", "block");
		$.ajax({
			type: "POST",
			url: "func/control.php",
			data: dados,
			success: function(data){
				alert(data);
				SlideOut();
				$("#loading").css('display', 'none');
				$("#botao").css("display", "block");
				$("#nome").val("");
				$("#email").val("");
				$("#texto").val("");
				$("#cont").html("");
			}
		});
	}
}
function Contador(campo){
	texto = $(campo).val();
	x = texto.length;
	z = 250 - x;
	if(z > 0){
		$("#cont").html(z+" caracteres restantes.");
	}else{
		$("#cont").html("Nenhum caracter restante.");
		t = texto.substr(0, 249);
		$(campo).val(t);
	} 
}
function ChecaAtualizacao(){
    $.ajax({
        type: "POST",
        url: "func/atualiza.php",
        success: function(data){
				if(data == "sim"){
					$("#atualiza").toggle("blind", {}, 700);
				}
			}
		});
	setTimeout("ChecaAtualizacao();", 10000);
}
function ExcluirMsg(cod){
	pergunta = prompt("Para excluir esta mensagem, por favor digite a senha do administrador. (1234)");
	if(pergunta=='1234'){
		$.ajax({
			type: "POST",
			url: "func/control.php",
			data:{acao: 2, id: cod} ,
			success: function(data){
				alert(data);
				window.location.reload();
			}
		});
	}
}
