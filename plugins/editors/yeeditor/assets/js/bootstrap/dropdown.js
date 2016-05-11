/* ========================================================================
 * Bootstrap: dropdown.js v3.1.1
 * http://getbootstrap.com/javascript/#dropdowns
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // DROPDOWN CLASS DEFINITION
  // =========================

  var backdrop = '.yee-dropdown-backdrop'
  var toggle   = '[data-yee-toggle=dropdown]'
  var Dropdown = function (element) {
    $(element).on('click.bs.yeeDropdown', this.toggle)
  }

  Dropdown.prototype.toggle = function (e) {
    var $this = $(this)

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('yee-open')

    clearMenus()

    if (!isActive) {
      if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
        // if mobile we use a backdrop because click events don't delegate
        $('<div class="yee-dropdown-backdrop"/>').insertAfter($(this)).on('click', clearMenus)
      }

      var relatedTarget = { relatedTarget: this }
      $parent.trigger(e = $.Event('show.bs.yeeDropdown', relatedTarget))

      if (e.isDefaultPrevented()) return

      $parent
        .toggleClass('yee-open')
        .trigger('shown.bs.yeeDropdown', relatedTarget)

      $this.focus()
    }

    return false
  }

  Dropdown.prototype.keydown = function (e) {
    if (!/(38|40|27)/.test(e.keyCode)) return

    var $this = $(this)

    e.preventDefault()
    e.stopPropagation()

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('yee-open')

    if (!isActive || (isActive && e.keyCode == 27)) {
      if (e.which == 27) $parent.find(toggle).focus()
      return $this.click()
    }

    var desc = ' li:not(.divider):visible a'
    var $items = $parent.find('[role=menu]' + desc + ', [role=listbox]' + desc)

    if (!$items.length) return

    var index = $items.index($items.filter(':focus'))

    if (e.keyCode == 38 && index > 0)                 index--                        // up
    if (e.keyCode == 40 && index < $items.length - 1) index++                        // down
    if (!~index)                                      index = 0

    $items.eq(index).focus()
  }

  function clearMenus(e) {
    $(backdrop).remove()
    $(toggle).each(function () {
      var $parent = getParent($(this))
      var relatedTarget = { relatedTarget: this }
      if (!$parent.hasClass('yee-open')) return
      //$parent.trigger(e = $.Event('hide.bs.yeeDropdown', relatedTarget)) //cancel the line for fix conflict with mootools-more.js - by feng
	  e = $.Event('hide.bs.yeeDropdown', relatedTarget)
      if (e.isDefaultPrevented()) return
      $parent.removeClass('yee-open').trigger('hidden.bs.yeeDropdown', relatedTarget)
    })
  }

  function getParent($this) {
    var selector = $this.attr('data-yee-target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') //strip for ie7
    }

    var $parent = selector && $(selector)

    return $parent && $parent.length ? $parent : $this.parent()
  }


  // DROPDOWN PLUGIN DEFINITION
  // ==========================

  var old = $.fn.yeeDropdown

  $.fn.yeeDropdown = function (option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.yeeDropdown')

      if (!data) $this.data('bs.yeeDropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  $.fn.yeeDropdown.Constructor = Dropdown


  // DROPDOWN NO CONFLICT
  // ====================

  $.fn.yeeDropdown.noConflict = function () {
    $.fn.yeeDropdown = old
    return this
  }


  // APPLY TO STANDARD DROPDOWN ELEMENTS
  // ===================================

  $(document)
    .on('click.bs.yeeDropdown.data-yee-api', clearMenus)
    .on('click.bs.yeeDropdown.data-yee-api', '.yee-dropdown form', function (e) { e.stopPropagation() })
    .on('click.bs.yeeDropdown.data-yee-api', toggle, Dropdown.prototype.toggle)
    .on('keydown.bs.yeeDropdown.data-yee-api', toggle + ', [role=menu], [role=listbox]', Dropdown.prototype.keydown)

}(jQuery);
