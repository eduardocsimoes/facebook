<?php 
	class Posts extends model{

		public function addPosts($msg, $foto, $grupo = 0){

			$usuario = $_SESSION['lgsocial'];
			$tipo = 'texto';
			$url = '';

			if(count($foto) > 0){
				$tipos = array('image/jpeg','image/jpg','image/png');

				if(in_array($foto['type'], $tipos)){
					$tipo = 'foto';

					$url = md5(time().rand(0,999));
					switch ($foto['type']) {
						case 'image/jpeg':
						case 'image/jpg':
							$url .= '.jpg';
							break;
						case 'image/png':
							$url .= '.png';
							break;
					}

					move_uploaded_file($foto['tmp_name'], 'assets/images/posts/'.$url);
				}
			}

			$sql = "INSERT INTO posts SET id_usuario = :id, data_criacao = NOW(), tipo = :tipo, texto = :msg, url = :url, id_grupo = :grupo";
			$sql = $this->db->prepare($sql);

			$sql->bindValue(":id", $usuario);
			$sql->bindValue(":msg", $msg);
			$sql->bindValue(":tipo", $tipo);
			$sql->bindValue(":url", $url);
			$sql->bindValue(":grupo", $grupo);
			$sql->execute();
		}

		public function getFeed($id_grupo = 0){

			$array = array();

			$r = new Relacionamentos();
			$ids = $r->getIdsFriends($_SESSION['lgsocial']);
			$ids[] = $_SESSION['lgsocial'];

			$sql = "SELECT *, 
						   (SELECT usuarios.nome FROM usuarios WHERE usuarios.id = posts.id_usuario) as nome,
						   (SELECT count(*) FROM posts_likes WHERE posts_likes.id_post = posts.id) as likes,
						   (SELECT count(*) FROM posts_likes WHERE posts_likes.id_post = posts.id AND posts_likes.id_usuario = ".$_SESSION['lgsocial'].") as liked
					FROM posts WHERE id_usuario IN (".implode(',', $ids).") AND id_grupo = :id_grupo ORDER BY data_criacao DESC";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id_grupo", $id_grupo);
			$sql->execute();

			if($sql->rowCount() > 0){
				$array = $sql->fetchAll();

				foreach($array as $key => $value){

					$sql1 = "SELECT *, 
								   (SELECT usuarios.nome FROM usuarios WHERE usuarios.id = posts_comentarios.id_usuario) as nome
							FROM posts_comentarios WHERE id_post = :id_post ORDER BY data_criacao";

					$sql1 = $this->db->prepare($sql1);
					$sql1->bindValue(":id_post", $value['id']);
					$sql1->execute();

					if($sql1->rowCount() > 0){
						$array[$key]['comentarios'] = $sql1->fetchAll();
					}
				}
			}

			return $array;
		}

		public function isLiked($id, $id_usuario){

			$sql = "SELECT * FROM posts_likes WHERE id_post = :id AND id_usuario = :id_usuario";
			$sql = $this->db->prepare($sql);

			$sql->bindValue(":id", $id);
			$sql->bindValue(":id_usuario", $id_usuario);
			$sql->execute();

			if($sql->rowCount() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function addLike($id, $id_usuario){

			$sql = "INSERT INTO posts_likes SET id_post = :id, id_usuario = :id_usuario";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id", $id);
			$sql->bindValue(":id_usuario", $id_usuario);
			$sql->execute();			
		}

		public function removeLike($id, $id_usuario){

			$sql = "DELETE FROM posts_likes WHERE id_post = :id AND id_usuario = :id_usuario";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id", $id);
			$sql->bindValue(":id_usuario", $id_usuario);
			$sql->execute();			
		}

		public function addComentario($id, $id_usuario, $txt){

			$sql = "INSERT INTO posts_comentarios SET id_post = :id, id_usuario = :id_usuario, data_criacao = NOW(), texto = :txt";

			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id", $id);
			$sql->bindValue(":id_usuario", $id_usuario);
			$sql->bindValue(":txt", $txt);
			$sql->execute();
		}

/*		public function getComentarios($id_post){

			$array = array();

			$id_usuario = $_SESSION['lgsocial'];

			$sql = "SELECT *, 
						   (SELECT usuarios.nome FROM usuarios WHERE usuarios.id = posts.id_usuario) as nome,
					FROM posts_comentarios WHERE id_post = :id_post ORDER BY data_criacao";

			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id_post", $id_post);
			$sql->execute();

			if($sql->rowCount() > 0){
				$array = $sql->fetchAll();
			}

			return $array;
		}		*/
	}
 ?>