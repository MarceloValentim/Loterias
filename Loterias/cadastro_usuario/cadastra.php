<?php

include "/config.php";
include "functions.php";


$wusu_nome = trim($_POST['nome']);
$wusu_email = trim($_POST['email']);
$wusu_key_genero = trim($_POST['genero']);
$wusu_key_escolaridade = trim($_POST['escolaridade']);
$wusu_data_nascimento = trim($_POST['data_nascimento']);

/* Vamos checar algum erro nos campos, mas tenha em mente que existem formas bem mais eficientes de tratar os dados que são enviados ou n&atilde;o pelos campos do formulário */

if ((!$wusu_nome) || (!$wusu_email) || (!$wusu_key_genero) || (!$wusu_escolaridade) || (!$wusu_data_nascimento)){

	echo "Favor preencher todos os campos! <br /> <br />";

	if (!$wusu_nome){

		echo "Nome &eacute; um campo requerido. <br />";

	}

	if (!$wusu_email){

		echo "E-mail &eacute; um campo requerido. <br />";

	}

	if (!$wusu_key_genero){

		echo "Genero &eacute; um campo requerido.<br />";

	}

	if (!$wusu_key_escolaridade){

		echo "Escolaridade &eacute; um campo requerido. <br />";

	}

	if (!$wusu_data_nascimento){

		echo "Data de nascimento &eacute; um campo requerido. <br />";

	}


	echo "<br />Preencha os campos necess&aacute;rios abaixo: <br /><br />";

	include "formulario_cadastro.php"; 

}
else{

	/* Vamos checar se o nome de Usuário escolhido e/ou Email já existem no banco de dados */

	$sql_email_check = mysql_query("SELECT COUNT(usu_email) FROM usuario WHERE usu_email='{$wusu_email}'");
	
	$eReg = mysql_fetch_array($sql_email_check);
	
	$email_check = $eReg[0];
	
	if ($email_check > 0) {

		echo "<strong>ERRO </strong>- Por favor corrija os seguintes erros abaixo: <br /> <br />";

		if ($email_check > 0){

		    echo "Este email ( <strong>".$wusu_email."</strong> ) j&aacute; est&aacute; sendo utilizado.<br />Por favor utilize outra conta de email! <br />";

		    unset($wusu_email);

		}

		echo "<br />";
		include "formulario_cadastro.php";

	}
	else
	{

		$wusu_email = strtolower(trim($_POST['email']));
		$char = "@";
		$pos = strpos($wusu_email, $char);

        if ($pos === false){

			echo "<strong>ERRO:</strong><br />";
			echo "O endere&ccedil;o de email [ <strong><em>".$wusu_email."</em></strong> ] que est&aacute; tentando utilizar n&atilde;o &eacute; v&aacute;lido.<br />";
			echo "Por favor, utilize um email v&aacute;lido.<br /><br />";
			include "formulario_cadastro.php"; 

        }else{

            $v_mail = verifica_email($wusu_email);

            if ($v_mail){

                /* Se passarmos por esta verificação ilesos é hora de finalmente cadastrar
	    	    os dados Vamos utilizar uma função para gerar uma senha randômica */ 

				function makeRandomPassword(){

					$salt = "abchefghjkmnpqrstuvwxyz0123456789";
					srand((double)microtime()*1000000); 

					$i = 0;

					while($i <= 7){

						$num = rand() % 33;
						$tmp = substr($salt, $num, 1);
						$pass = $pass . $tmp;
						$i++;

					}

					return $pass;

				}

				$senha_randomica = makeRandomPassword();

				$senha = md5($senha_randomica);

				// Inserindo os dados no banco de dados

				$info = htmlspecialchars($info);

				$sql = mysql_query("INSERT INTO usuario (usu_nome, usu_email, usu_senha, usu_data_nascimento, usu_key_escolaridade, usu_key_genero, usu_data_inclusao) 
									VALUES('{$nome}', '{$email}', '{$senha}', '{$data_nascimento}', '{$escolaridade}', '{$genero}', now())") 
									or die( mysql_error() );

				if (!$sql){

					echo "Ocorreu algum erro ao criar sua conta, por favor entre em contato com o Webmaster.";

				}
				else {

					$usuario_id = mysql_insert_id();

					// Enviar um email ao usu&aacute;rio para confirmação e ativar o cadastro!

					$headers = "MIME-Version: 1.0\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\n";
					$headers .= "From: Teu Domínio - Webmaster<teuemail@teudominiodeemail.com>"; // TEU DOMÌNIO E TEU EMAIL 

					$subject = "Confirmação de cadastro";
					$mensagem = "Prezado <strong>$nome $sobrenome</strong>,
			
								<br />
			
								Obrigado pelo seu cadastro em nosso site, 
								<a href ='http://www.teusite.com'>www.teusite.com</a>!
						
								<br /><br />

								Para confirmar seu cadastro e ativar sua conta, podendo assim acessar áreas exclusivas, 
								por favor clique no link abaixo ou copie e cole o link na barra de endereço do seu navegador.
						
								<br /><br /> 

								<a href ='http://www.teusite.com/ativar.php?id=$usuario_id&code=$senha'>
								http://www.teusite.com/ativar.php?id=$usuario_id&code=$senha
								</a>

								<br /> <br />

								Após a ativação de sua conta, você poderá ter acesso ao conteúdo exclusivo, 
								efetuando o login com os dados abaixo:
						
								<br /> <br /> 

								<strong>Usuario</strong>: {$usuario}
						
								<br /> 
						
								<strong>Senha</strong>: {$senha_randomica}
						
								<br /><br /> 

								Obrigado!<br /> <br /> 

								Webmaster<br /> <br /> <br /> 

								Esta é uma mensagem automática, por favor não responda!";

					mail($wusu_email, $subject, $mensagem, $headers);

					echo "Foi enviado para seu email - ( ".$wusu_email." ) um pedido de confirma&ccedil;&atilde;o de cadastro, 
							por favor verifique e sigas as instru&ccedil;&otilde;es!";

				}

            }else{

                echo "<strong>ERRO:</strong><br />";
                echo "O endere&ccedil;o de email [ <strong><em>".$wusu_email."</em></strong> ] que est&aacute; tentando utilizar n&atilde;o &eacute; v&aacute;lido.<br />";
                echo "Por favor, utilize um email v&aacute;lido.<br /><br />";
				include "formulario_cadastro.php"; 

            }

        }

    }

}

?>