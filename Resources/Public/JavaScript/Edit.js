/* globals jQuery, parseInt */
define([
	'jquery',
	'TYPO3/CMS/Sessionplaner/DragDrop',
	'TYPO3/CMS/Backend/Modal',
	'TYPO3/CMS/Backend/Severity'
], function ($, dragDrop, modal, Severity) {
	'use strict';

	function Sessionplaner() {
		this.uiBlock = null;
		this.stash = null;
		this.sessionData = {};
		this.ajaxActive = false;

		this.initialize();
	}

	/**
	 * Returns all url parameter
	 *
	 * @returns {Array}
	 */
	Sessionplaner.prototype.getUrlVars = function () {
		let vars = [],
			hash,
			hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

		for (let i = 0; i < hashes.length; i++) {
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
	Sessionplaner.prototype.getUrlVar = function(name) {
		return this.getUrlVars()[name];
	};

	/**
	 * @param {string} id
	 *
	 * @return {object}
	 */
	Sessionplaner.prototype.getTemplateElement = function (id) {
		return $($('#' + id).html().replace(/^\s+|\s+$/g, ''));
	};

	/**
	 * @param {object} serializedData
	 *
	 * @return {object}
	 */
	Sessionplaner.prototype.prepareData = function (serializedData) {
		let data = {};

		$.each(serializedData, function(index, fieldNameAndValue) {
			if (fieldNameAndValue.name === 'attendees'
				|| fieldNameAndValue.name === 'type'
				|| fieldNameAndValue.name === 'level'
				|| fieldNameAndValue.name === 'day'
				|| fieldNameAndValue.name === 'room'
				|| fieldNameAndValue.name === 'slot'
			) {
				fieldNameAndValue.value = parseInt(fieldNameAndValue.value) || 0;
			}
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
	Sessionplaner.prototype.applySessionValuesToForm = function ($form, sessionData) {
		$.each(sessionData, function(index, value) {
			let $element = $('dd .' + index + ':first', $form);

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
	Sessionplaner.prototype.applySessionValuesToCard = function ($card, sessionData) {
		let $sessionCard = $card.find('.t3-page-ce-body-inner');

		$.each(sessionData, function(index, value) {
			$('.' + index, $sessionCard)
				.data('value', value)
				.text(value);
		});

		return $card;
	};

	/**
	 * @param {object} sessionData
	 * @param {object} $cardParent
	 *
	 * @returns {object}
	 */
	Sessionplaner.prototype.addValuesFromParent = function (sessionData, $cardParent) {
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
	Sessionplaner.prototype.createSessionCard = function (sessionData) {
		let $card = this.getTemplateElement('sessionCardTemplate');

		return this.applySessionValuesToCard($card, sessionData);
	};

	/**
	 * @param {object} sessionData
	 */
	Sessionplaner.prototype.updateSessionCard = function (sessionData) {
		let $card = $('.uid[data-value="' + sessionData.uid + '"]', '.t3js-page-ce').parents('.t3js-page-ce');

		this.applySessionValuesToCard($card, sessionData);
	};

	/**
	 * @param {object} card
	 *
	 * @returns {object}
	 */
	Sessionplaner.prototype.getDataFromCard = function (card) {
		let $sessionCard = $(card).find('.t3-page-ce-body-inner'),
			data = {};

		$sessionCard.find('.property').each(function() {
			let $element = $(this);
			data[$element.data('name')] = $element.data('value');
		});

		return data;
	};


	/**
	 * @param {object} response
	 */
	Sessionplaner.prototype.createSessionSuccess = function (response) {
		this.sessionData.uid = response.data.uid;

		let $card = this.createSessionCard(this.sessionData);
		this.stash.prepend($card);

		dragDrop.initializeDraggable($card);
	};

	Sessionplaner.prototype.updateSessionSuccess = function () {
		this.updateSessionCard(this.sessionData);
	};

	Sessionplaner.prototype.movedSessionSuccess = function () {
	};

	Sessionplaner.prototype.deleteSessionSuccess = function () {
		$(this).parents('.t3-page-ce').remove();
	};


	/**
	 * @return {boolean}
	 */
	Sessionplaner.prototype.beforeSend = function () {
		let result = true;

		if (!this.ajaxActive) {
			this.ajaxActive = true;

			this.uiBlock.removeClass('hidden');
		} else {
			result = false;
		}

		return result;
	};

	Sessionplaner.prototype.afterSend = function () {
		this.uiBlock.addClass('hidden');

		this.ajaxActive = false;
	};

	Sessionplaner.prototype.sendAjaxRequest = function (ajaxUrlKey, sessionData, cb) {
		let self = this;

		$.ajax(TYPO3.settings.ajaxUrls[ajaxUrlKey], {
			method: 'post',
			beforeSend: self.beforeSend,
			complete: self.afterSend,
			data: {
				id: self.getUrlVar('id'),
				tx_sessionplaner: {
					session: sessionData
				}
			}
		}).done(cb);
	};

	/**
	 * @param {object} event
	 */
	Sessionplaner.prototype.createSession = function (event) {
		this.sessionData = this.prepareData($('form', event.target).serializeArray());

		this.sendAjaxRequest(
			'evoweb_sessionplaner_create',
			this.sessionData,
			function (data) {
				this.createSessionSuccess(data);
			}
		);
	};

	/**
	 * @param {object} event
	 */
	Sessionplaner.prototype.updateSession = function (event) {
		let updateSessionData = this.prepareData($('form', event.target).serializeArray());
		updateSessionData.uid = this.sessionData.uid;
		this.sessionData = updateSessionData;

		this.sendAjaxRequest(
			'evoweb_sessionplaner_update',
			this.sessionData,
			function (data) {
				this.updateSessionSuccess(data);
			}
		);
	};

	/**
	 * @param {object} element
	 * @param {object} event
	 */
	Sessionplaner.prototype.deleteSession = function (element, event) {
		event.preventDefault();
		let uid = $(element).parents('.t3-page-ce').find('.uid').data('value');

		this.sendAjaxRequest(
			'evoweb_sessionplaner_delete',
			{ uid: uid },
			function (data) {
				this.deleteSessionSuccess(data);
			}
		);
	};

	/**
	 * @param {object} $movedElement
	 * @param {object} $droppedOnElement
	 */
	Sessionplaner.prototype.movedSession = function ($movedElement, $droppedOnElement) {
		let movedSessionData = this.getDataFromCard($movedElement);
		this.sessionData = this.addValuesFromParent(movedSessionData, $droppedOnElement);

		this.sendAjaxRequest(
			'evoweb_sessionplaner_update',
			this.sessionData,
			function (data) {
				this.movedSessionSuccess(data);
			}
		);
	};

	Sessionplaner.prototype.createNewSessionForm = function () {
		let self = this,
			$newSession = this.getTemplateElement('sessionFormTemplate');

		modal.confirm(
			'Create session',
			$newSession,
			Severity.ok,
			[
				{
					text: 'Create session',
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
		}).on('confirm.button.ok', function (event) { self.createSession(event); });
	};

	Sessionplaner.prototype.createNewSessionFormInGrid = function () {
		let self = this,
			$newSession = this.getTemplateElement('sessionFormTemplate');

		modal.confirm(
			'Create session',
			$newSession,
			Severity.ok,
			[
				{
					text: 'Create session',
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
		}).on('confirm.button.ok', function (event) { self.createSession(event); });
	};

	Sessionplaner.prototype.editSessionForm = function (element) {
		this.sessionData = this.getDataFromCard(element);

		let $editSession = this.applySessionValuesToForm(
			this.getTemplateElement('sessionFormTemplate'),
			this.sessionData
		);

		modal.confirm(
			'Edit session',
			$editSession,
			Severity.ok,
			[
				{
					text: 'Update session',
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
		}).on('confirm.button.ok', function () { this.updateSession(); });
	};

	Sessionplaner.prototype.moveNewButton = function (element) {

	};

	/**
	 * Hook into drop stop to store moving the session
	 */
	Sessionplaner.prototype.initializeDragAndDrop = function () {
		let self = this,
			originalDrop = dragDrop.onDrop;

		dragDrop.onDrop = function($draggableElement, $dropAbleElement, event) {
			self.movedSession($draggableElement, $dropAbleElement);
			originalDrop($draggableElement, $dropAbleElement, event);
		}
	};

	Sessionplaner.prototype.initialize = function () {
		let self = this;

		this.uiBlock = $('#t3js-ui-block');
		this.stash = $('#stash');

		$(document)
			.on('click', '#actions-document-new', function () { self.createNewSessionForm(); })
			.on('click', '#actions-document-new-in-grid', function () { self.createNewSessionFormInGrid(); })
			.on('click', '.icon-actions-edit-delete', function (event) { self.deleteSession(this, event); })
			.on('dblclick', '.t3js-page-ce', function () { self.editSessionForm(this); })
			.on('mouseover', '', function () { self.moveNewButton(this); })
			.on('mouseout', '', function () { self.moveNewButton(this); });

		this.initializeDragAndDrop();
	};

	return new Sessionplaner();
});
