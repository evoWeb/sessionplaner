/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Module: TYPO3/CMS/Sessionplaner/DragDrop
 * this JS code is a copy of the drag+drop logic for the Layout module (Web => Page)
 * based on jQuery UI
 */
define([
	'jquery',
	'jquery-ui/sortable',
	'jquery-ui/droppable'
], function ($) {
	'use strict';

	var DragDrop = {
		contentIdentifier: '.t3js-session',
		dragIdentifier: '.t3-session-dragitem',
		dragHeaderIdentifier: '.t3js-session-draghandle',
		dropZoneIdentifier: '.t3js-session-dropzone-available',
		columnIdentifier: '.t3js-page-column',
		columnHolderIdentifier: '.zzz',
		validDropZoneClass: 'active',
		dropPossibleHoverClass: 't3-session-dropzone-possible',
		addContentIdentifier: '.t3js-session-new',
		clone: true,
		originalStyles: ''
	};

	/**
	 * initializes Drag+Drop for all content elements on the page
	 */
	DragDrop.initialize = function () {
		$(DragDrop.contentIdentifier).draggable({
			handle: this.dragHeaderIdentifier,
			scope: 'sessionplaner',
			cursor: 'move',
			distance: 20,
			addClasses: 'active-drag',
			revert: 'invalid',
			zIndex: 100,
			start: function (event, ui) {
				DragDrop.onDragStart($(this), ui);
			},
			stop: function (event, ui) {
				DragDrop.onDragStop($(this), ui);
			}
		});

		$(DragDrop.dropZoneIdentifier).droppable({
			accept: this.contentIdentifier,
			scope: 'sessionplaner',
			tolerance: 'pointer',
			over: function (event, ui) {
				DragDrop.onDropHoverOver($(ui.draggable), $(this));
			},
			out: function (event, ui) {
				DragDrop.onDropHoverOut($(ui.draggable), $(this));
			},
			drop: function (event, ui) {
				DragDrop.onDrop($(ui.draggable), $(this), event);
			}
		});
	};

	/**
	 * called when a draggable is selected to be moved
	 * @param $element a jQuery object for the draggable
	 * @private
	 */
	DragDrop.onDragStart = function ($element) {
		// Add css class for the drag shadow
		DragDrop.originalStyles = $element.get(0).style.cssText;
		$element.children(DragDrop.dragIdentifier).addClass('dragitem-shadow');
		$element.append('<div class="ui-draggable-copy-message">' + TYPO3.lang['dragdrop.copy.message'] + '</div>');
		// Hide create new element button
		$element.children(DragDrop.dropZoneIdentifier).addClass('drag-start');
		$element.closest(DragDrop.columnIdentifier).removeClass('active');

		$element.parents(DragDrop.columnHolderIdentifier).find(DragDrop.addContentIdentifier).hide();
		$element.find(DragDrop.dropZoneIdentifier).hide();

		// make the drop zones visible
		$(DragDrop.dropZoneIdentifier).each(function () {
			if (
				$(this).parent().find('.icon-actions-document-new').length
			) {
				$(this).addClass(DragDrop.validDropZoneClass);
			} else {
				$(this).closest(DragDrop.contentIdentifier).find('> ' + DragDrop.addContentIdentifier + ', > > ' + DragDrop.addContentIdentifier).show();
			}
		});
	};

	/**
	 * called when a draggable is released
	 * @param $element a jQuery object for the draggable
	 * @private
	 */
	DragDrop.onDragStop = function ($element) {
		// Remove css class for the drag shadow
		$element.children(DragDrop.dragIdentifier).removeClass('dragitem-shadow');
		// Show create new element button
		$element.children(DragDrop.dropZoneIdentifier).removeClass('drag-start');
		$element.closest(DragDrop.columnIdentifier).addClass('active');
		$element.parents(DragDrop.columnHolderIdentifier).find(DragDrop.addContentIdentifier).show();
		$element.find(DragDrop.dropZoneIdentifier).show();
		$element.find('.ui-draggable-copy-message').remove();

		// Reset inline style
		$element.get(0).style.cssText = DragDrop.originalStyles;

		$(DragDrop.dropZoneIdentifier + '.' + DragDrop.validDropZoneClass).removeClass(DragDrop.validDropZoneClass);
	};

	/**
	 * adds CSS classes when hovering over a dropzone
	 * @param $draggableElement
	 * @param $droppableElement
	 * @private
	 */
	DragDrop.onDropHoverOver = function ($draggableElement, $droppableElement) {
		if ($droppableElement.hasClass(DragDrop.validDropZoneClass)) {
			$droppableElement.addClass(DragDrop.dropPossibleHoverClass);
		}
	};

	/**
	 * removes the CSS classes after hovering out of a dropzone again
	 * @param $draggableElement
	 * @param $droppableElement
	 * @private
	 */
	DragDrop.onDropHoverOut = function ($draggableElement, $droppableElement) {
		$droppableElement.removeClass(DragDrop.dropPossibleHoverClass);
	};

	/**
	 * this method does the whole logic when a draggable is dropped on to a dropzone
	 * sending out the request and afterwards move the HTML element in the right place.
	 *
	 * @param $draggableElement
	 * @param $droppableElement
	 * @param {Event} evt the event
	 * @private
	 */
	DragDrop.onDrop = function ($draggableElement, $droppableElement, evt) {
		// found in Sessionplaner.movedSession
	};

	$(DragDrop.initialize);
	return DragDrop;
});
