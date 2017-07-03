/* globals jQuery, TYPO3 */
define([
	'jquery',
	'TYPO3/CMS/Sessionplaner/DragDrop',
	'TYPO3/CMS/Backend/Modal'
], function ($, dragDrop, modal) {
	'use strict';

	var Sessionplaner = {
		uiBlock: null,
		stash: null,
		sessionData: {},
		ajaxActive: false
	};

	/**
	 * Returns all url parameter
	 *
	 * @returns {Array}
	 */
	Sessionplaner.getUrlVars = function () {
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for (var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	};

	/**
	 * Needed to get the selected page for the ajax requests
	 *
	 * @param {string} name
	 *
	 * @returns {*}
	 */
	Sessionplaner.getUrlVar = function(name) {
		return Sessionplaner.getUrlVars()[name];
	};

	/**
	 * @param {string} id
	 *
	 * @return {object}
	 */
	Sessionplaner.getTemplateElement = function (id) {
		return $($('#' + id).html().replace(/^\s+|\s+$/g, ''));
	};

	/**
	 * @param {object} serializedData
	 *
	 * @return {object}
	 */
	Sessionplaner.prepareData = function (serializedData) {
		var data = {};

		$.each(serializedData, function(index, fieldNameAndValue) {
			data[fieldNameAndValue.name] = fieldNameAndValue.value;
		});

		return data;
	};

	/**
	 * @param {object} $form
	 * @param {object} sessionData
	 *
	 * @returns {object}
	 */
	Sessionplaner.applySessionValuesToForm = function ($form, sessionData) {
		$.each(sessionData, function(index, value) {
			var $element = $('dd .' + index + ':first', $form);

			if ($element.length > 0) {
				$element.val(value);
			}
		});

		return $form;
	};

	/**
	 * @param {object} $card
	 * @param {object} sessionData
	 *
	 * @return {object}
	 */
	Sessionplaner.applySessionValuesToCard = function ($card, sessionData) {
		$.each(sessionData, function(index, value) {
			var $element = $('.' + index, $card);

			$element.data('value', value);

			if ($element.children().length < 2) {
				$element.text(value);
			}
		});

		return $card;
	};

	/**
	 * @param {object} sessionData
	 * @param {object} $cardParent
	 *
	 * @returns {object}
	 */
	Sessionplaner.addValuesFromParent = function (sessionData, $cardParent) {
		if ($cardParent.attr('id') === 'stash') {
			sessionData.slot = 0;
			sessionData.room = 0;
		} else {
			sessionData.slot = $cardParent.data('slot');
			sessionData.room = $cardParent.data('room');
		}

		return sessionData;
	};

	/**
	 * Create session card
	 *
	 * @param {object} sessionData
	 *
	 * @return {object}
	 */
	Sessionplaner.createSessionCard = function (sessionData) {
		var $card = Sessionplaner.getTemplateElement('sessionCardTemplate');

		$card = Sessionplaner.applySessionValuesToCard($card, sessionData);

		return $card;
	};

	/**
	 * @param {object} sessionData
	 *
	 * @return void
	 */
	Sessionplaner.updateSessionCard = function (sessionData) {
		var $card = $('.uid[data-value="' + sessionData.uid + '"]', '.t3js-page-ce').parent();

		Sessionplaner.applySessionValuesToCard($card, sessionData);
	};

	/**
	 * @param {object} card
	 *
	 * @returns object
	 */
	Sessionplaner.getDataFromCard = function (card) {
		var data = {};

		$(card).children().children().each(function() {
			var $element = $(this);
			data[$element.data('name')] = $element.data('value');
		});

		return data;
	};


	/**
	 * @param {object} response
	 *
	 * @return void
	 */
	Sessionplaner.createSessionSuccess = function (response) {
		Sessionplaner.sessionData.uid = response.data.uid;

		var $card = Sessionplaner.createSessionCard(Sessionplaner.sessionData);
		Sessionplaner.stash.append($card);

		Sessionplaner.initializeSessionCard($card);
	};

	/**
	 * @return void
	 */
	Sessionplaner.updateSessionSuccess = function () {
		Sessionplaner.updateSessionCard(Sessionplaner.sessionData);
	};

	/**
	 * @return void
	 */
	Sessionplaner.movedSessionSuccess = function () {
	};


	/**
	 * @return {boolean}
	 */
	Sessionplaner.beforeSend = function () {
		var result = true;

		if (!Sessionplaner.ajaxActive) {
			Sessionplaner.ajaxActive = true;

			Sessionplaner.uiBlock.removeClass('hidden');
		} else {
			result = false;
		}

		return result;
	};

	/**
	 * @return void
	 */
	Sessionplaner.afterSend = function () {
		Sessionplaner.uiBlock.addClass('hidden');

		Sessionplaner.ajaxActive = false;
	};


	/**
	 * @retrn void
	 */
	Sessionplaner.createSession = function (e) {
		var createdSessionData = Sessionplaner.prepareData($('form', e.target).serializeArray());
		Sessionplaner.sessionData = createdSessionData;

		$.ajax({
			type: 'POST',
			url: TYPO3.settings.ajaxUrls['evoweb_sessionplaner_edit'],
			context: this,
			params: {},
			data: {
				id: Sessionplaner.getUrlVar('id'),
				tx_sessionplaner: {
					action: 'addSession',
					session: createdSessionData
				}
			},
			beforeSend: Sessionplaner.beforeSend,
			complete: Sessionplaner.afterSend,
			success: Sessionplaner.createSessionSuccess
		});
	};

	/**
	 * @return void
	 */
	Sessionplaner.updateSession = function (e) {
		var updateSessionData = Sessionplaner.prepareData($('form', e.target).serializeArray());
		updateSessionData.uid = Sessionplaner.sessionData.uid;
		Sessionplaner.sessionData = updateSessionData;

		$.ajax({
			type: 'POST',
			url: TYPO3.settings.ajaxUrls['evoweb_sessionplaner_edit'],
			context: this,
			params: {},
			data: {
				id: Sessionplaner.getUrlVar('id'),
				tx_sessionplaner: {
					action: 'updateSession',
					session: updateSessionData
				}
			},
			beforeSend: Sessionplaner.beforeSend,
			complete: Sessionplaner.afterSend,
			success: Sessionplaner.updateSessionSuccess
		});
	};

	/**
	 * @param {object} $movedElement
	 * @param {object} $droppedOnElement
	 *
	 * @return void
	 */
	Sessionplaner.movedSession = function ($movedElement, $droppedOnElement) {
		var movedSessionData = Sessionplaner.getDataFromCard($movedElement);
		movedSessionData = Sessionplaner.addValuesFromParent(movedSessionData, $droppedOnElement);
		Sessionplaner.sessionData = movedSessionData;

		$.ajax({
			type: 'POST',
			url: TYPO3.settings.ajaxUrls['evoweb_sessionplaner_edit'],
			context: this,
			params: {},
			data: {
				id: Sessionplaner.getUrlVar('id'),
				tx_sessionplaner: {
					action: 'updateSession',
					session: movedSessionData
				}
			},
			beforeSend: Sessionplaner.beforeSend,
			complete: Sessionplaner.afterSend,
			success: Sessionplaner.movedSessionSuccess
		});
	};


	/**
	 * @return void
	 */
	Sessionplaner.createNewSessionForm = function () {
		var $newSession = Sessionplaner.getTemplateElement('sessionFormTemplate');
		var t = (opener !== null && typeof opener.top.TYPO3 !== 'undefined' ? opener.top : top);
		modal.confirm(
			t.TYPO3.lang['alert'] || 'Alert',
			$newSession,
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
			modal.dismiss();
		}).on('confirm.button.ok', Sessionplaner.createSession);
	};

	/**
	 * @return void
	 */
	Sessionplaner.editSessionForm = function () {
		Sessionplaner.sessionData = Sessionplaner.getDataFromCard(this);

		var $editSession = Sessionplaner.applySessionValuesToForm(
			Sessionplaner.getTemplateElement('sessionFormTemplate'),
			Sessionplaner.sessionData
		);
		var t = (opener !== null && typeof opener.top.TYPO3 !== 'undefined' ? opener.top : top);
		modal.confirm(
			t.TYPO3.lang['alert'] || 'Alert',
			$editSession,
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
			modal.dismiss();
		}).on('confirm.button.ok', Sessionplaner.updateSession);
	};


	/**
	 * Hook into drop stop to store moving the session
	 *
	 * @return void
	 */
	Sessionplaner.initializeDragAndDrop = function () {
		var originalDrop = dragDrop.onDrop;
		dragDrop.onDrop = function($draggableElement, $droppableElement, event) {
			Sessionplaner.movedSession($draggableElement, $droppableElement);
			originalDrop($draggableElement, $droppableElement, event);
		}
	};

	/**
	 * @param {object} $card
	 *
	 * @return void
	 */
	Sessionplaner.initializeSessionCard = function ($card) {
		if ($card === null) {
			$card = $('.t3js-page-ce');
		}

		$card
			.disableSelection()
			.draggable({
				scope: 'sessions',
				connectToSortable: '#stash',
				snap: true,
				revert: 'invalid'
			});
	};

	/**
	 * @return void
	 */
	Sessionplaner.initialize = function () {
		Sessionplaner.uiBlock = $('#t3js-ui-block');
		Sessionplaner.stash = $('#stash');

		$(document)
			.on('click', '#actions-document-new', Sessionplaner.createNewSessionForm)
			.on('dblclick', '.t3js-page-ce', Sessionplaner.editSessionForm);

		Sessionplaner.initializeDragAndDrop();
		Sessionplaner.initializeSessionCard(null);
	};

	$(Sessionplaner.initialize);
	return Sessionplaner;
});