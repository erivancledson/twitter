<?php
class usuarios extends model {

	private $uid;
         //passa o id 
	public function __construct($id = '') {
		parent::__construct();
                    //se o id tiver preenchido
		if(!empty($id)) {
			$this->uid = $id;
		}
	}
	
	public function isLogged() {
                //se existir uma sessão ela não esta vazia
		if(isset($_SESSION['twlg']) && !empty($_SESSION['twlg'])) {
			return true;
		} else {
                    //caso contrario retorne falso
			return false;
		}

	}
 //verificar se o email esta na tabela
	public function usuarioExiste($email) {

		$sql = "SELECT * FROM usuarios WHERE email = '$email'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}

	}
          //cadastrar usuario
	public function inserirUsuario($nome, $email, $senha) {

		$sql = "INSERT INTO usuarios SET nome = '$nome', email = '$email', senha = '$senha'";
		$this->db->query($sql);
                  //pega o id do usuario que foi adicionado
		$id = $this->db->lastInsertId();
                //retorna o id
		return $id;
	}

	public function fazerLogin($email, $senha) {
                  //verificar email e senha
		$sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
		$sql = $this->db->query($sql);
                 //se existi algum usuario com esse email e senha entra
		if($sql->rowCount() > 0) {
			$sql = $sql->fetch();
                        //cria a sessão
			$_SESSION['twlg'] = $sql['id'];
                        
			return true;
		} else {
			return false;
		}	

	}

	public function getNome() {
                //se eiste um id definido
		if(!empty($this->uid)) {
                       
			$sql = "SELECT nome FROM usuarios WHERE id = '".($this->uid)."'";
			$sql = $this->db->query($sql);
                      //se o usuario existe
			if($sql->rowCount() > 0) {
                            //retorna  o nome dele
				$sql = $sql->fetch();
				return $sql['nome'];
			}			

		}

	}
           //pessoas que eu sigo
	public function countSeguidos() {
		
		$sql = "SELECT * FROM relacionamentos WHERE id_seguidor = '".($this->uid)."'";
		$sql = $this->db->query($sql);

		return $sql->rowCount();

	}
       //pessoas que me segue
	public function countSeguidores() {
		$sql = "SELECT * FROM relacionamentos WHERE id_seguido = '".($this->uid)."'";
		$sql = $this->db->query($sql);

		return $sql->rowCount();
	}
              //retorna os usuarios para seguir
	public function getUsuarios($limite) {
		$array = array();
                //saber se eu sigou ou não sigo o usuario
		$sql = "SELECT
		*,
		(select count(*) from relacionamentos where relacionamentos.id_seguidor = '".($this->uid)."' AND relacionamentos.id_seguido = usuarios.id  ) as seguido
		FROM usuarios WHERE id != '".($this->uid)."' LIMIT $limite";
		$sql = $this->db->query($sql);
                 //mostra as 5 sugestões de usuarios
		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getSeguidos() {
		$array = array();
                //só os meus seguidos ver o que eu postei e meu proprio usuario
		$sql = "SELECT id_seguido FROM relacionamentos WHERE id_seguidor = '".($this->uid)."'";
		$sql = $this->db->query($sql);
                     
		if($sql->rowCount() > 0) {
			$sql = $sql->fetchAll();
			foreach($sql as $seg) {
				$array[] = $seg['id_seguido'];
			}
		}

		return $array;
	}

}