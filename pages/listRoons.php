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
	$msgs = Localization::getInstance();

?>

<div class="listRoons">
<?php
	$roons =  $_REQUEST["roons"];
	
	if (count($roons)>0){
			
		foreach ($roons as $room){
			//If the room doesn't belong to the user and it isn't active, nothing will be printed
			if (!($room->getUserId() != $_SESSION['id'] && $room->getActive() == 0)){
				
				// Instantiates the permissions of the room
				$_POST['currentRoom'] = $room->getRoomId();
				
				$action = new ActionMapping();
				$action->setName("listPermissions");
				$action->setType("ListPermissionsAction");
				$action->setRole("");
				
				$listPermissionsAction = new ListPermissionsAction();
				$listPermissionsAction->execute($action);
				
				$permissions = $_REQUEST["permissions"];
				
				// List users
				$action = new ActionMapping();
				$action->setName("listUsers");
				$action->setType("ListUsersAction");
				$action->setRole("");
				
				$listUsersAction = new ListUsersAction();
				$listUsersAction->execute($action);
				
				$listUsers = $_REQUEST['users'];
				
				if (isset($listEnableUsers) || isset($listAllowedUsers)){
					unset($listEnableUsers);
					unset($listAllowedUsers);
				}
				
				// Coloca em um vetor os usuários que ainda não tem permissão na sala corrente
				foreach ($listUsers as $user){
					if ($user->getUserId() != $_SESSION['id']){
						foreach ($permissions as $permission){
							if ($user->getUserId() == $permission->getUserId()){
								$control = TRUE;
							}
						}
						if (!$control){
							$listEnableUsers[] = array("nome" => utf8_encode($user->getName()), "id" => $user->getUserId());
						}
						$control = FALSE;
					}
				}
				
				// Lista usuários que já possuem permissão na sala corrente
				foreach ($permissions as $permission){
					if ($permission->getUserId() != $_SESSION['id']){
						foreach ($listUsers as $user){
							if ($permission->getUserId() == $user->getUserId()){
								$listAllowedUsers[] = array("nome" => utf8_encode($user->getName()), "id" => $user->getUserId());
						
							}
						}
					}
				}
				
				$stringEnableUsers = json_encode($listEnableUsers);
				$stringAllowedUsers = json_encode($listAllowedUsers);
				
				$listEnableUsers2 = str_replace("\"", "\'", $stringEnableUsers);
				$listAllowedUsers2 = str_replace("\"", "\'", $stringAllowedUsers);
								
				foreach ($permissions as $permission){
					if ($permission->getUserId() == $_SESSION['id']){
											
				?>
					
					<form action="wb.php" method="get" style="display:inline">
						<?php 
						//If the room belongs to the current user, the user will start her
						if ($_SESSION['id'] == $room->getUserId())
							{ ?> <input  type="hidden" name="do" value="start" /><?php }
						else
							{ ?> <input  type="hidden" name="do" value="join" /><?php }
						?>
							
						<input  type="hidden" name="idRoom" value="<?php echo $room->getRoomId(); ?>" />
										
						<?php echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$room->getName()."&nbsp;&nbsp;&nbsp;&nbsp;"; ?>
						
						<input  
							class="btnRoom counterNavigationUserPage"
							type="submit"
							type="image"  
							onfocus="showTip('tipEnterRoom', 'btnRoom')" 
							onblur="hideTip('tipEnterRoom')" 
							onmousemove="showTip('tipEnterRoom')" 
							onmouseout="hideTip('tipEnterRoom')" 
							value=""
							alt="<?php echo $msgs->getText('listRoons.enterRoom.description'); ?>"
							onclick="inputSize = getCookie('inputSize'); inputSize = inputSize - 2; setCookie('inputSize',inputSize,30);"
							aria-describedby="tipEnterRoom"
						/>
						<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;";?>
					<?php 		
					// If the room belongs to the current user, the user can select current production
					if ($_SESSION['id'] == $room->getUserId()){
						
						$listProductionsAction = new ListProductionsAction();
						$listProductionsAction->execute($action);
												
						$productions = $_REQUEST["productions"];
					?>
						<select size='1' name='idProduction' id="comboBoxIdProduction" class="counterNavigationUserPage">
							<option selected value='new'><?php echo $msgs->getText('userPage.comboBox.newProcuction'); ?></option>
					<?php
						foreach ($productions as $production){
							echo "<option value=".$production->getProductionId().">".$production->getProductionId()." - ".$production->getCreationDate()."</option>";
						}
					?>
						</select>
					<?php 
					}
					else { 
						echo $msgs->getText('userPage.roomOwner');
						foreach ($listUsers as $user){
							if ($user->getUserId() == $room->getUserId())
								echo $user->getName();
						}
					}
					?>
						
					</form>
					
					<?php 		
						// If the room belongs to the current user, the user can edit
						if ($_SESSION['id'] == $room->getUserId()){
							echo "&nbsp;&nbsp;&nbsp;&nbsp;";
					?>											
						<input  
							class="btnEditRoom counterNavigationUserPage"
							type="submit"
							type="image"  
							onfocus="showTip('tipUptRoom', 'btnEditRoom')" 
							onblur="hideTip('tipUptRoom')"  
							onmousemove="showTip('tipUptRoom')" 
							onmouseout="hideTip('tipUptRoom')" 
							onclick="openUptRoomForm('<?php echo $room->getName(); ?>', '<?php echo $room->getRoomId(); ?>', '<?php echo $listEnableUsers2; ?>', '<?php echo $listAllowedUsers2; ?>'); $('#dialogUpdateRoom').dialog('open'); currentModalWindow='dialogUptRoom';"
							value=""
							alt="<?php echo $msgs->getText('listRoons.editRoom.description'); ?>"
							aria-describedby="tipUptRoom"
						/>								
					<?php
						}		
					}
				}
			}
		}
	}
?>
</div>