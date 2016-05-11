/* ========================================================================
 * Bootstrap: popover.js v3.1.1
 * http://getbootstrap.com/javascript/#popovers
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // POPOVER PUBLIC CLASS DEFINITION
  // ===============================

  var Popover = function (element, options) {
    this.init('yeePopover', element, options)
  }

  if (!$.fn.yeeTooltip) throw new Error('Popover requires tooltip.js')

  Popover.DEFAULTS = $.extend({}, $.fn.yeeTooltip.Constructor.DEFAULTS, {
    yeePlacement: 'right',
    yeeTrigger: 'click',
    yeeContent: '',
    yeeTemplate: '<div class="yee-popover"><div class="arrow"></div><h3 class="yee-popover-title"></h3><div class="yee-popover-content"></div></div>'
  })


  // NOTE: POPOVER EXTENDS tooltip.js
  // ================================

  Popover.prototype = $.extend({}, $.fn.yeeTooltip.Constructor.prototype)

  Popover.prototype.constructor = Popover

  Popover.prototype.getDefaults = function () {
    return Popover.DEFAULTS
  }

  Popover.prototype.setContent = function () {
    var $tip    = this.tip()
    var title   = this.getTitle()
    var content = this.getContent()

    $tip.find('.yee-popover-title')[this.options.yeeHtml ? 'html' : 'text'](title)
    $tip.find('.yee-popover-content')[ // we use append for html objects to maintain js events
      this.options.yeeHtml ? (typeof content == 'string' ? 'html' : 'append') : 'text'
    ](content)

    $tip.removeClass('fade top bottom left right in')

    // IE8 doesn't accept hiding via the `:empty` pseudo selector, we have to do
    // this manually by checking the contents.
    if (!$tip.find('.yee-popover-title').html()) $tip.find('.yee-popover-title').hide()
  }

  Popover.prototype.hasContent = function () {
    return this.getTitle() || this.getContent()
  }

  Popover.prototype.getContent = function () {
    var $e = this.$element
    var o  = this.options

    return $e.attr('data-yee-content')
      || (typeof o.content == 'function' ?
            o.content.call($e[0]) :
            o.content)
  }

  Popover.prototype.arrow = function () {
    return this.$arrow = this.$arrow || this.tip().find('.arrow')
  }

  Popover.prototype.tip = function () {
    if (!this.$tip) this.$tip = $(this.options.yeeTemplate)
    return this.$tip
  }


  // POPOVER PLUGIN DEFINITION
  // =========================

  var old = $.fn.yeePopover

  $.fn.yeePopover = function (option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.yeePopover')
      var options = typeof option == 'object' && option

      if (!data && option == 'destroy') return
      if (!data) $this.data('bs.yeePopover', (data = new Popover(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.yeePopover.Constructor = Popover


  // POPOVER NO CONFLICT
  // ===================

  $.fn.yeePopover.noConflict = function () {
    $.fn.yeePopover = old
    return this
  }

}(jQuery);
