!function(t,e,i){"use strict";var o={version:"2.1",tipLocation:"bottom",nubPosition:"auto",scroll:!0,scrollSpeed:300,timer:0,autoStart:!1,startTimerOnClick:!0,startOffset:0,nextButton:!0,tipAnimation:"fade",pauseAfter:[],tipAnimationFadeSpeed:300,cookieMonster:!1,cookieName:"joyride",cookieDomain:!1,cookiePath:!1,localStorage:!1,localStorageKey:"joyride",tipContainer:"body",modal:!1,expose:!1,postExposeCallback:t.noop,preRideCallback:t.noop,postRideCallback:t.noop,preStepCallback:t.noop,postStepCallback:t.noop,template:{link:'<a href="#close" class="joyride-close-tip">X</a>',timer:'<div class="joyride-timer-indicator-wrap"><span class="joyride-timer-indicator"></span></div>',tip:'<div class="joyride-tip-guide"><span class="joyride-nub"></span></div>',wrapper:'<div class="joyride-content-wrapper" role="dialog"></div>',button:'<a href="#" class="joyride-next-tip"></a>',modal:'<div class="joyride-modal-bg"></div>',expose:'<div class="joyride-expose-wrapper"></div>',exposeCover:'<div class="joyride-expose-cover"></div>'}},n=n||!1,r={},s={init:function(i){return this.each(function(){t.isEmptyObject(r)?(r=t.extend(!0,o,i),r.document=e.document,r.$document=t(r.document),r.$window=t(e),r.$content_el=t(this),r.$body=t(r.tipContainer),r.body_offset=t(r.tipContainer).position(),r.$tip_content=t("> li",r.$content_el),r.paused=!1,r.attempts=0,r.tipLocationPatterns={top:["bottom"],bottom:[],left:["right","top","bottom"],right:["left","top","bottom"]},s.jquery_check(),t.isFunction(t.cookie)||(r.cookieMonster=!1),r.cookieMonster&&t.cookie(r.cookieName)||r.localStorage&&s.support_localstorage()&&localStorage.getItem(r.localStorageKey)||(r.$tip_content.each(function(e){s.create({$li:t(this),index:e})}),r.autoStart&&(!r.startTimerOnClick&&r.timer>0?(s.show("init"),s.startTimer()):s.show("init"))),r.$document.on("click.joyride",".joyride-next-tip, .joyride-modal-bg",function(t){t.preventDefault(),r.$li.next().length<1?s.end():r.timer>0?(clearTimeout(r.automate),s.hide(),s.show(),s.startTimer()):(s.hide(),s.show())}),r.$document.on("click.joyride",".joyride-close-tip",function(t){t.preventDefault(),s.end(!0)}),r.$window.bind("resize.joyride",function(){if(r.$li){if(r.exposed&&r.exposed.length>0){var e=t(r.exposed);e.each(function(){var e=t(this);s.un_expose(e),s.expose(e)})}s.is_phone()?s.pos_phone():s.pos_default()}})):s.restart()})},resume:function(){s.set_li(),s.show()},nextTip:function(){r.$li.next().length<1?s.end():r.timer>0?(clearTimeout(r.automate),s.hide(),s.show(),s.startTimer()):(s.hide(),s.show())},tip_template:function(e){var i,o,n;return e.tip_class=e.tip_class||"",i=t(r.template.tip).addClass(e.tip_class),o=t.trim(t(e.li).html())+s.button_text(e.button_text)+r.template.link+s.timer_instance(e.index),n=t(r.template.wrapper),e.li.attr("data-aria-labelledby")&&n.attr("aria-labelledby",e.li.attr("data-aria-labelledby")),e.li.attr("data-aria-describedby")&&n.attr("aria-describedby",e.li.attr("data-aria-describedby")),i.append(n),i.first().attr("data-index",e.index),t(".joyride-content-wrapper",i).append(o),i[0]},timer_instance:function(e){var i;return i=0===e&&r.startTimerOnClick&&r.timer>0||0===r.timer?"":s.outerHTML(t(r.template.timer)[0])},button_text:function(e){return r.nextButton?(e=t.trim(e)||"Next",e=s.outerHTML(t(r.template.button).append(e)[0])):e="",e},create:function(e){var i=e.$li.attr("data-button")||e.$li.attr("data-text"),o=e.$li.attr("class"),n=t(s.tip_template({tip_class:o,index:e.index,button_text:i,li:e.$li}));t(r.tipContainer).append(n)},show:function(e){var o,n,a={},p=[],l=0,d=null;if(r.$li===i||-1===t.inArray(r.$li.index(),r.pauseAfter))if(r.paused?r.paused=!1:s.set_li(e),r.attempts=0,r.$li.length&&r.$target.length>0){for(e&&(r.preRideCallback(r.$li.index(),r.$next_tip),r.modal&&s.show_modal()),r.preStepCallback(r.$li.index(),r.$next_tip),p=(r.$li.data("options")||":").split(";"),l=p.length,o=l-1;o>=0;o--)n=p[o].split(":"),2===n.length&&(a[t.trim(n[0])]=t.trim(n[1]));r.tipSettings=t.extend({},r,a),r.tipSettings.tipLocationPattern=r.tipLocationPatterns[r.tipSettings.tipLocation],r.modal&&r.expose&&s.expose(),!/body/i.test(r.$target.selector)&&r.scroll&&s.scroll_to(),s.is_phone()?s.pos_phone(!0):s.pos_default(!0),d=t(".joyride-timer-indicator",r.$next_tip),/pop/i.test(r.tipAnimation)?(d.outerWidth(0),r.timer>0?(r.$next_tip.show(),d.animate({width:t(".joyride-timer-indicator-wrap",r.$next_tip).outerWidth()},r.timer)):r.$next_tip.show()):/fade/i.test(r.tipAnimation)&&(d.outerWidth(0),r.timer>0?(r.$next_tip.fadeIn(r.tipAnimationFadeSpeed),r.$next_tip.show(),d.animate({width:t(".joyride-timer-indicator-wrap",r.$next_tip).outerWidth()},r.timer)):r.$next_tip.fadeIn(r.tipAnimationFadeSpeed)),r.$current_tip=r.$next_tip,t(".joyride-next-tip",r.$current_tip).focus(),s.tabbable(r.$current_tip)}else r.$li&&r.$target.length<1?s.show():s.end();else r.paused=!0},is_phone:function(){return n?n.mq("only screen and (max-width: 767px)"):r.$window.width()<767?!0:!1},support_localstorage:function(){return n?n.localstorage:!!e.localStorage},hide:function(){r.modal&&r.expose&&s.un_expose(),r.modal||t(".joyride-modal-bg").hide(),r.$current_tip.hide(),r.postStepCallback(r.$li.index(),r.$current_tip)},set_li:function(t){t?(r.$li=r.$tip_content.eq(r.startOffset),s.set_next_tip(),r.$current_tip=r.$next_tip):(r.$li=r.$li.next(),s.set_next_tip()),s.set_target()},set_next_tip:function(){r.$next_tip=t(".joyride-tip-guide[data-index="+r.$li.index()+"]")},set_target:function(){var e=r.$li.attr("data-class"),i=r.$li.attr("data-id"),o=function(){return i?t(r.document.getElementById(i)):e?t("."+e).filter(":visible").first():t("body")};r.$target=o()},scroll_to:function(){var e,i;e=r.$window.height()/2,i=Math.ceil(r.$target.offset().top-e+r.$next_tip.outerHeight()),t("html, body").stop().animate({scrollTop:i},r.scrollSpeed)},paused:function(){return-1===t.inArray(r.$li.index()+1,r.pauseAfter)?!0:!1},destroy:function(){t.isEmptyObject(r)||r.$document.off(".joyride"),t(e).off(".joyride"),t(".joyride-close-tip, .joyride-next-tip, .joyride-modal-bg").off(".joyride"),t(".joyride-tip-guide, .joyride-modal-bg").remove(),clearTimeout(r.automate),r={}},restart:function(){r.autoStart?(s.hide(),r.$li=i,s.show("init")):(!r.startTimerOnClick&&r.timer>0?(s.show("init"),s.startTimer()):s.show("init"),r.autoStart=!0)},pos_default:function(e){var i=(Math.ceil(r.$window.height()/2),r.$next_tip.offset(),t(".joyride-nub",r.$next_tip)),o=Math.ceil(i.outerWidth()/2),n=Math.ceil(i.outerHeight()/2),a=e||!1;if(a&&(r.$next_tip.css("visibility","hidden"),r.$next_tip.show()),/body/i.test(r.$target.selector))r.$li.length&&s.pos_modal(i);else{var p=r.tipSettings.tipAdjustmentY?parseInt(r.tipSettings.tipAdjustmentY):0,l=r.tipSettings.tipAdjustmentX?parseInt(r.tipSettings.tipAdjustmentX):0;s.bottom()?(r.$next_tip.css({top:r.$target.offset().top+n+r.$target.outerHeight()+p,left:r.$target.offset().left+l}),/right/i.test(r.tipSettings.nubPosition)&&r.$next_tip.css("left",r.$target.offset().left-r.$next_tip.outerWidth()+r.$target.outerWidth()),s.nub_position(i,r.tipSettings.nubPosition,"top")):s.top()?(r.$next_tip.css({top:r.$target.offset().top-r.$next_tip.outerHeight()-n+p,left:r.$target.offset().left+l}),s.nub_position(i,r.tipSettings.nubPosition,"bottom")):s.right()?(r.$next_tip.css({top:r.$target.offset().top+p,left:r.$target.outerWidth()+r.$target.offset().left+o+l}),s.nub_position(i,r.tipSettings.nubPosition,"left")):s.left()&&(r.$next_tip.css({top:r.$target.offset().top+p,left:r.$target.offset().left-r.$next_tip.outerWidth()-o+l}),s.nub_position(i,r.tipSettings.nubPosition,"right")),!s.visible(s.corners(r.$next_tip))&&r.attempts<r.tipSettings.tipLocationPattern.length&&(i.removeClass("bottom").removeClass("top").removeClass("right").removeClass("left"),r.tipSettings.tipLocation=r.tipSettings.tipLocationPattern[r.attempts],r.attempts++,s.pos_default(!0))}a&&(r.$next_tip.hide(),r.$next_tip.css("visibility","visible"))},pos_phone:function(e){var i=r.$next_tip.outerHeight(),o=(r.$next_tip.offset(),r.$target.outerHeight()),n=t(".joyride-nub",r.$next_tip),a=Math.ceil(n.outerHeight()/2),p=e||!1;n.removeClass("bottom").removeClass("top").removeClass("right").removeClass("left"),p&&(r.$next_tip.css("visibility","hidden"),r.$next_tip.show()),/body/i.test(r.$target.selector)?r.$li.length&&s.pos_modal(n):s.top()?(r.$next_tip.offset({top:r.$target.offset().top-i-a}),n.addClass("bottom")):(r.$next_tip.offset({top:r.$target.offset().top+o+a}),n.addClass("top")),p&&(r.$next_tip.hide(),r.$next_tip.css("visibility","visible"))},pos_modal:function(t){s.center(),t.hide(),s.show_modal()},show_modal:function(){t(".joyride-modal-bg").length<1&&t("body").append(r.template.modal).show(),/pop/i.test(r.tipAnimation)?t(".joyride-modal-bg").show():t(".joyride-modal-bg").fadeIn(r.tipAnimationFadeSpeed)},expose:function(){var i,o,n,a,p="expose-"+Math.floor(1e4*Math.random());if(arguments.length>0&&arguments[0]instanceof t)n=arguments[0];else{if(!r.$target||/body/i.test(r.$target.selector))return!1;n=r.$target}return n.length<1?(e.console&&console.error("element not valid",n),!1):(i=t(r.template.expose),r.$body.append(i),i.css({top:n.offset().top,left:n.offset().left,width:n.outerWidth(!0),height:n.outerHeight(!0)}),o=t(r.template.exposeCover),a={zIndex:n.css("z-index"),position:n.css("position")},n.css("z-index",1*i.css("z-index")+1),"static"==a.position&&n.css("position","relative"),n.data("expose-css",a),o.css({top:n.offset().top,left:n.offset().left,width:n.outerWidth(!0),height:n.outerHeight(!0)}),r.$body.append(o),i.addClass(p),o.addClass(p),r.tipSettings.exposeClass&&(i.addClass(r.tipSettings.exposeClass),o.addClass(r.tipSettings.exposeClass)),n.data("expose",p),r.postExposeCallback(r.$li.index(),r.$next_tip,n),void s.add_exposed(n))},un_expose:function(){var i,o,n,a,p=!1;if(arguments.length>0&&arguments[0]instanceof t)o=arguments[0];else{if(!r.$target||/body/i.test(r.$target.selector))return!1;o=r.$target}return o.length<1?(e.console&&console.error("element not valid",o),!1):(i=o.data("expose"),n=t("."+i),arguments.length>1&&(p=arguments[1]),p===!0?t(".joyride-expose-wrapper,.joyride-expose-cover").remove():n.remove(),a=o.data("expose-css"),"auto"==a.zIndex?o.css("z-index",""):o.css("z-index",a.zIndex),a.position!=o.css("position")&&("static"==a.position?o.css("position",""):o.css("position",a.position)),o.removeData("expose"),o.removeData("expose-z-index"),void s.remove_exposed(o))},add_exposed:function(e){r.exposed=r.exposed||[],e instanceof t?r.exposed.push(e[0]):"string"==typeof e&&r.exposed.push(e)},remove_exposed:function(e){var i;e instanceof t?i=e[0]:"string"==typeof e&&(i=e),r.exposed=r.exposed||[];for(var o=0;o<r.exposed.length;o++)if(r.exposed[o]==i)return void r.exposed.splice(o,1)},center:function(){var t=r.$window;return r.$next_tip.css({top:(t.height()-r.$next_tip.outerHeight())/2+t.scrollTop(),left:(t.width()-r.$next_tip.outerWidth())/2+t.scrollLeft()}),!0},bottom:function(){return/bottom/i.test(r.tipSettings.tipLocation)},top:function(){return/top/i.test(r.tipSettings.tipLocation)},right:function(){return/right/i.test(r.tipSettings.tipLocation)},left:function(){return/left/i.test(r.tipSettings.tipLocation)},corners:function(t){var e=r.$window,i=e.height()/2,o=Math.ceil(r.$target.offset().top-i+r.$next_tip.outerHeight()),n=e.width()+e.scrollLeft(),s=e.height()+o,a=e.height()+e.scrollTop(),p=e.scrollTop();return p>o&&(p=0>o?0:o),s>a&&(a=s),[t.offset().top<p,n<t.offset().left+t.outerWidth(),a<t.offset().top+t.outerHeight(),e.scrollLeft()>t.offset().left]},visible:function(t){for(var e=t.length;e--;)if(t[e])return!1;return!0},nub_position:function(t,e,i){t.addClass("auto"===e?i:e)},startTimer:function(){r.$li.length?r.automate=setTimeout(function(){s.hide(),s.show(),s.startTimer()},r.timer):clearTimeout(r.automate)},end:function(e){e=e||!1,e&&r.$window.unbind("resize.joyride"),r.cookieMonster&&t.cookie(r.cookieName,"ridden",{expires:365,domain:r.cookieDomain,path:r.cookiePath}),r.localStorage&&localStorage.setItem(r.localStorageKey,!0),r.timer>0&&clearTimeout(r.automate),r.modal&&r.expose&&s.un_expose(),r.$current_tip&&r.$current_tip.hide(),r.$li&&(r.postStepCallback(r.$li.index(),r.$current_tip,e),r.postRideCallback(r.$li.index(),r.$current_tip,e)),t(".joyride-modal-bg").hide()},jquery_check:function(){return t.isFunction(t.fn.on)?!0:(t.fn.on=function(t,e,i){return this.delegate(e,t,i)},t.fn.off=function(t,e,i){return this.undelegate(e,t,i)},!1)},outerHTML:function(t){return t.outerHTML||(new XMLSerializer).serializeToString(t)},version:function(){return r.version},tabbable:function(e){t(e).on("keydown",function(i){if(!i.isDefaultPrevented()&&i.keyCode&&27===i.keyCode)return i.preventDefault(),void s.end(!0);if(9===i.keyCode){var o=t(e).find(":tabbable"),n=o.filter(":first"),r=o.filter(":last");i.target!==r[0]||i.shiftKey?i.target===n[0]&&i.shiftKey&&(r.focus(1),i.preventDefault()):(n.focus(1),i.preventDefault())}})}};t.fn.joyride=function(e){return s[e]?s[e].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof e&&e?void t.error("Method "+e+" does not exist on jQuery.joyride"):s.init.apply(this,arguments)}}(jQuery,this);