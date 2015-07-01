 <!-- 
	Copyright 2011 - Nucleo de Informatica na Educacao Especial (NIEE) 
	
	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at
	
	    http://www.apache.org/licenses/LICENSE-2.0
	
	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.
-->
<?php $msgs = Localization::getInstance(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"
	lang="<?php echo $msgs->getLanguage(); ?>">

	<head>
		<title><?php echo $msgs->getText('title'); ?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
		
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	  	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		
		<script type="text/javascript" src="pages/bases/javascript/accessibility.js"></script>
		<script type="text/javascript" src="pages/bases/javascript/application.js"></script>
		<script type="text/javascript" src="pages/bases/javascript/chat.js"></script>
		<script type="text/javascript" src="pages/bases/javascript/drag.js"></script>
		<script type="text/javascript" src="pages/bases/javascript/image.js"></script>
		<script type="text/javascript" src="pages/bases/javascript/init.js"></script>
		<script type="text/javascript" src="pages/bases/javascript/libWhiteBoard.js"></script>		
	    <script type="text/javascript" src="pages/bases/javascript/filterlist.js"></script>
		<script type="text/javascript" src="pages/bases/javascript/utilities.js"></script>
		
		
	    <link rel="stylesheet" type="text/css" href="pages/bases/css/position.css" />
		<link rel="stylesheet" type="text/css" href="pages/bases/css/widgets.css" />
	   
	    <?php require_once 'dialogModal.php'; ?>
	     
		<script>
			$(document).ready(function() { 

				createTabs(); 
				initModalWindow();
				createMidiatecaDlg(); 
	
				// Control which DOM Element is focused inside DIV WRITING
				focusedElement = null;
				$( "#writing" ).delegate( "*", "focus", function( event ) {
					focusedElementId = '#' + $(this).attr('id');			    
				});			
			});
		
			// Production id
		  	if (getCookie("alteredProduction")){
			  	var idProduction = parseInt(getCookie("alteredProduction"));
			  	deleteCookie("alteredProduction");			  	
		  	}else
		  		var idProduction = <?php echo $_SESSION['idProduction'] ?>;
			// User id
			var idUser = <?php echo $_SESSION['id'] ?>;
			// User Name
			var userName = <?php echo "\"".$_SESSION['name']."\"" ?>;
			// Localization
			var lang = <?php echo "\"".$msgs->getLanguage()."\"" ?>;
			// Array to map id with user
			var users = [];
		  	
			var ownerRoom = <?php  
			 	if($_SESSION['roomCreator'] == 1 || $_SESSION['roomCreator'] ==true) 
			 		echo 1; 
				else 
			 		echo 0; 
			 ?>;
				 
		  	// Handle messages from Midiateca Iframe 
		  	window.onmessage = function(e){
				var url = e.data; 
				createImage(url);
				console.log('Message received from: '+e.origin + ' -> url: ' + url);
			};

			window.onbeforeunload = function() {
				return "";
			};

			function getIdProduction() {
				return idProduction;
			}

	  	</script>	
	  	
	  	<!-- Don't remove it of this location, because this function uses variables previously created (ownerRoom) -->
	  	<script type="text/javascript" src="pages/bases/javascript/navigationArrows/roomTemplate.js"></script>
	  	
	  	<?php require_once 'jsLocalization.php'; ?>
	  	
	  	<style type="text/css">
	  		td img { 
	  			display: block; 
	  		}
	  	</style>
	  	
	  	<?php
	  	 
	  	/**
	  	 * Returns true if the current user is the owner of the room.
	  	 *
	  	 * @param  	   		: Nothing
	  	 * @return Boolean	: True to the owner of the room
	  	 */
	  	
	  	function isRoomOwner(){
	  		if (!isset($_GET['idRoom'])){
	  			$_GET['idRoom'] = $_SESSION['idRoomAux'];
	  			unset($_SESSION['idRoomAux']);
	  		}
	  		
	  		$action = new ActionMapping();
	  		$action->setName("listRoons");
	  		$action->setType("ListRoonsAction");
	  		$action->setRole("");
	  		
	  		$listRoonsAction = new ListRoonsAction();
	  		$listRoonsAction->execute($action);
	  		
	  		$roons =  $_REQUEST["roons"];
	  		
	  		foreach ($roons as $room){
	  			if ($room->getRoomId() == $_GET['idRoom'] && $room->getUserId() == $_SESSION['id']){
	  				$control = true;
	  				$_SESSION['roomOwner']=$room->getUserId();
	  			}
	  		}
	  		return $control;
	  	}
	  	?>
	  	
	</head>

	<body onload="startSocket()" bgcolor="#ffffff">
	
		<div id="system" role="application">
		
			<div id="control">
			
				<div id="painelActiveUsers"
					 aria-live="assertive"
					 aria-atomic="false" 
					 aria-busy="true"
					 aria-relevant="all">
					 
					<?php if (!isRoomOwner() || isset($_SESSION['eduquito']) || isset($_SESSION['plataform'])){?>
					<div id="activeUsers" style="background-image: url('pages/images/painelActiveUsers2.gif')">
					<?php }else{?>
					<div id="activeUsers" style="background-image: url('pages/images/painelActiveUsers.gif')">
					<?php }?>
						<div id="title">
							<?php echo $msgs->getText('roomTemplate.users'); ?>
						</div>
						
						<div id="users"></div>
	
					</div>
					<?php if (isRoomOwner() && (!isset($_SESSION['eduquito']) || !isset($_SESSION['plataform']))){?>
						<input 
							id="btnInviteFriend"
							tabindex="1"
							type="submit"
							type="image"
							onfocus="showTip('tipInviteFriendBtn', 'btnInviteFriend')" 
							onblur="hideTip('tipInviteFriendBtn')" 
							onmouseover="showTip('tipInviteFriendBtn')" 
							onmouseout="hideTip('tipInviteFriendBtn')" 	
							value="<?php echo $msgs->getText('roomTemplate.inviteFriendBtn'); ?>" 
							alt="<?php echo $msgs->getText('roomTemplate.inviteFriendBtn.description'); ?>"
							onclick="libOpenModalWindow('#dialogInviteFriend'); currentModalWindow='dialogInviteFriends';" 
							aria-describedby="tipInviteFriendBtn"	
						/>
					<?php } ?>
				</div>
				
				<div id="painelVideo">
					<?php if (!isRoomOwner()){?>
					<div id="divVideo" style="background-image: url('pages/images/painelVideo2.gif')">
					<?php }else{?>
					<div id="divVideo" style="background-image: url('pages/images/painelVideo.gif')">
					<?php }?>
						<br />
						<div id="video">
							<?php require_once 'comm.php'; ?>
						</div>
					</div>
					
					<div id="buttonsVideoStreaming">         
					 	<input  
					 		class="btnsStream" 
					 		id="btnPlayStopStream" 
					 		tabindex="2" 
					 		type="submit" 
					 		type="image" 
					 		onfocus="showTip('tipPlayStopStreamBtn')"  
					 		onblur="hideTip('tipPlayStopStreamBtn')"  
					 		onmouseover="showTip('tipPlayStopStreamBtn')"  
					 		onmouseout="hideTip('tipPlayStopStreamBtn')"  
					 		value="<?php echo $msgs->getText('roomTemplate.playStopStreamBtn'); ?>"  
					 		alt="<?php echo $msgs->getText('roomTemplate.playStopStreamBtn.description'); ?>" 
					 		style="background-image: url(pages/images/buttonPlayDisable.png);" 
					 		aria-describedby="tipPlayStopStreamBtn"  
						/> 
					 	<input  
						 	class="btnsStream" 
						 	id="btnPublishStream" 
						 	tabindex="3" 
						 	type="submit" 
						 	type="image" 
						 	onfocus="showTip('tipPublishStreamBtn')"  
						 	onblur="hideTip('tipPublishStreamBtn')"  
						 	onmouseover="showTip('tipPublishStreamBtn')"  
						 	onmouseout="hideTip('tipPublishStreamBtn')"  
						 	value="<?php echo $msgs->getText('roomTemplate.publishStreamBtn'); ?>"  
					 		alt="<?php echo $msgs->getText('roomTemplate.publishStreamBtn.description'); ?>" 
					 		style="background-image: url(pages/images/buttonPublishDisable.png);" 
					 		aria-describedby="tipPublishStreamBtn"   
					 	/> 
					 </div> 
				</div>
				
				<div id="painelChat">
					<div id="chat">
						<div id="title">
							<?php echo $msgs->getText('roomTemplate.chat'); ?>
						</div>
										
						<div id="chatContent" 
						     aria-live="assertive" 
						     aria-atomic="true" 
						     aria-busy="true" 
						     aria-relevant="additions">
						</div>
	
						<input 
							type="text" 
							tabindex="4"
							id="chatInput" 
							class="input"
							size="22"
							onkeypress="sendChatTextFromKeyboard(event)" 
							onfocus="showTip('tipChatSendMsgEnter', 'chatInput');alreadyRead();"
							onblur="hideTip('tipChatSendMsgEnter')" 
							onmouseover="showTip('tipChatSendMsgEnter')" 
							onmouseout="hideTip('tipChatSendMsgEnter')"
							aria-describedby="tipChatSendMsgEnter"	
						/>
					</div>
					<input 
						id="btnSendMsg"
						tabindex="5"
						type="submit"
						type="image"
						onfocus="showTip('tipChatSendMsgBtn', 'btnSendMsg')" 
						onblur="hideTip('tipChatSendMsgBtn')"
						onmouseover="showTip('tipChatSendMsgBtn')" 
						onmouseout="hideTip('tipChatSendMsgBtn')"	
						value="<?php echo $msgs->getText('roomTemplate.sendMsgBtn'); ?>" 
						alt="<?php echo $msgs->getText('roomTemplate.sendMsgBtn.description'); ?>"
						onclick="sendChatText();" 
						aria-describedby="tipChatSendMsgBtn"
					/>
				</div>
				
				
			</div>

			<div id="topMenu">
			
				<div id="logo"></div>
				
				<div id="buttonsAccessibility">
					<input 
						type="submit"
						id="btn1"
						type="image"
						alt=""
						tabindex="5000"
						value=""
						onfocus="showTip('tipShortcuts', 'btn1')" 
						onblur="hideTip('tipShortcuts')" 
						onmouseover="showTip('tipShortcuts')" 
						onmouseout="hideTip('tipShortcuts')" 
						onclick="libOpenModalWindow('#dialogShortcuts'); currentModalWindow='dialogShortcuts';"
						aria-describedby="tipShortcuts"
					/>
					<input 
						type="submit"
						id="btn2"
						type="image"
						alt=""
						tabindex="5001"
						value=""
						onfocus="showTip('tipFontLess', 'btn2')" 
						onblur="hideTip('tipFontLess')" 
						onmouseover="showTip('tipFontLess')" 
						onmouseout="hideTip('tipFontLess')" 
						onclick="resizeFont('less')"
						aria-describedby="tipFontLess"
					/>
					<input 
						type="submit"
						id="btn3"
						type="image"
						alt=""
						tabindex="5002"
						value=""
						onfocus="showTip('tipFontMore', 'btn3')" 
						onblur="hideTip('tipFontMore')" 
						onmouseover="showTip('tipFontMore')" 
						onmouseout="hideTip('tipFontMore')" 
						onclick="resizeFont('more')"
						aria-describedby="tipFontMore"
					/>
					<input 
						type="submit"
						id="btn4"
						type="image"
						alt=""
						tabindex="5003"
						value=""
						onfocus="showTip('tipHelpLibras', 'btn4')" 
						onblur="hideTip('tipHelpLibras')" 
						onmouseover="showTip('tipHelpLibras')" 
						onmouseout="hideTip('tipHelpLibras')" 
						onclick="libOpenModalWindow('#dialogHelpLibras'); currentModalWindow='dialogHelpLibras';"
						aria-describedby="tipHelpLibras"
					/>
					<input 
						type="submit"
						id="btn5"
						type="image" 
						alt=""
						tabindex="5004"
						value=""
						onfocus="showTip('tipHelpAudio', 'btn5')" 
						onblur="hideTip('tipHelpAudio')" 
						onmouseover="showTip('tipHelpAudio')" 
						onmouseout="hideTip('tipHelpAudio')" 
						onclick="libOpenModalWindow('#dialogHelpAudio'); currentModalWindow='dialogHelpAudio';"
						aria-describedby="tipHelpAudio"
					/>
					
				</div>
				
				<div id="buttonsOthers">
					<input 
						type="submit"
						id="btn7"
						type="image"
						alt=""
						tabindex="5005"
						value=""
						onfocus="showTip('tipHelp', 'btn7')" 
						onblur="hideTip('tipHelp')" 
						onmouseover="showTip('tipHelp')" 
						onmouseout="hideTip('tipHelp')" 
						onclick="libOpenModalWindow('#dialogHelp'); currentModalWindow='dialogHelp';"
						aria-describedby="tipHelp"
					/>
					<form action="wb.php" method="get" style="display:inline" onsubmit = "if (getCookie('alteredProduction')) deleteCookie('alteredProduction'); inputSize = parseInt(getCookie('inputSize').substring(0,2)); inputSize += 2; setCookie('inputSize',inputSize,30);">
						<input  type="hidden" name="do" value="exitRoom" />
						<input  
							type="submit"
							id="btnExitRoom"
							type="image" 
							onfocus="showTip('tipBtnExitRoom', 'btnExitRoom')" 
							onblur="hideTip('tipBtnExitRoom')" 
							onmouseover="showTip('tipBtnExitRoom')" 
							onmouseout="hideTip('tipBtnExitRoom')" 
							value=""
							tabindex="5006"
							alt="" 
							aria-describedby="tipBtnExitRoom"
						/>
					</form>
				</div>	
						
			</div>
			 
			<div id="tipsBar">
				<div id="tipMsgSave" class="tip"
			    	 style="display:inline">
   					<?php echo $msgs->getText('roomTemplate.msgSave'); ?>
				</div>
				<div id="tipTextArea" class="tip">
   					<?php echo $msgs->getText('divTextField'); ?>
				</div>
				<div id="tipAddTextArea" class="tip">
   					<?php echo $msgs->getText('roomTemplate.mainMenu.btnText.description'); ?>
				</div>
				<div id="tipAddYoutubeVideo" class="tip"> 
					<?php echo $msgs->getText('roomTemplate.mainMenu.btnYoutubeVideo.description'); ?> 
				</div>
				<div id="tipImage" class="tip">
					<?php echo $msgs->getText('roomTemplate.mainMenu.btnImage.description'); ?>
				</div>
				<div id="tipRolateLeft" class="tip">
					<?php echo $msgs->getText('roomTemplate.mainMenu.btnRolateLeft.description'); ?>
				</div>
				<div id="tipRolateRight" class="tip">
					<?php echo $msgs->getText('roomTemplate.mainMenu.btnRolateRight.description'); ?>
				</div>
				<div id="tipBtnDelete" class="tip">
					<?php echo $msgs->getText('roomTemplate.mainMenu.btnDelete.description'); ?>
				</div>
				<div id="tipBtnExitRoom" class="tip">
				   	 <?php echo $msgs->getText('roomTemplate.btnExitRoom.description'); ?>
				</div>
				<div id="tipChatSendMsgBtn" class="tip">
					<?php echo $msgs->getText('roomTemplate.sendMsgBtn.description'); ?>
				</div>
				<div id="tipChatSendMsgEnter" class="tip">
					<?php echo $msgs->getText('roomTemplate.sendMsgEnter'); ?>
				</div>
				<div id="tipInviteFriendBtn" class="tip">
					<?php echo $msgs->getText('roomTemplate.inviteFriendBtn.description'); ?>
				</div>
				<div id="tipFontMore" class="tip">
					<?php echo $msgs->getText('roomTemplate.btnFontMore.description'); ?>
				</div>
				<div id="tipFontLess" class="tip">
					<?php echo $msgs->getText('roomTemplate.btnFontLess.description'); ?>
				</div>
				<div id="tipPlayStopStreamBtn" class="tip"> 
					<?php echo $msgs->getText('roomTemplate.playStopStreamBtn.description'); ?> 
				</div> 
				<div id="tipPublishStreamBtn" class="tip"> 
				 	<?php echo $msgs->getText('roomTemplate.publishStreamBtn.description'); ?> 
				</div>
				<div id="tipShortcuts" class="tip">
					<?php echo $msgs->getText('roomTemplate.btnShortcuts.description'); ?>
				</div>
				<div id="tipHelp" class="tip">
					<?php echo $msgs->getText('roomTemplate.btnHelp.description'); ?>
				</div>
				<div id="tipHelpLibras" class="tip">
					<?php echo $msgs->getText('roomTemplate.btnHelpLibras.description'); ?>
				</div>
				<div id="tipHelpAudio" class="tip">
					<?php echo $msgs->getText('roomTemplate.btnHelpAudio.description'); ?>
				</div>
				<div id="tipBtnPosition" class="tip">
					<?php echo $msgs->getText('roomTemplate.mainMenu.btnPosition.description'); ?>
				</div>
				<div id="tipBtnOpenProduction" class="tip">
					<?php echo $msgs->getText('roomTemplate.mainMenu.btnOpenProduction.description'); ?>
				</div>
			</div>		
			
			<div id="content">
				<div id="document">
				
					<div id="mainMenu">
						<input 
							class="btnMainMenu"
							id="btnText"
							tabindex="6"
							type="submit"
							type="image"
							onfocus="showTip('tipAddTextArea', 'btnText')"
							onblur="hideTip('tipAddTextArea')"
							onmouseover="showTip('tipAddTextArea')"
							onmouseout="hideTip('tipAddTextArea')"
							value="<?php echo $msgs->getText('roomTemplate.mainMenu.btnText'); ?>" 
							alt="<?php echo $msgs->getText('buttonText'); ?>"
							onclick="createInitialTextArea();" 
							style="background-image: url(pages/images/btnTexto.gif);"
							aria-describedby="tipAddTextArea"
						/>
						
						<input 
							class="btnMainMenu"
							id="btnVideo"
							tabindex="7"
							type="submit"
							type="image"
							onfocus="showTip('tipAddYoutubeVideo', 'btnVideo')"
							onblur="hideTip('tipAddYoutubeVideo')"
							onmouseover="showTip('tipAddYoutubeVideo')"
							onmouseout="hideTip('tipAddYoutubeVideo')"
							value="<?php echo $msgs->getText('roomTemplate.mainMenu.btnYoutubeVideo'); ?>" 
							alt="<?php echo $msgs->getText('buttonYoutubeVideo'); ?>"
							onclick="$('#dialogInputYoutubeVideo').dialog('open'); currentModalWindow='dialogYouTubeVideo';" 
							style="background-image: url(pages/images/btnYoutubeVideo.png);"
							aria-describedby="tipAddYoutubeVideo"
						/>
						
						<input 
							class="btnMainMenu"
							id="btnImage"
							tabindex="8"
							type="submit"
							type="image"
							onfocus="showTip('tipImage', 'btnImage')"
							onblur="hideTip('tipImage')"
							onmouseover="showTip('tipImage')"
							onmouseout="hideTip('tipImage')"
							value="<?php echo $msgs->getText('roomTemplate.mainMenu.btnImage'); ?>" 
							alt="<?php echo $msgs->getText('roomTemplate.mainMenu.btnImage'); ?>"
							onclick="callMidiateca()" 
							style="background-image: url(pages/images/btnImagem.gif);"
							aria-describedby="tipImage"
						/>
						
						<input 
							class="btnMainMenu"
							id="btnRolateLeft"
							tabindex="9"
							type="submit"
							type="image"
							onfocus="showTip('tipRolateLeft', 'btnRolateLeft')"
							onblur="hideTip('tipRolateLeft')"
							onmouseover="showTip('tipRolateLeft')"
							onmouseout="hideTip('tipRolateLeft')"
							value="<?php echo $msgs->getText('roomTemplate.mainMenu.btnRolateLeft'); ?>" 
							alt="<?php echo $msgs->getText('roomTemplate.mainMenu.btnRolateLeft'); ?>"
							onclick="rotateCounterClockwise()"
							style="background-image: url(pages/images/btnEsquerda.gif);"
							aria-describedby="tipRolateLeft"
						/>
						
						<input 
							class="btnMainMenu"
							id="btnRolateRight"
							tabindex="10"
							type="submit"
							type="image"
							onfocus="showTip('tipRolateRight', 'btnRolateRight')"
							onblur="hideTip('tipRolateRight')"
							onmouseover="showTip('tipRolateRight')"
							onmouseout="hideTip('tipRolateRight')"
							value="<?php echo $msgs->getText('roomTemplate.mainMenu.btnRolateRight'); ?>" 
							alt="<?php echo $msgs->getText('roomTemplate.mainMenu.btnRolateRight'); ?>"
							onclick="rotateClockwise()"
							style="background-image: url(pages/images/btnDireita.gif);"
							aria-describedby="tipRolateRight"
						/>
						
						<input 
							class="btnMainMenu"
							id="btnDelete"
							tabindex="11"
							type="submit"
							type="image"
							onfocus="showTip('tipBtnDelete', 'btnDelete')"
							onblur="hideTip('tipBtnDelete')"
							onmouseover="showTip('tipBtnDelete')"
							onmouseout="hideTip('tipBtnDelete')"
							value="<?php echo $msgs->getText('roomTemplate.mainMenu.btnDelete'); ?>" 
							alt="<?php echo $msgs->getText('roomTemplate.mainMenu.btnDelete'); ?>"
							onclick="removeFromWhiteBoard(focusedElementId)"
							style="background-image: url(pages/images/btnDeletar.gif);"
							aria-describedby="tipBtnDelete"
						/>
						<?php if (isRoomOwner()){?>
						<input 
							class="btnMainMenu"
							id="btnOpenProduction"
							tabindex="12"
							type="submit"
							type="image"
							onfocus="showTip('tipBtnOpenProduction', 'btnOpenProduction')"
							onblur="hideTip('tipBtnOpenProduction')"
							onmouseover="showTip('tipBtnOpenProduction')"
							onmouseout="hideTip('tipBtnOpenProduction')"
							value="<?php echo $msgs->getText('roomTemplate.mainMenu.btnOpenProduction'); ?>" 
							alt="<?php echo $msgs->getText('roomTemplate.mainMenu.btnOpenProduction'); ?>"
							onclick="libOpenModalWindow('#dialogLoadProduction'); currentModalWindow='dialogOpenProduction';"
							style="background-image: url(pages/images/btnOpenProduction.gif);"
							aria-describedby="tipBtnOpenProduction"
						/>
						<?php }?>
						<!-- 
						<input 
							class="btnMainMenu"
							id="btnPosition"
							tabindex="13"
							type="submit"
							type="image"
							onfocus="showTip('tipBtnPosition', 'btnPosition')"
							onblur="hideTip('tipBtnPosition')"
							onmouseover="showTip('tipBtnPosition')"
							onmouseout="hideTip('tipBtnPosition')"
							value="<?php //echo $msgs->getText('roomTemplate.mainMenu.btnPosition'); ?>" 
							alt="<?php //echo $msgs->getText('roomTemplate.mainMenu.btnPosition'); ?>"
							onclick="libOpenModalMvElement(focusedElement)"
							style="background-image: url(pages/images/btnPosicao.gif);"
							aria-describedby="tipBtnPosition"
						/>
						 -->
					</div>
				
					<div id="writing"></div>
							
					<div id="logArea"
					     aria-live="assertive"
					     aria-atomic="true"
					     aria-busy="true"
					     aria-relevant="additions"
					     role="log">
					</div>
								
				</div>
			
				<div id="embededVideo"></div>
					
				<div id="dialog-modal"></div>
				
			</div>
	
		</div>
		
		<div id="dialogInviteFriend" title="<?php echo $msgs->getText('inviteFriendForm.title'); ?>" class="dialog">
			<?php require_once 'pages/inviteFriendForm.php';?>
		</div>	
		
		<div id="dialogMoveElement" title="<?php echo $msgs->getText('mvElement.title'); ?>" class="dialog">
			<?php require_once 'pages/moveElementForm.php';?>
		</div>	
		
		<div id="dialogInputYoutubeVideo" title="<?php echo $msgs->getText('youTubeVideo.Title'); ?>" class="dialog"> 
			<?php require_once 'pages/youTubeVideoForm.php';?>
		</div>
		
		<div id="dialogShortcuts" title="<?php echo $msgs->getText('roomTemplate.dialogShortcuts.Title'); ?>" class="dialog"> 
			<?php require_once 'pages/dialogShortcuts.php';?>
		</div>
		
		<div id="dialogHelp" title="<?php echo $msgs->getText('roomTemplate.dialogHelp.Title'); ?>" class="dialog"> 
			<?php require_once 'pages/dialogHelp.php';?>
		</div>
		
		<div id="dialogHelpLibras" title="<?php echo $msgs->getText('roomTemplate.dialogHelpLibras.Title'); ?>" class="dialog"> 
			<?php require_once 'pages/dialogHelpLibras.php';?>
		</div>
		
		<div id="dialogHelpAudio" title="<?php echo $msgs->getText('roomTemplate.dialogHelpAudio.Title'); ?>" class="dialog"> 
			<?php require_once 'pages/dialogHelpAudio.php';?>
		</div>
		
		<?php if (isRoomOwner()){?>
		<div id="dialogLoadProduction" title="<?php echo $msgs->getText('roomTemplate.dialogLoadProduction.Title'); ?>" class="dialog"> 
			<?php require_once 'pages/dialogLoadProduction.php';?>
		</div>
		<?php }?>
		<script type="text/javascript">
			checkCookie();
		</script>
	</body>
</html>