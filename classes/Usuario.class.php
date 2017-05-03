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
}
?>
