(function($){	
	$(function(){		
		yeeFrontend.init();
	});
	var yeeFrontend = {
		action: ['Tab','Carousel','Faq', 'PrettyPhoto'],
		Tab: function(){
			$(".yee .nav-tabs a").click(function (e) {
				e.preventDefault();
				$(this).parent().addClass('active').siblings().removeClass('active');
				var $target = $($(this).attr('href'));
				$target.siblings().removeClass('active').hide();
				$target.addClass('active').show();
				return false;
			});
		},
		Carousel: function(){
			// fix bootstrap carousel conflict with mootools
			if (typeof jQuery != 'undefined' && typeof MooTools != 'undefined' ){ 
				(function($) { 
					$(document).ready(function(){
						$('.carousel').each(function(index, element) {	        	
							$(this)[0].slide = null;
							if($(this).attr('data-autoplay') == 'yes'){
								$(this).carousel();
							}
						});
					});
				})(jQuery);
			}
		},
		Faq: function(){
				
			$('.yee .faq_wrapper').each(function(i,ele){
				ele = $(ele);
				var title = ele.find('.yee_faq_title'),
					content = ele.find('.yee_faq_content'),
					icon = ele.find('i');
				title.css('cursor','pointer');
				title.click(function(){
					content.hasClass('hide') ? content.removeClass('hide') : content.addClass('hide');
					if(icon.hasClass('icon-plus')){
						icon.removeClass('icon-plus').addClass('icon-minus');
					}else if(icon.hasClass('icon-minus')){
						icon.removeClass('icon-minus').addClass('icon-plus');
					}
				});
			});	
			
		},
		PrettyPhoto: function(){
			if(typeof $.prettyPhoto !='undefined'){
				$('[prettyPhoto-theme]').each(function(idx, obj){
					var theme = $(obj).attr('prettyPhoto-theme');
					$(obj).find("[rel^='prettyPhoto']").prettyPhoto({
						theme: theme
					});
				});
				$('[rel="prettyPhoto[content-image]"]').prettyPhoto();
			}
		},
		init: function(){
			$.each(yeeFrontend.action,function(idx, value){
				yeeFrontend[value]();
			});
		}
	}

})(window.jQuery);

!function ($) {

  "use strict"; // jshint ;_;


 /* CAROUSEL CLASS DEFINITION
  * ========================= */

  var Carousel = function (element, options) {
    this.$element = $(element)
    this.$indicators = this.$element.find('.carousel-indicators')
    this.options = options
    this.options.pause == 'hover' && this.$element
      .on('mouseenter', $.proxy(this.pause, this))
      .on('mouseleave', $.proxy(this.cycle, this))
  }

  Carousel.prototype = {

    cycle: function (e) {
      if (!e) this.paused = false
      if (this.interval) clearInterval(this.interval);
      this.options.interval
        && !this.paused
        && (this.interval = setInterval($.proxy(this.next, this), this.options.interval))
      return this
    }

  , getActiveIndex: function () {
      this.$active = this.$element.find('.item.active')
      this.$items = this.$active.parent().children()
      return this.$items.index(this.$active)
    }

  , to: function (pos) {
      var activeIndex = this.getActiveIndex()
        , that = this

      if (pos > (this.$items.length - 1) || pos < 0) return

      if (this.sliding) {
        return this.$element.one('slid', function () {
          that.to(pos)
        })
      }

      if (activeIndex == pos) {
        return this.pause().cycle()
      }

      return this.slide(pos > activeIndex ? 'next' : 'prev', $(this.$items[pos]))
    }

  , pause: function (e) {
      if (!e) this.paused = true
      if (this.$element.find('.next, .prev').length && $.support.transition.end) {
        this.$element.trigger($.support.transition.end)
        this.cycle(true)
      }
      clearInterval(this.interval)
      this.interval = null
      return this
    }

  , next: function () {
      if (this.sliding) return
      return this.slide('next')
    }

  , prev: function () {
      if (this.sliding) return
      return this.slide('prev')
    }

  , slide: function (type, next) {
      var $active = this.$element.find('.item.active')
        , $next = next || $active[type]()
        , isCycling = this.interval
        , direction = type == 'next' ? 'left' : 'right'
        , fallback  = type == 'next' ? 'first' : 'last'
        , that = this
        , e

      this.sliding = true

      isCycling && this.pause()

      $next = $next.length ? $next : this.$element.find('.item')[fallback]()

      e = $.Event('slide', {
        relatedTarget: $next[0]
      , direction: direction
      })

      if ($next.hasClass('active')) return

      if (this.$indicators.length) {
        this.$indicators.find('.active').removeClass('active')
        this.$element.one('slid', function () {
          var $nextIndicator = $(that.$indicators.children()[that.getActiveIndex()])
          $nextIndicator && $nextIndicator.addClass('active')
        })
      }

      if ($.support.transition && this.$element.hasClass('slide')) {
        this.$element.trigger(e)
        if (e.isDefaultPrevented()) return
        $next.addClass(type)
        $next[0].offsetWidth // force reflow
        $active.addClass(direction)
        $next.addClass(direction)
        this.$element.one($.support.transition.end, function () {
          $next.removeClass([type, direction].join(' ')).addClass('active')
          $active.removeClass(['active', direction].join(' '))
          that.sliding = false
          setTimeout(function () { that.$element.trigger('slid') }, 0)
        })
      } else {
        this.$element.trigger(e)
        if (e.isDefaultPrevented()) return
        $active.removeClass('active')
        $next.addClass('active')
        this.sliding = false
        this.$element.trigger('slid')
      }

      isCycling && this.cycle()

      return this
    }

  }


 /* CAROUSEL PLUGIN DEFINITION
  * ========================== */

  var old = $.fn.yecarousel

  $.fn.yecarousel = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('yecarousel')
        , options = $.extend({}, $.fn.yecarousel.defaults, typeof option == 'object' && option)
        , action = typeof option == 'string' ? option : options.slide
      if (!data) $this.data('yecarousel', (data = new Carousel(this, options)))
      if (typeof option == 'number') data.to(option)
      else if (action) data[action]()
      else if (options.interval) data.pause().cycle()
    })
  }

  $.fn.yecarousel.defaults = {
    interval: 5000
  , pause: 'hover'
  }

  $.fn.yecarousel.Constructor = Carousel


 /* CAROUSEL NO CONFLICT
  * ==================== */

  $.fn.yecarousel.noConflict = function () {
    $.fn.yecarousel = old
    return this
  }

 /* CAROUSEL DATA-API
  * ================= */

  $(document).on('click.yecarousel.data-api', '[data-slide], [data-slide-to]', function (e) {
    var $this = $(this), href
      , $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')) //strip for ie7
      , options = $.extend({}, $target.data(), $this.data())
      , slideIndex

    $target.yecarousel(options)

    if (slideIndex = $this.attr('data-slide-to')) {
      $target.data('yecarousel').pause().to(slideIndex).cycle()
    }

    e.preventDefault()
  })

}(window.jQuery);
