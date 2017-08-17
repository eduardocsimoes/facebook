<?php 
	class Grupos extends model{

		public function getGrupos(){

			$array = array();

			$sql = "SELECT id, titulo FROM grupos";
			$sql = $this->db->prepare($sql);
			$sql->execute();

			if($sql->rowCount() > 0){
				$array = $sql->fetchAll();
			}

			return $array;
		}

		public function getInfo($id_grupo){

			$array = array();

			$sql = "SELECT * FROM grupos WHERE id = :id_grupo";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id_grupo", $id_grupo);
			$sql->execute();

			if($sql->rowCount() > 0){
				$array = $sql->fetch();
			}

			return $array;
		}

		public function criar($titulo){

			$id_usuario = $_SESSION['lgsocial'];

			$sql = "INSERT INTO grupos SET id_usuario = :id_usuario, titulo = :titulo";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id_usuario", $id_usuario);
			$sql->bindValue(":titulo", $titulo);
			$sql->execute();

			$id_grupo = $this->db->lastInsertId();

			$sql = "INSERT INTO grupos_membros SET id_membro = :id_usuario, id_grupo = :id_grupo";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id_usuario", $id_usuario);
			$sql->bindValue(":id_grupo", $id_grupo);
			$sql->execute();			

			return $id_grupo;
		}

		public function isMembro($id_grupo, $id_usuario){

			$sql = "SELECT * FROM grupos_membros WHERE id_grupo = :id_grupo AND id_membro = :id_usuario";
			$sql = $this->db->prepare($sql);
			$sql->bindValue("id_grupo", $id_grupo);
			$sql->bindValue("id_usuario", $id_usuario);
			$sql->execute();

			if($sql->rowCount() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getQuantMembros($id_grupo){

			$sql = "SELECT COUNT(*) as c FROM grupos_membros WHERE id_grupo = :id_grupo";
			$sql = $this->db->prepare($sql);
			$sql->bindValue("id_grupo", $id_grupo);
			$sql->execute();

			$sql = $sql->fetch();

			return $sql['c'];
		}

		public function addMembro($id_usuario, $id_grupo){

			$sql = "INSERT INTO grupos_membros SET id_membro = :id_usuario, id_grupo = :id_grupo";
			$sql = $this->db->prepare($sql);
			$sql->bindValue("id_usuario", $id_usuario);
			$sql->bindValue("id_grupo", $id_grupo);
			$sql->execute();			
		}
	}
 ?>
