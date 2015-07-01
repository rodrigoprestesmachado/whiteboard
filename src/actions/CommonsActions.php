<?php

	/**
	 * Copyright 2011 - Nucleo de Informatica na Educacao Especial (NIEE) 
	 * 
	 * Licensed under the Apache License, Version 2.0 (the "License");
	 * you may not use this file except in compliance with the License.
	 * You may obtain a copy of the License at
	 * 
	 *     http://www.apache.org/licenses/LICENSE-2.0
	 * 
	 * Unless required by applicable law or agreed to in writing, software
	 * distributed under the License is distributed on an "AS IS" BASIS,
	 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 * See the License for the specific language governing permissions and
	 * limitations under the License.
	 */

	require_once 'src/data/DAOFactory.php';
	require_once 'src/actions/AbstractAction.php';
    require_once 'pages/bases/PageController.php';
    require_once 'src/util/EMail.php';
    require_once 'src/util/class.phpmailer.php';
    
    /**
	 * Link the user to a page
	 */
	class ForwardAction extends AbstractAction {
        public function __construct(){
            parent::__construct();
 		}
 		
        public function execute($action){
            $forwards = $action->getForwards();
            if ($forwards['success'] != ""){
            	$this->pageController->run($forwards['success']);
			}
		}
	}
    
    /**
	 * Description : White Board login class
	 */
 	class LoginAction extends AbstractAction {
		
 		public function __construct(){
            parent::__construct();
 		}

		public function execute($action) {
			
			$forwards = $action->getForwards();
			
			$sucess = true;
			
			if (is_null($_SESSION['user'])){
				$user = $this->dao->login($_POST["email"], $_POST["password"]);
				
				if (count($user) > 0) {
					$_SESSION['id'] = $user->getUserId();
		 			$_SESSION['name'] = $user->getName();
		 			$_SESSION['roomCreator'] = $user->getRoomcreator();
		 			$_SESSION['email'] = $user->getEmail();
		 			$_SESSION['user'] = $user;
		 		}
		 		else {
		 			$sucess = false;

	                $_REQUEST["errorMsg"] = $this->message->getText("error.loginFail");
	                $this->pageController->run($forwards['error']);
				}	
			}
			
			if ($sucess){
				$action = new ActionMapping();
				$action->setName("listRoons");
				$action->setType("ListRoonsAction");
				$action->setRole("");					
				$action->setForwards(array("success"=>".showUserPage", "error"=>".error"));
				
				$listRoonsAction = new ListRoonsAction();
				$listRoonsAction->execute($action);
			}
			
		}
	}	
	
	/**
	 * Description : White Board logout class
	 */
	class LogoutAction extends AbstractAction {
		
		public function __construct() {
            parent::__construct();
 		}

		public function execute($action) {
			
			if (isset($_SESSION["idRoom"])){
				// Setting the room state to off
				$this->dao->updateRoomState($_SESSION["idRoom"], false, 0);	
			}
			
			unset($_SESSION['id']); 
			unset($_SESSION['name']);
			unset($_SESSION['user']); 
			session_destroy();

			$action = new ActionMapping();
			$action->setName("loginForm");
			$action->setType("ForwardAction");
			$action->setRole("");					
			$action->setForwards(array("success"=>".showLoginForm","error"=>".error"));
			
			$forwardAction = new ForwardAction();
			$forwardAction->execute($action);
		}
		
	}
	
	/**
	 * Description : White Board register class
	 */
	class RegisterAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
	
			$forwards = $action->getForwards();
	
			// Checks if all fields were provided
			if(
					!empty($_POST['nameNewUser']) &&
					!empty($_POST['emailNewUser']) &&
					!empty($_POST['passwordNewUser']) &&
					!empty($_POST['confirmPasswordNewUser'])
			) {
				$listUsers = $this->dao->listUsers();
				
				$cont = 0;
				foreach ($listUsers as $user){
					if ($user->getEmail() == $_POST['emailNewUser'])
						$cont++;
				}
				
				if ($cont == 0){
					// Checks if the passwords are corresponding
					if($_POST['passwordNewUser'] == $_POST['confirmPasswordNewUser']){
		
						// Instantiates a new user;
						$user = new User();
						$user->setName($_POST['nameNewUser']);
						$user->setEmail($_POST['emailNewUser']);
						$user->setPassword($_POST['passwordNewUser']);
						$user->setRoomcreator(false);
						$resultUser = $this->dao->saveNewUser($user);
						
						
						// Once you register, the user is logged into the system
						$_POST['email'] = $user->getEmail();
						$_POST['password'] = $user->getPassword(); 
						
						$loginAction = new LoginAction();
						$loginAction->execute($action);
						
						// Showing the page
						$this->pageController->run($forwards['success']);
		
					}
					else{
						// It will set a variable with the id of the button
						// that opens the modal window that was active
						$_SESSION['openModalWindow'] = "#dialogRegister";
						
						// Error if the passwords do not match
						$_REQUEST["errorMsg"] = $this->message->getText("error.incompatiblePasswords");
						$this->pageController->run($forwards['error']);
					}
				}else{
					// It will set a variable with the id of the button
					// that opens the modal window that was active
					$_SESSION['openModalWindow'] = "#dialogRegister";
					
					// Error if the passwords do not match
					$_REQUEST["errorMsg"] = $this->message->getText("error.unavailableEmail");
					$this->pageController->run($forwards['error']);
				}
			}
			else{
				// It will set a variable with the id of the button 
				// that opens the modal window that was active
				$_SESSION['openModalWindow'] = "#dialogRegister";
				
				// Error if there are blank fields
				$_REQUEST["errorMsg"] = $this->message->getText("error.blankField");
				$this->pageController->run($forwards['error']);
			}
	
	
		}
	}
	
	/**
	 * Description : White Board update user class
	 */
	class updateUserAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
	
			$forwards = $action->getForwards();
	
			// Recovery user object
			$user = $this->dao->getUser($_SESSION['id']);
	
			// If not entered a new email, it stays the old email
			if (empty($_POST['email']))
				$userEmail = $user->getEmail();
			else
			{
				$userEmail = $_POST['email'];
			}
	
			// Verifies that the password and password confirmation were entered
			if (empty($_POST['password']) || empty($_POST['confirmPassword']))
				$userNewPassword = $user->getPassword();
			else
			{
				// Verifies that the password and password confirmation match
				if ($_POST['password'] == $_POST['confirmPassword'])
					$userNewPassword = $_POST['password'];
				else
				{
					// If not match, the old password prevails
					$userNewPassword = $user->getPassword();
				}
			}
			
			$listUsers = $this->dao->listUsers();
			
			$cont = 0;
			
			if ($_POST['email'] == $user->getEmail())
				$cont--;
			
			foreach ($listUsers as $user){
				if ($user->getEmail() == $_POST['email'])
					$cont++;
			}
			
			if ($cont == 0){
				// Retrieves the current user id
				$idUser = $_SESSION['id'];
				
				// Upadate user;
				$resultUser = $this->dao->updateUserData($idUser, $userEmail, $userNewPassword);
				
				$_SESSION['email'] = $userEmail;
				
				// Showing the page
				$this->pageController->run($forwards['success']);
			
			}
			else{
				// It will set a variable with the id of the button
				// that opens the modal window that was active
				$_SESSION['openModalWindow'] = "#dialogUpdateUser";
			
				// Error if the passwords do not match
				$_REQUEST["errorMsg"] = $this->message->getText("error.unavailableEmail");
				$this->pageController->run($forwards['error']);
			}
		}
	}
	
	/**
	 * Description : List all users of White Board
	 */
	class ListUsersAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
			$forwards = $action->getForwards();
	
			$users = $this->dao->listUsers();
	
			$_REQUEST["users"] = $users;
			$this->pageController->run($forwards['success']);
		}
	}
	
	/**
	 * Description : Send invite for users
	 */
	class InviteFriendsAction extends AbstractAction {
	
		public function __construct(){
			parent::__construct();
		}
	
		public function execute($action) {
			$forwards = $action->getForwards();
			$msgs = Localization::getInstance();
			
			$message = $_POST['inviteFriendMessage'];
			$message = $message . "<br />" . $msgs->getText('inviteFriendForm.defaultMessage');
			$subject = $msgs->getText('inviteFriendForm.emailTitle'); 			
			if (!empty($_POST['emailsSelecteds'])){
				$listUsers = explode("-", $_POST['emailsSelecteds']);
	
				$code = md5($_POST[roomId]);
				$message = $message . "<br />" . $code;
				
				// Envio de email utilizando o PHPMailer
				unset($listUsers[0]);
								
				$mail = new PHPMailer;
				$mail->IsSMTP();
				$mail->IsHTML(true);
				//$mail->SMTPDebug= 2;
				
				$mail->Port		= 25;
				$mail->Host		= "nead.poa.ifrs.edu.br";
				
				//$mail->SMTPAuth = true;  // True caso use autentificação
				//$mail->Username = ''; // Usuário
				//$mail->Password = ''; // Senha
				//$mail->SMTPSecure = "ssl";
				
				$mail->Subject  = $subject;
				
				$mail->From 	= "whiteboard@whiteboard.com";
				$mail->FromName = "WhiteBoard";
				
				foreach ($listUsers as $allowedUserEmail){
					$mail->AddAddress($allowedUserEmail);
				}
				
				$mail->Body = $message;
				$mail->AltBody = $mail->Body;
				
				$enviado = $mail->Send();
				
				$mail->ClearAllRecipients();
				$mail->ClearAttachments();
				
				if ($enviado) {
					//echo "E-mail enviado com sucesso!";
				} else {
					echo "Não foi possível enviar o e-mail.<br /><br />";
					echo "<b>Informações do erro:</b> <br />" . $mail->ErrorInfo;
				}		
			}
			
			$_SESSION['idRoomAux'] = $_POST[roomId];
			
			$this->pageController->run($forwards['success']);
		}
	}
	
	/**
	 * Description : White Board exit room class
	 */
	class ExitRoomAction extends AbstractAction {
	
		public function __construct() {
			parent::__construct();
		}
	
		public function execute($action) {
			
			if (isset($_SESSION["idRoom"])){
				// Setting the room state to off
				$this->dao->updateRoomState($_SESSION["idRoom"], false, 0);
			}
	
			unset($_SESSION['idRoom']);
			unset($_SESSION['idProduction']);
	
			if (isset($_SESSION['eduquito']) || isset($_SESSION['plataform'])){
				unset($_SESSION['eduquito']);
				unset($_SESSION['plataform']);
				
				unset($_SESSION['id']);
				unset($_SESSION['name']);
				unset($_SESSION['roomCreator']);
				unset($_SESSION['email']);
				unset($_SESSION['user']);
				
				echo "<script type='text/javascript'>";
				echo "history.go(-3);";
				echo "</script>";
			}
			else {
				$listRoonsAction = new ListRoonsAction();
				$listRoonsAction->execute($action);
				
				$this->pageController->run($forwards['success']);
			}
				
		}
	
	}
		
?>