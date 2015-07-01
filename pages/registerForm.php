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
	 * limitationsborder: 10px dotted #29C3FF; under the License.
	 */
?>

<?php $msgs = Localization::getInstance(); ?>

<form action="wb.php?do=register" method="post" name="registerForm" onsubmit="return isEmail('registerForm', 'textNewUserEmail', 'emailNewUser');">
	
	<div class="registerForm">
			
		<div class="line">
			<div class="left">
				<?php echo $msgs->getText('registerForm.name'); ?>
			</div>			
			<input 
				id="textNewUserName" 
				type="text" 
				class="input counterNavigationRegister"
				name="nameNewUser" 
				onfocus="showTip('tipNewUserName', 'textNewUserName')" 
				onblur="hideTip('tipNewUserName')" 
				onmousemove="showTip('tipNewUserName')" 
				onmouseout="hideTip('tipNewUserName')" 
			    alt="<?php echo $msgs->getText('registerForm.name.description'); ?>"
				maxlength="45"
				aria-describedby="tipNewUserName"
			/>		
		</div>
		
		<div class="line">
			<div class="left">
				<?php echo $msgs->getText('registerForm.email'); ?>
			</div>
			<input 
				id="textNewUserEmail" 
				type="text" 
				class="input counterNavigationRegister"
				name="emailNewUser" 
				onfocus="showTip('tipNewUserEmail', 'textNewUserEmail')" 
				onblur="hideTip('tipNewUserEmail')" 
				onmousemove="showTip('tipNewUserEmail')" 
				onmouseout="hideTip('tipNewUserEmail')" 
			    alt="<?php echo $msgs->getText('registerForm.email.description'); ?>"
				maxlength="40"
				aria-describedby="tipNewUserEmail"
			/>
		</div>
		
		<div id="tipInvalidEmail" style="display:none;">
			<?php echo $msgs->getText('error.wrongEmail'); ?>
		</div>
		
		<div class="line">
			<div class="left">
				<?php echo $msgs->getText('registerForm.password'); ?>
			</div>
			<input 
				id="textNewUserPassword" 
				type="password" 
				class="input counterNavigationRegister"
				name="passwordNewUser"
				onfocus="showTip('tipNewUserPassword', 'textNewUserPassword')" 
				onblur="hideTip('tipNewUserPassword')" 
				onmousemove="showTip('tipNewUserPassword')" 
				onmouseout="hideTip('tipNewUserPassword')" 
			    alt="<?php echo $msgs->getText('registerForm.password.description'); ?>"
				maxlength="20"
				aria-describedby="tipNewUserPassword"
			/>
		</div>
		
		<div class="line">
			<div class="left">
				<?php echo $msgs->getText('registerForm.confirmPassword'); ?>
			</div>
			<input 
				id="textConfirmNewUserPassword" 
				type="password" 
				class="input counterNavigationRegister"
				name="confirmPasswordNewUser"
				onfocus="showTip('tipConfirmNewUserPassword', 'textConfirmNewUserPassword')" 
				onblur="hideTip('tipConfirmNewUserPassword')" 
				onmousemove="showTip('tipConfirmNewUserPassword')" 
				onmouseout="hideTip('tipConfirmNewUserPassword')" 
			    alt="<?php echo $msgs->getText('registerForm.confirmPassword.description'); ?>"
				maxlength="20"
				aria-describedby="tipConfirmNewUserPassword"
			/>
		</div>
		
		<div class="line">
			<font size="2"><?php echo $msgs->getText('userPage.requiredField');?></font>
		</div>
		
		<div class="center">
			<input 
				id="textNewUserSubmit"
				type="submit"
				class="counterNavigationRegister"
				onfocus="showTip('tipNewUserSubmit', 'textNewUserSubmit')" 
				onblur="hideTip('tipNewUserSubmit')"  
				onmousemove="showTip('tipNewUserSubmit')" 
				onmouseout="hideTip('tipNewUserSubmit')" 
				value="<?php echo $msgs->getText('registerForm.submit'); ?>" 
			    alt="<?php echo $msgs->getText('registerForm.submit.description'); ?>"
			    aria-describedby="tipNewUserSubmit"
			/>
		</div>
	

		<div class="center">		
			<div id="tipNewUserName" class="tip">
		     	 <?php echo $msgs->getText('registerForm.name.description'); ?>
			</div>
			<div id="tipNewUserEmail" class="tip">
		     	 <?php echo $msgs->getText('registerForm.email.description'); ?>
			</div>
			<div id="tipNewUserPassword" class="tip">
		     	 <?php echo $msgs->getText('registerForm.password.description'); ?>
			</div>
			<div id="tipConfirmNewUserPassword" class="tip">
		     	 <?php echo $msgs->getText('registerForm.confirmPassword.description'); ?>
			</div>
			<div id="tipNewUserSubmit" class="tip">
		     	 <?php echo $msgs->getText('registerForm.submit.description'); ?>
			</div>
			<div id="tipBtnCloseRegisterForm" class="tip">
		     	 <?php echo $msgs->getText('userPage.btnClose.description'); ?>
			</div>	
		</div>
	</div>
</form>