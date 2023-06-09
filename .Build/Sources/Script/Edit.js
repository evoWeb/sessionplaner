/* globals jQuery, parseInt */
define([
    'jquery',
    'TYPO3/CMS/Sessionplaner/DragDrop',
    'TYPO3/CMS/Backend/Modal',
    'TYPO3/CMS/Backend/Severity'
], function ($, DragDrop, Modal, Severity) {
    'use strict';

    var Sessionplaner = {
        settings: {
            pageId: 0,
            uiBlock: null,
            stash: null,
            gridButtonGroup: null,
            gridNewSessionButton: null,
            sessionData: {},
            ajaxActive: false,
            dragActive: false
        }
    }

    Sessionplaner.setPageId = function (pageId) {
        Sessionplaner.settings.pageId = pageId;
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
        let data = {};

        $.each(serializedData, function (index, fieldNameAndValue) {
            if (fieldNameAndValue.name === 'attendees'
                || fieldNameAndValue.name === 'requesttype'
                || fieldNameAndValue.name === 'type'
                || fieldNameAndValue.name === 'level'
                || fieldNameAndValue.name === 'day'
                || fieldNameAndValue.name === 'room'
                || fieldNameAndValue.name === 'slot'
                || fieldNameAndValue.name === 'hidden'
                || fieldNameAndValue.name === 'norecording'
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
    Sessionplaner.applySessionValuesToForm = function ($form, sessionData) {
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
    Sessionplaner.applySessionValuesToCard = function ($card, sessionData) {
        $.each(sessionData, function (name, value) {
            $card.find('.property[data-name="' + name + '"]')
                .data('value', value)
                .text(value);
        });

        if (sessionData.hidden) {
            $card.addClass('t3-page-ce-hidden');
        } else {
            $card.removeClass('t3-page-ce-hidden');
        }

        if (sessionData.norecording) {
            $card.addClass('session-norecording');
        } else {
            $card.removeClass('session-norecording');
        }

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
            sessionData.day = 0;
            sessionData.slot = 0;
            sessionData.room = 0;
        } else {
            sessionData.day = $cardParent.data('day');
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
        let $card = Sessionplaner.getTemplateElement('sessionCardTemplate');

        return Sessionplaner.applySessionValuesToCard($card, sessionData);
    };

    /**
     * @param {object} sessionData
     */
    Sessionplaner.updateSessionCard = function (sessionData) {
        let $card = $('.uid[data-value="' + sessionData.uid + '"]', '.t3js-page-ce').parents('.t3js-page-ce');

        Sessionplaner.applySessionValuesToCard($card, sessionData);
    };

    /**
     * @param {object} card
     *
     * @returns {object}
     */
    Sessionplaner.getDataFromCard = function ($card) {
        let data = {};
        $card.find('.t3-page-ce-body-inner .property').each(function () {
            let $element = $(this);
            data[$element.data('name')] = $element.data('value');
        });

        return data;
    };


    /**
     * @param {object} response
     */
    Sessionplaner.createSessionSuccess = function (response) {
        Sessionplaner.settings.sessionData.uid = response.data.uid;
        let $card = Sessionplaner.createSessionCard(Sessionplaner.settings.sessionData);
        if (Sessionplaner.settings.sessionData.room && Sessionplaner.settings.sessionData.slot) {
            $('[data-room="' + Sessionplaner.settings.sessionData.room + '"][data-slot="' + Sessionplaner.settings.sessionData.slot + '"]').prepend($card);
        } else {
            Sessionplaner.settings.stash.prepend($card);
        }
        DragDrop.initializeDraggable($card);
    };

    Sessionplaner.updateSessionSuccess = function () {
        Sessionplaner.updateSessionCard(Sessionplaner.settings.sessionData);
    };

    Sessionplaner.movedSessionSuccess = function () {
    };

    Sessionplaner.deleteSessionSuccess = function () {
        $('[data-name="uid"]').each(function () {
            let $element = $(this);
            if (parseInt($element.data('value')) === Sessionplaner.settings.sessionData.uid) {
                $element.parents('.t3-page-ce').remove();
            }
        });
    };


    /**
     * @return {boolean}
     */
    Sessionplaner.beforeSend = function () {
        let result = true;

        if (!Sessionplaner.settings.ajaxActive) {
            Sessionplaner.settings.ajaxActive = true;
            Sessionplaner.settings.uiBlock.removeClass('hidden');
        } else {
            result = false;
        }

        return result;
    };

    Sessionplaner.afterSend = function () {
        Sessionplaner.settings.uiBlock.addClass('hidden');
        Sessionplaner.settings.ajaxActive = false;
    };

    Sessionplaner.sendAjaxRequest = function (ajaxUrlKey, sessionData, doneCallback) {
        $.ajax(TYPO3.settings.ajaxUrls[ajaxUrlKey], {
            method: 'post',
            beforeSend: function () {
                Sessionplaner.beforeSend();
            },
            complete: function () {
                Sessionplaner.afterSend();
            },
            data: {
                id: Sessionplaner.settings.pageId,
                tx_sessionplaner: {
                    session: sessionData
                }
            }
        }).done(doneCallback);
    };

    /**
     * @param {object} event
     */
    Sessionplaner.createSession = function (event) {
        let sessionData = Sessionplaner.prepareData($('form', event.target).serializeArray())
        Sessionplaner.settings.sessionData = sessionData;

        Sessionplaner.sendAjaxRequest(
            'evoweb_sessionplaner_create',
            Sessionplaner.settings.sessionData,
            function (data) {
                if (data.status !== 'error') {
                    Sessionplaner.createSessionSuccess(data);
                } else {
                    Sessionplaner.createNewSessionForm(sessionData);
                }
            }
        );
    };

    /**
     * @param {object} event
     */
    Sessionplaner.updateSession = function (event) {
        let updateSessionData = Sessionplaner.prepareData($('form', event.target).serializeArray());
        updateSessionData.uid = Sessionplaner.settings.sessionData.uid;
        Sessionplaner.settings.sessionData = updateSessionData;

        Sessionplaner.sendAjaxRequest(
            'evoweb_sessionplaner_update',
            Sessionplaner.settings.sessionData,
            function (data) {
                if (data.status !== 'error') {
                    Sessionplaner.updateSessionSuccess(data);
                } else {
                    Sessionplaner.editSession(updateSessionData);
                }
            }
        );
    };

    /**
     * @param {object} element
     */
    Sessionplaner.deleteSession = function (element) {
        Sessionplaner.settings.sessionData = { uid: $(element).parents('.t3-page-ce').find('.uid').data('value') };
        Sessionplaner.sendAjaxRequest(
            'evoweb_sessionplaner_delete',
            Sessionplaner.settings.sessionData,
            function (data) {
                Sessionplaner.deleteSessionSuccess(data);
            }
        );
    };

    /**
     * @param {object} $movedElement
     * @param {object} $droppedOnElement
     */
    Sessionplaner.movedSession = function ($movedElement, $droppedOnElement) {
        let movedSessionData = Sessionplaner.getDataFromCard($movedElement);

        Sessionplaner.settings.sessionData = Sessionplaner.addValuesFromParent(movedSessionData, $droppedOnElement);
        Sessionplaner.sendAjaxRequest(
            'evoweb_sessionplaner_update',
            Sessionplaner.settings.sessionData,
            function (data) {
                Sessionplaner.movedSessionSuccess(data);
            }
        );
    };


    Sessionplaner.createNewSessionForm = function (sessionData) {
        Sessionplaner.settings.sessionData = sessionData || {};
        Modal.confirm(
            'Create session',
            Sessionplaner.applySessionValuesToForm(
                Sessionplaner.getTemplateElement('sessionFormTemplate'),
                Sessionplaner.settings.sessionData
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
            Modal.dismiss();
        }).on('confirm.button.ok', function (event) {
            Sessionplaner.createSession(event);
        });
    };

    Sessionplaner.createNewSessionFormInGrid = function () {
        Modal.confirm(
            'Create session',
            Sessionplaner.applySessionValuesToForm(
                Sessionplaner.getTemplateElement('sessionFormTemplate'),
                Sessionplaner.settings.sessionData
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
            Modal.dismiss();
        }).on('confirm.button.ok', function (event) {
            Sessionplaner.createSession(event);
        });
    };

    Sessionplaner.editSession = function (sessionData) {
        Sessionplaner.settings.sessionData = sessionData;

        Modal.confirm(
            'Edit session',
            Sessionplaner.applySessionValuesToForm(
                Sessionplaner.getTemplateElement('sessionFormTemplate'),
                Sessionplaner.settings.sessionData
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
            Modal.dismiss();
        }).on('confirm.button.ok', function (event) {
            Sessionplaner.updateSession(event);
        });
    };

    Sessionplaner.mouseOver = function (element) {
        let $element = $(element);
        Sessionplaner.settings.sessionData = {
            room: $element.data('room'),
            slot: $element.data('slot')
        };
        if (!Sessionplaner.settings.dragActive && $element.children().length === 0) {
            Sessionplaner.settings.gridNewSessionButton.appendTo($element);
        }
    };

    Sessionplaner.mouseOut = function (element, event) {
        let e = event.toElement || event.relatedTarget;
        if (e === null
            || e === element
            || e.parentNode === element
            || e.parentNode.parentNode === element
            || e.parentNode.parentNode.parentNode === element
            || e.parentNode.parentNode.parentNode.parentNode === element) {
            return;
        }
        Sessionplaner.settings.gridNewSessionButton.appendTo(Sessionplaner.settings.gridButtonGroup);
    };

    /**
     * Hook into drop stop to store moving the session
     */
    Sessionplaner.initializeDragAndDrop = function () {
        let originalDragStart = DragDrop.onDragStart,
            originalDrop = DragDrop.onDrop;

        DragDrop.onDragStart = function ($draggableElement) {
            Sessionplaner.settings.dragActive = true;
            originalDragStart($draggableElement);
        };

        DragDrop.onDrop = function ($draggableElement, $dropAbleElement, event) {
            Sessionplaner.movedSession($draggableElement, $dropAbleElement);
            originalDrop($draggableElement, $dropAbleElement, event);
            Sessionplaner.settings.dragActive = false;
        }
    };

    Sessionplaner.initialize = function () {
        Sessionplaner.settings.uiBlock = $('#t3js-ui-block');
        Sessionplaner.settings.stash = $('#stash');
        Sessionplaner.settings.gridButtonGroup = $('#gridButtonGroup');
        Sessionplaner.settings.gridNewSessionButton = Sessionplaner.settings.gridButtonGroup.find('#actions-document-new-in-grid');
        Sessionplaner.initializeEvents();
    };

    Sessionplaner.initializeEvents = function () {
        $(document)
            .on('click', '#actions-document-new', function () {
                Sessionplaner.createNewSessionForm();
            })
            .on('click', '#actions-document-new-in-grid', function () {
                Sessionplaner.createNewSessionFormInGrid();
            })
            .on('click', '.icon-actions-edit-delete', function () {
                Sessionplaner.deleteSession(this);
            })
            .on('dblclick', '.t3js-page-ce', function () {
                let sessionData = Sessionplaner.getDataFromCard($(this));
                Sessionplaner.editSession(sessionData);
            })
            .on('mouseover', '.t3js-grid-cell', function () {
                Sessionplaner.mouseOver(this);
            })
            .on('mouseout', '.t3js-grid-cell', function (event) {
                Sessionplaner.mouseOut(this, event);
            });
        Sessionplaner.initializeDragAndDrop();
    };


    Sessionplaner.initialize();

    return Sessionplaner;
});
