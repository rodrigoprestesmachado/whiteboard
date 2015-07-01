<script type="text/javascript">
$(document).ready(function() {
	
	$("#dialogRegister").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 340,
		height: 260,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseRegisterForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseRegisterForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseRegisterForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseRegisterForm');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseRegisterForm");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationRegister");
		},
		close: function() {
			currentModalWindow = null;
		}
	});
	

	$("#dialogUpdateUser").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 390,
		height: 345,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseUptUserForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseUptUserForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseUptUserForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseUptUserForm');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseUptUserForm");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationUptUser");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogNewRoom").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 450,
		height: 480,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseNewRoomForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseNewRoomForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseNewRoomForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseNewRoomForm');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseNewRoomForm");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationCreateRoom");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogUpdateRoom").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 450,
		height: 480,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseUptRoomForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseUptRoomForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseUptRoomForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseUptRoomForm');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseUptRoomForm");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationUptRoom");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogInputYoutubeVideo").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 400,
		height: 225,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseYouTubeVideoForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseYouTubeVideoForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseYouTubeVideoForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseYouTubeVideoForm');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseYouTubeVideoForm");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationYouTube");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogMoveElement").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 520,
		height: 320,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseMoveElementForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseMoveElementForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseMoveElementForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseMoveElementForm');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseMoveElementForm");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationMoveElement");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogInviteFriend").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 450,
		height: 500,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseInviteFriendForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseInviteFriendForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseInviteFriendForm');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseInviteFriendForm');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseInviteFriendForm");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationInviteFriends");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogShortcuts").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 500,
		height: 500,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseShortcuts');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseShortcuts');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseShortcuts');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseShortcuts');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseShortcuts");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationShortcuts");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogHelp").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 500,
		height: 500,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseHelp');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseHelp');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseHelp');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseHelp');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseHelp");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationHelp");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogHelpLibras").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 500,
		height: 500,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseHelpLibras');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseHelpLibras');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseHelpLibras');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseHelpLibras');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseHelpLibras");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationHelpLibras");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogHelpAudio").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 500,
		height: 500,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseHelpAudio');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseHelpAudio');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseHelpAudio');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseHelpAudio');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseHelpAudio");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationHelpAudio");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogLoadProduction").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 350,
		height: 300,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseDialogLoadProduction');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseDialogLoadProduction');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseDialogLoadProduction');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseDialogLoadProduction');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseDialogLoadProduction");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationLoadProduction");
		},
		close: function() {
			currentModalWindow = null;
		}
	});

	$("#dialogRoomCode").dialog({
		modal: true, 
		autoOpen: false, 
		resizable: false,
		width: 300,
		height: 200,
		open: function() {
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusin(function() {
				showTip('tipBtnCloseRoomCode');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').focusout(function() {
				hideTip('tipBtnCloseRoomCode');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseover(function() {
				showTip('tipBtnCloseRoomCode');
		    });
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').mouseout(function() {
				hideTip('tipBtnCloseRoomCode');
		    });

			$('.ui-dialog-titlebar-close').attr("aria-describedby","tipBtnCloseRoomCode");
			$(this).closest('.ui-dialog').find('.ui-dialog-titlebar-close').addClass("counterNavigationCode");
		},
		close: function() {
			currentModalWindow = null;
		}
	});
	
});
</script>