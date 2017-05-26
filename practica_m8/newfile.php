<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Model\Alumno;
use Model\Clase;
use Model\Profesor;
use Model\AdminCRUD;

class LoginController extends Controller {
	
	public function show(){
		include ("views/login.tpl.php");
	}
	
	// conflictoo
	public function Conflicto(){
		include("bootstrap.php");
		
		// agregar en el model para la mac y para el correo
		// @Table(uniqueConstraints=@UniqueConstraint(columnNames="NIF"))
		
		if($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["boton"]=="Entrar") {
			
			$correo = $this->sanitize($_POST["email"]);
			$password = $this->sanitize($_POST["password"]);
			
			$alumno = $em->getRepository('Model\Alumno')->findOneBy(array(
					'correo' => $correo,
					'password' => $password
			));
			
			$profe = $em->getRepository('Model\Profesor')->findOneBy(array(
					'correo' => $correo,
					'password' => $password
			));
			
			// identificador de rol
			if ($alumno){
				$id = $alumno->getId();
				
				$alumne = new AlumnoController();
				
				$alumne->cargaEm($em);
				
				$alumne->show($id);
				
			} else if ($profe){
				$id = $profe->getId();
				
				$professor = new ProfesorController();
				$professor->cargaEm($em);
				$professor->show($id);
				// redirigir a seccion profe
			}else {
				$mensaje = "Correo o contraseña invalido";
				include ("views/login.tpl.php");
			}
			
			
		}else {
			
			$correo = "";
			$password = "";
		}
		
	}
	
	
}