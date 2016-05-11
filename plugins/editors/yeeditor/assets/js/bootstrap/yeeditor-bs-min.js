+function($){"use strict";function e(){var e=document.createElement("bootstrap"),t={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var i in t)if(void 0!==e.style[i])return{end:t[i]};return!1}$.fn.emulateTransitionEnd=function(e){var t=!1,i=this;$(this).one($.support.transition.end,function(){t=!0});var o=function(){t||$(i).trigger($.support.transition.end)};return setTimeout(o,e),this},$(function(){$.support.transition=e()})}(jQuery),+function($){"use strict";var e='[data-yee-dismiss="alert"]',t=function(t){$(t).on("click",e,this.close)};t.prototype.close=function(e){function t(){n.trigger("closed.bs.yeeAlert").remove()}var i=$(this),o=i.attr("data-yee-target");o||(o=i.attr("href"),o=o&&o.replace(/.*(?=#[^\s]*$)/,""));var n=$(o);e&&e.preventDefault(),n.length||(n=i.hasClass("alert")?i:i.parent()),n.trigger(e=$.Event("close.bs.yeeAlert")),e.isDefaultPrevented()||(n.removeClass("in"),$.support.transition&&n.hasClass("fade")?n.one($.support.transition.end,t).emulateTransitionEnd(150):t())};var i=$.fn.yeeAlert;$.fn.yeeAlert=function(e){return this.each(function(){var i=$(this),o=i.data("bs.yeeAlert");o||i.data("bs.yeeAlert",o=new t(this)),"string"==typeof e&&o[e].call(i)})},$.fn.yeeAlert.Constructor=t,$.fn.yeeAlert.noConflict=function(){return $.fn.yeeAlert=i,this},$(document).on("click.bs.yeeAlert.data-yee-api",e,t.prototype.close)}(jQuery),+function($){"use strict";var e=function(t,i){this.$element=$(t),this.options=$.extend({},e.DEFAULTS,i),this.isLoading=!1};e.DEFAULTS={yeeLoadingText:"loading..."},e.prototype.setState=function(e){var t="disabled",i=this.$element,o=i.is("input")?"val":"html",n=i.data();e+="Text",n.resetText||i.data("resetText",i[o]()),i[o](n[e]||this.options[e]),setTimeout($.proxy(function(){"loadingText"==e?(this.isLoading=!0,i.addClass(t).attr(t,t)):this.isLoading&&(this.isLoading=!1,i.removeClass(t).removeAttr(t))},this),0)},e.prototype.toggle=function(){var e=!0,t=this.$element.closest('[data-yee-toggle="buttons"]');if(t.length){var i=this.$element.find("input");"radio"==i.prop("type")&&(i.prop("checked")&&this.$element.hasClass("active")?e=!1:t.find(".active").removeClass("active")),e&&i.prop("checked",!this.$element.hasClass("active")).trigger("change")}e&&this.$element.toggleClass("active")};var t=$.fn.yeeButton;$.fn.yeeButton=function(t){return this.each(function(){var i=$(this),o=i.data("bs.yeeButton"),n="object"==typeof t&&t;o||i.data("bs.yeeButton",o=new e(this,n)),"toggle"==t?o.toggle():t&&o.setState(t)})},$.fn.yeeButton.Constructor=e,$.fn.yeeButton.noConflict=function(){return $.fn.yeeButton=t,this},$(document).on("click.bs.yeeButton.data-yee-api","[data-yee-toggle^=button]",function(e){var t=$(e.target);t.hasClass("yee-btn")||(t=t.closest(".yee-btn")),t.yeeButton("toggle"),e.preventDefault()})}(jQuery),+function($){"use strict";var e=function(e,t){this.$element=$(e),this.$indicators=this.$element.find(".yee-carousel-indicators"),this.options=t,this.paused=this.sliding=this.interval=this.$active=this.$items=null,"hover"==this.options.yeePause&&this.$element.on("mouseenter",$.proxy(this.pause,this)).on("mouseleave",$.proxy(this.cycle,this))};e.DEFAULTS={yeeInterval:5e3,yeePause:"hover",yeeWrap:!0},e.prototype.cycle=function(e){return e||(this.paused=!1),this.interval&&clearInterval(this.interval),this.options.yeeInterval&&!this.paused&&(this.interval=setInterval($.proxy(this.next,this),this.options.yeeInterval)),this},e.prototype.getActiveIndex=function(){return this.$active=this.$element.find(".item.active"),this.$items=this.$active.parent().children(),this.$items.index(this.$active)},e.prototype.to=function(e){var t=this,i=this.getActiveIndex();return e>this.$items.length-1||0>e?void 0:this.sliding?this.$element.one("slid.bs.yeeCarousel",function(){t.to(e)}):i==e?this.pause().cycle():this.yeeslide(e>i?"next":"prev",$(this.$items[e]))},e.prototype.pause=function(e){return e||(this.paused=!0),this.$element.find(".next, .prev").length&&$.support.transition&&(this.$element.trigger($.support.transition.end),this.cycle(!0)),this.interval=clearInterval(this.interval),this},e.prototype.next=function(){return this.sliding?void 0:this.yeeslide("next")},e.prototype.prev=function(){return this.sliding?void 0:this.yeeslide("prev")},e.prototype.yeeslide=function(e,t){var i=this.$element.find(".item.active"),o=t||i[e](),n=this.interval,s="next"==e?"left":"right",a="next"==e?"first":"last",r=this;if(!o.length){if(!this.options.yeeWrap)return;o=this.$element.find(".item")[a]()}if(o.hasClass("active"))return this.sliding=!1;var l=$.Event("yeeslide.bs.yeeCarousel",{relatedTarget:o[0],direction:s});return this.$element.trigger(l),l.isDefaultPrevented()?void 0:(this.sliding=!0,n&&this.pause(),this.$indicators.length&&(this.$indicators.find(".active").removeClass("active"),this.$element.one("slid.bs.yeeCarousel",function(){var e=$(r.$indicators.children()[r.getActiveIndex()]);e&&e.addClass("active")})),$.support.transition&&this.$element.hasClass("yee-slide")?(o.addClass(e),o[0].offsetWidth,i.addClass(s),o.addClass(s),i.one($.support.transition.end,function(){o.removeClass([e,s].join(" ")).addClass("active"),i.removeClass(["active",s].join(" ")),r.sliding=!1,setTimeout(function(){r.$element.trigger("slid.bs.yeeCarousel")},0)}).emulateTransitionEnd(1e3*i.css("transition-duration").slice(0,-1))):(i.removeClass("active"),o.addClass("active"),this.sliding=!1,this.$element.trigger("slid.bs.yeeCarousel")),n&&this.cycle(),this)};var t=$.fn.yeeCarousel;$.fn.yeeCarousel=function(t){return this.each(function(){var i=$(this),o=i.data("bs.yeeCarousel"),n=$.extend({},e.DEFAULTS,i.data(),"object"==typeof t&&t),s="string"==typeof t?t:n.yeeSlide;o||i.data("bs.yeeCarousel",o=new e(this,n)),"number"==typeof t?o.to(t):s?o[s]():n.yeeInterval&&o.pause().cycle()})},$.fn.yeeCarousel.Constructor=e,$.fn.yeeCarousel.noConflict=function(){return $.fn.yeeCarousel=t,this},$(document).on("click.bs.yeeCarousel.data-yee-api","[data-yee-slide], [data-yee-slide-to]",function(e){var t=$(this),i,o=$(t.attr("data-yee-target")||(i=t.attr("href"))&&i.replace(/.*(?=#[^\s]+$)/,"")),n=$.extend({},o.data(),t.data()),s=t.attr("data-yee-slide-to");s&&(n.yeeInterval=!1),o.yeeCarousel(n),(s=t.attr("data-yee-slide-to"))&&o.data("bs.yeeCarousel").to(s),e.preventDefault()}),$(window).on("load",function(){$('[data-yee-ride="carousel"]').each(function(){var e=$(this);e.yeeCarousel(e.data())})})}(jQuery),+function($){"use strict";var e=function(t,i){this.$element=$(t),this.options=$.extend({},e.DEFAULTS,i),this.transitioning=null,this.options.yeeParent&&(this.$parent=$(this.options.yeeParent)),this.options.yeeToggle&&this.toggle()};e.DEFAULTS={yeeToggle:!0},e.prototype.dimension=function(){var e=this.$element.hasClass("width");return e?"width":"height"},e.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var e=$.Event("show.bs.yeeCollapse");if(this.$element.trigger(e),!e.isDefaultPrevented()){var t=this.$parent&&this.$parent.find("> .yee-panel > .in");if(t&&t.length){var i=t.data("bs.yeeCollapse");if(i&&i.transitioning)return;t.yeeCollapse("hide"),i||t.data("bs.yeeCollapse",null)}var o=this.dimension();this.$element.removeClass("yee-collapse").addClass("yee-collapsing")[o](0),this.transitioning=1;var n=function(){this.$element.removeClass("yee-collapsing").addClass("yee-collapse in")[o]("auto"),this.transitioning=0,this.$element.trigger("shown.bs.yeeCollapse")};if(!$.support.transition)return n.call(this);var s=$.camelCase(["scroll",o].join("-"));this.$element.one($.support.transition.end,$.proxy(n,this)).emulateTransitionEnd(350)[o](this.$element[0][s])}}},e.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var e=$.Event("hide.bs.yeeCollapse");if(this.$element.trigger(e),!e.isDefaultPrevented()){var t=this.dimension();this.$element[t](this.$element[t]())[0].offsetHeight,this.$element.addClass("yee-collapsing").removeClass("yee-collapse").removeClass("in"),this.transitioning=1;var i=function(){this.transitioning=0,this.$element.trigger("hidden.bs.yeeCollapse").removeClass("yee-collapsing").addClass("yee-collapse")};return $.support.transition?void this.$element[t](0).one($.support.transition.end,$.proxy(i,this)).emulateTransitionEnd(350):i.call(this)}}},e.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()};var t=$.fn.yeeCollapse;$.fn.yeeCollapse=function(t){return this.each(function(){var i=$(this),o=i.data("bs.yeeCollapse"),n=$.extend({},e.DEFAULTS,i.data(),"object"==typeof t&&t);!o&&n.yeeToggle&&"show"==t&&(t=!t),o||i.data("bs.yeeCollapse",o=new e(this,n)),"string"==typeof t&&o[t]()})},$.fn.yeeCollapse.Constructor=e,$.fn.yeeCollapse.noConflict=function(){return $.fn.yeeCollapse=t,this},$(document).on("click.bs.yeeCollapse.data-yee-api","[data-yee-toggle=collapse]",function(e){var t=$(this),i,o=t.attr("data-yee-target")||e.preventDefault()||(i=t.attr("href"))&&i.replace(/.*(?=#[^\s]+$)/,""),n=$(o),s=n.data("bs.yeeCollapse"),a=s?"toggle":t.data(),r=t.attr("data-yee-parent"),l=r&&$(r);s&&s.transitioning||(l&&l.find('[data-yee-toggle=collapse][data-yee-parent="'+r+'"]').not(t).addClass("collapsed"),t[n.hasClass("in")?"addClass":"removeClass"]("collapsed")),n.yeeCollapse(a)})}(jQuery),+function($){"use strict";function e(e){$(i).remove(),$(o).each(function(){var i=t($(this)),o={relatedTarget:this};i.hasClass("yee-open")&&(e=$.Event("hide.bs.yeeDropdown",o),e.isDefaultPrevented()||i.removeClass("yee-open").trigger("hidden.bs.yeeDropdown",o))})}function t(e){var t=e.attr("data-yee-target");t||(t=e.attr("href"),t=t&&/#[A-Za-z]/.test(t)&&t.replace(/.*(?=#[^\s]*$)/,""));var i=t&&$(t);return i&&i.length?i:e.parent()}var i=".yee-dropdown-backdrop",o="[data-yee-toggle=dropdown]",n=function(e){$(e).on("click.bs.yeeDropdown",this.toggle)};n.prototype.toggle=function(i){var o=$(this);if(!o.is(".disabled, :disabled")){var n=t(o),s=n.hasClass("yee-open");if(e(),!s){"ontouchstart"in document.documentElement&&!n.closest(".navbar-nav").length&&$('<div class="yee-dropdown-backdrop"/>').insertAfter($(this)).on("click",e);var a={relatedTarget:this};if(n.trigger(i=$.Event("show.bs.yeeDropdown",a)),i.isDefaultPrevented())return;n.toggleClass("yee-open").trigger("shown.bs.yeeDropdown",a),o.focus()}return!1}},n.prototype.keydown=function(e){if(/(38|40|27)/.test(e.keyCode)){var i=$(this);if(e.preventDefault(),e.stopPropagation(),!i.is(".disabled, :disabled")){var n=t(i),s=n.hasClass("yee-open");if(!s||s&&27==e.keyCode)return 27==e.which&&n.find(o).focus(),i.click();var a=" li:not(.divider):visible a",r=n.find("[role=menu]"+a+", [role=listbox]"+a);if(r.length){var l=r.index(r.filter(":focus"));38==e.keyCode&&l>0&&l--,40==e.keyCode&&l<r.length-1&&l++,~l||(l=0),r.eq(l).focus()}}}};var s=$.fn.yeeDropdown;$.fn.yeeDropdown=function(e){return this.each(function(){var t=$(this),i=t.data("bs.yeeDropdown");i||t.data("bs.yeeDropdown",i=new n(this)),"string"==typeof e&&i[e].call(t)})},$.fn.yeeDropdown.Constructor=n,$.fn.yeeDropdown.noConflict=function(){return $.fn.yeeDropdown=s,this},$(document).on("click.bs.yeeDropdown.data-yee-api",e).on("click.bs.yeeDropdown.data-yee-api",".yee-dropdown form",function(e){e.stopPropagation()}).on("click.bs.yeeDropdown.data-yee-api",o,n.prototype.toggle).on("keydown.bs.yeeDropdown.data-yee-api",o+", [role=menu], [role=listbox]",n.prototype.keydown)}(jQuery),+function($){"use strict";var e=function(e,t){this.options=t,this.$element=$(e),this.$backdrop=this.isShown=null,this.options.yeeRemote&&this.$element.find(".yee-modal-content").load(this.options.yeeRemote,$.proxy(function(){this.$element.trigger("loaded.bs.yeeModal")},this))};e.DEFAULTS={yeeBackdrop:!0,yeeKeyboard:!0,yeeShow:!0},e.prototype.toggle=function(e){return this[this.isShown?"hide":"show"](e)},e.prototype.show=function(e){var t=this,i=$.Event("show.bs.yeeModal",{relatedTarget:e});this.$element.trigger(i),this.isShown||i.isDefaultPrevented()||(this.isShown=!0,this.escape(),this.$element.on("click.dismiss.bs.yeeModal",'[data-yee-dismiss="modal"]',$.proxy(this.hide,this)),this.backdrop(function(){var i=$.support.transition&&t.$element.hasClass("fade");t.$element.parent().length||t.$element.appendTo(document.body),t.$element.show().scrollTop(0),i&&t.$element[0].offsetWidth,t.$element.addClass("in").attr("aria-hidden",!1);var o=$.Event("shown.bs.yeeModal",{relatedTarget:e});i?t.$element.find(".yee-modal-dialog").one($.support.transition.end,function(){t.$element.focus().trigger(o)}).emulateTransitionEnd(300):t.$element.focus().trigger(o)}))},e.prototype.hide=function(e){e&&e.preventDefault(),e=$.Event("hide.bs.yeeModal"),this.$element.trigger(e),this.isShown&&!e.isDefaultPrevented()&&(this.isShown=!1,this.escape(),$(document).off("focusin.bs.yeeModal"),this.$element.removeClass("in").attr("aria-hidden",!0).off("click.dismiss.bs.yeeModal"),$.support.transition&&this.$element.hasClass("fade")?this.$element.one($.support.transition.end,$.proxy(this.hideModal,this)).emulateTransitionEnd(300):this.hideModal())},e.prototype.enforceFocus=function(){$(document).off("focusin.bs.yeeModal").on("focusin.bs.yeeModal",$.proxy(function(e){this.$element[0]===e.target||this.$element.has(e.target).length||this.$element.focus()},this))},e.prototype.escape=function(){this.isShown&&this.options.yeeKeyboard?this.$element.on("keyup.dismiss.bs.yeeModal",$.proxy(function(e){27==e.which&&this.hide()},this)):this.isShown||this.$element.off("keyup.dismiss.bs.yeeModal")},e.prototype.hideModal=function(){var e=this;this.$element.hide(),this.backdrop(function(){e.removeBackdrop(),e.$element.trigger("hidden.bs.yeeModal")})},e.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},e.prototype.backdrop=function(e){var t=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.yeeBackdrop){var i=$.support.transition&&t;if(this.$backdrop=$('<div class="yee-modal-backdrop '+t+'" />').appendTo(document.body),this.$element.on("click.dismiss.bs.yeeModal",$.proxy(function(e){e.target===e.currentTarget&&("static"==this.options.yeeBackdrop?this.$element[0].focus.call(this.$element[0]):this.hide.call(this))},this)),i&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!e)return;i?this.$backdrop.one($.support.transition.end,e).emulateTransitionEnd(150):e()}else!this.isShown&&this.$backdrop?(this.$backdrop.removeClass("in"),$.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one($.support.transition.end,e).emulateTransitionEnd(150):e()):e&&e()};var t=$.fn.yeeModal;$.fn.yeeModal=function(t,i){return this.each(function(){var o=$(this),n=o.data("bs.yeeModal"),s=$.extend({},e.DEFAULTS,o.data(),"object"==typeof t&&t);n||o.data("bs.yeeModal",n=new e(this,s)),"string"==typeof t?n[t](i):s.yeeShow&&n.show(i)})},$.fn.yeeModal.Constructor=e,$.fn.yeeModal.noConflict=function(){return $.fn.yeeModal=t,this},$(document).on("click.bs.yeeModal.data-yee-api",'[data-yee-toggle="modal"]',function(e){var t=$(this),i=t.attr("href"),o=$(t.attr("data-yee-target")||i&&i.replace(/.*(?=#[^\s]+$)/,"")),n=o.data("bs.yeeModal")?"toggle":$.extend({remote:!/#/.test(i)&&i},o.data(),t.data());t.is("a")&&e.preventDefault(),o.yeeModal(n,this).one("hide",function(){t.is(":visible")&&t.focus()})}),$(document).on("show.bs.yeeModal",".yee-modal",function(){$(document.body).addClass("yee-modal-open")}).on("hidden.bs.yeeModal",".yee-modal",function(){$(document.body).removeClass("yee-modal-open")})}(jQuery),+function($){"use strict";var e=function(e,t){this.type=this.options=this.enabled=this.timeout=this.hoverState=this.$element=null,this.init("yeeTooltip",e,t)};e.DEFAULTS={yeeAnimation:!0,yeePlacement:"top",yeeSelector:!1,yeeTemplate:'<div class="yee-tooltip"><div class="yee-tooltip-arrow"></div><div class="yee-tooltip-inner"></div></div>',yeeTrigger:"hover focus",yeeTitle:"",yeeDelay:0,yeeHtml:!1,yeeContainer:!1},e.prototype.init=function(e,t,i){this.enabled=!0,this.type=e,this.$element=$(t),this.options=this.getOptions(i);for(var o=this.options.yeeTrigger.split(" "),n=o.length;n--;){var s=o[n];if("click"==s)this.$element.on("click."+this.type,this.options.yeeSelector,$.proxy(this.toggle,this));else if("manual"!=s){var a="hover"==s?"mouseenter":"focusin",r="hover"==s?"mouseleave":"focusout";this.$element.on(a+"."+this.type,this.options.yeeSelector,$.proxy(this.enter,this)),this.$element.on(r+"."+this.type,this.options.yeeSelector,$.proxy(this.leave,this))}}this.options.yeeSelector?this._options=$.extend({},this.options,{yeeTrigger:"manual",yeeSelector:""}):this.fixTitle()},e.prototype.getDefaults=function(){return e.DEFAULTS},e.prototype.getOptions=function(e){return e=$.extend({},this.getDefaults(),this.$element.data(),e),e.yeeDelay&&"number"==typeof e.yeeDelay&&(e.yeeDelay={show:e.yeeDelay,hide:e.yeeDelay}),e},e.prototype.getDelegateOptions=function(){var e={},t=this.getDefaults();return this._options&&$.each(this._options,function(i,o){t[i]!=o&&(e[i]=o)}),e},e.prototype.enter=function(e){var t=e instanceof this.constructor?e:$(e.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type);return clearTimeout(t.timeout),t.hoverState="in",t.options.yeeDelay&&t.options.yeeDelay.show?void(t.timeout=setTimeout(function(){"in"==t.hoverState&&t.show()},t.options.yeeDelay.show)):t.show()},e.prototype.leave=function(e){var t=e instanceof this.constructor?e:$(e.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type);return clearTimeout(t.timeout),t.hoverState="out",t.options.yeeDelay&&t.options.yeeDelay.hide?void(t.timeout=setTimeout(function(){"out"==t.hoverState&&t.hide()},t.options.yeeDelay.hide)):t.hide()},e.prototype.show=function(){var e=$.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){if(this.$element.trigger(e),e.isDefaultPrevented())return;var t=this,i=this.tip();this.setContent(),this.options.yeeAnimation&&i.addClass("fade");var o="function"==typeof this.options.yeePlacement?this.options.yeePlacement.call(this,i[0],this.$element[0]):this.options.yeePlacement,n=/\s?auto?\s?/i,s=n.test(o);s&&(o=o.replace(n,"")||"top"),i.detach().css({top:0,left:0,display:"block"}).addClass(o),this.options.yeeContainer?i.appendTo(this.options.yeeContainer):i.insertAfter(this.$element);var a=this.getPosition(),r=i[0].offsetWidth,l=i[0].offsetHeight;if(s){var h=this.$element.parent(),p=o,d=document.documentElement.scrollTop||document.body.scrollTop,f="body"==this.options.yeeContainer?window.innerWidth:h.outerWidth(),c="body"==this.options.yeeContainer?window.innerHeight:h.outerHeight(),y="body"==this.options.yeeContainer?0:h.offset().left;o="bottom"==o&&a.top+a.height+l-d>c?"top":"top"==o&&a.top-d-l<0?"bottom":"right"==o&&a.right+r>f?"left":"left"==o&&a.left-r<y?"right":o,i.removeClass(p).addClass(o)}var u=this.getCalculatedOffset(o,a,r,l);this.applyPlacement(u,o),this.hoverState=null;var v=function(){t.$element.trigger("shown.bs."+t.type)};$.support.transition&&this.$tip.hasClass("fade")?i.one($.support.transition.end,v).emulateTransitionEnd(150):v()}},e.prototype.applyPlacement=function(e,t){var i,o=this.tip(),n=o[0].offsetWidth,s=o[0].offsetHeight,a=parseInt(o.css("margin-top"),10),r=parseInt(o.css("margin-left"),10);isNaN(a)&&(a=0),isNaN(r)&&(r=0),e.top=e.top+a,e.left=e.left+r,$.offset.setOffset(o[0],$.extend({using:function(e){o.css({top:Math.round(e.top),left:Math.round(e.left)})}},e),0),o.addClass("in");var l=o[0].offsetWidth,h=o[0].offsetHeight;if("top"==t&&h!=s&&(i=!0,e.top=e.top+s-h),/bottom|top/.test(t)){var p=0;e.left<0&&(p=-2*e.left,e.left=0,o.offset(e),l=o[0].offsetWidth,h=o[0].offsetHeight),this.replaceArrow(p-n+l,l,"left")}else this.replaceArrow(h-s,h,"top");i&&o.offset(e)},e.prototype.replaceArrow=function(e,t,i){this.arrow().css(i,e?50*(1-e/t)+"%":"")},e.prototype.setContent=function(){var e=this.tip(),t=this.getTitle();e.find(".yee-tooltip-inner")[this.options.yeeHtml?"html":"text"](t),e.removeClass("fade in top bottom left right")},e.prototype.hide=function(){function e(){"in"!=t.hoverState&&i.detach(),t.$element.trigger("hidden.bs."+t.type)}var t=this,i=this.tip(),o=$.Event("hide.bs."+this.type);return this.$element.trigger(o),o.isDefaultPrevented()?void 0:(i.removeClass("in"),$.support.transition&&this.$tip.hasClass("fade")?i.one($.support.transition.end,e).emulateTransitionEnd(150):e(),this.hoverState=null,this)},e.prototype.fixTitle=function(){var e=this.$element;(e.attr("title")||"string"!=typeof e.attr("data-yee-original-title"))&&e.attr("data-yee-original-title",e.attr("title")||"").attr("title","")},e.prototype.hasContent=function(){return this.getTitle()},e.prototype.getPosition=function(){var e=this.$element[0];return $.extend({},"function"==typeof e.getBoundingClientRect?e.getBoundingClientRect():{width:e.offsetWidth,height:e.offsetHeight},this.$element.offset())},e.prototype.getCalculatedOffset=function(e,t,i,o){return"bottom"==e?{top:t.top+t.height,left:t.left+t.width/2-i/2}:"top"==e?{top:t.top-o,left:t.left+t.width/2-i/2}:"left"==e?{top:t.top+t.height/2-o/2,left:t.left-i}:{top:t.top+t.height/2-o/2,left:t.left+t.width}},e.prototype.getTitle=function(){var e,t=this.$element,i=this.options;return e=t.attr("data-yee-original-title")||("function"==typeof i.title?i.title.call(t[0]):i.title)},e.prototype.tip=function(){return this.$tip=this.$tip||$(this.options.yeeTemplate)},e.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".yee-tooltip-arrow")},e.prototype.validate=function(){this.$element[0].parentNode||(this.hide(),this.$element=null,this.options=null)},e.prototype.enable=function(){this.enabled=!0},e.prototype.disable=function(){this.enabled=!1},e.prototype.toggleEnabled=function(){this.enabled=!this.enabled},e.prototype.toggle=function(e){var t=e?$(e.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type):this;t.tip().hasClass("in")?t.leave(t):t.enter(t)},e.prototype.destroy=function(){clearTimeout(this.timeout),this.hide().$element.off("."+this.type).removeData("bs."+this.type)};var t=$.fn.yeeTooltip;$.fn.yeeTooltip=function(t){return this.each(function(){var i=$(this),o=i.data("bs.yeeTooltip"),n="object"==typeof t&&t;(o||"destroy"!=t)&&(o||i.data("bs.yeeTooltip",o=new e(this,n)),"string"==typeof t&&o[t]())})},$.fn.yeeTooltip.Constructor=e,$.fn.yeeTooltip.noConflict=function(){return $.fn.yeeTooltip=t,this}}(jQuery),+function($){"use strict";var e=function(e,t){this.init("yeePopover",e,t)};if(!$.fn.yeeTooltip)throw new Error("Popover requires tooltip.js");e.DEFAULTS=$.extend({},$.fn.yeeTooltip.Constructor.DEFAULTS,{yeePlacement:"right",yeeTrigger:"click",yeeContent:"",yeeTemplate:'<div class="yee-popover"><div class="arrow"></div><h3 class="yee-popover-title"></h3><div class="yee-popover-content"></div></div>'}),e.prototype=$.extend({},$.fn.yeeTooltip.Constructor.prototype),e.prototype.constructor=e,e.prototype.getDefaults=function(){return e.DEFAULTS},e.prototype.setContent=function(){var e=this.tip(),t=this.getTitle(),i=this.getContent();e.find(".yee-popover-title")[this.options.yeeHtml?"html":"text"](t),e.find(".yee-popover-content")[this.options.yeeHtml?"string"==typeof i?"html":"append":"text"](i),e.removeClass("fade top bottom left right in"),e.find(".yee-popover-title").html()||e.find(".yee-popover-title").hide()},e.prototype.hasContent=function(){return this.getTitle()||this.getContent()},e.prototype.getContent=function(){var e=this.$element,t=this.options;return e.attr("data-yee-content")||("function"==typeof t.content?t.content.call(e[0]):t.content)},e.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")},e.prototype.tip=function(){return this.$tip||(this.$tip=$(this.options.yeeTemplate)),this.$tip};var t=$.fn.yeePopover;$.fn.yeePopover=function(t){return this.each(function(){var i=$(this),o=i.data("bs.yeePopover"),n="object"==typeof t&&t;(o||"destroy"!=t)&&(o||i.data("bs.yeePopover",o=new e(this,n)),"string"==typeof t&&o[t]())})},$.fn.yeePopover.Constructor=e,$.fn.yeePopover.noConflict=function(){return $.fn.yeePopover=t,this}}(jQuery),+function($){"use strict";function e(t,i){var o,n=$.proxy(this.process,this);this.$element=$($(t).is("body")?window:t),this.$body=$("body"),this.$scrollElement=this.$element.on("scroll.bs.scroll-spy.data-yee-api",n),this.options=$.extend({},e.DEFAULTS,i),this.selector=(this.options.yeeTarget||(o=$(t).attr("href"))&&o.replace(/.*(?=#[^\s]+$)/,"")||"")+" .nav li > a",this.offsets=$([]),this.targets=$([]),this.activeTarget=null,this.refresh(),this.process()}e.DEFAULTS={yeeOffset:10},e.prototype.refresh=function(){var e=this.$element[0]==window?"offset":"position";this.offsets=$([]),this.targets=$([]);var t=this,i=this.$body.find(this.selector).map(function(){var i=$(this),o=i.data("target")||i.attr("href"),n=/^#./.test(o)&&$(o);return n&&n.length&&n.is(":visible")&&[[n[e]().top+(!$.isWindow(t.$scrollElement.get(0))&&t.$scrollElement.scrollTop()),o]]||null}).sort(function(e,t){return e[0]-t[0]}).each(function(){t.offsets.push(this[0]),t.targets.push(this[1])})},e.prototype.process=function(){var e=this.$scrollElement.scrollTop()+this.options.yeeOffset,t=this.$scrollElement[0].scrollHeight||this.$body[0].scrollHeight,i=t-this.$scrollElement.height(),o=this.offsets,n=this.targets,s=this.activeTarget,a;if(e>=i)return s!=(a=n.last()[0])&&this.activate(a);if(s&&e<=o[0])return s!=(a=n[0])&&this.activate(a);for(a=o.length;a--;)s!=n[a]&&e>=o[a]&&(!o[a+1]||e<=o[a+1])&&this.activate(n[a])},e.prototype.activate=function(e){this.activeTarget=e,$(this.selector).parentsUntil(this.options.yeeTarget,".active").removeClass("active");var t=this.selector+'[data-yee-target="'+e+'"],'+this.selector+'[href="'+e+'"]',i=$(t).parents("li").addClass("active");i.parent(".yee-dropdown-menu").length&&(i=i.closest("li.yee-dropdown").addClass("active")),i.trigger("activate.bs.yeeScrollspy")};var t=$.fn.yeeScrollspy;$.fn.yeeScrollspy=function(t){return this.each(function(){var i=$(this),o=i.data("bs.yeeScrollspy"),n="object"==typeof t&&t;o||i.data("bs.yeeScrollspy",o=new e(this,n)),"string"==typeof t&&o[t]()})},$.fn.yeeScrollspy.Constructor=e,$.fn.yeeScrollspy.noConflict=function(){return $.fn.yeeScrollspy=t,this},$(window).on("load",function(){$('[data-yee-spy="scroll"]').each(function(){var e=$(this);e.yeeScrollspy(e.data())})})}(jQuery),+function($){"use strict";var e=function(e){this.element=$(e)};e.prototype.show=function(){var e=this.element,t=e.closest("ul:not(.yee-dropdown-menu)"),i=e.data("target");if(i||(i=e.attr("href"),i=i&&i.replace(/.*(?=#[^\s]*$)/,"")),!e.parent("li").hasClass("active")){var o=t.find(".active:last a")[0],n=$.Event("show.bs.yeeTab",{relatedTarget:o});if(e.trigger(n),!n.isDefaultPrevented()){var s=$(i);this.activate(e.parent("li"),t),this.activate(s,s.parent(),function(){e.trigger({type:"shown.bs.yeeTab",relatedTarget:o})})}}},e.prototype.activate=function(e,t,i){function o(){n.removeClass("active").find("> .yee-dropdown-menu > .active").removeClass("active"),e.addClass("active"),s?(e[0].offsetWidth,e.addClass("in")):e.removeClass("fade"),e.parent(".yee-dropdown-menu")&&e.closest("li.yee-dropdown").addClass("active"),i&&i()}var n=t.find("> .active"),s=i&&$.support.transition&&n.hasClass("fade");s?n.one($.support.transition.end,o).emulateTransitionEnd(150):o(),n.removeClass("in")};var t=$.fn.yeeTab;$.fn.yeeTab=function(t){return this.each(function(){var i=$(this),o=i.data("bs.yeeTab");o||i.data("bs.yeeTab",o=new e(this)),"string"==typeof t&&o[t]()})},$.fn.yeeTab.Constructor=e,$.fn.yeeTab.noConflict=function(){return $.fn.yeeTab=t,this},$(document).on("click.bs.yeeTab.data-yee-api",'[data-yee-toggle="tab"], [data-yee-toggle="pill"]',function(e){e.preventDefault(),$(this).yeeTab("show")})}(jQuery),+function($){"use strict";var e=function(t,i){this.options=$.extend({},e.DEFAULTS,i),this.$window=$(window).on("scroll.bs.affix.data-yee-api",$.proxy(this.checkPosition,this)).on("click.bs.affix.data-yee-api",$.proxy(this.checkPositionWithEventLoop,this)),this.$element=$(t),this.affixed=this.unpin=this.pinnedOffset=null,this.checkPosition()};e.RESET="affix affix-top affix-bottom",e.DEFAULTS={yeeOffset:0},e.prototype.getPinnedOffset=function(){if(this.pinnedOffset)return this.pinnedOffset;this.$element.removeClass(e.RESET).addClass("affix");var t=this.$window.scrollTop(),i=this.$element.offset();return this.pinnedOffset=i.top-t},e.prototype.checkPositionWithEventLoop=function(){setTimeout($.proxy(this.checkPosition,this),1)},e.prototype.checkPosition=function(){if(this.$element.is(":visible")){var t=$(document).height(),i=this.$window.scrollTop(),o=this.$element.offset(),n=this.options.yeeOffset,s=n.top,a=n.bottom;"top"==this.affixed&&(o.top+=i),"object"!=typeof n&&(a=s=n),"function"==typeof s&&(s=n.top(this.$element)),"function"==typeof a&&(a=n.bottom(this.$element));var r=null!=this.unpin&&i+this.unpin<=o.top?!1:null!=a&&o.top+this.$element.height()>=t-a?"bottom":null!=s&&s>=i?"top":!1;if(this.affixed!==r){this.unpin&&this.$element.css("top","");var l="affix"+(r?"-"+r:""),h=$.Event(l+".bs.affix");this.$element.trigger(h),h.isDefaultPrevented()||(this.affixed=r,this.unpin="bottom"==r?this.getPinnedOffset():null,this.$element.removeClass(e.RESET).addClass(l).trigger($.Event(l.replace("affix","affixed"))),"bottom"==r&&this.$element.offset({top:t-a-this.$element.height()}))}}};var t=$.fn.affix;$.fn.affix=function(t){return this.each(function(){var i=$(this),o=i.data("bs.affix"),n="object"==typeof t&&t;o||i.data("bs.affix",o=new e(this,n)),"string"==typeof t&&o[t]()})},$.fn.affix.Constructor=e,$.fn.affix.noConflict=function(){return $.fn.affix=t,this},$(window).on("load",function(){$('[data-yee-spy="affix"]').each(function(){var e=$(this),t=e.data();t.offset=t.offset||{},t.offsetBottom&&(t.offset.bottom=t.offsetBottom),t.offsetTop&&(t.offset.top=t.offsetTop),e.affix(t)})})}(jQuery);