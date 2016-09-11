<?php
class posts extends model {
            //adiciona o post 
	public function inserirPost($msg) {
		$id_usuario = $_SESSION['twlg'];
                   //adiciona ela no banco
		$sql = "INSERT INTO posts SET id_usuario = '$id_usuario', data_post = NOW(), mensagem = '$msg'";
		$this->db->query($sql);

	}

	public function getFeed($lista, $limit) {
            //pega as postagens
		$array = array();
             //ver se tem alguma mensagem
                //implode separa por virgula cada mensagem
                //ordena ela por data de ordem decrescente
		if(count($lista) > 0) {

			$sql = "SELECT *, (select nome from usuarios where usuarios.id = posts.id_usuario) as nome FROM posts WHERE id_usuario IN (".implode(',', $lista).") ORDER BY data_post DESC LIMIT ".$limit;
			$sql = $this->db->query($sql);
                        //se tiver mostra as portagens
			if($sql->rowCount() > 0) {
				$array = $sql->fetchAll();
			}			

		}

		return $array;
	}

}