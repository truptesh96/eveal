jQuery(function($){

    /*------- Scroll Out JS ---------*/
    var ScrollOut = function () {
        "use strict"
        function S(e, t, n) { return e < t ? t : n < e ? n : e } function T(e) { return +(0 < e) - +(e < 0) } var q, t = {}
        function n(e) { return "-" + e[0].toLowerCase() } function d(e) { return t[e] || (t[e] = e.replace(/([A-Z])/g, n)) } function v(e, t) { return e && 0 !== e.length ? e.nodeName ? [e] : [].slice.call(e[0].nodeName ? e : (t || document.documentElement).querySelectorAll(e)) : [] } function h(e, t) { for (var n in t) n.indexOf("_") && e.setAttribute("data-" + d(n), t[n]) } var z = []
        function e() { q = 0, z.slice().forEach(function (e) { return e() }), F() } function F() { !q && z.length && (q = requestAnimationFrame(e)) } function N(e, t, n, r) { return "function" == typeof e ? e(t, n, r) : e } function m() { } return function (L) {
            var i, P, _, H, o = (L = L || {}).onChange || m, l = L.onHidden || m, c = L.onShown || m, s = L.onScroll || m, f = L.cssProps ? (i = L.cssProps, function (e, t) {
                for (var n in t) n.indexOf("_") && (!0 === i || i[n]) && e.style.setProperty("--" + d(n), (r = t[n], Math.round(1e4 * r) / 1e4))
                var r
            }) : m, e = L.scrollingElement, A = e ? v(e)[0] : window, W = e ? v(e)[0] : document.documentElement, x = !1, O = {}, y = []
            function t() { y = v(L.targets || "[data-scroll]", v(L.scope || W)[0]).map(function (e) { return { element: e } }) } function n() {
                var e = W.clientWidth, t = W.clientHeight, n = T(-P + (P = W.scrollLeft || window.pageXOffset)), r = T(-_ + (_ = W.scrollTop || window.pageYOffset)), i = W.scrollLeft / (W.scrollWidth - e || 1), o = W.scrollTop / (W.scrollHeight - t || 1)
                x = x || O.scrollDirX !== n || O.scrollDirY !== r || O.scrollPercentX !== i || O.scrollPercentY !== o, O.scrollDirX = n, O.scrollDirY = r, O.scrollPercentX = i, O.scrollPercentY = o
                for (var l, c = !1, s = 0; s < y.length; s++) {
                    for (var f = y[s], u = f.element, a = u, d = 0, v = 0; d += a.offsetLeft, v += a.offsetTop, (a = a.offsetParent) && a !== A;); var h = u.clientHeight || u.offsetHeight || 0, m = u.clientWidth || u.offsetWidth || 0, g = (S(d + m, P, P + e) - S(d, P, P + e)) / m, p = (S(v + h, _, _ + t) - S(v, _, _ + t)) / h, w = 1 === g ? 0 : T(d - P), X = 1 === p ? 0 : T(v - _), Y = S((P - (m / 2 + d - e / 2)) / (e / 2), -1, 1), b = S((_ - (h / 2 + v - t / 2)) / (t / 2), -1, 1), D = void 0
                    D = L.offset ? N(L.offset, u, f, W) > _ ? 0 : 1 : (N(L.threshold, u, f, W) || 0) < g * p ? 1 : 0
                    var E = f.visible !== D; (f._changed || E || f.visibleX !== g || f.visibleY !== p || f.index !== s || f.elementHeight !== h || f.elementWidth !== m || f.offsetX !== d || f.offsetY !== v || f.intersectX != f.intersectX || f.intersectY != f.intersectY || f.viewportX !== Y || f.viewportY !== b) && (c = !0, f._changed = !0, f._visibleChanged = E, f.visible = D, f.elementHeight = h, f.elementWidth = m, f.index = s, f.offsetX = d, f.offsetY = v, f.visibleX = g, f.visibleY = p, f.intersectX = w, f.intersectY = X, f.viewportX = Y, f.viewportY = b, f.visible = D)
                } H || !x && !c || (l = C, z.push(l), F(), H = function () { !(z = z.filter(function (e) { return e !== l })).length && q && (cancelAnimationFrame(q), q = 0) })
            } function C() {
                u(), x && (x = !1, h(W, { scrollDirX: O.scrollDirX, scrollDirY: O.scrollDirY }), f(W, O), s(W, O, y))
                for (var e = y.length - 1; -1 < e; e--) {
                    var t = y[e], n = t.element, r = t.visible, i = n.hasAttribute("scrollout-once") || !1
                    t._changed && (t._changed = !1, f(n, t)), t._visibleChanged && (h(n, { scroll: r ? "in" : "out" }), o(n, t, W), (r ? c : l)(n, t, W)), r && (L.once || i) && y.splice(e, 1)
                }
            } function u() { H && (H(), H = void 0) } t(), n(), C()
            var r = 0, a = function () { r = r || setTimeout(function () { r = 0, n() }, 0) }
            return window.addEventListener("resize", a), A.addEventListener("scroll", a), { index: t, update: n, teardown: function () { u(), window.removeEventListener("resize", a), A.removeEventListener("scroll", a) } }
        }
    }()
    /*------- Scroll Out JS Ends ---------*/

    function smoothScroll() {
        ScrollOut({ targets: '.anim', onShown(el) { el.classList.add("in"); threshold: .5; } });
        ScrollOut({
            targets: '.anim.repeat', onShown(el) { el.classList.add("in"); el.classList.remove("out"); threshold: .5; }, onHidden(el) {
                el.classList.remove("in");
                el.classList.add("out");
            }
        });
    }
 
    // Slider
	function sliderInit() {
		$('.slickSlides:not(.slickSlides.slick-initialized)').each(function(){
		  if( $(this).find('.slide').length >= $(this).attr('data-minslides') ) {
			var options = $(this).attr('data-slick');
			var options = JSON.parse($(this).attr('data-slick'));
			$(this).slick(options);
		  }
		});
	} 
    // Marque
    function marqueElem() { $('.marqueElem').each(function() { $marQueeWidth = $(this).find('.inner').width($(this).find('.tieOne').outerWidth()); $(this).width($marQueeWidth); }); }
		 
    // Tabbing
    function handleTabs() {
        $('.tabLink').click(function(e) {
            e.preventDefault(); var $this = $(this); var target = $this.attr('href'); $('.tabLink').removeClass('active').attr('aria-selected', 'false').attr('tabindex', '-1');
            $this.addClass('active').attr('aria-selected', 'true').attr('tabindex', '0'); $('.tabContent').removeClass('active').attr('aria-hidden', 'true'); 
            $(target).addClass('active').attr('aria-hidden', 'false');
        });
        $('.tabLink').first().addClass('active').attr('aria-selected', 'true').attr('tabindex', '0'); $('.tabContent').first().addClass('active').attr('aria-hidden', 'false');
    }

	$(document).ready(function() {
		
		handleTabs(); marqueElem(); sliderInit(); smoothScroll();

        $('.accordionTrig').click(function(){
            var $this = $(this);
            $this.toggleClass('active'); $this.next('.accordionContent').slideToggle('1200');
            var expanded = $this.attr('aria-expanded') === 'true' || false; $this.attr('aria-expanded', !expanded);  $this.next('.faqContent').attr('aria-hidden', expanded);   
        }); 
	});



    // Move Image on mouse moment
    $(".moveImage").on("mouseover mousemove ", function() {
      $(this).children("img").css({ transform: "scale(1.5)" });
    }).on("mouseout", function() {
      $(this).children("img").css({ transform: "scale(1)" });
    }).on("mousemove", function(e) { $(this).children("img").css({ "transform-origin":((e.pageX - $(this).offset().left) / $(this).width()) * 100 + "% " + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 + "%" });
    });

 
});


