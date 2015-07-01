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
?>

<?php 
$msgs = Localization::getInstance(); 
?>

<form action="wb.php?do=updateUser" method="post" name="uptUserForm" onsubmit="return isEmail('uptUserForm', 'textUpdateUserEmail', 'email');">
	
	<div class="updateUser">

		<?php echo $msgs->getText('updateUserForm.whatChange'); ?><br />
		
		<div class="left">
			<input 
				type="checkbox" 
				name="checkEmail"
				class="counterNavigationUptUser"
				onfocus="showTip('tipCheckEmail', 'checkEmail')" 
				onblur="hideTip('tipCheckEmail');"
				onmousemove="showTip('tipCheckEmail')" 
				onmouseout="hideTip('tipCheckEmail')" 
				onclick="showContent('divUptEmail', 'checkEmail');"
				alt="<?php echo $msgs->getText('updateUserForm.checkEmail.description'); ?>"
				aria-describedby="tipCheckEmail"
			/>
			<?php echo $msgs->getText('updateUserForm.opEmail'); ?>
		</div>
		
		<br />
		
		<div id="divUptEmail" style="display:none"><br />
			<div class="line">
				<div class="left">
					<?php echo $msgs->getText('updateUserForm.email'); ?>
				</div>
				<input 
					id="textUpdateUserEmail" 
					type="text" 
					class="input counterNavigationUptUser"
					name="email" 
					onfocus="showTip('tipUpdateUserEmail', 'textUpdateUserEmail')" 
					onblur="hideTip('tipUpdateUserEmail'); hideTip('tipInvalidEmail');" 
					onmousemove="showTip('tipUpdateUserEmail')" 
					onmouseout="hideTip('tipUpdateUserEmail')" 
				    alt="<?php echo $msgs->getText('updateUserForm.email.description'); ?>"
					value="<?php echo $_SESSION['email'];?>"
					maxlength="40"
					aria-describedby="tipUpdateUserEmail"
				/>
				<br />
				<div id="tipInvalidEmail" class="tip">
     	 			<?php echo $msgs->getText('error.wrongEmail'); ?>
				</div>
			</div>
		</div>
		
		<br />
		
		<div class="left">
			<input 
				type="checkbox" 
				class="counterNavigationUptUser"
				name="checkPassword" 
				onfocus="showTip('tipCheckPassword', 'checkPassword')" 
				onblur="hideTip('tipCheckPassword');" 
				onmousemove="showTip('tipCheckPassword')" 
				onmouseout="hideTip('tipCheckPassword')" 
				onclick="showContent('divUptPassword','checkPassword');"
				alt="<?php echo $msgs->getText('updateUserForm.checkPassword.description'); ?>"
				aria-describedby="tipCheckPassword"
			/>
			<?php echo $msgs->getText('updateUserForm.opPassword'); ?>
		</div>	
		
		<br />	
		
		<div id="divUptPassword" style="display:none"><br />
			<div class="line">
				<div class="left">
					<?php echo $msgs->getText('updateUserForm.password'); ?>
				</div>
				<input 
					id="textUpdateUserPassword" 
					type="password" 
					class="input counterNavigationUptUser"
					name="password"
					onfocus="showTip('tipUpdateUserPassword', 'textUpdateUserPassword')" 
					onblur="hideTip('tipUpdateUserPassword')" 
					onmousemove="showTip('tipUpdateUserPassword')" 
					onmouseout="hideTip('tipUpdateUserPassword')" 
				    alt="<?php echo $msgs->getText('updateUserForm.password.description'); ?>"
					maxlength="20"
					aria-describedby="tipUpdateUserPassword"
				/>
			</div>
			<div class="line">
				<div class="left">
					<?php echo $msgs->getText('updateUserForm.confirmPassword'); ?>
				</div>
				<input 
					id="textConfirmUpdateUserPassword" 
					type="password" 
					class="input counterNavigationUptUser"
					name="confirmPassword"
					onfocus="showTip('tipConfirmUpdateUserPassword', 'textConfirmUpdateUserPassword')" 
					onblur="hideTip('tipConfirmUpdateUserPassword')" 
					onmousemove="showTip('tipConfirmUpdateUserPassword')" 
					onmouseout="hideTip('tipConfirmUpdateUserPassword')" 
				    alt="<?php echo $msgs->getText('updateUserForm.confirmPassword.description'); ?>"
					maxlength="20"
					aria-describedby="tipConfirmUpdateUserPassword"
				/>
			</div>
		</div>
				
		<br />
		
		<div class="center">
			<input 
				id="textUpdateUserSubmit"
				class="counterNavigationUptUser"
				type="submit"
				onfocus="showTip('tipUpdateUserSubmit', 'textUpdateUserSubmit')" 
				onblur="hideTip('tipUpdateUserSubmit')"  
				onmousemove="showTip('tipUpdateUserSubmit')" 
				onmouseout="hideTip('tipUpdateUserSubmit')" 
				value="<?php echo $msgs->getText('updateUserForm.submit'); ?>" 
			    alt="<?php echo $msgs->getText('updateUserForm.submit.description'); ?>"
			    aria-describedby="tipUpdateUserSubmit"
			/>
		</div>
		
		<div class="center">
			<div id="tipUpdateUserEmail" class="tip">
		     	 <?php echo $msgs->getText('updateUserForm.email.description'); ?>
			</div>
			<div id="tipUpdateUserPassword" class="tip">
		     	 <?php echo $msgs->getText('updateUserForm.password.description'); ?>
			</div>
			<div id="tipConfirmUpdateUserPassword" class="tip">
		     	 <?php echo $msgs->getText('updateUserForm.confirmPassword.description'); ?>
			</div>
			<div id="tipUpdateUserSubmit" class="tip">
		     	 <?php echo $msgs->getText('updateUserForm.submit.description'); ?>
			</div>
			<div id="tipBtnCloseUptUserForm" class="tip">
		     	 <?php echo $msgs->getText('userPage.btnClose.description'); ?>
			</div>	
			<div id="tipCheckEmail" class="tip">
		     	 <?php echo $msgs->getText('updateUserForm.checkEmail.description'); ?>
			</div>	
			<div id="tipCheckPassword" class="tip">
		     	 <?php echo $msgs->getText('updateUserForm.checkPassword.description'); ?>
			</div>	
		</div>		
	</div>
</form>