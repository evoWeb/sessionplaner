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
		contentIdentifier: '.t3js-page-ce',
		dragHeaderIdentifier: '.t3js-page-ce-draghandle',
		dropZoneIdentifier: '.t3js-page-ce-dropzone-available',
		dragIdentifier: '.t3-page-ce-dragitem',
		validDropZoneClass: 'active',
		dropPossibleHoverClass: 't3-page-ce-dropzone-possible',
		addContentIdentifier: '.t3js-page-new-ce',
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
				// needs to be called instead of giving the reference
				// to the method directly to be able to override
				// the onDragStart method as hook where ever the
				// module is used.
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
		// Backup inline styles
		DragDrop.originalStyles = $element.get(0).style.cssText;

		// Add css class for the drag shadow
		$element.children(DragDrop.dragIdentifier).addClass('dragitem-shadow');

		// make the drop zones visible
		$(DragDrop.dropZoneIdentifier).addClass(DragDrop.validDropZoneClass);
	};

	/**
	 * called when a draggable is released
	 * @param $element a jQuery object for the draggable
	 * @private
	 */
	DragDrop.onDragStop = function ($element) {
		// Remove css class for the drag shadow
		$element.children(DragDrop.dragIdentifier).removeClass('dragitem-shadow');

		// make the drop zones invisible
		$(DragDrop.dropZoneIdentifier + '.' + DragDrop.validDropZoneClass).removeClass(DragDrop.validDropZoneClass);

		// Reset inline style
		$element.get(0).style.cssText = DragDrop.originalStyles;
	};

	/**
	 * adds CSS classes when hovering over a dropzone
	 * @param $draggableElement
	 * @param $droppableElement
	 * @private
	 */
	DragDrop.onDropHoverOver = function ($draggableElement, $droppableElement) {
		console.log('over and active');
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
