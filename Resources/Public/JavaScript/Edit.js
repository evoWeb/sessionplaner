define([
	'jquery',
	'jquery-ui/droppable',
	'TYPO3/CMS/Backend/Modal'
], function ($) {
	'use strict';

	$.extend({
		getUrlVars: function() {
			var vars = [], hash;
			var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			for (var i = 0; i < hashes.length; i++) {
				hash = hashes[i].split('=');
				vars.push(hash[0]);
				vars[hash[0]] = hash[1];
			}
			return vars;
		},

		getUrlVar: function(name) {
			return this.getUrlVars()[name];
		}
	});

	var $newSession,
		$editSession,
		$stash,
		$mask,
		sessionData = {},
		ajaxActive = false;

	/**
	 *
	 * @param id string
	 * @return element
	 */
	function getTemplateElement(id) {
		return $($('#' + id).html().replace(/^\s+|\s+$/g, ''));
	}

	/**
	 * @param serializedData
	 * @return object
	 */
	function prepareData(serializedData) {
		var data = {};

		$.each(serializedData, function(index, fieldNameAndValue) {
			data[fieldNameAndValue.name] = fieldNameAndValue.value;
		});

		return data;
	}

	/**
	 * @param $form element
	 * @param sessionData object
	 * @returns element
	 */
	function applySessionValuesToForm($form, sessionData) {
		$.each(sessionData, function(index, value) {
			var $element = $('dd .' + index + ':first', $form);

			if ($element.length > 0) {
				$element.val(value);
			}
		});

		return $form;
	}

	/**
	 * @param $card element
	 * @param sessionData object
	 * @return element
	 */
	function applySessionValuesToCard($card, sessionData) {
		$.each(sessionData, function(index, value) {
			var $element = $('.' + index, $card);

			$element.data('value', value);

			if ($element.children().length < 2) {
				$element.text(value);
			}
		});

		return $card;
	}

	/**
	 * @param sessionData object
	 * @param card element
	 * @returns object
	 */
	function addValuesFromParent(sessionData, card) {
		var cardParent = $(card).parent();

		if (cardParent.attr('id') === 'stash') {
			sessionData.slot = 0;
			sessionData.room = 0;
		} else {
			sessionData.slot = cardParent.data('slot');
			sessionData.room = cardParent.data('room');
		}

		return sessionData;
	}

	/**
	 * Create session card
	 *
	 * @param sessionData
	 * @return element
	 */
	function createSessionCard(sessionData) {
		var $card = getTemplateElement('sessionCardTemplate');

		$card = applySessionValuesToCard($card, sessionData);

		return $card;
	}

	/**
	 * @param sessionData
	 * @return void
	 */
	function updateSessionCard(sessionData) {
		var $card = $('.uid[data-value="' + sessionData.uid + '"]', '.sessionCard').parent();

		applySessionValuesToCard($card, sessionData);
	}

	/**
	 * @param $dialog element
	 * @return void
	 */
	function closeModal($dialog) {
		$dialog.dialog('close').remove();
	}

	/**
	 * @param card element
	 * @returns object
	 */
	function getDataFromCard(card) {
		var data = {};

		$(card).children().each(function() {
			var $element = $(this);
			data[$element.attr('class')] = $element.data('value');
		});

		return data;
	}


	/**
	 * @param response object
	 * @return void
	 */
	function createSessionSuccess(response) {
		sessionData.uid = response.data.uid;

		var $card = createSessionCard(sessionData);
		$stash.append($card);

		initializeSessionCard($card);
		closeModal($newSession);
	}

	/**
	 * @return void
	 */
	function updateSessionSuccess() {
		updateSessionCard(sessionData);

		closeModal.apply($(this));
	}

	/**
	 * @return void
	 */
	function movedSessionSuccess() {
	}


	/**
	 * @return boolean
	 */
	function beforeSend() {
		var result = true;

		if (!ajaxActive) {
			ajaxActive = true;

			$mask = $('<div class="t3-mask-loading"><div class="ext-el-mask"></div></div>');
			$mask.appendTo(document.body);
		} else {
			result = false;
		}

		return result;
	}

	/**
	 * @return void
	 */
	function afterSend() {
		ajaxActive = false;

		if (typeof($mask) === 'object') {
			$mask.remove();
		}
	}


	/**
	 * @retrn void
	 */
	function createSession(e) {
		var createdSessionData = prepareData($('form', e.target).serializeArray());
		sessionData = createdSessionData;

		$.ajax({
			type: 'POST',
			url: TYPO3.settings.ajaxUrls['evoweb_sessionplaner_edit'],
			context: this,
			params: {},
			data: {
				id: $.getUrlVar('id'),
				tx_sessionplaner: {
					action: 'addSession',
					session: createdSessionData
				}
			},
			beforeSend: beforeSend,
			complete: afterSend,
			success: createSessionSuccess
		});
	}

	/**
	 * @return void
	 */
	function updateSession() {
		var editSessionData = prepareData($('form', $editSession).serializeArray());
		editSessionData.uid = sessionData.uid;
		sessionData = editSessionData;

		$.ajax({
			type: 'POST',
			url: TYPO3.settings.ajaxUrls['evoweb_sessionplaner_edit'],
			context: this,
			params: {},
			data: {
				id: $.getUrlVar('id'),
				tx_sessionplaner: {
					action: 'updateSession',
					session: editSessionData
				}
			},
			beforeSend: beforeSend,
			complete: afterSend,
			success: updateSessionSuccess
		});
	}

	/**
	 * @return void
	 */
	function movedSession() {
		var movedSessionData = getDataFromCard(this);
		movedSessionData = addValuesFromParent(movedSessionData, this);
		sessionData = movedSessionData;

		$.ajax({
			type: 'POST',
			url: TYPO3.settings.ajaxUrls['evoweb_sessionplaner_edit'],
			context: this,
			params: {},
			data: {
				id: $.getUrlVar('id'),
				tx_sessionplaner: {
					action: 'updateSession',
					session: movedSessionData
				}
			},
			beforeSend: beforeSend,
			complete: afterSend,
			success: movedSessionSuccess
		});
	}


	/**
	 * @return void
	 */
	function createNewSessionForm() {
		$newSession = getTemplateElement('session');
		var t = (opener !== null && typeof opener.top.TYPO3 !== 'undefined' ? opener.top : top);
		t.TYPO3.Modal.confirm(
			t.TYPO3.lang['alert'] || 'Alert',
			$newSession.html(),
			t.TYPO3.Severity.ok,
			[
				{
					text: 'Create a session',
					active: true,
					btnClass: 'btn-default',
					name: 'ok'
				},
				{
					text: 'Cancel',
					active: true,
					btnClass: 'btn-default',
					name: 'cancel'
				}
			]
		).on('button.clicked', function() {
			t.TYPO3.Modal.dismiss();
		}).on('confirm.button.ok', createSession);
	}

	/**
	 * @return void
	 */
	function editSessionForm() {
		sessionData = getDataFromCard(this);

		$editSession = applySessionValuesToForm(getTemplateElement('session'), sessionData);
		$editSession.dialog({
			width: 440,
			height: 330,
			modal: true,
			buttons: {
				'Update session': updateSession,
				Cancel: function() { closeModal($editSession); }
			}
		});
	}

	/**
	 * @return void
	 */
	function initializeDragAndDrop() {
		$('#stash, .active td.room')
			.droppable({
				scope: 'sessions',
				drop: function(event, ui) {
					$(ui.draggable).css({ top: 0, left: 0 }).appendTo($(this));
					movedSession.apply(ui.draggable[0]);
				}
			});
	}

	function initializeSessionCard($card) {
		if (typeof $card === 'undefined') {
			$card = $('.sessionCard');
		}

		$card
			.disableSelection()
			.draggable({
				scope: 'sessions',
				connectToSortable: '#stash',
				snap: true,
				revert: 'invalid'
			});
	}

	$(document).ready(function() {
		$stash = $('#stash');
		$('#actions-document-new').click(createNewSessionForm);
		$(document).on('dblclick', '.sessionCard', editSessionForm);

		initializeDragAndDrop();
		initializeSessionCard();
	});
});