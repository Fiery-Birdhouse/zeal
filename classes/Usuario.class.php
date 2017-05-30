<?php
class Usuario extends Record {
	const TABLE = 'Usuarios'; // table name
	const PK = 'idUsuario'; // primary key

	/**
	 * Valida os dados de usuário informados e inicia uma sessão
	 * @param  	string 		$usuario
	 * @param  	string 		$senha
	 * @param  	string 		$token
	 * @return 	mixed
	 */
	static function logar($usuario = null, $senha = null, $token = null) {
		// Verifica se a autenticação será realizada por token
		if ($token) {
			$usuario = Usuario::find(
				array("token = ?", $token),
				array('limit' =>  1)
			);

			if (!empty($usuario)) {
				$_SESSION['usuario']['id'] = $usuario[0]->codUsuario;
				return 0;
			} else {
				return "c1"; // Usuário inexistente
			}
		} elseif ($usuario && $senha) { // Autenticação por nome de usuário e senha
			// Pesquisa conta pelo nome de usuário
			$usuario = Usuario::find(
				array("usuario = ?", $usuario),
				array('limit' =>  1)
			);

			if (!empty($usuario)) {
				if (password_verify($senha, $usuario[0]->senha)) {
					$_SESSION['usuario']['id'] = $usuario[0]->codUsuario;
					return 0;
				} else {
					return "c2"; // Senha incorreta
				}
			} else {
				return "c1"; // Usuário inexistente
			}

		} else {
			return "c0"; // Caso algum dado não tenha sido informado
		}
	}

	/**
	 * Realiza o registro de uma nova conta de usuário
	 * @param  	string 		$usuario
	 * @param  	string 		$senha
	 * @param  	string 		$token
	 * @return 	mixed
	 */
	static function registrar($usuario = null, $senha = null, $token = null, $logar = false) {
		$novoUsuario = new usuario();

		if ($token) { // Registro por token
			// Pesquisa por algum usuário com o mesmo token cadastrado
			$usuarioExistente = Usuario::find(array('token = ?', $token), null);

			if (empty($usuarioExistente)) {
				$novoUsuario->token = $token;
				$novoUsuario->store();

				return 0;
			} else {
				return 'c3';
			}
		} elseif (Usuario::dadosInvalidos($usuario, $senha)) {
			return Usuario::dadosInvalidos($usuario, $senha); // Retorna código de erro caso haja alguma irregularidade nos dados informados
		} else {
			$usuarioExistente = Usuario::find(array('usuario = ?', $usuario), null);

			if (empty($usuarioExistente)) {
				$novoUsuario->usuario = $usuario;
				$novoUsuario->senha = password_hash($senha, PASSWORD_DEFAULT);
				$novoUsuario->store();

				// Tenta logar assim que o usuário é registrado
				if ($logar) {
					Usuario::logar($usuario, $senha);
				}

				return 0;
			} else {
				return 'c3';
			}
		}
	}


	/**
	 * Verifica se os detalhes de novo usuário podem ser utilizados
	 * @param  	string 		$usuario
	 * @param  	string 		$senha
	 * @return 	mixed		Código de erro ou 0 para sucesso
	 */
	static function dadosInvalidos($usuario = null, $senha = null) {
		if (empty($usuario)) {
			return 'c4';
		}

		if (empty($senha)) {
			return 'c5';
		}

		if (strlen($usuario) < 3 || strlen($usuario) > 32) {
			return 'c6';
		}

		if (strlen($senha) < 8) {
			return 'c7';
		}

		return 0;
	}
}
?>
