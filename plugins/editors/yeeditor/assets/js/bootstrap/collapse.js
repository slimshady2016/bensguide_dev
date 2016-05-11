/* ========================================================================
 * Bootstrap: collapse.js v3.1.1
 * http://getbootstrap.com/javascript/#collapse
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // COLLAPSE PUBLIC CLASS DEFINITION
  // ================================

  var Collapse = function (element, options) {
    this.$element      = $(element)
    this.options       = $.extend({}, Collapse.DEFAULTS, options)
    this.transitioning = null

    if (this.options.yeeParent) this.$parent = $(this.options.yeeParent)
    if (this.options.yeeToggle) this.toggle()
  }

  Collapse.DEFAULTS = {
    yeeToggle: true
  }

  Collapse.prototype.dimension = function () {
    var hasWidth = this.$element.hasClass('width')
    return hasWidth ? 'width' : 'height'
  }

  Collapse.prototype.show = function () {
    if (this.transitioning || this.$element.hasClass('in')) return

    var startEvent = $.Event('show.bs.yeeCollapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    var actives = this.$parent && this.$parent.find('> .yee-panel > .in')

    if (actives && actives.length) {
      var hasData = actives.data('bs.yeeCollapse')
      if (hasData && hasData.transitioning) return
      actives.yeeCollapse('hide')
      hasData || actives.data('bs.yeeCollapse', null)
    }

    var dimension = this.dimension()

    this.$element
      .removeClass('yee-collapse')
      .addClass('yee-collapsing')
      [dimension](0)

    this.transitioning = 1

    var complete = function () {
      this.$element
        .removeClass('yee-collapsing')
        .addClass('yee-collapse in')
        [dimension]('auto')
      this.transitioning = 0
      this.$element.trigger('shown.bs.yeeCollapse')
    }

    if (!$.support.transition) return complete.call(this)

    var scrollSize = $.camelCase(['scroll', dimension].join('-'))

    this.$element
      .one($.support.transition.end, $.proxy(complete, this))
      .emulateTransitionEnd(350)
      [dimension](this.$element[0][scrollSize])
  }

  Collapse.prototype.hide = function () {
    if (this.transitioning || !this.$element.hasClass('in')) return

    var startEvent = $.Event('hide.bs.yeeCollapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    var dimension = this.dimension()

    this.$element
      [dimension](this.$element[dimension]())
      [0].offsetHeight

    this.$element
      .addClass('yee-collapsing')
      .removeClass('yee-collapse')
      .removeClass('in')

    this.transitioning = 1

    var complete = function () {
      this.transitioning = 0
      this.$element
        .trigger('hidden.bs.yeeCollapse')
        .removeClass('yee-collapsing')
        .addClass('yee-collapse')
    }

    if (!$.support.transition) return complete.call(this)

    this.$element
      [dimension](0)
      .one($.support.transition.end, $.proxy(complete, this))
      .emulateTransitionEnd(350)
  }

  Collapse.prototype.toggle = function () {
    this[this.$element.hasClass('in') ? 'hide' : 'show']()
  }


  // COLLAPSE PLUGIN DEFINITION
  // ==========================

  var old = $.fn.yeeCollapse

  $.fn.yeeCollapse = function (option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.yeeCollapse')
      var options = $.extend({}, Collapse.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data && options.yeeToggle && option == 'show') option = !option
      if (!data) $this.data('bs.yeeCollapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.yeeCollapse.Constructor = Collapse


  // COLLAPSE NO CONFLICT
  // ====================

  $.fn.yeeCollapse.noConflict = function () {
    $.fn.yeeCollapse = old
    return this
  }


  // COLLAPSE DATA-API
  // =================

  $(document).on('click.bs.yeeCollapse.data-yee-api', '[data-yee-toggle=collapse]', function (e) {
    var $this   = $(this), href
    var target  = $this.attr('data-yee-target')
        || e.preventDefault()
        || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') //strip for ie7
    var $target = $(target)
    var data    = $target.data('bs.yeeCollapse')
    var option  = data ? 'toggle' : $this.data()
    var parent  = $this.attr('data-yee-parent')
    var $parent = parent && $(parent)

    if (!data || !data.transitioning) {
      if ($parent) $parent.find('[data-yee-toggle=collapse][data-yee-parent="' + parent + '"]').not($this).addClass('collapsed')
      $this[$target.hasClass('in') ? 'addClass' : 'removeClass']('collapsed')
    }

    $target.yeeCollapse(option)
  })

}(jQuery);
