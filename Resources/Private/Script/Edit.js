/* globals jQuery, parseInt */
define([
    'jquery',
    'TYPO3/CMS/Sessionplaner/DragDrop',
    'TYPO3/CMS/Backend/Modal',
    'TYPO3/CMS/Backend/Severity'
], function ($, dragDrop, modal, Severity) {
    'use strict';

    function Sessionplaner() {
        this.pageId = 0;
        this.uiBlock = null;
        this.stash = null;
        this.gridButtonGroup = null;
        this.gridNewSessionButton = null;
        this.sessionData = {};
        this.ajaxActive = false;
        this.dragActive = false;
        this.initialize();
    }

    Sessionplaner.prototype.setPageId = function (pageId) {
        this.pageId = pageId;
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

        $.each(serializedData, function (index, fieldNameAndValue) {
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
        $.each(sessionData, function (index, value) {
            let $element = $('#session-form-' + index + ':first', $form);
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

        $.each(sessionData, function (index, value) {
            $('.' + index, $sessionCard)
                .attr('data-value', value)
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
        $sessionCard.find('.property').each(function () {
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
        if (this.sessionData.room && this.sessionData.slot) {
            $('[data-room="' + this.sessionData.room + '"][data-slot="' + this.sessionData.slot + '"]').prepend($card);
        } else {
            this.stash.prepend($card);
        }
        dragDrop.initializeDraggable($card);
    };

    Sessionplaner.prototype.updateSessionSuccess = function () {
        this.updateSessionCard(this.sessionData);
    };

    Sessionplaner.prototype.movedSessionSuccess = function () {
    };

    Sessionplaner.prototype.deleteSessionSuccess = function () {
        let self = this;

        $('[data-name="uid"]').each(function () {
            let $element = $(this);
            if (parseInt($element.data('value')) === self.sessionData.uid) {
                $element.parents('.t3-page-ce').remove();
            }
        });
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

    Sessionplaner.prototype.sendAjaxRequest = function (ajaxUrlKey, sessionData, doneCallback) {
        let self = this;

        $.ajax(TYPO3.settings.ajaxUrls[ajaxUrlKey], {
            method: 'post',
            beforeSend: function () {
                self.beforeSend();
            },
            complete: function () {
                self.afterSend();
            },
            data: {
                id: self.pageId,
                tx_sessionplaner: {
                    session: sessionData
                }
            }
        }).done(doneCallback);
    };

    /**
     * @param {object} event
     */
    Sessionplaner.prototype.createSession = function (event) {
        let self = this;
        let sessionData = this.prepareData($('form', event.target).serializeArray())

        this.sessionData = sessionData;
        this.sendAjaxRequest(
            'evoweb_sessionplaner_create',
            this.sessionData,
            function (data) {
                if (data.status !== 'error') {
                    self.createSessionSuccess(data);
                } else {
                    self.createNewSessionForm(sessionData);
                }
            }
        );
    };

    /**
     * @param {object} event
     */
    Sessionplaner.prototype.updateSession = function (event) {
        let self = this;
        let updateSessionData = this.prepareData($('form', event.target).serializeArray());
        updateSessionData.uid = this.sessionData.uid;

        this.sessionData = updateSessionData;
        this.sendAjaxRequest(
            'evoweb_sessionplaner_update',
            this.sessionData,
            function (data) {
                if (data.status !== 'error') {
                    self.updateSessionSuccess(data);
                } else {
                    self.editSession(updateSessionData);
                }
            }
        );
    };

    /**
     * @param {object} element
     */
    Sessionplaner.prototype.deleteSession = function (element) {
        let self = this;

        this.sessionData = { uid: $(element).parents('.t3-page-ce').find('.uid').data('value') };
        this.sendAjaxRequest(
            'evoweb_sessionplaner_delete',
            this.sessionData,
            function (data) {
                self.deleteSessionSuccess(data);
            }
        );
    };

    /**
     * @param {object} $movedElement
     * @param {object} $droppedOnElement
     */
    Sessionplaner.prototype.movedSession = function ($movedElement, $droppedOnElement) {
        let self = this,
            movedSessionData = this.getDataFromCard($movedElement);

        this.sessionData = this.addValuesFromParent(movedSessionData, $droppedOnElement);
        this.sendAjaxRequest(
            'evoweb_sessionplaner_update',
            this.sessionData,
            function (data) {
                self.movedSessionSuccess(data);
            }
        );
    };


    Sessionplaner.prototype.createNewSessionForm = function (sessionData) {
        let self = this;
        this.sessionData = sessionData || {};

        modal.confirm(
            'Create session',
            this.applySessionValuesToForm(
                this.getTemplateElement('sessionFormTemplate'),
                this.sessionData
            ),
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
        ).on('button.clicked', function () {
            modal.dismiss();
        }).on('confirm.button.ok', function (event) {
            self.createSession(event);
        });
    };

    Sessionplaner.prototype.createNewSessionFormInGrid = function () {
        let self = this;

        modal.confirm(
            'Create session',
            this.applySessionValuesToForm(
                this.getTemplateElement('sessionFormTemplate'),
                this.sessionData
            ),
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
        ).on('button.clicked', function () {
            modal.dismiss();
        }).on('confirm.button.ok', function (event) {
            self.createSession(event);
        });
    };

    Sessionplaner.prototype.editSession = function (sessionData) {
        let self = this;
        this.sessionData = sessionData;

        modal.confirm(
            'Edit session',
            this.applySessionValuesToForm(
                this.getTemplateElement('sessionFormTemplate'),
                this.sessionData
            ),
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
        ).on('button.clicked', function () {
            modal.dismiss();
        }).on('confirm.button.ok', function (event) {
            self.updateSession(event);
        });
    };

    Sessionplaner.prototype.mouseOver = function (element) {
        let $element = $(element);
        this.sessionData = {
            room: $element.data('room'),
            slot: $element.data('slot')
        };
        if (!this.dragActive && $element.children().length === 0) {
            this.gridNewSessionButton.appendTo($element);
        }
    };

    Sessionplaner.prototype.mouseOut = function (element, event) {
        let e = event.toElement || event.relatedTarget;
        if (e === null
            || e === element
            || e.parentNode === element
            || e.parentNode.parentNode === element
            || e.parentNode.parentNode.parentNode === element
            || e.parentNode.parentNode.parentNode.parentNode === element) {
            return;
        }
        this.gridNewSessionButton.appendTo(this.gridButtonGroup);
    };

    /**
     * Hook into drop stop to store moving the session
     */
    Sessionplaner.prototype.initializeDragAndDrop = function () {
        let self = this,
            originalDragStart = dragDrop.onDragStart,
            originalDrop = dragDrop.onDrop;

        dragDrop.onDragStart = function ($draggableElement) {
            self.dragActive = true;
            originalDragStart($draggableElement);
        };

        dragDrop.onDrop = function ($draggableElement, $dropAbleElement, event) {
            self.movedSession($draggableElement, $dropAbleElement);
            originalDrop($draggableElement, $dropAbleElement, event);
            self.dragActive = false;
        }
    };

    Sessionplaner.prototype.initialize = function () {
        let self = this;

        this.uiBlock = $('#t3js-ui-block');
        this.stash = $('#stash');
        this.gridButtonGroup = $('#gridButtonGroup');
        this.gridNewSessionButton = this.gridButtonGroup.find('#actions-document-new-in-grid');

        $(document)
            .on('click', '#actions-document-new', function () {
                self.createNewSessionForm();
            })
            .on('click', '#actions-document-new-in-grid', function () {
                self.createNewSessionFormInGrid();
            })
            .on('click', '.icon-actions-edit-delete', function () {
                self.deleteSession(this);
            })
            .on('dblclick', '.t3js-page-ce', function () {
                self.editSession(self.getDataFromCard(this));
            })
            .on('mouseover', '.t3js-grid-cell', function () {
                self.mouseOver(this);
            })
            .on('mouseout', '.t3js-grid-cell', function (event) {
                self.mouseOut(this, event);
            });

        this.initializeDragAndDrop();
    };

    return new Sessionplaner();
});
