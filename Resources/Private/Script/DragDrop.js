/**
 * Module: TYPO3/CMS/Sessionplaner/DragDrop
 * this JS code is copied and modified drag+drop logic of the Layout module (Web => Page)
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
   *
   * @return void
   */
  DragDrop.initialize = function () {
    DragDrop.initializeDraggable();
    DragDrop.initializeDroppable();
  };

  /**
   * Initialize draggable elements
   * If none is given as parameter all are selected
   *
   * @param {object} $draggableElement a jQuery object for the draggable
   *
   * @return void
   */
  DragDrop.initializeDraggable = function ($draggableElement) {
    if (typeof $draggableElement !== 'object') {
      $draggableElement = $(DragDrop.contentIdentifier);
    }

    $draggableElement.draggable({
      handle: DragDrop.dragHeaderIdentifier,
      scope: 'sessionplaner',
      cursor: 'move',
      distance: 20,
      addClasses: false,
      revert: 'invalid',
      zIndex: 100,
      start: function () {
        // needs to be called instead of giving the reference
        // to the method directly to be able to override
        // the onDragStart method as hook where ever the
        // module is used.
        DragDrop.onDragStart($(this));
      },
      stop: function () {
        DragDrop.onDragStop($(this));
      }
    });
  };

  /**
   * Initialize droppable elements
   *
   * @return void
   */
  DragDrop.initializeDroppable = function () {
    $(DragDrop.dropZoneIdentifier).droppable({
      accept: DragDrop.contentIdentifier,
      scope: 'sessionplaner',
      tolerance: 'pointer',
      over: function (event, ui) {
        DragDrop.onDropHoverOver($(ui.draggable), $(this));
      },
      out: function (event, ui) {
        DragDrop.onDropHoverOut($(ui.draggable), $(this));
      },
      drop: function (event, ui) {
        DragDrop.onDrop($(ui.draggable), $(this));
      }
    });
  };

  /**
   * called when a draggable is selected to be moved
   *
   * @param {object} $draggableElement a jQuery object for the draggable
   *
   * @return void
   */
  DragDrop.onDragStart = function ($draggableElement) {
    // Backup inline styles
    DragDrop.originalStyles = $draggableElement.get(0).style.cssText;

    // Add css class for the drag shadow
    $draggableElement.children(DragDrop.dragIdentifier).addClass('dragitem-shadow');

    // make the drop zones visible
    $(DragDrop.dropZoneIdentifier).each(function () {
      var $droppableElement = $(this);
      if ($droppableElement.attr('id') === 'stash'
        || $droppableElement.children().length === 0
      ) {
        $droppableElement.addClass(DragDrop.validDropZoneClass);
      }
    });
  };

  /**
   * called when a draggable is released
   *
   * @param {object} $draggableElement a jQuery object for the draggable
   *
   * @return void
   */
  DragDrop.onDragStop = function ($draggableElement) {
    // Remove css class for the drag shadow
    $draggableElement.children(DragDrop.dragIdentifier).removeClass('dragitem-shadow');

    // make the drop zones invisible
    $(DragDrop.dropZoneIdentifier + '.' + DragDrop.validDropZoneClass).removeClass(DragDrop.validDropZoneClass);

    $(DragDrop.dropZoneIdentifier).droppable('enable');

    // Reset inline style
    $draggableElement.get(0).style.cssText = DragDrop.originalStyles;
  };

  /**
   * adds CSS classes when hovering over a dropzone
   *
   * @param {object} $draggableElement
   * @param {object} $droppableElement
   *
   * @return void
   */
  DragDrop.onDropHoverOver = function ($draggableElement, $droppableElement) {
    $droppableElement.droppable('enable');
    if ($droppableElement.attr('id') !== 'stash' && $droppableElement.children().length) {
      $droppableElement.droppable('disable');
    } else if ($droppableElement.hasClass(DragDrop.validDropZoneClass)) {
      $droppableElement.addClass(DragDrop.dropPossibleHoverClass);
    }
  };

  /**
   * removes the CSS classes after hovering out of a dropzone again
   *
   * @param {object} $draggableElement
   * @param {object} $droppableElement
   *
   * @return void
   */
  DragDrop.onDropHoverOut = function ($draggableElement, $droppableElement) {
    $droppableElement.removeClass(DragDrop.dropPossibleHoverClass);
  };

  /**
   * this method does the whole logic when a draggable is dropped on to a dropzone
   * sending out the request and afterwards move the HTML element in the right place.
   *
   * @param {object} $draggableElement
   * @param {object} $droppableElement
   *
   * @return void
   */
  DragDrop.onDrop = function ($draggableElement, $droppableElement) {
    $droppableElement.removeClass(DragDrop.dropPossibleHoverClass);
    $draggableElement
      .detach()
      .css({top: 0, left: 0})
      .appendTo($droppableElement);
  };

  $(DragDrop.initialize);
  return DragDrop;
});
