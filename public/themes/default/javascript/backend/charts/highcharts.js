/*
 Highcharts 4.0.4 JS v/Highstock 2.0.4 (2014-09-02)

 (c) 2009-2014 Torstein Honsi

 License: www.highcharts.com/license

 Highcharts funnel module

 (c) 2010-2014 Torstein Honsi

 License: www.highcharts.com/license
 Highcharts 4.1.3 JS v/Highstock 2.1.2 (2015-02-27)
 Exporting module

 (c) 2010-2014 Torstein Honsi

 License: www.highcharts.com/license
 Highcharts 4.1.3 JS v/Highstock 2.1.2 (2015-02-27)
 Data module

 (c) 2012-2014 Torstein Honsi

 License: www.highcharts.com/license
 Highcharts 4.1.3 JS v/Highstock 2.1.2 (2015-02-27)
 Plugin for displaying a message when there is no data visible in chart.

 (c) 2010-2014 Highsoft AS
 Author: Oystein Moseng

 License: www.highcharts.com/license
 Highcharts 4.1.3 JS v/Highstock 2.1.2 (2015-02-27)
 Solid angular gauge module

 (c) 2010-2014 Torstein Honsi

 License: www.highcharts.com/license
 Highcharts 4.1.3 JS v/Highstock 2.1.2 (2015-02-27)

 (c) 2011-2014 Torstein Honsi

 License: www.highcharts.com/license
 */
(function () {
    function n(a, b) {
        var c;
        a || (a = {});
        for (c in b) a[c] = b[c];
        return a
    }

    function E() {
        var a, b = arguments,
            c, d = {}, e = function (a, b) {
                var c, d;
                "object" !== typeof a && (a = {});
                for (d in b) b.hasOwnProperty(d) && ((c = b[d]) && "object" === typeof c && "[object Array]" !== Object.prototype.toString.call(c) && "renderTo" !== d && "number" !== typeof c.nodeType ? a[d] = e(a[d] || {}, c) : a[d] = b[d]);
                return a
            };
        !0 === b[0] && (d = b[1], b = Array.prototype.slice.call(b, 2));
        c = b.length;
        for (a = 0; a < c; a++) d = e(d, b[a]);
        return d
    }

    function O(a, b) {
        return parseInt(a, b || 10)
    }

    function Y(a) {
        return "string" === typeof a
    }

    function Q(a) {
        return a && "object" === typeof a
    }

    function S(a) {
        return "[object Array]" === Object.prototype.toString.call(a)
    }

    function aa(a) {
        return "number" === typeof a
    }

    function B(a) {
        return la.log(a) / la.LN10
    }

    function l(a) {
        return la.pow(10, a)
    }

    function y(a, b) {
        for (var c = a.length; c--;)
            if (a[c] === b) {
                a.splice(c, 1);
                break
            }
    }

    function u(a) {
        return a !== G && null !== a
    }

    function C(a, b, c) {
        var d, e;
        if (Y(b)) u(c) ? a.setAttribute(b, c) : a && a.getAttribute && (e = a.getAttribute(b));
        else if (u(b) && Q(b))
            for (d in b) a.setAttribute(d, b[d]);
        return e
    }

    function w(a) {
        return S(a) ? a : [a]
    }

    function p() {
        var a = arguments,
            b, c, d = a.length;
        for (b = 0; b < d; b++)
            if (c = a[b], c !== G && null !== c) return c
    }

    function I(a, b) {
        Oa && !wa && b && b.opacity !== G && (b.filter = "alpha(opacity=" + 100 * b.opacity + ")");
        n(a.style, b)
    }

    function K(a, b, c, d, e) {
        a = Z.createElement(a);
        b && n(a, b);
        e && I(a, {
            padding: 0,
            border: "none",
            margin: 0
        });
        c && I(a, c);
        d && d.appendChild(a);
        return a
    }

    function M(a, b) {
        var c = function () {
            return G
        };
        c.prototype = new a;
        n(c.prototype, b);
        return c
    }

    function J(a, b, c, d) {
        var e = ga.numberFormat,
            f = ha.lang,
            g = +a || 0,
            h = -1 === b ? (g.toString().split(".")[1] || "").length : isNaN(b = ka(b)) ? 2 : b,
            m = void 0 === c ? f.decimalPoint : c,
            f = void 0 === d ? f.thousandsSep : d,
            q = 0 > g ? "-" : "",
            r = String(O(g = ka(g).toFixed(h))),
            v = 3 < r.length ? r.length % 3 : 0;
        return e !== J ? e(a, b, c, d) : q + (v ? r.substr(0, v) + f : "") + r.substr(v).replace(/(\d{3})(?=\d)/g, "$1" + f) + (h ? m + ka(g - r).toFixed(h).slice(2) : "")
    }

    function A(a, b) {
        return Array((b || 2) + 1 - String(a).length).join(0) + a
    }

    function k(a, b, c) {
        var d = a[b];
        a[b] = function () {
            var a = Array.prototype.slice.call(arguments);
            a.unshift(d);
            return c.apply(this, a)
        }
    }

    function t(a, b) {
        for (var c = "{", d = !1, e, f, g, h, m, q = []; -1 !== (c = a.indexOf(c));) {
            e = a.slice(0, c);
            if (d) {
                f = e.split(":");
                g = f.shift().split(".");
                m = g.length;
                e = b;
                for (h = 0; h < m; h++) e = e[g[h]];
                f.length && (f = f.join(":"), g = /\.([0-9])/, h = ha.lang, m = void 0, /f$/.test(f) ? (m = (m = f.match(g)) ? m[1] : -1, null !== e && (e = J(e, m, h.decimalPoint, -1 < f.indexOf(",") ? h.thousandsSep : ""))) : e = Ha(f, e))
            }
            q.push(e);
            a = a.slice(c + 1);
            c = (d = !d) ? "}" : "{"
        }
        q.push(a);
        return q.join("")
    }

    function F(a) {
        return la.pow(10, fa(la.log(a) / la.LN10))
    }

    function R(a, b, c, d) {
        var e;
        c = p(c, 1);
        e = a / c;
        b || (b = [1, 2, 2.5, 5, 10], !1 === d && (1 === c ? b = [1, 2, 5, 10] : .1 >= c && (b = [1 / c])));
        for (d = 0; d < b.length && !(a = b[d], e <= (b[d] + (b[d + 1] || b[d])) / 2); d++);
        return a * c
    }

    function da(a, b) {
        var c = a.length,
            d, e;
        for (e = 0; e < c; e++) a[e].ss_i = e;
        a.sort(function (a, c) {
            d = b(a, c);
            return 0 === d ? a.ss_i - c.ss_i : d
        });
        for (e = 0; e < c; e++) delete a[e].ss_i
    }

    function ea(a) {
        for (var b = a.length, c = a[0]; b--;) a[b] < c && (c = a[b]);
        return c
    }

    function Ia(a) {
        for (var b = a.length, c = a[0]; b--;) a[b] > c && (c = a[b]);
        return c
    }

    function ca(a, b) {
        for (var c in a) a[c] && a[c] !== b && a[c].destroy && a[c].destroy(), delete a[c]
    }

    function Va(a) {
        kb || (kb = K("div"));
        a && kb.appendChild(a);
        kb.innerHTML = ""
    }

    function qa(a) {
        return parseFloat(a.toPrecision(14))
    }

    function ta(a, b) {
        La = p(a, b.animation)
    }

    function Pb() {
        var a = ha.global.useUTC,
            b = a ? "getUTC" : "get",
            c = a ? "setUTC" : "set";
        ua = ha.global.Date || window.Date;
        Pa = 6E4 * (a && ha.global.timezoneOffset || 0);
        lb = a ? ua.UTC : function (a, b, c, g, h, m) {
            return (new ua(a, b, p(c, 1), p(g, 0), p(h, 0), p(m, 0))).getTime()
        };
        yb = b + "Minutes";
        zb = b + "Hours";
        Ab = b + "Day";
        Wa = b + "Date";
        mb = b + "Month";
        nb = b + "FullYear";
        Qb = c + "Minutes";
        Rb = c + "Hours";
        Bb = c + "Date";
        Sb = c + "Month";
        Tb = c + "FullYear"
    }

    function ia() {
    }

    function ra(a, b, c, d) {
        this.axis = a;
        this.pos = b;
        this.type = c || "";
        this.isNew = !0;
        c || d || this.addLabel()
    }

    function T() {
        this.init.apply(this, arguments)
    }

    function na() {
        this.init.apply(this, arguments)
    }

    function Xa(a, b, c, d, e) {
        var f = a.chart.inverted;
        this.axis = a;
        this.isNegative = c;
        this.options = b;
        this.x = d;
        this.total = null;
        this.points = {};
        this.stack = e;
        this.alignOptions = {
            align: b.align || (f ? c ? "left" : "right" : "center"),
            verticalAlign: b.verticalAlign || (f ? "middle" : c ? "bottom" : "top"),
            y: p(b.y, f ? 4 : c ? 14 : -6),
            x: p(b.x, f ? c ? -6 : 6 : 0)
        };
        this.textAlign = b.textAlign || (f ? c ? "right" : "left" : "center")
    }

    function ab(a) {
        var b = a.options,
            c = b.navigator,
            d = c.enabled,
            b = b.scrollbar,
            e = b.enabled,
            f = d ? c.height : 0,
            g = e ? b.height : 0;
        this.handles = [];
        this.scrollbarButtons = [];
        this.elementsToDestroy = [];
        this.chart = a;
        this.setBaseSeries();
        this.height = f;
        this.scrollbarHeight = g;
        this.scrollbarEnabled = e;
        this.navigatorEnabled = d;
        this.navigatorOptions = c;
        this.scrollbarOptions = b;
        this.outlineHeight = f + g;
        this.init()
    }

    function bb(a) {
        this.init(a)
    }

    function Ub(a, b, c) {
        this.init.call(this, a, b, c)
    }

    var G, Z = document,
        oa = window,
        la = Math,
        L = la.round,
        fa = la.floor,
        Ya = la.ceil,
        N = la.max,
        U = la.min,
        ka = la.abs,
        xa = la.cos,
        ya = la.sin,
        Ea = la.PI,
        Qa = 2 * Ea / 360,
        Ma = navigator.userAgent,
        Vb = oa.opera,
        Oa = /msie/i.test(Ma) && !Vb,
        ob = 8 === Z.documentMode,
        Cb = /AppleWebKit/.test(Ma),
        cb = /Firefox/.test(Ma),
        eb = /(Mobile|Android|Windows Phone)/.test(Ma),
        Na = "http://www.w3.org/2000/svg",
        wa = !!Z.createElementNS && !!Z.createElementNS(Na, "svg").createSVGRect,
        hc = cb && 4 > parseInt(Ma.split("Firefox/")[1], 10),
        za = !wa && !Oa && !!Z.createElement("canvas").getContext,
        Za, db, Wb = {}, Db = 0,
        kb, ha, Ha, La, Eb, ba, Aa, ma = function () {
            return G
        }, sa = [],
        fb = 0,
        ic = /^[0-9]+$/,
        ua, lb, Pa, yb, zb, Ab, Wa, mb, nb, Qb, Rb, Bb, Sb, Tb, P = {}, ga;
    oa.Highcharts ? Aa(16, !0) : ga = oa.Highcharts = {};
    Ha = function (a, b, c) {
        if (!u(b) || isNaN(b)) return "Invalid date";
        a = p(a, "%Y-%m-%d %H:%M:%S");
        var d = new ua(b - Pa),
            e, f = d[zb](),
            g = d[Ab](),
            h = d[Wa](),
            m = d[mb](),
            q = d[nb](),
            r = ha.lang,
            v = r.weekdays,
            d = n({
                a: v[g].substr(0, 3),
                A: v[g],
                d: A(h),
                e: h,
                b: r.shortMonths[m],
                B: r.months[m],
                m: A(m + 1),
                y: q.toString().substr(2, 2),
                Y: q,
                H: A(f),
                I: A(f % 12 || 12),
                l: f % 12 || 12,
                M: A(d[yb]()),
                p: 12 > f ? "AM" : "PM",
                P: 12 > f ? "am" : "pm",
                S: A(d.getSeconds()),
                L: A(L(b % 1E3), 3)
            }, ga.dateFormats);
        for (e in d)
            for (; -1 !== a.indexOf("%" + e);) a = a.replace("%" + e, "function" === typeof d[e] ? d[e](b) : d[e]);
        return c ? a.substr(0, 1).toUpperCase() + a.substr(1) : a
    };
    Aa = function (a, b) {
        var c = "Highcharts error #" + a + ": www.highcharts.com/errors/" + a;
        if (b) throw c;
        oa.console && console.log(c)
    };
    ba = {
        millisecond: 1,
        second: 1E3,
        minute: 6E4,
        hour: 36E5,
        day: 864E5,
        week: 6048E5,
        month: 26784E5,
        year: 31556952E3
    };
    Eb = {
        init: function (a, b, c) {
            b = b || "";
            var d = a.shift,
                e = -1 < b.indexOf("C"),
                f = e ? 7 : 3,
                g;
            b = b.split(" ");
            c = [].concat(c);
            var h, m, q = function (a) {
                for (g = a.length; g--;) "M" === a[g] && a.splice(g + 1, 0, a[g + 1], a[g + 2], a[g + 1], a[g + 2])
            };
            e && (q(b), q(c));
            a.isArea && (h = b.splice(b.length - 6, 6), m = c.splice(c.length - 6, 6));
            if (d <= c.length / f && b.length === c.length)
                for (; d--;) c = [].concat(c).splice(0, f).concat(c);
            a.shift = 0;
            if (b.length)
                for (a = c.length; b.length < a;) d = [].concat(b).splice(b.length - f, f), e && (d[f - 6] = d[f - 2], d[f - 5] = d[f - 1]), b = b.concat(d);
            h && (b = b.concat(h), c = c.concat(m));
            return [b, c]
        },
        step: function (a, b, c, d) {
            var e = [],
                f = a.length;
            if (1 === c) e = d;
            else if (f === b.length && 1 > c)
                for (; f--;) d = parseFloat(a[f]), e[f] = isNaN(d) ? a[f] : c * parseFloat(b[f] - d) + d;
            else e = b;
            return e
        }
    };
    (function (a) {
        oa.HighchartsAdapter = oa.HighchartsAdapter || a && {
                init: function (b) {
                    var c = a.fx;
                    a.extend(a.easing, {
                        easeOutQuad: function (a, b, c, g, h) {
                            return -g * (b /= h) * (b - 2) + c
                        }
                    });
                    a.each(["cur", "_default", "width", "height", "opacity"], function (b, e) {
                        var f = c.step,
                            g;
                        "cur" === e ? f = c.prototype : "_default" === e && a.Tween && (f = a.Tween.propHooks[e], e = "set");
                        (g = f[e]) && (f[e] = function (a) {
                            var c;
                            a = b ? a : this;
                            if ("align" !== a.prop) return c = a.elem, c.attr ? c.attr(a.prop, "cur" === e ? G : a.now) : g.apply(this, arguments)
                        })
                    });
                    k(a.cssHooks.opacity, "get", function (a, b, c) {
                        return b.attr ? b.opacity || 0 : a.call(this, b, c)
                    });
                    this.addAnimSetter("d", function (a) {
                        var c = a.elem,
                            f;
                        a.started || (f = b.init(c, c.d, c.toD), a.start = f[0], a.end = f[1], a.started = !0);
                        c.attr("d", b.step(a.start, a.end, a.pos, c.toD))
                    });
                    this.each = Array.prototype.forEach ? function (a, b) {
                        return Array.prototype.forEach.call(a, b)
                    } : function (a, b) {
                        var c, g = a.length;
                        for (c = 0; c < g; c++)
                            if (!1 === b.call(a[c], a[c], c, a)) return c
                    };
                    a.fn.highcharts = function () {
                        var a = "Chart",
                            b = arguments,
                            c, g;
                        this[0] && (Y(b[0]) && (a = b[0], b = Array.prototype.slice.call(b, 1)), c = b[0], c !== G && (c.chart = c.chart || {}, c.chart.renderTo = this[0], new ga[a](c, b[1]), g = this), c === G && (g = sa[C(this[0], "data-highcharts-chart")]));
                        return g
                    }
                },
                addAnimSetter: function (b, c) {
                    a.Tween ? a.Tween.propHooks[b] = {
                        set: c
                    } : a.fx.step[b] = c
                },
                getScript: a.getScript,
                inArray: a.inArray,
                adapterRun: function (b, c) {
                    return a(b)[c]()
                },
                grep: a.grep,
                map: function (a, c) {
                    for (var d = [], e = 0, f = a.length; e < f; e++) d[e] = c.call(a[e], a[e], e, a);
                    return d
                },
                offset: function (b) {
                    return a(b).offset()
                },
                addEvent: function (b, c, d) {
                    a(b).bind(c, d)
                },
                removeEvent: function (b, c, d) {
                    var e = Z.removeEventListener ? "removeEventListener" : "detachEvent";
                    Z[e] && b && !b[e] && (b[e] = function () {
                    });
                    a(b).unbind(c, d)
                },
                fireEvent: function (b, c, d, e) {
                    var f = a.Event(c),
                        g = "detached" + c,
                        h;
                    !Oa && d && (delete d.layerX, delete d.layerY, delete d.returnValue);
                    n(f, d);
                    b[c] && (b[g] = b[c], b[c] = null);
                    a.each(["preventDefault", "stopPropagation"], function (a, b) {
                        var c = f[b];
                        f[b] = function () {
                            try {
                                c.call(f)
                            } catch (a) {
                                "preventDefault" === b && (h = !0)
                            }
                        }
                    });
                    a(b).trigger(f);
                    b[g] && (b[c] = b[g], b[g] = null);
                    !e || f.isDefaultPrevented() || h || e(f)
                },
                washMouseEvent: function (a) {
                    var c = a.originalEvent || a;
                    c.pageX === G && (c.pageX = a.pageX, c.pageY = a.pageY);
                    return c
                },
                animate: function (b, c, d) {
                    var e = a(b);
                    b.style || (b.style = {});
                    c.d && (b.toD = c.d, c.d = 1);
                    e.stop();
                    c.opacity !== G && b.attr && (c.opacity += "px");
                    b.hasAnim = 1;
                    e.animate(c, d)
                },
                stop: function (b) {
                    b.hasAnim && a(b).stop()
                }
            }
    })(oa.jQuery);
    var pb = oa.HighchartsAdapter,
        Ba = pb || {};
    pb && pb.init.call(pb, Eb);
    var qb = Ba.adapterRun,
        jc = Ba.getScript,
        Ra = Ba.inArray,
        D = Ba.each,
        rb = Ba.grep,
        kc = Ba.offset,
        Fa = Ba.map,
        W = Ba.addEvent,
        pa = Ba.removeEvent,
        ja = Ba.fireEvent,
        lc = Ba.washMouseEvent,
        sb = Ba.animate,
        gb = Ba.stop,
        Fb = {
            enabled: !0,
            x: 0,
            y: 15,
            style: {
                color: "#606060",
                cursor: "default",
                fontSize: "11px"
            }
        };
    ha = {
        colors: "#7cb5ec #434348 #90ed7d #f7a35c #8085e9 #f15c80 #e4d354 #8085e8 #8d4653 #91e8e1".split(" "),
        symbols: ["circle", "diamond", "square", "triangle", "triangle-down"],
        lang: {
            loading: "Loading...",
            months: "January February March April May June July August September October November December".split(" "),
            shortMonths: "Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "),
            weekdays: "Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),
            decimalPoint: ".",
            numericSymbols: "kMGTPE".split(""),
            resetZoom: "Reset zoom",
            resetZoomTitle: "Reset zoom level 1:1",
            thousandsSep: ","
        },
        global: {
            useUTC: !0,
            canvasToolsURL: "http://code.highcharts.com@product.cdnpath@//Highstock 2.0.4/modules/canvas-tools.js",
            VMLRadialGradientURL: "http://code.highcharts.com@product.cdnpath@//Highstock 2.0.4/gfx/vml-radial-gradient.png"
        },
        chart: {
            borderColor: "#4572A7",
            borderRadius: 0,
            defaultSeriesType: "line",
            ignoreHiddenSeries: !0,
            spacing: [10, 10, 15, 10],
            backgroundColor: "#FFFFFF",
            plotBorderColor: "#C0C0C0",
            resetZoomButton: {
                theme: {
                    zIndex: 20
                },
                position: {
                    align: "right",
                    x: -10,
                    y: 10
                }
            }
        },
        title: {
            text: "Chart title",
            align: "center",
            margin: 15,
            style: {
                color: "#333333",
                fontSize: "18px"
            }
        },
        subtitle: {
            text: "",
            align: "center",
            style: {
                color: "#555555"
            }
        },
        plotOptions: {
            line: {
                allowPointSelect: !1,
                showCheckbox: !1,
                animation: {
                    duration: 1E3
                },
                events: {},
                lineWidth: 2,
                marker: {
                    lineWidth: 0,
                    radius: 4,
                    lineColor: "#FFFFFF",
                    states: {
                        hover: {
                            enabled: !0,
                            lineWidthPlus: 1,
                            radiusPlus: 2
                        },
                        select: {
                            fillColor: "#FFFFFF",
                            lineColor: "#000000",
                            lineWidth: 2
                        }
                    }
                },
                point: {
                    events: {}
                },
                dataLabels: E(Fb, {
                    align: "center",
                    enabled: !1,
                    formatter: function () {
                        return null === this.y ? "" : J(this.y, -1)
                    },
                    verticalAlign: "bottom",
                    y: 0
                }),
                cropThreshold: 300,
                pointRange: 0,
                states: {
                    hover: {
                        lineWidthPlus: 1,
                        marker: {},
                        halo: {
                            size: 10,
                            opacity: .25
                        }
                    },
                    select: {
                        marker: {}
                    }
                },
                stickyTracking: !0,
                turboThreshold: 1E3
            }
        },
        labels: {
            style: {
                position: "absolute",
                color: "#3E576F"
            }
        },
        legend: {
            enabled: !0,
            align: "center",
            layout: "horizontal",
            labelFormatter: function () {
                return this.name
            },
            borderColor: "#909090",
            borderRadius: 0,
            navigation: {
                activeColor: "#274b6d",
                inactiveColor: "#CCC"
            },
            shadow: !1,
            itemStyle: {
                color: "#333333",
                fontSize: "12px",
                fontWeight: "bold"
            },
            itemHoverStyle: {
                color: "#000"
            },
            itemHiddenStyle: {
                color: "#CCC"
            },
            itemCheckboxStyle: {
                position: "absolute",
                width: "13px",
                height: "13px"
            },
            symbolPadding: 5,
            verticalAlign: "bottom",
            x: 0,
            y: 0,
            title: {
                style: {
                    fontWeight: "bold"
                }
            }
        },
        loading: {
            labelStyle: {
                fontWeight: "bold",
                position: "relative",
                top: "45%"
            },
            style: {
                position: "absolute",
                backgroundColor: "white",
                opacity: .5,
                textAlign: "center"
            }
        },
        tooltip: {
            enabled: !0,
            animation: wa,
            backgroundColor: "rgba(249, 249, 249, .85)",
            borderWidth: 1,
            borderRadius: 3,
            dateTimeLabelFormats: {
                millisecond: "%A, %b %e, %H:%M:%S.%L",
                second: "%A, %b %e, %H:%M:%S",
                minute: "%A, %b %e, %H:%M",
                hour: "%A, %b %e, %H:%M",
                day: "%A, %b %e, %Y",
                week: "Week from %A, %b %e, %Y",
                month: "%B %Y",
                year: "%Y"
            },
            headerFormat: '<span style="font-size: 10px">{point.key}</span><br/>',
            pointFormat: '<span style="color:{series.color}">\u25cf</span> {series.name}: <b>{point.y}</b><br/>',
            shadow: !0,
            snap: eb ? 25 : 10,
            style: {
                color: "#333333",
                cursor: "default",
                fontSize: "12px",
                padding: "8px",
                whiteSpace: "nowrap"
            }
        },
        credits: {
            enabled: false,
            text: "Highcharts.com",
            href: "http://www.highcharts.com",
            position: {
                align: "right",
                x: -10,
                verticalAlign: "bottom",
                y: -5
            },
            style: {
                cursor: "pointer",
                color: "#909090",
                fontSize: "9px"
            }
        }
    };
    var X = ha.plotOptions,
        hb = X.line;
    Pb();
    var mc = /rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]?(?:\.[0-9]+)?)\s*\)/,
        nc = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,
        oc = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/,
        Ja = function (a) {
            var b = [],
                c,
                d;
            (function (a) {
                a && a.stops ? d = Fa(a.stops, function (a) {
                    return Ja(a[1])
                }) : (c = mc.exec(a)) ? b = [O(c[1]), O(c[2]), O(c[3]), parseFloat(c[4], 10)] : (c = nc.exec(a)) ? b = [O(c[1], 16), O(c[2], 16), O(c[3], 16), 1] : (c = oc.exec(a)) && (b = [O(c[1]), O(c[2]), O(c[3]), 1])
            })(a);
            return {
                get: function (c) {
                    var f;
                    d ? (f = E(a), f.stops = [].concat(f.stops), D(d, function (a, b) {
                        f.stops[b] = [f.stops[b][0], a.get(c)]
                    })) : f = b && !isNaN(b[0]) ? "rgb" === c ? "rgb(" + b[0] + "," + b[1] + "," + b[2] + ")" : "a" === c ? b[3] : "rgba(" + b.join(",") + ")" : a;
                    return f
                },
                brighten: function (a) {
                    if (d) D(d, function (b) {
                        b.brighten(a)
                    });
                    else if (aa(a) && 0 !== a) {
                        var c;
                        for (c = 0; 3 > c; c++) b[c] += O(255 * a), 0 > b[c] && (b[c] = 0), 255 < b[c] && (b[c] = 255)
                    }
                    return this
                },
                rgba: b,
                setOpacity: function (a) {
                    b[3] = a;
                    return this
                }
            }
        };
    ia.prototype = {
        opacity: 1,
        textProps: "fontSize fontWeight fontFamily color lineHeight width textDecoration textShadow HcTextStroke".split(" "),
        init: function (a, b) {
            this.element = "span" === b ? K(b) : Z.createElementNS(Na, b);
            this.renderer = a
        },
        animate: function (a, b, c) {
            b = p(b, La, !0);
            gb(this);
            b ? (b = E(b, {}), c && (b.complete = c), sb(this, a, b)) : (this.attr(a), c && c());
            return this
        },
        colorGradient: function (a, b, c) {
            var d = this.renderer,
                e, f, g, h, m, q, r, v, z, x, H = [];
            a.linearGradient ? f = "linearGradient" : a.radialGradient && (f = "radialGradient");
            if (f) {
                g = a[f];
                h = d.gradients;
                q = a.stops;
                z = c.radialReference;
                S(g) && (a[f] = g = {
                    x1: g[0],
                    y1: g[1],
                    x2: g[2],
                    y2: g[3],
                    gradientUnits: "userSpaceOnUse"
                });
                "radialGradient" === f && z && !u(g.gradientUnits) && (g = E(g, {
                    cx: z[0] - z[2] / 2 + g.cx * z[2],
                    cy: z[1] - z[2] / 2 + g.cy * z[2],
                    r: g.r * z[2],
                    gradientUnits: "userSpaceOnUse"
                }));
                for (x in g) "id" !== x && H.push(x, g[x]);
                for (x in q) H.push(q[x]);
                H = H.join(",");
                h[H] ? a = h[H].attr("id") : (g.id = a = "highcharts-" + Db++, h[H] = m = d.createElement(f).attr(g).add(d.defs), m.stops = [], D(q, function (a) {
                    0 === a[1].indexOf("rgba") ? (e = Ja(a[1]), r = e.get("rgb"), v = e.get("a")) : (r = a[1], v = 1);
                    a = d.createElement("stop").attr({
                        offset: a[0],
                        "stop-color": r,
                        "stop-opacity": v
                    }).add(m);
                    m.stops.push(a)
                }));
                c.setAttribute(b, "url(" + d.url + "#" + a + ")")
            }
        },
        attr: function (a, b) {
            var c, d, e = this.element,
                f, g = this,
                h;
            "string" === typeof a && b !== G && (c = a, a = {}, a[c] = b);
            if ("string" === typeof a) g = (this[a + "Getter"] || this._defaultGetter).call(this, a, e);
            else {
                for (c in a) d = a[c], h = !1, this.symbolName && /^(x|y|width|height|r|start|end|innerR|anchorX|anchorY)/.test(c) && (f || (this.symbolAttr(a), f = !0), h = !0), !this.rotation || "x" !== c && "y" !== c || (this.doTransform = !0), h || (this[c + "Setter"] || this._defaultSetter).call(this, d, c, e), this.shadows && /^(width|height|visibility|x|y|d|transform|cx|cy|r)$/.test(c) && this.updateShadows(c, d);
                this.doTransform && (this.updateTransform(), this.doTransform = !1)
            }
            return g
        },
        updateShadows: function (a, b) {
            for (var c = this.shadows, d = c.length; d--;) c[d].setAttribute(a, "height" === a ? N(b - (c[d].cutHeight || 0), 0) : "d" === a ? this.d : b)
        },
        addClass: function (a) {
            var b = this.element,
                c = C(b, "class") || "";
            -1 === c.indexOf(a) && C(b, "class", c + " " + a);
            return this
        },
        symbolAttr: function (a) {
            var b = this;
            D("x y r start end width height innerR anchorX anchorY".split(" "), function (c) {
                b[c] = p(a[c], b[c])
            });
            b.attr({
                d: b.renderer.symbols[b.symbolName](b.x, b.y, b.width, b.height, b)
            })
        },
        clip: function (a) {
            return this.attr("clip-path", a ? "url(" + this.renderer.url + "#" + a.id + ")" : "none")
        },
        crisp: function (a) {
            var b, c = {}, d, e = a.strokeWidth || this.strokeWidth || 0;
            d = L(e) % 2 / 2;
            a.x = fa(a.x || this.x || 0) + d;
            a.y = fa(a.y || this.y || 0) + d;
            a.width = fa((a.width || this.width || 0) - 2 * d);
            a.height = fa((a.height || this.height || 0) - 2 * d);
            a.strokeWidth = e;
            for (b in a) this[b] !== a[b] && (this[b] = c[b] = a[b]);
            return c
        },
        css: function (a) {
            var b = this.styles,
                c = {}, d = this.element,
                e, f, g = "";
            e = !b;
            a && a.color && (a.fill = a.color);
            if (b)
                for (f in a) a[f] !== b[f] && (c[f] = a[f], e = !0);
            if (e) {
                e = this.textWidth = a && a.width && "text" === d.nodeName.toLowerCase() && O(a.width);
                b && (a = n(b, c));
                this.styles = a;
                e && (za || !wa && this.renderer.forExport) && delete a.width;
                if (Oa && !wa) I(this.element, a);
                else {
                    b = function (a, b) {
                        return "-" + b.toLowerCase()
                    };
                    for (f in a) g += f.replace(/([A-Z])/g, b) + ":" + a[f] + ";";
                    C(d, "style", g)
                }
                e && this.added && this.renderer.buildText(this)
            }
            return this
        },
        on: function (a, b) {
            var c = this,
                d = c.element;
            db && "click" === a ? (d.ontouchstart = function (a) {
                c.touchEventFired = ua.now();
                a.preventDefault();
                b.call(d, a)
            }, d.onclick = function (a) {
                (-1 === Ma.indexOf("Android") || 1100 < ua.now() - (c.touchEventFired || 0)) && b.call(d, a)
            }) : d["on" + a] = b;
            return this
        },
        setRadialReference: function (a) {
            this.element.radialReference = a;
            return this
        },
        translate: function (a, b) {
            return this.attr({
                translateX: a,
                translateY: b
            })
        },
        invert: function () {
            this.inverted = !0;
            this.updateTransform();
            return this
        },
        updateTransform: function () {
            var a = this.translateX || 0,
                b = this.translateY || 0,
                c = this.scaleX,
                d = this.scaleY,
                e = this.inverted,
                f = this.rotation,
                g = this.element;
            e && (a += this.attr("width"), b += this.attr("height"));
            a = ["translate(" + a + "," + b + ")"];
            e ? a.push("rotate(90) scale(-1,1)") : f && a.push("rotate(" + f + " " + (g.getAttribute("x") || 0) + " " + (g.getAttribute("y") || 0) + ")");
            (u(c) || u(d)) && a.push("scale(" + p(c, 1) + " " + p(d, 1) + ")");
            a.length && g.setAttribute("transform", a.join(" "))
        },
        toFront: function () {
            var a = this.element;
            a.parentNode.appendChild(a);
            return this
        },
        align: function (a, b, c) {
            var d, e, f, g, h = {};
            e = this.renderer;
            f = e.alignedObjects;
            if (a) {
                if (this.alignOptions = a, this.alignByTranslate = b, !c || Y(c)) this.alignTo = d = c || "renderer", y(f, this), f.push(this), c = null
            } else a = this.alignOptions, b = this.alignByTranslate, d = this.alignTo;
            c = p(c, e[d], e);
            d = a.align;
            e = a.verticalAlign;
            f = (c.x || 0) + (a.x || 0);
            g = (c.y || 0) + (a.y || 0);
            if ("right" === d || "center" === d) f += (c.width - (a.width || 0)) / {
                    right: 1,
                    center: 2
                }[d];
            h[b ? "translateX" : "x"] = L(f);
            if ("bottom" === e || "middle" === e) g += (c.height - (a.height || 0)) / ({
                    bottom: 1,
                    middle: 2
                }[e] || 1);
            h[b ? "translateY" : "y"] = L(g);
            this[this.placed ? "animate" : "attr"](h);
            this.placed = !0;
            this.alignAttr = h;
            return this
        },
        getBBox: function () {
            var a = this.bBox,
                b = this.renderer,
                c, d, e = this.rotation;
            c = this.element;
            var f = this.styles,
                g = e * Qa;
            d = this.textStr;
            var h;
            if ("" === d || ic.test(d)) h = "num." + d.toString().length + (f ? "|" + f.fontSize + "|" + f.fontFamily : "");
            h && (a = b.cache[h]);
            if (!a) {
                if (c.namespaceURI === Na || b.forExport) {
                    try {
                        a = c.getBBox ? n({}, c.getBBox()) : {
                            width: c.offsetWidth,
                            height: c.offsetHeight
                        }
                    } catch (m) {
                    }
                    if (!a || 0 > a.width) a = {
                        width: 0,
                        height: 0
                    }
                } else a = this.htmlGetBBox();
                b.isSVG && (c = a.width, d = a.height, Oa && f && "11px" === f.fontSize && "16.9" === d.toPrecision(3) && (a.height = d = 14), e && (a.width = ka(d * ya(g)) + ka(c * xa(g)), a.height = ka(d * xa(g)) + ka(c * ya(g))));
                this.bBox = a;
                h && (b.cache[h] = a)
            }
            return a
        },
        show: function (a) {
            a && this.element.namespaceURI === Na ? this.element.removeAttribute("visibility") : this.attr({
                visibility: a ? "inherit" : "visible"
            });
            return this
        },
        hide: function () {
            return this.attr({
                visibility: "hidden"
            })
        },
        fadeOut: function (a) {
            var b = this;
            b.animate({
                opacity: 0
            }, {
                duration: a || 150,
                complete: function () {
                    b.attr({
                        y: -9999
                    })
                }
            })
        },
        add: function (a) {
            var b = this.renderer,
                c = a || b,
                d = c.element || b.box,
                e = this.element,
                f = this.zIndex,
                g, h;
            a && (this.parentGroup = a);
            this.parentInverted = a && a.inverted;
            void 0 !== this.textStr && b.buildText(this);
            f && (c.handleZ = !0, f = O(f));
            if (c.handleZ)
                for (a = d.childNodes, g = 0; g < a.length; g++)
                    if (b = a[g], c = C(b, "zIndex"), b !== e && (O(c) > f || !u(f) && u(c))) {
                        d.insertBefore(e, b);
                        h = !0;
                        break
                    }
            h || d.appendChild(e);
            this.added = !0;
            if (this.onAdd) this.onAdd();
            return this
        },
        safeRemoveChild: function (a) {
            var b = a.parentNode;
            b && b.removeChild(a)
        },
        destroy: function () {
            var a = this,
                b = a.element || {}, c = a.shadows,
                d = a.renderer.isSVG && "SPAN" === b.nodeName && a.parentGroup,
                e, f;
            b.onclick = b.onmouseout = b.onmouseover = b.onmousemove = b.point = null;
            gb(a);
            a.clipPath && (a.clipPath = a.clipPath.destroy());
            if (a.stops) {
                for (f = 0; f < a.stops.length; f++) a.stops[f] = a.stops[f].destroy();
                a.stops = null
            }
            a.safeRemoveChild(b);
            for (c && D(c, function (b) {
                a.safeRemoveChild(b)
            }); d && d.div && 0 === d.div.childNodes.length;) b = d.parentGroup, a.safeRemoveChild(d.div), delete d.div, d = b;
            a.alignTo && y(a.renderer.alignedObjects, a);
            for (e in a) delete a[e];
            return null
        },
        shadow: function (a, b, c) {
            var d = [],
                e, f, g = this.element,
                h, m, q, r;
            if (a) {
                m = p(a.width, 3);
                q = (a.opacity || .15) / m;
                r = this.parentInverted ? "(-1,-1)" : "(" + p(a.offsetX, 1) + ", " + p(a.offsetY, 1) + ")";
                for (e = 1; e <= m; e++) f = g.cloneNode(0), h = 2 * m + 1 - 2 * e, C(f, {
                    isShadow: "true",
                    stroke: a.color || "black",
                    "stroke-opacity": q * e,
                    "stroke-width": h,
                    transform: "translate" + r,
                    fill: "none"
                }), c && (C(f, "height", N(C(f, "height") - h, 0)), f.cutHeight = h), b ? b.element.appendChild(f) : g.parentNode.insertBefore(f, g), d.push(f);
                this.shadows = d
            }
            return this
        },
        xGetter: function (a) {
            "circle" === this.element.nodeName && (a = {
                    x: "cx",
                    y: "cy"
                }[a] || a);
            return this._defaultGetter(a)
        },
        _defaultGetter: function (a) {
            a = p(this[a], this.element ? this.element.getAttribute(a) : null, 0);
            /^[\-0-9\.]+$/.test(a) && (a = parseFloat(a));
            return a
        },
        dSetter: function (a, b, c) {
            a && a.join && (a = a.join(" "));
            /(NaN| {2}|^$)/.test(a) && (a = "M 0 0");
            c.setAttribute(b, a);
            this[b] = a
        },
        dashstyleSetter: function (a) {
            var b;
            if (a = a && a.toLowerCase()) {
                a = a.replace("shortdashdotdot", "3,1,1,1,1,1,").replace("shortdashdot", "3,1,1,1").replace("shortdot", "1,1,").replace("shortdash", "3,1,").replace("longdash", "8,3,").replace(/dot/g, "1,3,").replace("dash", "4,3,").replace(/,$/, "").split(",");
                for (b = a.length; b--;) a[b] = O(a[b]) * this["stroke-width"];
                a = a.join(",").replace("NaN", "none");
                this.element.setAttribute("stroke-dasharray", a)
            }
        },
        alignSetter: function (a) {
            this.element.setAttribute("text-anchor", {
                left: "start",
                center: "middle",
                right: "end"
            }[a])
        },
        opacitySetter: function (a, b, c) {
            this[b] = a;
            c.setAttribute(b, a)
        },
        titleSetter: function (a) {
            var b = this.element.getElementsByTagName("title")[0];
            b || (b = Z.createElementNS(Na, "title"), this.element.appendChild(b));
            b.textContent = p(a, "").replace(/<[^>]*>/g, "")
        },
        textSetter: function (a) {
            a !== this.textStr && (delete this.bBox, this.textStr = a, this.added && this.renderer.buildText(this))
        },
        fillSetter: function (a, b, c) {
            "string" === typeof a ? c.setAttribute(b, a) : a && this.colorGradient(a, b, c)
        },
        zIndexSetter: function (a, b, c) {
            c.setAttribute(b, a);
            this[b] = a
        },
        _defaultSetter: function (a, b, c) {
            c.setAttribute(b, a)
        }
    };
    ia.prototype.yGetter = ia.prototype.xGetter;
    ia.prototype.translateXSetter = ia.prototype.translateYSetter = ia.prototype.rotationSetter = ia.prototype.verticalAlignSetter = ia.prototype.scaleXSetter = ia.prototype.scaleYSetter = function (a, b) {
        this[b] = a;
        this.doTransform = !0
    };
    ia.prototype["stroke-widthSetter"] = ia.prototype.strokeSetter = function (a, b, c) {
        this[b] = a;
        this.stroke && this["stroke-width"] ? (this.strokeWidth = this["stroke-width"], ia.prototype.fillSetter.call(this, this.stroke, "stroke", c), c.setAttribute("stroke-width", this["stroke-width"]), this.hasStroke = !0) : "stroke-width" === b && 0 === a && this.hasStroke && (c.removeAttribute("stroke"), this.hasStroke = !1)
    };
    var Ca = function () {
        this.init.apply(this, arguments)
    };
    Ca.prototype = {
        Element: ia,
        init: function (a, b, c, d, e) {
            var f = location,
                g;
            d = this.createElement("svg").attr({
                version: "1.1"
            }).css(this.getStyle(d));
            g = d.element;
            a.appendChild(g);
            -1 === a.innerHTML.indexOf("xmlns") && C(g, "xmlns", Na);
            this.isSVG = !0;
            this.box = g;
            this.boxWrapper = d;
            this.alignedObjects = [];
            this.url = (cb || Cb) && Z.getElementsByTagName("base").length ? f.href.replace(/#.*?$/, "").replace(/([\('\)])/g, "\\$1").replace(/ /g, "%20") : "";
            this.createElement("desc").add().element.appendChild(Z.createTextNode("Created with Highcharts 4.0.4 /Highstock 2.0.4"));
            this.defs = this.createElement("defs").add();
            this.forExport = e;
            this.gradients = {};
            this.cache = {};
            this.setSize(b, c, !1);
            var h;
            cb && a.getBoundingClientRect && (this.subPixelFix = b = function () {
                I(a, {
                    left: 0,
                    top: 0
                });
                h = a.getBoundingClientRect();
                I(a, {
                    left: Ya(h.left) - h.left + "px",
                    top: Ya(h.top) - h.top + "px"
                })
            }, b(), W(oa, "resize", b))
        },
        getStyle: function (a) {
            return this.style = n({
                fontFamily: '"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif',
                fontSize: "12px"
            }, a)
        },
        isHidden: function () {
            return !this.boxWrapper.getBBox().width
        },
        destroy: function () {
            var a = this.defs;
            this.box = null;
            this.boxWrapper = this.boxWrapper.destroy();
            ca(this.gradients || {});
            this.gradients = null;
            a && (this.defs = a.destroy());
            this.subPixelFix && pa(oa, "resize", this.subPixelFix);
            return this.alignedObjects = null
        },
        createElement: function (a) {
            var b = new this.Element;
            b.init(this, a);
            return b
        },
        draw: function () {
        },
        buildText: function (a) {
            for (var b = a.element, c = this, d = c.forExport, e = p(a.textStr, "").toString(), f = -1 !== e.indexOf("<"), g = b.childNodes, h, m, q = C(b, "x"), r = a.styles, v = a.textWidth, z = r && r.lineHeight, x = r && r.HcTextStroke, H = g.length, Xb = function (a) {
                return z ? O(z) : c.fontMetrics(/(px|em)$/.test(a && a.style.fontSize) ? a.style.fontSize : r && r.fontSize || c.style.fontSize || 12, a).h
            }; H--;) b.removeChild(g[H]);
            f || x || -1 !== e.indexOf(" ") ? (h = /<.*style="([^"]+)".*>/, m = /<.*href="(http[^"]+)".*>/, v && !a.added && this.box.appendChild(b), e = f ? e.replace(/<(b|strong)>/g, '<span style="font-weight:bold">').replace(/<(i|em)>/g, '<span style="font-style:italic">').replace(/<a/g, "<span").replace(/<\/(b|strong|i|em|a)>/g, "</span>").split(/<br.*?>/g) : [e], "" === e[e.length - 1] && e.pop(), D(e, function (e, f) {
                var g, z = 0;
                e = e.replace(/<span/g, "|||<span").replace(/<\/span>/g, "</span>|||");
                g = e.split("|||");
                D(g, function (e) {
                    if ("" !== e || 1 === g.length) {
                        var x = {}, H = Z.createElementNS(Na, "tspan"),
                            p;
                        h.test(e) && (p = e.match(h)[1].replace(/(;| |^)color([ :])/, "$1fill$2"), C(H, "style", p));
                        m.test(e) && !d && (C(H, "onclick", 'location.href="' + e.match(m)[1] + '"'), I(H, {
                            cursor: "pointer"
                        }));
                        e = (e.replace(/<(.|\n)*?>/g, "") || " ").replace(/&lt;/g, "<").replace(/&gt;/g, ">");
                        if (" " !== e) {
                            H.appendChild(Z.createTextNode(e));
                            z ? x.dx = 0 : f && null !== q && (x.x = q);
                            C(H, x);
                            b.appendChild(H);
                            !z && f && (!wa && d && I(H, {
                                display: "block"
                            }), C(H, "dy", Xb(H)));
                            if (v) {
                                e = e.replace(/([^\^])-/g, "$1- ").split(" ");
                                for (var x = 1 < g.length || 1 < e.length && "nowrap" !== r.whiteSpace, k, t, l = r.HcHeight, tb = [], u = Xb(H), A = 1; x && (e.length || tb.length);) delete a.bBox,
                                    k = a.getBBox(), t = k.width, !wa && c.forExport && (t = c.measureSpanWidth(H.firstChild.data, a.styles)), (k = t > v) && 1 !== e.length ? (H.removeChild(H.firstChild), tb.unshift(e.pop())) : (e = tb, tb = [], e.length && (A++, l && A * u > l ? (e = ["..."], a.attr("title", a.textStr)) : (H = Z.createElementNS(Na, "tspan"), C(H, {
                                    dy: u,
                                    x: q
                                }), p && C(H, "style", p), b.appendChild(H))), t > v && (v = t)), e.length && H.appendChild(Z.createTextNode(e.join(" ").replace(/- /g, "-")))
                            }
                            z++
                        }
                    }
                })
            })) : b.appendChild(Z.createTextNode(e))
        },
        button: function (a, b, c, d, e, f, g, h, m) {
            var q = this.label(a, b, c, m, null, null, null, null, "button"),
                r = 0,
                v, z, x, H, p, k;
            a = {
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 1
            };
            e = E({
                "stroke-width": 1,
                stroke: "#CCCCCC",
                fill: {
                    linearGradient: a,
                    stops: [
                        [0, "#FEFEFE"],
                        [1, "#F6F6F6"]
                    ]
                },
                r: 2,
                padding: 5,
                style: {
                    color: "black"
                }
            }, e);
            x = e.style;
            delete e.style;
            f = E(e, {
                stroke: "#68A",
                fill: {
                    linearGradient: a,
                    stops: [
                        [0, "#FFF"],
                        [1, "#ACF"]
                    ]
                }
            }, f);
            H = f.style;
            delete f.style;
            g = E(e, {
                stroke: "#68A",
                fill: {
                    linearGradient: a,
                    stops: [
                        [0, "#9BD"],
                        [1, "#CDF"]
                    ]
                }
            }, g);
            p = g.style;
            delete g.style;
            h = E(e, {
                style: {
                    color: "#CCC"
                }
            }, h);
            k = h.style;
            delete h.style;
            W(q.element, Oa ? "mouseover" : "mouseenter", function () {
                3 !== r && q.attr(f).css(H)
            });
            W(q.element, Oa ? "mouseout" : "mouseleave", function () {
                3 !== r && (v = [e, f, g][r], z = [x, H, p][r], q.attr(v).css(z))
            });
            q.setState = function (a) {
                (q.state = r = a) ? 2 === a ? q.attr(g).css(p) : 3 === a && q.attr(h).css(k) : q.attr(e).css(x)
            };
            return q.on("click", function () {
                3 !== r && d.call(q)
            }).attr(e).css(n({
                cursor: "default"
            }, x))
        },
        crispLine: function (a, b) {
            a[1] === a[4] && (a[1] = a[4] = L(a[1]) - b % 2 / 2);
            a[2] === a[5] && (a[2] = a[5] = L(a[2]) + b % 2 / 2);
            return a
        },
        path: function (a) {
            var b = {
                fill: "none"
            };
            S(a) ? b.d = a : Q(a) && n(b, a);
            return this.createElement("path").attr(b)
        },
        circle: function (a, b, c) {
            a = Q(a) ? a : {
                x: a,
                y: b,
                r: c
            };
            b = this.createElement("circle");
            b.xSetter = function (a) {
                this.element.setAttribute("cx", a)
            };
            b.ySetter = function (a) {
                this.element.setAttribute("cy", a)
            };
            return b.attr(a)
        },
        arc: function (a, b, c, d, e, f) {
            Q(a) && (b = a.y, c = a.r, d = a.innerR, e = a.start, f = a.end, a = a.x);
            a = this.symbol("arc", a || 0, b || 0, c || 0, c || 0, {
                innerR: d || 0,
                start: e || 0,
                end: f || 0
            });
            a.r = c;
            return a
        },
        rect: function (a, b, c, d, e, f) {
            e = Q(a) ? a.r : e;
            var g = this.createElement("rect");
            a = Q(a) ? a : a === G ? {} : {
                x: a,
                y: b,
                width: N(c, 0),
                height: N(d, 0)
            };
            f !== G && (a.strokeWidth = f, a = g.crisp(a));
            e && (a.r = e);
            g.rSetter = function (a) {
                C(this.element, {
                    rx: a,
                    ry: a
                })
            };
            return g.attr(a)
        },
        setSize: function (a, b, c) {
            var d = this.alignedObjects,
                e = d.length;
            this.width = a;
            this.height = b;
            for (this.boxWrapper[p(c, !0) ? "animate" : "attr"]({
                width: a,
                height: b
            }); e--;) d[e].align()
        },
        g: function (a) {
            var b = this.createElement("g");
            return u(a) ? b.attr({
                "class": "highcharts-" + a
            }) : b
        },
        image: function (a, b, c, d, e) {
            var f = {
                preserveAspectRatio: "none"
            };
            1 < arguments.length && n(f, {
                x: b,
                y: c,
                width: d,
                height: e
            });
            f = this.createElement("image").attr(f);
            f.element.setAttributeNS ? f.element.setAttributeNS("http://www.w3.org/1999/xlink", "href", a) : f.element.setAttribute("hc-svg-href", a);
            return f
        },
        symbol: function (a, b, c, d, e, f) {
            var g, h = this.symbols[a],
                h = h && h(L(b), L(c), d, e, f),
                m = /^url\((.*?)\)$/,
                q, r;
            h ? (g = this.path(h), n(g, {
                symbolName: a,
                x: b,
                y: c,
                width: d,
                height: e
            }), f && n(g, f)) : m.test(a) && (r = function (a, b) {
                a.element && (a.attr({
                    width: b[0],
                    height: b[1]
                }), a.alignByTranslate || a.translate(L((d - b[0]) / 2), L((e - b[1]) / 2)))
            }, q = a.match(m)[1], a = Wb[q] || f && f.width && f.height && [f.width, f.height], g = this.image(q).attr({
                x: b,
                y: c
            }), g.isImg = !0, a ? r(g, a) : (g.attr({
                width: 0,
                height: 0
            }), K("img", {
                onload: function () {
                    r(g, Wb[q] = [this.width, this.height])
                },
                src: q
            })));
            return g
        },
        symbols: {
            circle: function (a, b, c, d) {
                var e = .166 * c;
                return ["M", a + c / 2, b, "C", a + c + e, b, a + c + e, b + d, a + c / 2, b + d, "C", a - e, b + d, a - e, b, a + c / 2, b, "Z"]
            },
            square: function (a, b, c, d) {
                return ["M", a, b, "L", a + c, b, a + c, b + d, a, b + d, "Z"]
            },
            triangle: function (a, b, c, d) {
                return ["M", a + c / 2, b, "L", a + c, b + d, a, b + d, "Z"]
            },
            "triangle-down": function (a, b, c, d) {
                return ["M", a, b, "L", a + c, b, a + c / 2, b + d, "Z"]
            },
            diamond: function (a, b, c, d) {
                return ["M", a + c / 2, b, "L", a + c, b + d / 2, a + c / 2, b + d, a, b + d / 2, "Z"]
            },
            arc: function (a, b, c, d, e) {
                var f = e.start;
                c = e.r || c || d;
                var g = e.end - .001;
                d = e.innerR;
                var h = e.open,
                    m = xa(f),
                    q = ya(f),
                    r = xa(g),
                    g = ya(g);
                e = e.end - f < Ea ? 0 : 1;
                return ["M", a + c * m, b + c * q, "A", c, c, 0, e, 1, a + c * r, b + c * g, h ? "M" : "L", a + d * r, b + d * g, "A", d, d, 0, e, 0, a + d * m, b + d * q, h ? "" : "Z"]
            },
            callout: function (a, b, c, d, e) {
                var f = U(e && e.r || 0, c, d),
                    g = f + 6,
                    h = e && e.anchorX,
                    m = e && e.anchorY;
                e = L(e.strokeWidth || 0) % 2 / 2;
                a += e;
                b += e;
                e = ["M", a + f, b, "L", a + c - f, b, "C", a + c, b, a + c, b, a + c, b + f, "L", a + c, b + d - f, "C", a + c, b + d, a + c, b + d, a + c - f, b + d, "L", a + f, b + d, "C", a, b + d, a, b + d, a, b + d - f, "L", a, b + f, "C", a, b, a, b, a + f, b];
                h && h > c && m > b + g && m < b + d - g ? e.splice(13, 3, "L", a + c, m - 6, a + c + 6, m, a + c, m + 6, a + c, b + d - f) : h && 0 > h && m > b + g && m < b + d - g ? e.splice(33, 3, "L", a, m + 6, a - 6, m, a, m - 6, a, b + f) : m && m > d && h > a + g && h < a + c - g ? e.splice(23, 3, "L", h + 6, b + d, h, b + d + 6, h - 6, b + d, a + f, b + d) : m && 0 > m && h > a + g && h < a + c - g && e.splice(3, 3, "L", h - 6, b, h, b - 6, h + 6, b, c - f, b);
                return e
            }
        },
        clipRect: function (a, b, c, d) {
            var e = "highcharts-" + Db++,
                f = this.createElement("clipPath").attr({
                    id: e
                }).add(this.defs);
            a = this.rect(a, b, c, d, 0).add(f);
            a.id = e;
            a.clipPath = f;
            return a
        },
        text: function (a, b, c, d) {
            var e = za || !wa && this.forExport,
                f = {};
            if (d && !this.forExport) return this.html(a, b, c);
            f.x = Math.round(b || 0);
            c && (f.y = Math.round(c));
            if (a || 0 === a) f.text = a;
            a = this.createElement("text").attr(f);
            e && a.css({
                position: "absolute"
            });
            d || (a.xSetter = function (a, b, c) {
                var d = c.getElementsByTagName("tspan"),
                    e, f = c.getAttribute(b),
                    z;
                for (z = 0; z < d.length; z++) e = d[z], e.getAttribute(b) === f && e.setAttribute(b, a);
                c.setAttribute(b, a)
            });
            return a
        },
        fontMetrics: function (a, b) {
            a = a || this.style.fontSize;
            b && oa.getComputedStyle && (b = b.element || b, a = oa.getComputedStyle(b, "").fontSize);
            a = /px/.test(a) ? O(a) : /em/.test(a) ? 12 * parseFloat(a) : 12;
            var c = 24 > a ? a + 4 : L(1.2 * a),
                d = L(.8 * c);
            return {
                h: c,
                b: d,
                f: a
            }
        },
        label: function (a, b, c, d, e, f, g, h, m) {
            function q() {
                var a, b;
                a = H.element.style;
                k = (void 0 === F || void 0 === B || x.styles.textAlign) && H.textStr && H.getBBox();
                x.width = (F || k.width || 0) + 2 * l + A;
                x.height = (B || k.height || 0) + 2 * l;
                C = l + z.fontMetrics(a && a.fontSize, H).b;
                da && (p || (a = L(-t * l), b = h ? -C : 0, x.box = p = d ? z.symbol(d, a, b, x.width, x.height, J) : z.rect(a, b, x.width, x.height, 0, J["stroke-width"]), p.attr("fill", "none").add(x)), p.isImg || p.attr(n({
                    width: L(x.width),
                    height: L(x.height)
                }, J)), J = null)
            }

            function r() {
                var a = x.styles,
                    a = a && a.textAlign,
                    b = A + l * (1 - t),
                    c;
                c = h ? 0 : C;
                u(F) && k && ("center" === a || "right" === a) && (b += {
                        center: .5,
                        right: 1
                    }[a] * (F - k.width));
                if (b !== H.x || c !== H.y) H.attr("x", b), c !== G && H.attr("y", c);
                H.x = b;
                H.y = c
            }

            function v(a, b) {
                p ? p.attr(a, b) : J[a] = b
            }

            var z = this,
                x = z.g(m),
                H = z.text("", 0, 0, g).attr({
                    zIndex: 1
                }),
                p, k, t = 0,
                l = 3,
                A = 0,
                F, B, R, y, w = 0,
                J = {}, C, da;
            x.onAdd = function () {
                H.add(x);
                x.attr({
                    text: a || 0 === a ? a : "",
                    x: b,
                    y: c
                });
                p && u(e) && x.attr({
                    anchorX: e,
                    anchorY: f
                })
            };
            x.widthSetter = function (a) {
                F = a
            };
            x.heightSetter = function (a) {
                B = a
            };
            x.paddingSetter = function (a) {
                u(a) && a !== l && (l = a, r())
            };
            x.paddingLeftSetter = function (a) {
                u(a) && a !== A && (A = a, r())
            };
            x.alignSetter = function (a) {
                t = {
                    left: 0,
                    center: .5,
                    right: 1
                }[a]
            };
            x.textSetter = function (a) {
                a !== G && H.textSetter(a);
                q();
                r()
            };
            x["stroke-widthSetter"] = function (a, b) {
                a && (da = !0);
                w = a % 2 / 2;
                v(b, a)
            };
            x.strokeSetter = x.fillSetter = x.rSetter = function (a, b) {
                "fill" === b && a && (da = !0);
                v(b, a)
            };
            x.anchorXSetter = function (a, b) {
                e = a;
                v(b, a + w - R)
            };
            x.anchorYSetter = function (a, b) {
                f = a;
                v(b, a - y)
            };
            x.xSetter = function (a) {
                x.x = a;
                t && (a -= t * ((F || k.width) + l));
                R = L(a);
                x.attr("translateX", R)
            };
            x.ySetter = function (a) {
                y = x.y = L(a);
                x.attr("translateY", y)
            };
            var ea = x.css;
            return n(x, {
                css: function (a) {
                    if (a) {
                        var b = {};
                        a = E(a);
                        D(x.textProps, function (c) {
                            a[c] !== G && (b[c] = a[c], delete a[c])
                        });
                        H.css(b)
                    }
                    return ea.call(x, a)
                },
                getBBox: function () {
                    return {
                        width: k.width + 2 * l,
                        height: k.height + 2 * l,
                        x: k.x - l,
                        y: k.y - l
                    }
                },
                shadow: function (a) {
                    p && p.shadow(a);
                    return x
                },
                destroy: function () {
                    pa(x.element, "mouseenter");
                    pa(x.element, "mouseleave");
                    H && (H = H.destroy());
                    p && (p = p.destroy());
                    ia.prototype.destroy.call(x);
                    x = z = q = r = v = null
                }
            })
        }
    };
    Za = Ca;
    n(ia.prototype, {
        htmlCss: function (a) {
            var b = this.element;
            if (b = a && "SPAN" === b.tagName && a.width) delete a.width, this.textWidth = b, this.updateTransform();
            this.styles = n(this.styles, a);
            I(this.element, a);
            return this
        },
        htmlGetBBox: function () {
            var a = this.element,
                b = this.bBox;
            b || ("text" === a.nodeName && (a.style.position = "absolute"), b = this.bBox = {
                x: a.offsetLeft,
                y: a.offsetTop,
                width: a.offsetWidth,
                height: a.offsetHeight
            });
            return b
        },
        htmlUpdateTransform: function () {
            if (this.added) {
                var a = this.renderer,
                    b = this.element,
                    c = this.translateX || 0,
                    d = this.translateY || 0,
                    e = this.x || 0,
                    f = this.y || 0,
                    g = this.textAlign || "left",
                    h = {
                        left: 0,
                        center: .5,
                        right: 1
                    }[g],
                    m = this.shadows;
                I(b, {
                    marginLeft: c,
                    marginTop: d
                });
                m && D(m, function (a) {
                    I(a, {
                        marginLeft: c + 1,
                        marginTop: d + 1
                    })
                });
                this.inverted && D(b.childNodes, function (c) {
                    a.invertChild(c, b)
                });
                if ("SPAN" === b.tagName) {
                    var q = this.rotation,
                        r, v = O(this.textWidth),
                        z = [q, g, b.innerHTML, this.textWidth].join();
                    z !== this.cTT && (r = a.fontMetrics(b.style.fontSize).b, u(q) && this.setSpanRotation(q, h, r), m = p(this.elemWidth, b.offsetWidth), m > v && /[ \-]/.test(b.textContent || b.innerText) && (I(b, {
                        width: v + "px",
                        display: "block",
                        whiteSpace: "normal"
                    }), m = v), this.getSpanCorrection(m, r, h, q, g));
                    I(b, {
                        left: e + (this.xCorr || 0) + "px",
                        top: f + (this.yCorr || 0) + "px"
                    });
                    Cb && (r = b.offsetHeight);
                    this.cTT = z
                }
            } else this.alignOnAdd = !0
        },
        setSpanRotation: function (a, b, c) {
            var d = {}, e = Oa ? "-ms-transform" : Cb ? "-webkit-transform" : cb ? "MozTransform" : Vb ? "-o-transform" : "";
            d[e] = d.transform = "rotate(" + a + "deg)";
            d[e + (cb ? "Origin" : "-origin")] = d.transformOrigin = 100 * b + "% " + c + "px";
            I(this.element, d)
        },
        getSpanCorrection: function (a, b, c) {
            this.xCorr = -a * c;
            this.yCorr = -b
        }
    });
    n(Ca.prototype, {
        html: function (a, b, c) {
            var d = this.createElement("span"),
                e = d.element,
                f = d.renderer;
            d.textSetter = function (a) {
                a !== e.innerHTML && delete this.bBox;
                e.innerHTML = this.textStr = a
            };
            d.xSetter = d.ySetter = d.alignSetter = d.rotationSetter = function (a, b) {
                "align" === b && (b = "textAlign");
                d[b] = a;
                d.htmlUpdateTransform()
            };
            d.attr({
                text: a,
                x: L(b),
                y: L(c)
            }).css({
                position: "absolute",
                whiteSpace: "nowrap",
                fontFamily: this.style.fontFamily,
                fontSize: this.style.fontSize
            });
            d.css = d.htmlCss;
            f.isSVG && (d.add = function (a) {
                var b, c = f.box.parentNode,
                    q = [];
                if (this.parentGroup = a) {
                    if (b = a.div, !b) {
                        for (; a;) q.push(a),
                            a = a.parentGroup;
                        D(q.reverse(), function (a) {
                            var d;
                            b = a.div = a.div || K("div", {
                                    className: C(a.element, "class")
                                }, {
                                    position: "absolute",
                                    left: (a.translateX || 0) + "px",
                                    top: (a.translateY || 0) + "px"
                                }, b || c);
                            d = b.style;
                            n(a, {
                                translateXSetter: function (b, c) {
                                    d.left = b + "px";
                                    a[c] = b;
                                    a.doTransform = !0
                                },
                                translateYSetter: function (b, c) {
                                    d.top = b + "px";
                                    a[c] = b;
                                    a.doTransform = !0
                                },
                                visibilitySetter: function (a, b) {
                                    d[b] = a
                                }
                            })
                        })
                    }
                } else b = c;
                b.appendChild(e);
                d.added = !0;
                d.alignOnAdd && d.htmlUpdateTransform();
                return d
            });
            return d
        }
    });
    var ib, Sa;
    if (!wa && !za) {
        Sa = {
            init: function (a, b) {
                var c = ["<", b, ' filled="f" stroked="f"'],
                    d = ["position: ", "absolute", ";"],
                    e = "div" === b;
                ("shape" === b || e) && d.push("left:0;top:0;width:1px;height:1px;");
                d.push("visibility: ", e ? "hidden" : "visible");
                c.push(' style="', d.join(""), '"/>');
                b && (c = e || "span" === b || "img" === b ? c.join("") : a.prepVML(c), this.element = K(c));
                this.renderer = a
            },
            add: function (a) {
                var b = this.renderer,
                    c = this.element,
                    d = b.box,
                    d = a ? a.element || a : d;
                a && a.inverted && b.invertChild(c, d);
                d.appendChild(c);
                this.added = !0;
                this.alignOnAdd && !this.deferUpdateTransform && this.updateTransform();
                if (this.onAdd) this.onAdd();
                return this
            },
            updateTransform: ia.prototype.htmlUpdateTransform,
            setSpanRotation: function () {
                var a = this.rotation,
                    b = xa(a * Qa),
                    c = ya(a * Qa);
                I(this.element, {
                    filter: a ? ["progid:DXImageTransform.Microsoft.Matrix(M11=", b, ", M12=", -c, ", M21=", c, ", M22=", b, ", sizingMethod='auto expand')"].join("") : "none"
                })
            },
            getSpanCorrection: function (a, b, c, d, e) {
                var f = d ? xa(d * Qa) : 1,
                    g = d ? ya(d * Qa) : 0,
                    h = p(this.elemHeight, this.element.offsetHeight),
                    m;
                this.xCorr = 0 > f && -a;
                this.yCorr = 0 > g && -h;
                m = 0 > f * g;
                this.xCorr += g * b * (m ? 1 - c : c);
                this.yCorr -= f * b * (d ? m ? c : 1 - c : 1);
                e && "left" !== e && (this.xCorr -= a * c * (0 > f ? -1 : 1), d && (this.yCorr -= h * c * (0 > g ? -1 : 1)), I(this.element, {
                    textAlign: e
                }))
            },
            pathToVML: function (a) {
                for (var b = a.length, c = []; b--;) aa(a[b]) ? c[b] = L(10 * a[b]) - 5 : "Z" === a[b] ? c[b] = "x" : (c[b] = a[b], !a.isArc || "wa" !== a[b] && "at" !== a[b] || (c[b + 5] === c[b + 7] && (c[b + 7] += a[b + 7] > a[b + 5] ? 1 : -1), c[b + 6] === c[b + 8] && (c[b + 8] += a[b + 8] > a[b + 6] ? 1 : -1)));
                return c.join(" ") || "x"
            },
            clip: function (a) {
                var b = this,
                    c;
                a ? (c = a.members, y(c, b), c.push(b), b.destroyClip = function () {
                    y(c, b)
                }, a = a.getCSS(b)) : (b.destroyClip && b.destroyClip(), a = {
                    clip: ob ? "inherit" : "rect(auto)"
                });
                return b.css(a)
            },
            css: ia.prototype.htmlCss,
            safeRemoveChild: function (a) {
                a.parentNode && Va(a)
            },
            destroy: function () {
                this.destroyClip && this.destroyClip();
                return ia.prototype.destroy.apply(this)
            },
            on: function (a, b) {
                this.element["on" + a] = function () {
                    var a = oa.event;
                    a.target = a.srcElement;
                    b(a)
                };
                return this
            },
            cutOffPath: function (a, b) {
                var c;
                a = a.split(/[ ,]/);
                c = a.length;
                if (9 === c || 11 === c) a[c - 4] = a[c - 2] = O(a[c - 2]) - 10 * b;
                return a.join(" ")
            },
            shadow: function (a, b, c) {
                var d = [],
                    e, f = this.element,
                    g = this.renderer,
                    h, m = f.style,
                    q, r = f.path,
                    v, z, x, H;
                r && "string" !== typeof r.value && (r = "x");
                z = r;
                if (a) {
                    x = p(a.width, 3);
                    H = (a.opacity || .15) / x;
                    for (e = 1; 3 >= e; e++) v = 2 * x + 1 - 2 * e, c && (z = this.cutOffPath(r.value, v + .5)), q = ['<shape isShadow="true" strokeweight="', v, '" filled="false" path="', z, '" coordsize="10 10" style="', f.style.cssText, '" />'], h = K(g.prepVML(q), null, {
                        left: O(m.left) + p(a.offsetX, 1),
                        top: O(m.top) + p(a.offsetY, 1)
                    }), c && (h.cutOff = v + 1), q = ['<stroke color="', a.color || "black", '" opacity="', H * e, '"/>'], K(g.prepVML(q), null, null, h), b ? b.element.appendChild(h) : f.parentNode.insertBefore(h, f), d.push(h);
                    this.shadows = d
                }
                return this
            },
            updateShadows: ma,
            setAttr: function (a, b) {
                ob ? this.element[a] = b : this.element.setAttribute(a, b)
            },
            classSetter: function (a) {
                this.element.className = a
            },
            dashstyleSetter: function (a, b, c) {
                (c.getElementsByTagName("stroke")[0] || K(this.renderer.prepVML(["<stroke/>"]), null, null, c))[b] = a || "solid";
                this[b] = a
            },
            dSetter: function (a, b, c) {
                var d = this.shadows;
                a = a || [];
                this.d = a.join && a.join(" ");
                c.path = a = this.pathToVML(a);
                if (d)
                    for (c = d.length; c--;) d[c].path = d[c].cutOff ? this.cutOffPath(a, d[c].cutOff) : a;
                this.setAttr(b, a)
            },
            fillSetter: function (a, b, c) {
                var d = c.nodeName;
                "SPAN" === d ? c.style.color = a : "IMG" !== d && (c.filled = "none" !== a, this.setAttr("fillcolor", this.renderer.color(a, c, b, this)))
            },
            opacitySetter: ma,
            rotationSetter: function (a, b, c) {
                c = c.style;
                this[b] = c[b] = a;
                c.left = -L(ya(a * Qa) + 1) + "px";
                c.top = L(xa(a * Qa)) + "px"
            },
            strokeSetter: function (a, b, c) {
                this.setAttr("strokecolor", this.renderer.color(a, c, b))
            },
            "stroke-widthSetter": function (a, b, c) {
                c.stroked = !!a;
                this[b] = a;
                aa(a) && (a += "px");
                this.setAttr("strokeweight", a)
            },
            titleSetter: function (a, b) {
                this.setAttr(b, a)
            },
            visibilitySetter: function (a, b, c) {
                "inherit" === a && (a = "visible");
                this.shadows && D(this.shadows, function (c) {
                    c.style[b] = a
                });
                "DIV" === c.nodeName && (a = "hidden" === a ? "-999em" : 0, ob || (c.style[b] = a ? "visible" : "hidden"), b = "top");
                c.style[b] = a
            },
            xSetter: function (a, b, c) {
                this[b] = a;
                "x" === b ? b = "left" : "y" === b && (b = "top");
                this.updateClipping ? (this[b] = a, this.updateClipping()) : c.style[b] = a
            },
            zIndexSetter: function (a, b, c) {
                c.style[b] = a
            }
        };
        ga.VMLElement = Sa = M(ia, Sa);
        Sa.prototype.ySetter = Sa.prototype.widthSetter = Sa.prototype.heightSetter = Sa.prototype.xSetter;
        var pc = {
            Element: Sa,
            isIE8: -1 < Ma.indexOf("MSIE 8.0"),
            init: function (a, b, c, d) {
                var e;
                this.alignedObjects = [];
                d = this.createElement("div").css(n(this.getStyle(d), {
                    position: "relative"
                }));
                e = d.element;
                a.appendChild(d.element);
                this.isVML = !0;
                this.box = e;
                this.boxWrapper = d;
                this.cache = {};
                this.setSize(b, c, !1);
                if (!Z.namespaces.hcv) {
                    Z.namespaces.add("hcv", "urn:schemas-microsoft-com:vml");
                    try {
                        Z.createStyleSheet().cssText = "hcv\\:fill, hcv\\:path, hcv\\:shape, hcv\\:stroke{ behavior:url(#default#VML); display: inline-block; } "
                    } catch (f) {
                        Z.styleSheets[0].cssText += "hcv\\:fill, hcv\\:path, hcv\\:shape, hcv\\:stroke{ behavior:url(#default#VML); display: inline-block; } "
                    }
                }
            },
            isHidden: function () {
                return !this.box.offsetWidth
            },
            clipRect: function (a, b, c, d) {
                var e = this.createElement(),
                    f = Q(a);
                return n(e, {
                    members: [],
                    left: (f ? a.x : a) + 1,
                    top: (f ? a.y : b) + 1,
                    width: (f ? a.width : c) - 1,
                    height: (f ? a.height : d) - 1,
                    getCSS: function (a) {
                        var b = a.element,
                            c = b.nodeName;
                        a = a.inverted;
                        var d = this.top - ("shape" === c ? b.offsetTop : 0),
                            e = this.left,
                            b = e + this.width,
                            f = d + this.height,
                            d = {
                                clip: "rect(" + L(a ? e : d) + "px," + L(a ? f : b) + "px," + L(a ? b : f) + "px," + L(a ? d : e) + "px)"
                            };
                        !a && ob && "DIV" === c && n(d, {
                            width: b + "px",
                            height: f + "px"
                        });
                        return d
                    },
                    updateClipping: function () {
                        D(e.members, function (a) {
                            a.element && a.css(e.getCSS(a))
                        })
                    }
                })
            },
            color: function (a, b, c, d) {
                var e = this,
                    f, g = /^rgba/,
                    h, m, q = "none";
                a && a.linearGradient ? m = "gradient" : a && a.radialGradient && (m = "pattern");
                if (m) {
                    var r, v, z = a.linearGradient || a.radialGradient,
                        x, H, p, k, t, l = "";
                    a = a.stops;
                    var A, u = [],
                        F = function () {
                            h = ['<fill colors="' + u.join(",") + '" opacity="', p, '" o:opacity2="', H, '" type="', m, '" ', l, 'focus="100%" method="any" />'];
                            K(e.prepVML(h), null, null, b)
                        };
                    x = a[0];
                    A = a[a.length - 1];
                    0 < x[0] && a.unshift([0, x[1]]);
                    1 > A[0] && a.push([1, A[1]]);
                    D(a, function (a, b) {
                        g.test(a[1]) ? (f = Ja(a[1]), r = f.get("rgb"), v = f.get("a")) : (r = a[1], v = 1);
                        u.push(100 * a[0] + "% " + r);
                        b ? (p = v, k = r) : (H = v, t = r)
                    });
                    if ("fill" === c)
                        if ("gradient" === m) c = z.x1 || z[0] || 0, a = z.y1 || z[1] || 0, x = z.x2 || z[2] || 0, z = z.y2 || z[3] || 0, l = 'angle="' + (90 - 180 * la.atan((z - a) / (x - c)) / Ea) + '"', F();
                        else {
                            var q = z.r,
                                n = 2 * q,
                                B = 2 * q,
                                R = z.cx,
                                y = z.cy,
                                w = b.radialReference,
                                J, q = function () {
                                    w && (J = d.getBBox(), R += (w[0] - J.x) / J.width - .5, y += (w[1] - J.y) / J.height - .5, n *= w[2] / J.width, B *= w[2] / J.height);
                                    l = 'src="' + ha.global.VMLRadialGradientURL + '" size="' + n + "," + B + '" origin="0.5,0.5" position="' + R + "," + y + '" color2="' + t + '" ';
                                    F()
                                };
                            d.added ? q() : d.onAdd = q;
                            q = k
                        } else q = r
                } else g.test(a) && "IMG" !== b.tagName ? (f = Ja(a), h = ["<", c, ' opacity="', f.get("a"), '"/>'], K(this.prepVML(h), null, null, b), q = f.get("rgb")) : (q = b.getElementsByTagName(c), q.length && (q[0].opacity = 1, q[0].type = "solid"), q = a);
                return q
            },
            prepVML: function (a) {
                var b = this.isIE8;
                a = a.join("");
                b ? (a = a.replace("/>", ' xmlns="urn:schemas-microsoft-com:vml" />'), a = -1 === a.indexOf('style="') ? a.replace("/>", ' style="display:inline-block;behavior:url(#default#VML);" />') : a.replace('style="', 'style="display:inline-block;behavior:url(#default#VML);')) : a = a.replace("<", "<hcv:");
                return a
            },
            text: Ca.prototype.html,
            path: function (a) {
                var b = {
                    coordsize: "10 10"
                };
                S(a) ? b.d = a : Q(a) && n(b, a);
                return this.createElement("shape").attr(b)
            },
            circle: function (a, b, c) {
                var d = this.symbol("circle");
                Q(a) && (c = a.r, b = a.y, a = a.x);
                d.isCircle = !0;
                d.r = c;
                return d.attr({
                    x: a,
                    y: b
                })
            },
            g: function (a) {
                var b;
                a && (b = {
                    className: "highcharts-" + a,
                    "class": "highcharts-" + a
                });
                return this.createElement("div").attr(b)
            },
            image: function (a, b, c, d, e) {
                var f = this.createElement("img").attr({
                    src: a
                });
                1 < arguments.length && f.attr({
                    x: b,
                    y: c,
                    width: d,
                    height: e
                });
                return f
            },
            createElement: function (a) {
                return "rect" === a ? this.symbol(a) : Ca.prototype.createElement.call(this, a)
            },
            invertChild: function (a, b) {
                var c = this,
                    d = b.style,
                    e = "IMG" === a.tagName && a.style;
                I(a, {
                    flip: "x",
                    left: O(d.width) - (e ? O(e.top) : 1),
                    top: O(d.height) - (e ? O(e.left) : 1),
                    rotation: -90
                });
                D(a.childNodes, function (b) {
                    c.invertChild(b, a)
                })
            },
            symbols: {
                arc: function (a, b, c, d, e) {
                    var f = e.start,
                        g = e.end,
                        h = e.r || c || d;
                    c = e.innerR;
                    d = xa(f);
                    var m = ya(f),
                        q = xa(g),
                        r = ya(g);
                    if (0 === g - f) return ["x"];
                    f = ["wa", a - h, b - h, a + h, b + h, a + h * d, b + h * m, a + h * q, b + h * r];
                    e.open && !c && f.push("e", "M", a, b);
                    f.push("at", a - c, b - c, a + c, b + c, a + c * q, b + c * r, a + c * d, b + c * m, "x", "e");
                    f.isArc = !0;
                    return f
                },
                circle: function (a, b, c, d, e) {
                    e && (c = d = 2 * e.r);
                    e && e.isCircle && (a -= c / 2, b -= d / 2);
                    return ["wa", a, b, a + c, b + d, a + c, b + d / 2, a + c, b + d / 2, "e"]
                },
                rect: function (a, b, c, d, e) {
                    return Ca.prototype.symbols[u(e) && e.r ? "callout" : "square"].call(0, a, b, c, d, e)
                }
            }
        };
        ga.VMLRenderer = ib = function () {
            this.init.apply(this, arguments)
        };
        ib.prototype = E(Ca.prototype, pc);
        Za = ib
    }
    Ca.prototype.measureSpanWidth = function (a, b) {
        var c = Z.createElement("span"),
            d;
        d = Z.createTextNode(a);
        c.appendChild(d);
        I(c, b);
        this.box.appendChild(c);
        d = c.offsetWidth;
        Va(c);
        return d
    };
    var Gb, Yb;
    za && (ga.CanVGRenderer = Gb = function () {
        Na = "http://www.w3.org/1999/xhtml"
    }, Gb.prototype.symbols = {}, Yb = function () {
        function a() {
            var a = b.length,
                d;
            for (d = 0; d < a; d++) b[d]();
            b = []
        }

        var b = [];
        return {
            push: function (c, d) {
                0 === b.length && jc(d, a);
                b.push(c)
            }
        }
    }(), Za = Gb);
    ra.prototype = {
        addLabel: function () {
            var a = this.axis,
                b = a.options,
                c = a.chart,
                d = a.horiz,
                e = a.categories,
                f = a.names,
                g = this.pos,
                h = b.labels,
                m = h.rotation,
                q = a.tickPositions,
                d = d && e && !h.step && !h.staggerLines && !h.rotation && c.plotWidth / q.length || !d && (c.margin[3] || .33 * c.chartWidth),
                r = g === q[0],
                v = g === q[q.length - 1],
                z, f = e ? p(e[g], f[g], g) : g,
                e = this.label,
                x = q.info;
            a.isDatetimeAxis && x && (z = b.dateTimeLabelFormats[x.higherRanks[g] || x.unitName]);
            this.isFirst = r;
            this.isLast = v;
            b = a.labelFormatter.call({
                axis: a,
                chart: c,
                isFirst: r,
                isLast: v,
                dateTimeLabelFormat: z,
                value: a.isLog ? qa(l(f)) : f
            });
            g = d && {
                    width: N(1, L(d - 2 * (h.padding || 10))) + "px"
                };
            u(e) ? e && e.attr({
                text: b
            }).css(g) : (z = {
                align: a.labelAlign
            }, aa(m) && (z.rotation = m), d && h.ellipsis && (g.HcHeight = a.len / q.length), this.label = e = u(b) && h.enabled ? c.renderer.text(b, 0, 0, h.useHTML).attr(z).css(n(g, h.style)).add(a.labelGroup) : null, a.tickBaseline = c.renderer.fontMetrics(h.style.fontSize, e).b, m && 2 === a.side && (a.tickBaseline *= xa(m * Qa)));
            this.yOffset = e ? p(h.y, a.tickBaseline + (2 === a.side ? 8 : -(e.getBBox().height / 2))) : 0
        },
        getLabelSize: function () {
            var a = this.label,
                b = this.axis;
            return a ? a.getBBox()[b.horiz ? "height" : "width"] : 0
        },
        getLabelSides: function () {
            var a = this.label.getBBox(),
                b = this.axis,
                c = b.horiz,
                d = b.options.labels,
                a = c ? a.width : a.height,
                b = c ? d.x - a * {
                    left: 0,
                    center: .5,
                    right: 1
                }[b.labelAlign] : 0;
            return [b, c ? a + b : a]
        },
        handleOverflow: function (a, b) {
            var c = !0,
                d = this.axis,
                e = this.isFirst,
                f = this.isLast,
                g = d.horiz ? b.x : b.y,
                h = d.reversed,
                m = d.tickPositions,
                q = this.getLabelSides(),
                r = q[0],
                q = q[1],
                v, z, x, H = this.label.line;
            v = H || 0;
            z = d.labelEdge;
            x = d.justifyLabels && (e || f);
            z[v] === G || g + r > z[v] ? z[v] = g + q : x || (c = !1);
            if (x) {
                v = (z = d.justifyToPlot) ? d.pos : 0;
                z = z ? v + d.len : d.chart.chartWidth;
                do a += e ? 1 : -1, x = d.ticks[m[a]]; while (m[a] && (!x || !x.label || x.label.line !== H));
                d = x && x.label.xy && x.label.xy.x + x.getLabelSides()[e ? 0 : 1];
                e && !h || f && h ? g + r < v && (g = v - r, x && g + q > d && (c = !1)) : g + q > z && (g = z - q, x && g + r < d && (c = !1));
                b.x = g
            }
            return c
        },
        getPosition: function (a, b, c, d) {
            var e = this.axis,
                f = e.chart,
                g = d && f.oldChartHeight || f.chartHeight;
            return {
                x: a ? e.translate(b + c, null, null, d) + e.transB : e.left + e.offset + (e.opposite ? (d && f.oldChartWidth || f.chartWidth) - e.right - e.left : 0),
                y: a ? g - e.bottom + e.offset - (e.opposite ? e.height : 0) : g - e.translate(b + c, null, null, d) - e.transB
            }
        },
        getLabelPosition: function (a, b, c, d, e, f, g, h) {
            var m = this.axis,
                q = m.transA,
                r = m.reversed,
                v = m.staggerLines;
            a = a + e.x - (f && d ? f * q * (r ? -1 : 1) : 0);
            b = b + this.yOffset - (f && !d ? f * q * (r ? 1 : -1) : 0);
            v && (c.line = g / (h || 1) % v, b += m.labelOffset / v * c.line);
            return {
                x: a,
                y: b
            }
        },
        getMarkPath: function (a, b, c, d, e, f) {
            return f.crispLine(["M", a, b, "L", a + (e ? 0 : -c), b + (e ? c : 0)], d)
        },
        render: function (a, b, c) {
            var d = this.axis,
                e = d.options,
                f = d.chart.renderer,
                g = d.horiz,
                h = this.type,
                m = this.label,
                q = this.pos,
                r = e.labels,
                v = this.gridLine,
                z = h ? h + "Grid" : "grid",
                x = h ? h + "Tick" : "tick",
                H = e[z + "LineWidth"],
                k = e[z + "LineColor"],
                t = e[z + "LineDashStyle"],
                l = e[x + "Length"],
                z = e[x + "Width"] || 0,
                A = e[x + "Color"],
                u = e[x + "Position"],
                x = this.mark,
                F = r.step,
                n = !0,
                B = d.tickmarkOffset,
                D = this.getPosition(g, q, B, b),
                R = D.x,
                D = D.y,
                y = g && R === d.pos + d.len || !g && D === d.pos ? -1 : 1;
            c = p(c, 1);
            this.isActive = !0;
            if (H && (q = d.getPlotLinePath(q + B, H * y, b, !0), v === G && (v = {
                    stroke: k,
                    "stroke-width": H
                }, t && (v.dashstyle = t), h || (v.zIndex = 1), b && (v.opacity = 0), this.gridLine = v = H ? f.path(q).attr(v).add(d.gridGroup) : null), !b && v && q)) v[this.isNew ? "attr" : "animate"]({
                d: q,
                opacity: c
            });
            z && l && ("inside" === u && (l = -l), d.opposite && (l = -l), h = this.getMarkPath(R, D, l, z * y, g, f), x ? x.animate({
                d: h,
                opacity: c
            }) : this.mark = f.path(h).attr({
                stroke: A,
                "stroke-width": z,
                opacity: c
            }).add(d.axisGroup));
            m && !isNaN(R) && (m.xy = D = this.getLabelPosition(R, D, m, g, r, B, a, F), this.isFirst && !this.isLast && !p(e.showFirstLabel, 1) || this.isLast && !this.isFirst && !p(e.showLastLabel, 1) ? n = !1 : d.isRadial || r.step || r.rotation || b || 0 === c || (n = this.handleOverflow(a, D)), F && a % F && (n = !1), n && !isNaN(D.y) ? (D.opacity = c, m[this.isNew ? "attr" : "animate"](D), this.isNew = !1) : m.attr("y", -9999))
        },
        destroy: function () {
            ca(this, this.axis)
        }
    };
    ga.PlotLineOrBand = function (a, b) {
        this.axis = a;
        b && (this.options = b, this.id = b.id)
    };
    ga.PlotLineOrBand.prototype = {
        render: function () {
            var a = this,
                b = a.axis,
                c = b.horiz,
                d = (b.pointRange || 0) / 2,
                e = a.options,
                f = e.label,
                g = a.label,
                h = e.width,
                m = e.to,
                q = e.from,
                r = u(q) && u(m),
                v = e.value,
                z = e.dashStyle,
                x = a.svgElem,
                H = [],
                p, k = e.color,
                t = e.zIndex,
                l = e.events,
                A = {}, F = b.chart.renderer;
            b.isLog && (q = B(q), m = B(m), v = B(v));
            if (h) H = b.getPlotLinePath(v, h), A = {
                stroke: k,
                "stroke-width": h
            }, z && (A.dashstyle = z);
            else if (r) q = N(q, b.min - d), m = U(m, b.max + d), H = b.getPlotBandPath(q, m, e), k && (A.fill = k), e.borderWidth && (A.stroke = e.borderColor, A["stroke-width"] = e.borderWidth);
            else return;
            u(t) && (A.zIndex = t);
            if (x) H ? x.animate({
                d: H
            }, null, x.onGetPath) : (x.hide(), x.onGetPath = function () {
                x.show()
            }, g && (a.label = g = g.destroy()));
            else if (H && H.length && (a.svgElem = x = F.path(H).attr(A).add(), l))
                for (p in d = function (b) {
                    x.on(b, function (c) {
                        l[b].apply(a, [c])
                    })
                }, l) d(p);
            f && u(f.text) && H && H.length && 0 < b.width && 0 < b.height ? (f = E({
                align: c && r && "center",
                x: c ? !r && 4 : 10,
                verticalAlign: !c && r && "middle",
                y: c ? r ? 16 : 10 : r ? 6 : -4,
                rotation: c && !r && 90
            }, f), g || (A = {
                align: f.textAlign || f.align,
                rotation: f.rotation
            }, u(t) && (A.zIndex = t), a.label = g = F.text(f.text, 0, 0, f.useHTML).attr(A).css(f.style).add()), b = [H[1], H[4], r ? H[6] : H[1]], r = [H[2], H[5], r ? H[7] : H[2]], H = ea(b), c = ea(r), g.align(f, !1, {
                x: H,
                y: c,
                width: Ia(b) - H,
                height: Ia(r) - c
            }), g.show()) : g && g.hide();
            return a
        },
        destroy: function () {
            y(this.axis.plotLinesAndBands, this);
            delete this.axis;
            ca(this)
        }
    };
    T.prototype = {
        defaultOptions: {
            dateTimeLabelFormats: {
                millisecond: "%H:%M:%S.%L",
                second: "%H:%M:%S",
                minute: "%H:%M",
                hour: "%H:%M",
                day: "%e. %b",
                week: "%e. %b",
                month: "%b '%y",
                year: "%Y"
            },
            endOnTick: !1,
            gridLineColor: "#C0C0C0",
            labels: Fb,
            lineColor: "#C0D0E0",
            lineWidth: 1,
            minPadding: .01,
            maxPadding: .01,
            minorGridLineColor: "#E0E0E0",
            minorGridLineWidth: 1,
            minorTickColor: "#A0A0A0",
            minorTickLength: 2,
            minorTickPosition: "outside",
            startOfWeek: 1,
            startOnTick: !1,
            tickColor: "#C0D0E0",
            tickLength: 10,
            tickmarkPlacement: "between",
            tickPixelInterval: 100,
            tickPosition: "outside",
            tickWidth: 1,
            title: {
                align: "middle",
                style: {
                    color: "#707070"
                }
            },
            type: "linear"
        },
        defaultYAxisOptions: {
            endOnTick: !0,
            gridLineWidth: 1,
            tickPixelInterval: 72,
            showLastLabel: !0,
            labels: {
                x: -8,
                y: 3
            },
            lineWidth: 0,
            maxPadding: .05,
            minPadding: .05,
            startOnTick: !0,
            tickWidth: 0,
            title: {
                rotation: 270,
                text: "Values"
            },
            stackLabels: {
                enabled: !1,
                formatter: function () {
                    return J(this.total, -1)
                },
                style: Fb.style
            }
        },
        defaultLeftAxisOptions: {
            labels: {
                x: -15,
                y: null
            },
            title: {
                rotation: 270
            }
        },
        defaultRightAxisOptions: {
            labels: {
                x: 15,
                y: null
            },
            title: {
                rotation: 90
            }
        },
        defaultBottomAxisOptions: {
            labels: {
                x: 0,
                y: null
            },
            title: {
                rotation: 0
            }
        },
        defaultTopAxisOptions: {
            labels: {
                x: 0,
                y: -15
            },
            title: {
                rotation: 0
            }
        },
        init: function (a, b) {
            var c = b.isX;
            this.horiz = a.inverted ? !c : c;
            this.coll = (this.isXAxis = c) ? "xAxis" : "yAxis";
            this.opposite = b.opposite;
            this.side = b.side || (this.horiz ? this.opposite ? 0 : 2 : this.opposite ? 1 : 3);
            this.setOptions(b);
            var d = this.options,
                e = d.type;
            this.labelFormatter = d.labels.formatter || this.defaultLabelFormatter;
            this.userOptions = b;
            this.minPixelPadding = 0;
            this.chart = a;
            this.reversed = d.reversed;
            this.zoomEnabled = !1 !== d.zoomEnabled;
            this.categories = d.categories || "category" === e;
            this.names = [];
            this.isLog = "logarithmic" === e;
            this.isDatetimeAxis = "datetime" === e;
            this.isLinked = u(d.linkedTo);
            this.tickmarkOffset = this.categories && "between" === d.tickmarkPlacement && 1 === p(d.tickInterval, 1) ? .5 : 0;
            this.ticks = {};
            this.labelEdge = [];
            this.minorTicks = {};
            this.plotLinesAndBands = [];
            this.alternateBands = {};
            this.len = 0;
            this.minRange = this.userMinRange = d.minRange || d.maxZoom;
            this.range = d.range;
            this.offset = d.offset || 0;
            this.stacks = {};
            this.oldStacks = {};
            this.min = this.max = null;
            this.crosshair = p(d.crosshair, w(a.options.tooltip.crosshairs)[c ? 0 : 1], !1);
            var f, d = this.options.events;
            -1 === Ra(this, a.axes) && (c && !this.isColorAxis ? a.axes.splice(a.xAxis.length, 0, this) : a.axes.push(this), a[this.coll].push(this));
            this.series = this.series || [];
            a.inverted && c && this.reversed === G && (this.reversed = !0);
            this.removePlotLine = this.removePlotBand = this.removePlotBandOrLine;
            for (f in d) W(this, f, d[f]);
            this.isLog && (this.val2lin = B, this.lin2val = l)
        },
        setOptions: function (a) {
            this.options = E(this.defaultOptions, this.isXAxis ? {} : this.defaultYAxisOptions, [this.defaultTopAxisOptions, this.defaultRightAxisOptions, this.defaultBottomAxisOptions, this.defaultLeftAxisOptions][this.side], E(ha[this.coll], a))
        },
        defaultLabelFormatter: function () {
            var a = this.axis,
                b = this.value,
                c = a.categories,
                d = this.dateTimeLabelFormat,
                e = ha.lang.numericSymbols,
                f = e && e.length,
                g, h = a.options.labels.format,
                a = a.isLog ? b : a.tickInterval;
            if (h) g = t(h, this);
            else if (c) g = b;
            else if (d) g = Ha(d, b);
            else if (f && 1E3 <= a)
                for (; f-- && g === G;) c = Math.pow(1E3, f + 1), a >= c && null !== e[f] && (g = J(b / c, -1) + e[f]);
            g === G && (g = 1E4 <= ka(b) ? J(b, 0) : J(b, -1, G, ""));
            return g
        },
        getSeriesExtremes: function () {
            var a = this,
                b = a.chart;
            a.hasVisibleSeries = !1;
            a.dataMin = a.dataMax = a.ignoreMinPadding = a.ignoreMaxPadding = null;
            a.buildStacks && a.buildStacks();
            D(a.series, function (c) {
                if (c.visible || !b.options.chart.ignoreHiddenSeries) {
                    var d;
                    d = c.options.threshold;
                    var e;
                    a.hasVisibleSeries = !0;
                    a.isLog && 0 >= d && (d = null);
                    a.isXAxis ? (d = c.xData, d.length && (a.dataMin = U(p(a.dataMin, d[0]), ea(d)), a.dataMax = N(p(a.dataMax, d[0]), Ia(d)))) : (c.getExtremes(), e = c.dataMax, c = c.dataMin, u(c) && u(e) && (a.dataMin = U(p(a.dataMin, c), c), a.dataMax = N(p(a.dataMax, e), e)), u(d) && (a.dataMin >= d ? (a.dataMin = d, a.ignoreMinPadding = !0) : a.dataMax < d && (a.dataMax = d, a.ignoreMaxPadding = !0)))
                }
            })
        },
        translate: function (a, b, c, d, e, f) {
            var g = 1,
                h = 0,
                m = d ? this.oldTransA : this.transA;
            d = d ? this.oldMin : this.min;
            var q = this.minPixelPadding;
            e = (this.options.ordinal || this.isLog && e) && this.lin2val;
            m || (m = this.transA);
            c && (g *= -1, h = this.len);
            this.reversed && (g *= -1, h -= g * (this.sector || this.len));
            b ? (a = a * g + h - q, a = a / m + d, e && (a = this.lin2val(a))) : (e && (a = this.val2lin(a)), "between" === f && (f = .5), a = g * (a - d) * m + h + g * q + (aa(f) ? m * f * this.pointRange : 0));
            return a
        },
        toPixels: function (a, b) {
            return this.translate(a, !1, !this.horiz, null, !0) + (b ? 0 : this.pos)
        },
        toValue: function (a, b) {
            return this.translate(a - (b ? 0 : this.pos), !0, !this.horiz, null, !0)
        },
        getPlotLinePath: function (a, b, c, d, e) {
            var f = this.chart,
                g = this.left,
                h = this.top,
                m, q, r = c && f.oldChartHeight || f.chartHeight,
                v = c && f.oldChartWidth || f.chartWidth,
                z;
            m = this.transB;
            e = p(e, this.translate(a, null, null, c));
            a = c = L(e + m);
            m = q = L(r - e - m);
            if (isNaN(e)) z = !0;
            else if (this.horiz) {
                if (m = h, q = r - this.bottom, a < g || a > g + this.width) z = !0
            } else if (a = g, c = v - this.right, m < h || m > h + this.height) z = !0;
            return z && !d ? null : f.renderer.crispLine(["M", a, m, "L", c, q], b || 1)
        },
        getLinearTickPositions: function (a, b, c) {
            var d, e = qa(fa(b / a) * a),
                f = qa(Ya(c / a) * a),
                g = [];
            if (b === c && aa(b)) return [b];
            for (b = e; b <= f;) {
                g.push(b);
                b = qa(b + a);
                if (b === d) break;
                d = b
            }
            return g
        },
        getMinorTickPositions: function () {
            var a = this.options,
                b = this.tickPositions,
                c = this.minorTickInterval,
                d = [],
                e;
            if (this.isLog)
                for (e = b.length, a = 1; a < e; a++) d = d.concat(this.getLogTickPositions(c, b[a - 1], b[a], !0));
            else if (this.isDatetimeAxis && "auto" === a.minorTickInterval) d = d.concat(this.getTimeTicks(this.normalizeTimeTickInterval(c), this.min, this.max, a.startOfWeek)), d[0] < this.min && d.shift();
            else
                for (b = this.min + (b[0] - this.min) % c; b <= this.max; b += c) d.push(b);
            return d
        },
        adjustForMinRange: function () {
            var a = this.options,
                b = this.min,
                c = this.max,
                d, e = this.dataMax - this.dataMin >= this.minRange,
                f, g, h, m, q;
            this.isXAxis && this.minRange === G && !this.isLog && (u(a.min) || u(a.max) ? this.minRange = null : (D(this.series, function (a) {
                m = a.xData;
                for (g = q = a.xIncrement ? 1 : m.length - 1; 0 < g; g--)
                    if (h = m[g] - m[g - 1], f === G || h < f) f = h
            }), this.minRange = U(5 * f, this.dataMax - this.dataMin)));
            if (c - b < this.minRange) {
                var r = this.minRange;
                d = (r - c + b) / 2;
                d = [b - d, p(a.min, b - d)];
                e && (d[2] = this.dataMin);
                b = Ia(d);
                c = [b + r, p(a.max, b + r)];
                e && (c[2] = this.dataMax);
                c = ea(c);
                c - b < r && (d[0] = c - r, d[1] = p(a.min, c - r), b = Ia(d))
            }
            this.min = b;
            this.max = c
        },
        setAxisTranslation: function (a) {
            var b = this,
                c = b.max - b.min,
                d = b.axisPointRange || 0,
                e, f = 0,
                g = 0,
                h = b.linkedParent,
                m = !!b.categories,
                q = b.transA;
            if (b.isXAxis || m || d) h ? (f = h.minPointOffset, g = h.pointRangePadding) : D(b.series, function (a) {
                var h = m ? 1 : b.isXAxis ? a.pointRange : b.axisPointRange || 0,
                    q = a.options.pointPlacement,
                    x = a.closestPointRange;
                h > c && (h = 0);
                d = N(d, h);
                f = N(f, Y(q) ? 0 : h / 2);
                g = N(g, "on" === q ? 0 : h);
                !a.noSharedTooltip && u(x) && (e = u(e) ? U(e, x) : x)
            }), h = b.ordinalSlope && e ? b.ordinalSlope / e : 1, b.minPointOffset = f *= h, b.pointRangePadding = g *= h, b.pointRange = U(d, c), b.closestPointRange = e;
            a && (b.oldTransA = q);
            b.translationSlope = b.transA = q = b.len / (c + g || 1);
            b.transB = b.horiz ? b.left : b.bottom;
            b.minPixelPadding = q * f
        },
        setTickPositions: function (a) {
            var b = this,
                c = b.chart,
                d = b.options,
                e = d.startOnTick,
                f = d.endOnTick,
                g = b.isLog,
                h = b.isDatetimeAxis,
                m = b.isXAxis,
                q = b.isLinked,
                r = b.options.tickPositioner,
                v = d.maxPadding,
                z = d.minPadding,
                x = d.tickInterval,
                H = d.minTickInterval,
                k = d.tickPixelInterval,
                t, l = b.categories;
            q ? (b.linkedParent = c[b.coll][d.linkedTo], c = b.linkedParent.getExtremes(), b.min = p(c.min, c.dataMin), b.max = p(c.max, c.dataMax), d.type !== b.linkedParent.options.type && Aa(11, 1)) : (b.min = p(b.userMin, d.min, b.dataMin), b.max = p(b.userMax, d.max, b.dataMax));
            g && (!a && 0 >= U(b.min, p(b.dataMin, b.min)) && Aa(10, 1), b.min = qa(B(b.min)), b.max = qa(B(b.max)));
            b.range && u(b.max) && (b.userMin = b.min = N(b.min, b.max - b.range), b.userMax = b.max, b.range = null);
            b.beforePadding && b.beforePadding();
            b.adjustForMinRange();
            !(l || b.axisPointRange || b.usePercentage || q) && u(b.min) && u(b.max) && (c = b.max - b.min) && (u(d.min) || u(b.userMin) || !z || !(0 > b.dataMin) && b.ignoreMinPadding || (b.min -= c * z), u(d.max) || u(b.userMax) || !v || !(0 < b.dataMax) && b.ignoreMaxPadding || (b.max += c * v));
            aa(d.floor) && (b.min = N(b.min, d.floor));
            aa(d.ceiling) && (b.max = U(b.max, d.ceiling));
            b.min === b.max || void 0 === b.min || void 0 === b.max ? b.tickInterval = 1 : q && !x && k === b.linkedParent.options.tickPixelInterval ? b.tickInterval = b.linkedParent.tickInterval : (b.tickInterval = p(x, l ? 1 : (b.max - b.min) * k / N(b.len, k)), !u(x) && b.len < k && !this.isRadial && !this.isLog && !l && e && f && (t = !0, b.tickInterval /= 4));
            m && !a && D(b.series, function (a) {
                a.processData(b.min !== b.oldMin || b.max !== b.oldMax)
            });
            b.setAxisTranslation(!0);
            b.beforeSetTickPositions && b.beforeSetTickPositions();
            b.postProcessTickInterval && (b.tickInterval = b.postProcessTickInterval(b.tickInterval));
            b.pointRange && (b.tickInterval = N(b.pointRange, b.tickInterval));
            !x && b.tickInterval < H && (b.tickInterval = H);
            h || g || x || (b.tickInterval = R(b.tickInterval, null, F(b.tickInterval), p(d.allowDecimals, !(1 < b.tickInterval && 5 > b.tickInterval && 1E3 < b.max && 9999 > b.max))));
            b.minorTickInterval = "auto" === d.minorTickInterval && b.tickInterval ? b.tickInterval / 5 : d.minorTickInterval;
            b.tickPositions = a = d.tickPositions ? [].concat(d.tickPositions) : r && r.apply(b, [b.min, b.max]);
            a || (!b.ordinalPositions && (b.max - b.min) / b.tickInterval > N(2 * b.len, 200) && Aa(19, !0), a = h ? b.getTimeTicks(b.normalizeTimeTickInterval(b.tickInterval, d.units), b.min, b.max, d.startOfWeek, b.ordinalPositions, b.closestPointRange, !0) : g ? b.getLogTickPositions(b.tickInterval, b.min, b.max) : b.getLinearTickPositions(b.tickInterval, b.min, b.max), t && a.splice(1, a.length - 2), b.tickPositions = a);
            q || (d = a[0], g = a[a.length - 1], h = b.minPointOffset || 0, e ? b.min = d : b.min - h > d && a.shift(), f ? b.max = g : b.max + h < g && a.pop(), 0 === a.length && u(d) && a.push((g + d) / 2), 1 === a.length && (e = 1E13 < ka(b.max) ? 1 : .001, b.min -= e, b.max += e))
        },
        setMaxTicks: function () {
            var a = this.chart,
                b = a.maxTicks || {}, c = this.tickPositions,
                d = this._maxTicksKey = [this.coll, this.pos, this.len].join("-");
            !this.isLinked && !this.isDatetimeAxis && c && c.length > (b[d] || 0) && !1 !== this.options.alignTicks && (b[d] = c.length);
            a.maxTicks = b
        },
        adjustTickAmount: function () {
            var a = this._maxTicksKey,
                b = this.tickPositions,
                c = this.chart.maxTicks;
            if (c && c[a] && !this.isDatetimeAxis && !this.categories && !this.isLinked && !1 !== this.options.alignTicks && this.min !== G) {
                var d = this.tickAmount,
                    e = b.length;
                this.tickAmount = a = c[a];
                if (e < a) {
                    for (; b.length < a;) b.push(qa(b[b.length - 1] + this.tickInterval));
                    this.transA *= (e - 1) / (a - 1);
                    this.max = b[b.length - 1]
                }
                u(d) && a !== d && (this.isDirty = !0)
            }
        },
        setScale: function () {
            var a = this.stacks,
                b, c, d, e;
            this.oldMin = this.min;
            this.oldMax = this.max;
            this.oldAxisLength = this.len;
            this.setAxisSize();
            e = this.len !== this.oldAxisLength;
            D(this.series, function (a) {
                if (a.isDirtyData || a.isDirty || a.xAxis.isDirty) d = !0
            });
            if (e || d || this.isLinked || this.forceRedraw || this.userMin !== this.oldUserMin || this.userMax !== this.oldUserMax) {
                if (!this.isXAxis)
                    for (b in a)
                        for (c in a[b]) a[b][c].total = null, a[b][c].cum = 0;
                this.forceRedraw = !1;
                this.getSeriesExtremes();
                this.setTickPositions();
                this.oldUserMin = this.userMin;
                this.oldUserMax = this.userMax;
                this.isDirty || (this.isDirty = e || this.min !== this.oldMin || this.max !== this.oldMax)
            } else if (!this.isXAxis)
                for (b in this.oldStacks && (a = this.stacks = this.oldStacks), a)
                    for (c in a[b]) a[b][c].cum = a[b][c].total;
            this.setMaxTicks()
        },
        setExtremes: function (a, b, c, d, e) {
            var f = this,
                g = f.chart;
            c = p(c, !0);
            e = n(e, {
                min: a,
                max: b
            });
            ja(f, "setExtremes", e, function () {
                f.userMin = a;
                f.userMax = b;
                f.eventArgs = e;
                f.isDirtyExtremes = !0;
                c && g.redraw(d)
            })
        },
        zoom: function (a, b) {
            var c = this.dataMin,
                d = this.dataMax,
                e = this.options;
            this.allowZoomOutside || (u(c) && a <= U(c, p(e.min, c)) && (a = G), u(d) && b >= N(d, p(e.max, d)) && (b = G));
            this.displayBtn = a !== G || b !== G;
            this.setExtremes(a, b, !1, G, {
                trigger: "zoom"
            });
            return !0
        },
        setAxisSize: function () {
            var a = this.chart,
                b = this.options,
                c = b.offsetLeft || 0,
                d = this.horiz,
                e = p(b.width, a.plotWidth - c + (b.offsetRight || 0)),
                f = p(b.height, a.plotHeight),
                g = p(b.top, a.plotTop),
                b = p(b.left, a.plotLeft + c),
                c = /%$/;
            c.test(f) && (f = parseInt(f, 10) / 100 * a.plotHeight);
            c.test(g) && (g = parseInt(g, 10) / 100 * a.plotHeight + a.plotTop);
            this.left = b;
            this.top = g;
            this.width = e;
            this.height = f;
            this.bottom = a.chartHeight - f - g;
            this.right = a.chartWidth - e - b;
            this.len = N(d ? e : f, 0);
            this.pos = d ? b : g
        },
        getExtremes: function () {
            var a = this.isLog;
            return {
                min: a ? qa(l(this.min)) : this.min,
                max: a ? qa(l(this.max)) : this.max,
                dataMin: this.dataMin,
                dataMax: this.dataMax,
                userMin: this.userMin,
                userMax: this.userMax
            }
        },
        getThreshold: function (a) {
            var b = this.isLog,
                c = b ? l(this.min) : this.min,
                b = b ? l(this.max) : this.max;
            c > a || null === a ? a = c : b < a && (a = b);
            return this.translate(a, 0, 1, 0, 1)
        },
        autoLabelAlign: function (a) {
            a = (p(a, 0) - 90 * this.side + 720) % 360;
            return 15 < a && 165 > a ? "right" : 195 < a && 345 > a ? "left" : "center"
        },
        getOffset: function () {
            var a = this,
                b = a.chart,
                c = b.renderer,
                d = a.options,
                e = a.tickPositions,
                f = a.ticks,
                g = a.horiz,
                h = a.side,
                m = b.inverted ? [1, 0, 3, 2][h] : h,
                q, r, v = 0,
                z, x = 0,
                H = d.title,
                k = d.labels,
                t = 0,
                l = b.axisOffset,
                b = b.clipOffset,
                A = [-1, 1, 1, -1][h],
                F, n = 1,
                B = p(k.maxStaggerLines, 5),
                R, y, w, J, C;
            a.hasData = q = a.hasVisibleSeries || u(a.min) && u(a.max) && !!e;
            a.showAxis = r = q || p(d.showEmpty, !0);
            a.staggerLines = a.horiz && k.staggerLines;
            a.axisGroup || (a.gridGroup = c.g("grid").attr({
                zIndex: d.gridZIndex || 1
            }).add(), a.axisGroup = c.g("axis").attr({
                zIndex: d.zIndex || 2
            }).add(), a.labelGroup = c.g("axis-labels").attr({
                zIndex: k.zIndex || 7
            }).addClass("highcharts-" + a.coll.toLowerCase() + "-labels").add());
            if (q || a.isLinked) {
                a.labelAlign = p(k.align || a.autoLabelAlign(k.rotation));
                D(e, function (b) {
                    f[b] ? f[b].addLabel() : f[b] = new ra(a, b)
                });
                if (a.horiz && !a.staggerLines && B && !k.rotation) {
                    for (q = a.reversed ? [].concat(e).reverse() : e; n < B;) {
                        R = [];
                        y = !1;
                        for (F = 0; F < q.length; F++) w = q[F], J = (J = f[w].label && f[w].label.getBBox()) ? J.width : 0, C = F % n, J && (w = a.translate(w), R[C] !== G && w < R[C] && (y = !0), R[C] = w + J);
                        if (y) n++;
                        else break
                    }
                    1 < n && (a.staggerLines = n)
                }
                D(e, function (b) {
                    if (0 === h || 2 === h || {
                            1: "left",
                            3: "right"
                        }[h] === a.labelAlign) t = N(f[b].getLabelSize(), t)
                });
                a.staggerLines && (t *= a.staggerLines, a.labelOffset = t)
            } else
                for (F in f) f[F].destroy(), delete f[F];
            H && H.text && !1 !== H.enabled && (a.axisTitle || (a.axisTitle = c.text(H.text, 0, 0, H.useHTML).attr({
                zIndex: 7,
                rotation: H.rotation || 0,
                align: H.textAlign || {
                    low: "left",
                    middle: "center",
                    high: "right"
                }[H.align]
            }).addClass("highcharts-" + this.coll.toLowerCase() + "-title").css(H.style).add(a.axisGroup), a.axisTitle.isNew = !0), r && (v = a.axisTitle.getBBox()[g ? "height" : "width"], z = H.offset, x = u(z) ? 0 : p(H.margin, g ? 5 : 10)), a.axisTitle[r ? "show" : "hide"]());
            a.offset = A * p(d.offset, l[h]);
            c = 2 === h ? a.tickBaseline : 0;
            g = t + x + (t && A * (g ? p(k.y, a.tickBaseline + 8) : k.x) - c);
            a.axisTitleMargin = p(z, g);
            l[h] = N(l[h], a.axisTitleMargin + v + A * a.offset, g);
            b[m] = N(b[m], 2 * fa(d.lineWidth / 2))
        },
        getLinePath: function (a) {
            var b = this.chart,
                c = this.opposite,
                d = this.offset,
                e = this.horiz,
                f = this.left + (c ? this.width : 0) + d,
                d = b.chartHeight - this.bottom - (c ? this.height : 0) + d;
            c && (a *= -1);
            return b.renderer.crispLine(["M", e ? this.left : f, e ? d : this.top, "L", e ? b.chartWidth - this.right : f, e ? d : b.chartHeight - this.bottom], a)
        },
        getTitlePosition: function () {
            var a = this.horiz,
                b = this.left,
                c = this.top,
                d = this.len,
                e = this.options.title,
                f = a ? b : c,
                g = this.opposite,
                h = this.offset,
                m = O(e.style.fontSize || 12),
                d = {
                    low: f + (a ? 0 : d),
                    middle: f + d / 2,
                    high: f + (a ? d : 0)
                }[e.align],
                b = (a ? c + this.height : b) + (a ? 1 : -1) * (g ? -1 : 1) * this.axisTitleMargin + (2 === this.side ? m : 0);
            return {
                x: a ? d : b + (g ? this.width : 0) + h + (e.x || 0),
                y: a ? b - (g ? this.height : 0) + h : d + (e.y || 0)
            }
        },
        render: function () {
            var a = this,
                b = a.horiz,
                c = a.reversed,
                d = a.chart,
                e = d.renderer,
                f = a.options,
                g = a.isLog,
                h = a.isLinked,
                m = a.tickPositions,
                q, r = a.axisTitle,
                v = a.ticks,
                z = a.minorTicks,
                x = a.alternateBands,
                H = f.stackLabels,
                p = f.alternateGridColor,
                k = a.tickmarkOffset,
                t = f.lineWidth,
                A = d.hasRendered && u(a.oldMin) && !isNaN(a.oldMin),
                F = a.hasData,
                n = a.showAxis,
                B, R = f.labels.overflow,
                y = a.justifyLabels = b && !1 !== R,
                w;
            a.labelEdge.length = 0;
            a.justifyToPlot = "justify" === R;
            D([v, z, x], function (a) {
                for (var b in a) a[b].isActive = !1
            });
            if (F || h) a.minorTickInterval && !a.categories && D(a.getMinorTickPositions(), function (b) {
                z[b] || (z[b] = new ra(a, b, "minor"));
                A && z[b].isNew && z[b].render(null, !0);
                z[b].render(null, !1, 1)
            }), m.length && (q = m.slice(), (b && c || !b && !c) && q.reverse(), y && (q = q.slice(1).concat([q[0]])), D(q, function (b, c) {
                y && (c = c === q.length - 1 ? 0 : c + 1);
                if (!h || b >= a.min && b <= a.max) v[b] || (v[b] = new ra(a, b)), A && v[b].isNew && v[b].render(c, !0, .1), v[b].render(c)
            }), k && 0 === a.min && (v[-1] || (v[-1] = new ra(a, -1, null, !0)), v[-1].render(-1))), p && D(m, function (b, c) {
                0 === c % 2 && b < a.max && (x[b] || (x[b] = new ga.PlotLineOrBand(a)), B = b + k, w = m[c + 1] !== G ? m[c + 1] + k : a.max, x[b].options = {
                    from: g ? l(B) : B,
                    to: g ? l(w) : w,
                    color: p
                }, x[b].render(), x[b].isActive = !0)
            }), a._addedPlotLB || (D((f.plotLines || []).concat(f.plotBands || []), function (b) {
                a.addPlotBandOrLine(b)
            }), a._addedPlotLB = !0);
            D([v, z, x], function (a) {
                var b, c, e = [],
                    f = La ? La.duration || 500 : 0,
                    g = function () {
                        for (c = e.length; c--;) a[e[c]] && !a[e[c]].isActive && (a[e[c]].destroy(), delete a[e[c]])
                    };
                for (b in a) a[b].isActive || (a[b].render(b, !1, 0), a[b].isActive = !1, e.push(b));
                a !== x && d.hasRendered && f ? f && setTimeout(g, f) : g()
            });
            t && (b = a.getLinePath(t), a.axisLine ? a.axisLine.animate({
                d: b
            }) : a.axisLine = e.path(b).attr({
                stroke: f.lineColor,
                "stroke-width": t,
                zIndex: 7
            }).add(a.axisGroup), a.axisLine[n ? "show" : "hide"]());
            r && n && (r[r.isNew ? "attr" : "animate"](a.getTitlePosition()), r.isNew = !1);
            H && H.enabled && a.renderStackTotals();
            a.isDirty = !1
        },
        redraw: function () {
            this.render();
            D(this.plotLinesAndBands, function (a) {
                a.render()
            });
            D(this.series, function (a) {
                a.isDirty = !0
            })
        },
        destroy: function (a) {
            var b = this,
                c = b.stacks,
                d, e = b.plotLinesAndBands;
            a || pa(b);
            for (d in c) ca(c[d]), c[d] = null;
            D([b.ticks, b.minorTicks, b.alternateBands], function (a) {
                ca(a)
            });
            for (a = e.length; a--;) e[a].destroy();
            D("stackTotalGroup axisLine axisTitle axisGroup cross gridGroup labelGroup".split(" "), function (a) {
                b[a] && (b[a] = b[a].destroy())
            });
            this.cross && this.cross.destroy()
        },
        drawCrosshair: function (a, b) {
            if (this.crosshair)
                if (!1 === (u(b) || !p(this.crosshair.snap, !0))) this.hideCrosshair();
                else {
                    var c, d = this.crosshair,
                        e = d.animation;
                    p(d.snap, !0) ? u(b) && (c = this.chart.inverted != this.horiz ? b.plotX : this.len - b.plotY) : c = this.horiz ? a.chartX - this.pos : this.len - a.chartY + this.pos;
                    c = this.isRadial ? this.getPlotLinePath(this.isXAxis ? b.x : p(b.stackY, b.y)) : this.getPlotLinePath(null, null, null, null, c);
                    if (null === c) this.hideCrosshair();
                    else if (this.cross) this.cross.attr({
                        visibility: "visible"
                    })[e ? "animate" : "attr"]({
                        d: c
                    }, e);
                    else e = {
                            "stroke-width": d.width || 10,
                            stroke: d.color || "#DDDDDD",
                            zIndex: d.zIndex || 2
                        }, d.dashStyle && (e.dashstyle = d.dashStyle), this.cross = this.chart.renderer.path(c).attr(e).add()
                }
        },
        hideCrosshair: function () {
            this.cross && this.cross.hide()
        }
    };
    n(T.prototype, {
        getPlotBandPath: function (a, b) {
            var c = this.getPlotLinePath(b),
                d = this.getPlotLinePath(a);
            d && c ? d.push(c[4], c[5], c[1], c[2]) : d = null;
            return d
        },
        addPlotBand: function (a) {
            return this.addPlotBandOrLine(a, "plotBands")
        },
        addPlotLine: function (a) {
            return this.addPlotBandOrLine(a, "plotLines")
        },
        addPlotBandOrLine: function (a, b) {
            var c = (new ga.PlotLineOrBand(this, a)).render(),
                d = this.userOptions;
            c && (b && (d[b] = d[b] || [], d[b].push(a)), this.plotLinesAndBands.push(c));
            return c
        },
        removePlotBandOrLine: function (a) {
            for (var b = this.plotLinesAndBands, c = this.options, d = this.userOptions, e = b.length; e--;) b[e].id === a && b[e].destroy();
            D([c.plotLines || [], d.plotLines || [], c.plotBands || [], d.plotBands || []], function (b) {
                for (e = b.length; e--;) b[e].id === a && y(b, b[e])
            })
        }
    });
    T.prototype.getTimeTicks = function (a, b, c, d) {
        var e = [],
            f = {}, g = ha.global.useUTC,
            h, m = new ua(b - Pa),
            q = a.unitRange,
            r = a.count;
        if (u(b)) {
            q >= ba.second && (m.setMilliseconds(0), m.setSeconds(q >= ba.minute ? 0 : r * fa(m.getSeconds() / r)));
            if (q >= ba.minute) m[Qb](q >= ba.hour ? 0 : r * fa(m[yb]() / r));
            if (q >= ba.hour) m[Rb](q >= ba.day ? 0 : r * fa(m[zb]() / r));
            if (q >= ba.day) m[Bb](q >= ba.month ? 1 : r * fa(m[Wa]() / r));
            q >= ba.month && (m[Sb](q >= ba.year ? 0 : r * fa(m[mb]() / r)), h = m[nb]());
            if (q >= ba.year) m[Tb](h - h % r);
            if (q === ba.week) m[Bb](m[Wa]() - m[Ab]() + p(d, 1));
            b = 1;
            Pa && (m = new ua(m.getTime() + Pa));
            h = m[nb]();
            d = m.getTime();
            for (var v = m[mb](), z = m[Wa](), x = (ba.day + (g ? Pa : 6E4 * m.getTimezoneOffset())) % ba.day; d < c;) e.push(d),
                d = q === ba.year ? lb(h + b * r, 0) : q === ba.month ? lb(h, v + b * r) : g || q !== ba.day && q !== ba.week ? d + q * r : lb(h, v, z + b * r * (q === ba.day ? 1 : 7)), b++;
            e.push(d);
            D(rb(e, function (a) {
                return q <= ba.hour && a % ba.day === x
            }), function (a) {
                f[a] = "day"
            })
        }
        e.info = n(a, {
            higherRanks: f,
            totalRange: q * r
        });
        return e
    };
    T.prototype.normalizeTimeTickInterval = function (a, b) {
        var c = b || [
                    ["millisecond", [1, 2, 5, 10, 20, 25, 50, 100, 200, 500]],
                    ["second", [1, 2, 5, 10, 15, 30]],
                    ["minute", [1, 2, 5, 10, 15, 30]],
                    ["hour", [1, 2, 3, 4, 6, 8, 12]],
                    ["day", [1, 2]],
                    ["week", [1, 2]],
                    ["month", [1, 2, 3, 4, 6]],
                    ["year", null]
                ],
            d = c[c.length - 1],
            e = ba[d[0]],
            f = d[1],
            g;
        for (g = 0; g < c.length && !(d = c[g], e = ba[d[0]], f = d[1], c[g + 1] && a <= (e * f[f.length - 1] + ba[c[g + 1][0]]) / 2); g++);
        e === ba.year && a < 5 * e && (f = [1, 2, 5]);
        c = R(a / e, f, "year" === d[0] ? N(F(a / e), 1) : 1);
        return {
            unitRange: e,
            count: c,
            unitName: d[0]
        }
    };
    T.prototype.getLogTickPositions = function (a, b, c, d) {
        var e = this.options,
            f = this.len,
            g = [];
        d || (this._minorAutoInterval = null);
        if (.5 <= a) a = L(a), g = this.getLinearTickPositions(a, b, c);
        else if (.08 <= a)
            for (var f = fa(b), h, m, q, r, v, e = .3 < a ? [1, 2, 4] : .15 < a ? [1, 2,
                4, 6, 8
            ] : [1, 2, 3, 4, 5, 6, 7, 8, 9]; f < c + 1 && !v; f++)
                for (m = e.length, h = 0; h < m && !v; h++) q = B(l(f) * e[h]), q > b && (!d || r <= c) && r !== G && g.push(r), r > c && (v = !0), r = q;
        else b = l(b), c = l(c), a = e[d ? "minorTickInterval" : "tickInterval"], a = p("auto" === a ? null : a, this._minorAutoInterval, e.tickPixelInterval / (d ? 5 : 1) * (c - b) / ((d ? f / this.tickPositions.length : f) || 1)), a = R(a, null, F(a)), g = Fa(this.getLinearTickPositions(a, b, c), B), d || (this._minorAutoInterval = a / 5);
        d || (this.tickInterval = a);
        return g
    };
    var Hb = ga.Tooltip = function () {
        this.init.apply(this, arguments)
    };
    Hb.prototype = {
        init: function (a, b) {
            var c = b.borderWidth,
                d = b.style,
                e = O(d.padding);
            this.chart = a;
            this.options = b;
            this.crosshairs = [];
            this.now = {
                x: 0,
                y: 0
            };
            this.isHidden = !0;
            this.label = a.renderer.label("", 0, 0, b.shape || "callout", null, null, b.useHTML, null, "tooltip").attr({
                padding: e,
                fill: b.backgroundColor,
                "stroke-width": c,
                r: b.borderRadius,
                zIndex: 8
            }).css(d).css({
                padding: 0
            }).add().attr({
                y: -9999
            });
            za || this.label.shadow(b.shadow);
            this.shared = b.shared
        },
        destroy: function () {
            this.label && (this.label = this.label.destroy());
            clearTimeout(this.hideTimer);
            clearTimeout(this.tooltipTimeout)
        },
        move: function (a, b, c, d) {
            var e = this,
                f = e.now,
                g = !1 !== e.options.animation && !e.isHidden && (1 < ka(a - f.x) || 1 < ka(b - f.y)),
                h = e.followPointer || 1 < e.len;
            n(f, {
                x: g ? (2 * f.x + a) / 3 : a,
                y: g ? (f.y + b) / 2 : b,
                anchorX: h ? G : g ? (2 * f.anchorX + c) / 3 : c,
                anchorY: h ? G : g ? (f.anchorY + d) / 2 : d
            });
            e.label.attr(f);
            g && (clearTimeout(this.tooltipTimeout), this.tooltipTimeout = setTimeout(function () {
                e && e.move(a, b, c, d)
            }, 32))
        },
        hide: function (a) {
            var b = this,
                c;
            clearTimeout(this.hideTimer);
            this.isHidden || (c = this.chart.hoverPoints, this.hideTimer = setTimeout(function () {
                b.label.fadeOut();
                b.isHidden = !0
            }, p(a, this.options.hideDelay, 500)), c && D(c, function (a) {
                a.setState()
            }), this.chart.hoverPoints = null)
        },
        getAnchor: function (a, b) {
            var c, d = this.chart,
                e = d.inverted,
                f = d.plotTop,
                g = 0,
                h = 0,
                m;
            a = w(a);
            c = a[0].tooltipPos;
            this.followPointer && b && (b.chartX === G && (b = d.pointer.normalize(b)), c = [b.chartX - d.plotLeft, b.chartY - f]);
            c || (D(a, function (a) {
                m = a.series.yAxis;
                g += a.plotX;
                h += (a.plotLow ? (a.plotLow + a.plotHigh) / 2 : a.plotY) + (!e && m ? m.top - f : 0)
            }), g /= a.length, h /= a.length, c = [e ? d.plotWidth - h : g, this.shared && !e && 1 < a.length && b ? b.chartY - f : e ? d.plotHeight - g : h]);
            return Fa(c, L)
        },
        getPosition: function (a, b, c) {
            var d = this.chart,
                e = this.distance,
                f = {}, g, h = ["y", d.chartHeight, b, c.plotY + d.plotTop],
                m = ["x", d.chartWidth, a, c.plotX + d.plotLeft],
                q = c.ttBelow || d.inverted && !c.negative || !d.inverted && c.negative,
                r = function (a, b, c, d) {
                    var g = c < d - e;
                    b = d + e + c < b;
                    c = d - e - c;
                    d += e;
                    if (q && b) f[a] = d;
                    else if (!q && g) f[a] = c;
                    else if (g) f[a] = c;
                    else if (b) f[a] = d;
                    else return !1
                }, v = function (a, b, c, d) {
                    if (d < e || d > b - e) return !1;
                    f[a] = d < c / 2 ? 1 : d > b - c / 2 ? b - c - 2 : d - c / 2
                }, z = function (a) {
                    var b = h;
                    h = m;
                    m = b;
                    g = a
                }, x = function () {
                    !1 !== r.apply(0, h) ? !1 !== v.apply(0, m) || g || (z(!0), x()) : g ? f.x = f.y = 0 : (z(!0), x())
                };
            (d.inverted || 1 < this.len) && z();
            x();
            return f
        },
        defaultFormatter: function (a) {
            var b = this.points || w(this),
                c = b[0].series,
                d;
            d = [a.tooltipHeaderFormatter(b[0])];
            D(b, function (a) {
                c = a.series;
                d.push(c.tooltipFormatter && c.tooltipFormatter(a) || a.point.tooltipFormatter(c.tooltipOptions.pointFormat))
            });
            d.push(a.options.footerFormat || "");
            return d.join("")
        },
        refresh: function (a, b) {
            var c = this.chart,
                d = this.label,
                e = this.options,
                f, g, h = {}, m, q = [];
            m = e.formatter || this.defaultFormatter;
            var h = c.hoverPoints,
                r, v = this.shared;
            clearTimeout(this.hideTimer);
            this.followPointer = w(a)[0].series.tooltipOptions.followPointer;
            g = this.getAnchor(a, b);
            f = g[0];
            g = g[1];
            !v || a.series && a.series.noSharedTooltip ? h = a.getLabelConfig() : (c.hoverPoints = a, h && D(h, function (a) {
                a.setState()
            }), D(a, function (a) {
                a.setState("hover");
                q.push(a.getLabelConfig())
            }), h = {
                x: a[0].category,
                y: a[0].y
            }, h.points = q, this.len = q.length, a = a[0]);
            m = m.call(h, this);
            h = a.series;
            this.distance = p(h.tooltipOptions.distance, 16);
            !1 === m ? this.hide() : (this.isHidden && (gb(d), d.attr("opacity", 1).show()), d.attr({
                text: m
            }), r = e.borderColor || a.color || h.color || "#606060", d.attr({
                stroke: r
            }), this.updatePosition({
                plotX: f,
                plotY: g,
                negative: a.negative,
                ttBelow: a.ttBelow
            }), this.isHidden = !1);
            ja(c, "tooltipRefresh", {
                text: m,
                x: f + c.plotLeft,
                y: g + c.plotTop,
                borderColor: r
            })
        },
        updatePosition: function (a) {
            var b = this.chart,
                c = this.label,
                c = (this.options.positioner || this.getPosition).call(this, c.width, c.height, a);
            this.move(L(c.x), L(c.y), a.plotX + b.plotLeft, a.plotY + b.plotTop)
        },
        tooltipHeaderFormatter: function (a) {
            var b = a.series,
                c = b.tooltipOptions,
                d = c.dateTimeLabelFormats,
                e = c.xDateFormat,
                f = b.xAxis,
                g = f && "datetime" === f.options.type && aa(a.key),
                c = c.headerFormat,
                f = f && f.closestPointRange,
                h;
            if (g && !e) {
                if (f)
                    for (h in ba) {
                        if (ba[h] >= f || ba[h] <= ba.day && 0 < a.key % ba[h]) {
                            e = d[h];
                            break
                        }
                    } else e = d.day;
                e = e || d.year
            }
            g && e && (c = c.replace("{point.key}", "{point.key:" + e + "}"));
            return t(c, {
                point: a,
                series: b
            })
        }
    };
    var Ga;
    db = Z.documentElement.ontouchstart !== G;
    var Ta = ga.Pointer = function (a, b) {
        this.init(a, b)
    };
    Ta.prototype = {
        init: function (a, b) {
            var c = b.chart,
                d = c.events,
                e = za ? "" : c.zoomType,
                c = a.inverted,
                f;
            this.options = b;
            this.chart = a;
            this.zoomX = f = /x/.test(e);
            this.zoomY = e = /y/.test(e);
            this.zoomHor = f && !c || e && c;
            this.zoomVert = e && !c || f && c;
            this.hasZoom = f || e;
            this.runChartClick = d && !!d.click;
            this.pinchDown = [];
            this.lastValidTouch = {};
            ga.Tooltip && b.tooltip.enabled && (a.tooltip = new Hb(a, b.tooltip), this.followTouchMove = b.tooltip.followTouchMove);
            this.setDOMEvents()
        },
        normalize: function (a, b) {
            var c, d;
            a = a || window.event;
            a = lc(a);
            a.target || (a.target = a.srcElement);
            d = a.touches ? a.touches.length ? a.touches.item(0) : a.changedTouches[0] : a;
            b || (this.chartPosition = b = kc(this.chart.container));
            d.pageX === G ? (c = N(a.x, a.clientX - b.left), d = a.y) : (c = d.pageX - b.left, d = d.pageY - b.top);
            return n(a, {
                chartX: L(c),
                chartY: L(d)
            })
        },
        getCoordinates: function (a) {
            var b = {
                xAxis: [],
                yAxis: []
            };
            D(this.chart.axes, function (c) {
                b[c.isXAxis ? "xAxis" : "yAxis"].push({
                    axis: c,
                    value: c.toValue(a[c.horiz ? "chartX" : "chartY"])
                })
            });
            return b
        },
        getIndex: function (a) {
            var b = this.chart;
            return b.inverted ? b.plotHeight + b.plotTop - a.chartY : a.chartX - b.plotLeft
        },
        runPointActions: function (a) {
            var b = this.chart,
                c = b.series,
                d = b.tooltip,
                e, f, g = b.hoverPoint,
                h = b.hoverSeries,
                m, q, r = b.chartWidth,
                v = this.getIndex(a);
            if (d && this.options.tooltip.shared && (!h || !h.noSharedTooltip)) {
                f = [];
                m = c.length;
                for (q = 0; q < m; q++) c[q].visible && !1 !== c[q].options.enableMouseTracking && !c[q].noSharedTooltip && !0 !== c[q].singularTooltips && c[q].tooltipPoints.length && (e = c[q].tooltipPoints[v]) && e.series && (e._dist = ka(v - e.clientX), r = U(r, e._dist), f.push(e));
                for (m = f.length; m--;) f[m]._dist > r && f.splice(m, 1);
                f.length && f[0].clientX !== this.hoverX && (d.refresh(f, a), this.hoverX = f[0].clientX)
            }
            c = h && h.tooltipOptions.followPointer;
            if (h && h.tracker && !c) {
                if ((e = h.tooltipPoints[v]) && e !== g) e.onMouseOver(a)
            } else d && c && !d.isHidden && (h = d.getAnchor([{}], a), d.updatePosition({
                plotX: h[0],
                plotY: h[1]
            }));
            d && !this._onDocumentMouseMove && (this._onDocumentMouseMove = function (a) {
                if (sa[Ga]) sa[Ga].pointer.onDocumentMouseMove(a)
            }, W(Z, "mousemove", this._onDocumentMouseMove));
            D(b.axes, function (b) {
                b.drawCrosshair(a, p(e, g))
            })
        },
        reset: function (a, b) {
            var c = this.chart,
                d = c.hoverSeries,
                e = c.hoverPoint,
                f = c.tooltip,
                g = f && f.shared ? c.hoverPoints : e;
            (a = a && f && g) && w(g)[0].plotX === G && (a = !1);
            if (a) f.refresh(g), e && e.setState(e.state, !0);
            else {
                if (e) e.onMouseOut();
                if (d) d.onMouseOut();
                f && f.hide(b);
                this._onDocumentMouseMove && (pa(Z, "mousemove", this._onDocumentMouseMove), this._onDocumentMouseMove = null);
                D(c.axes, function (a) {
                    a.hideCrosshair()
                });
                this.hoverX = null
            }
        },
        scaleGroups: function (a, b) {
            var c = this.chart,
                d;
            D(c.series, function (e) {
                d = a || e.getPlotBox();
                e.xAxis && e.xAxis.zoomEnabled && (e.group.attr(d), e.markerGroup && (e.markerGroup.attr(d), e.markerGroup.clip(b ? c.clipRect : null)), e.dataLabelsGroup && e.dataLabelsGroup.attr(d))
            });
            c.clipRect.attr(b || c.clipBox)
        },
        dragStart: function (a) {
            var b = this.chart;
            b.mouseIsDown = a.type;
            b.cancelClick = !1;
            b.mouseDownX = this.mouseDownX = a.chartX;
            b.mouseDownY = this.mouseDownY = a.chartY
        },
        drag: function (a) {
            var b = this.chart,
                c = b.options.chart,
                d = a.chartX,
                e = a.chartY,
                f = this.zoomHor,
                g = this.zoomVert,
                h = b.plotLeft,
                m = b.plotTop,
                q = b.plotWidth,
                r = b.plotHeight,
                v, z = this.mouseDownX,
                x = this.mouseDownY,
                H = c.panKey && a[c.panKey + "Key"];
            d < h ? d = h : d > h + q && (d = h + q);
            e < m ? e = m : e > m + r && (e = m + r);
            this.hasDragged = Math.sqrt(Math.pow(z - d, 2) + Math.pow(x - e, 2));
            10 < this.hasDragged && (v = b.isInsidePlot(z - h, x - m), b.hasCartesianSeries && (this.zoomX || this.zoomY) && v && !H && !this.selectionMarker && (this.selectionMarker = b.renderer.rect(h, m, f ? 1 : q, g ? 1 : r, 0).attr({
                fill: c.selectionMarkerFill || "rgba(69,114,167,0.25)",
                zIndex: 7
            }).add()), this.selectionMarker && f && (d -= z, this.selectionMarker.attr({
                width: ka(d),
                x: (0 < d ? 0 : d) + z
            })), this.selectionMarker && g && (d = e - x, this.selectionMarker.attr({
                height: ka(d),
                y: (0 < d ? 0 : d) + x
            })), v && !this.selectionMarker && c.panning && b.pan(a, c.panning))
        },
        drop: function (a) {
            var b = this.chart,
                c = this.hasPinched;
            if (this.selectionMarker) {
                var d = {
                        xAxis: [],
                        yAxis: [],
                        originalEvent: a.originalEvent || a
                    }, e = this.selectionMarker,
                    f = e.attr ? e.attr("x") : e.x,
                    g = e.attr ? e.attr("y") : e.y,
                    h = e.attr ? e.attr("width") : e.width,
                    m = e.attr ? e.attr("height") : e.height,
                    q;
                if (this.hasDragged || c) D(b.axes, function (b) {
                    if (b.zoomEnabled) {
                        var c = b.horiz,
                            e = "touchend" === a.type ? b.minPixelPadding : 0,
                            x = b.toValue((c ? f : g) + e),
                            c = b.toValue((c ? f + h : g + m) - e);
                        isNaN(x) || isNaN(c) || (d[b.coll].push({
                            axis: b,
                            min: U(x, c),
                            max: N(x, c)
                        }), q = !0)
                    }
                }), q && ja(b, "selection", d, function (a) {
                    b.zoom(n(a, c ? {
                        animation: !1
                    } : null))
                });
                this.selectionMarker = this.selectionMarker.destroy();
                c && this.scaleGroups()
            }
            b && (I(b.container, {
                cursor: b._cursor
            }), b.cancelClick = 10 < this.hasDragged, b.mouseIsDown = this.hasDragged = this.hasPinched = !1, this.pinchDown = [])
        },
        onContainerMouseDown: function (a) {
            a = this.normalize(a);
            a.preventDefault && a.preventDefault();
            this.dragStart(a)
        },
        onDocumentMouseUp: function (a) {
            sa[Ga] && sa[Ga].pointer.drop(a)
        },
        onDocumentMouseMove: function (a) {
            var b = this.chart,
                c = this.chartPosition,
                d = b.hoverSeries;
            a = this.normalize(a, c);
            c && d && !this.inClass(a.target, "highcharts-tracker") && !b.isInsidePlot(a.chartX - b.plotLeft, a.chartY - b.plotTop) && this.reset()
        },
        onContainerMouseLeave: function () {
            var a = sa[Ga];
            a && (a.pointer.reset(), a.pointer.chartPosition = null)
        },
        onContainerMouseMove: function (a) {
            var b = this.chart;
            Ga = b.index;
            a = this.normalize(a);
            a.returnValue = !1;
            "mousedown" === b.mouseIsDown && this.drag(a);
            !this.inClass(a.target, "highcharts-tracker") && !b.isInsidePlot(a.chartX - b.plotLeft, a.chartY - b.plotTop) || b.openMenu || this.runPointActions(a)
        },
        inClass: function (a, b) {
            for (var c; a;) {
                if (c = C(a, "class")) {
                    if (-1 !== c.indexOf(b)) return !0;
                    if (-1 !== c.indexOf("highcharts-container")) return !1
                }
                a = a.parentNode
            }
        },
        onTrackerMouseOut: function (a) {
            var b = this.chart.hoverSeries,
                c = (a = a.relatedTarget || a.toElement) && a.point && a.point.series;
            if (b && !b.options.stickyTracking && !this.inClass(a, "highcharts-tooltip") && c !== b) b.onMouseOut()
        },
        onContainerClick: function (a) {
            var b = this.chart,
                c = b.hoverPoint,
                d = b.plotLeft,
                e = b.plotTop;
            a = this.normalize(a);
            a.cancelBubble = !0;
            b.cancelClick || (c && this.inClass(a.target, "highcharts-tracker") ? (ja(c.series, "click", n(a, {
                point: c
            })), b.hoverPoint && c.firePointEvent("click", a)) : (n(a, this.getCoordinates(a)), b.isInsidePlot(a.chartX - d, a.chartY - e) && ja(b, "click", a)))
        },
        setDOMEvents: function () {
            var a = this,
                b = a.chart.container;
            b.onmousedown = function (b) {
                a.onContainerMouseDown(b)
            };
            b.onmousemove = function (b) {
                a.onContainerMouseMove(b)
            };
            b.onclick = function (b) {
                a.onContainerClick(b)
            };
            W(b, "mouseleave", a.onContainerMouseLeave);
            1 === fb && W(Z, "mouseup", a.onDocumentMouseUp);
            db && (b.ontouchstart = function (b) {
                a.onContainerTouchStart(b)
            }, b.ontouchmove = function (b) {
                a.onContainerTouchMove(b)
            }, 1 === fb && W(Z, "touchend", a.onDocumentTouchEnd))
        },
        destroy: function () {
            var a;
            pa(this.chart.container, "mouseleave", this.onContainerMouseLeave);
            fb || (pa(Z, "mouseup", this.onDocumentMouseUp), pa(Z, "touchend", this.onDocumentTouchEnd));
            clearInterval(this.tooltipTimeout);
            for (a in this) this[a] = null
        }
    };
    n(ga.Pointer.prototype, {
        pinchTranslate: function (a, b, c, d, e, f) {
            (this.zoomHor || this.pinchHor) && this.pinchTranslateDirection(!0, a, b, c, d, e, f);
            (this.zoomVert || this.pinchVert) && this.pinchTranslateDirection(!1, a, b, c, d, e, f)
        },
        pinchTranslateDirection: function (a, b, c, d, e, f, g, h) {
            var m = this.chart,
                q = a ? "x" : "y",
                r = a ? "X" : "Y",
                v = "chart" + r,
                z = a ? "width" : "height",
                x = m["plot" + (a ? "Left" : "Top")],
                H, p, k = h || 1,
                t = m.inverted,
                l = m.bounds[a ? "h" : "v"],
                A = 1 === b.length,
                F = b[0][v],
                n = c[0][v],
                B = !A && b[1][v],
                u = !A && c[1][v],
                D;
            c = function () {
                !A && 20 < ka(F - B) && (k = h || ka(n - u) / ka(F - B));
                p = (x - n) / k + F;
                H = m["plot" + (a ? "Width" : "Height")] / k
            };
            c();
            b = p;
            b < l.min ? (b = l.min, D = !0) : b + H > l.max && (b = l.max - H, D = !0);
            D ? (n -= .8 * (n - g[q][0]), A || (u -= .8 * (u - g[q][1])), c()) : g[q] = [n, u];
            t || (f[q] = p - x, f[z] = H);
            f = t ? 1 / k : k;
            e[z] = H;
            e[q] = b;
            d[t ? a ? "scaleY" : "scaleX" : "scale" + r] = k;
            d["translate" + r] = f * x + (n - f * F)
        },
        pinch: function (a) {
            var b = this,
                c = b.chart,
                d = b.pinchDown,
                e = b.followTouchMove,
                f = a.touches,
                g = f.length,
                h = b.lastValidTouch,
                m = b.hasZoom,
                q = b.selectionMarker,
                r = {}, v = 1 === g && (b.inClass(a.target, "highcharts-tracker") && c.runTrackerClick || b.runChartClick),
                z = {};
            !m && !e || v || a.preventDefault();
            Fa(f, function (a) {
                return b.normalize(a)
            });
            "touchstart" === a.type ? (D(f, function (a, b) {
                d[b] = {
                    chartX: a.chartX,
                    chartY: a.chartY
                }
            }), h.x = [d[0].chartX, d[1] && d[1].chartX], h.y = [d[0].chartY, d[1] && d[1].chartY], D(c.axes, function (a) {
                if (a.zoomEnabled) {
                    var b = c.bounds[a.horiz ? "h" : "v"],
                        d = a.minPixelPadding,
                        e = a.toPixels(p(a.options.min, a.dataMin)),
                        f = a.toPixels(p(a.options.max, a.dataMax)),
                        g = U(e, f),
                        e = N(e, f);
                    b.min = U(a.pos, g - d);
                    b.max = N(a.pos + a.len, e + d)
                }
            }), b.res = !0) : d.length && (q || (b.selectionMarker = q = n({
                destroy: ma
            }, c.plotBox)), b.pinchTranslate(d, f, r, q, z, h), b.hasPinched = m, b.scaleGroups(r, z), !m && e && 1 === g ? this.runPointActions(b.normalize(a)) : b.res && (b.res = !1, this.reset(!1, 0)))
        },
        onContainerTouchStart: function (a) {
            var b = this.chart;
            Ga = b.index;
            1 === a.touches.length ? (a = this.normalize(a), b.isInsidePlot(a.chartX - b.plotLeft, a.chartY - b.plotTop) ? (this.runPointActions(a), this.pinch(a)) : this.reset()) : 2 === a.touches.length && this.pinch(a)
        },
        onContainerTouchMove: function (a) {
            1 !== a.touches.length && 2 !== a.touches.length || this.pinch(a)
        },
        onDocumentTouchEnd: function (a) {
            sa[Ga] && sa[Ga].pointer.drop(a)
        }
    });
    if (oa.PointerEvent || oa.MSPointerEvent) {
        var Ka = {}, Ib = !!oa.PointerEvent,
            qc = function () {
                var a, b = [];
                b.item = function (a) {
                    return this[a]
                };
                for (a in Ka) Ka.hasOwnProperty(a) && b.push({
                    pageX: Ka[a].pageX,
                    pageY: Ka[a].pageY,
                    target: Ka[a].target
                });
                return b
            }, Jb = function (a, b, c, d) {
                a = a.originalEvent || a;
                "touch" !== a.pointerType && a.pointerType !== a.MSPOINTER_TYPE_TOUCH || !sa[Ga] || (d(a), d = sa[Ga].pointer, d[b]({
                    type: c,
                    target: a.currentTarget,
                    preventDefault: ma,
                    touches: qc()
                }))
            };
        n(Ta.prototype, {
            onContainerPointerDown: function (a) {
                Jb(a, "onContainerTouchStart", "touchstart", function (a) {
                    Ka[a.pointerId] = {
                        pageX: a.pageX,
                        pageY: a.pageY,
                        target: a.currentTarget
                    }
                })
            },
            onContainerPointerMove: function (a) {
                Jb(a, "onContainerTouchMove", "touchmove", function (a) {
                    Ka[a.pointerId] = {
                        pageX: a.pageX,
                        pageY: a.pageY
                    };
                    Ka[a.pointerId].target || (Ka[a.pointerId].target = a.currentTarget)
                })
            },
            onDocumentPointerUp: function (a) {
                Jb(a, "onContainerTouchEnd", "touchend", function (a) {
                    delete Ka[a.pointerId]
                })
            },
            batchMSEvents: function (a) {
                a(this.chart.container, Ib ? "pointerdown" : "MSPointerDown", this.onContainerPointerDown);
                a(this.chart.container, Ib ? "pointermove" : "MSPointerMove", this.onContainerPointerMove);
                a(Z, Ib ? "pointerup" : "MSPointerUp", this.onDocumentPointerUp)
            }
        });
        k(Ta.prototype, "init", function (a, b, c) {
            a.call(this, b, c);
            (this.hasZoom || this.followTouchMove) && I(b.container, {
                "-ms-touch-action": "none",
                "touch-action": "none"
            })
        });
        k(Ta.prototype, "setDOMEvents", function (a) {
            a.apply(this);
            (this.hasZoom || this.followTouchMove) && this.batchMSEvents(W)
        });
        k(Ta.prototype, "destroy", function (a) {
            this.batchMSEvents(pa);
            a.call(this)
        })
    }
    var ub = ga.Legend = function (a, b) {
        this.init(a, b)
    };
    ub.prototype = {
        init: function (a, b) {
            var c = this,
                d = b.itemStyle,
                e = p(b.padding, 8),
                f = b.itemMarginTop || 0;
            this.options = b;
            b.enabled && (c.itemStyle = d, c.itemHiddenStyle = E(d, b.itemHiddenStyle), c.itemMarginTop = f, c.padding = e, c.initialItemX = e, c.initialItemY = e - 5, c.maxItemWidth = 0, c.chart = a, c.itemHeight = 0, c.lastLineHeight = 0, c.symbolWidth = p(b.symbolWidth, 16), c.pages = [], c.render(), W(c.chart, "endResize", function () {
                c.positionCheckboxes()
            }))
        },
        colorizeItem: function (a, b) {
            var c = this.options,
                d = a.legendItem,
                e = a.legendLine,
                f = a.legendSymbol,
                g = this.itemHiddenStyle.color,
                c = b ? c.itemStyle.color : g,
                h = b ? a.legendColor || a.color || "#CCC" : g,
                g = a.options && a.options.marker,
                m = {
                    fill: h
                }, q;
            d && d.css({
                fill: c,
                color: c
            });
            e && e.attr({
                stroke: h
            });
            if (f) {
                if (g && f.isMarker)
                    for (q in m.stroke = h, g = a.convertAttribs(g), g) d = g[q], d !== G && (m[q] = d);
                f.attr(m)
            }
        },
        positionItem: function (a) {
            var b = this.options,
                c = b.symbolPadding,
                b = !b.rtl,
                d = a._legendItemPos,
                e = d[0],
                d = d[1],
                f = a.checkbox;
            a.legendGroup && a.legendGroup.translate(b ? e : this.legendWidth - e - 2 * c - 4, d);
            f && (f.x = e, f.y = d)
        },
        destroyItem: function (a) {
            var b = a.checkbox;
            D(["legendItem", "legendLine", "legendSymbol", "legendGroup"], function (b) {
                a[b] && (a[b] = a[b].destroy())
            });
            b && Va(a.checkbox)
        },
        destroy: function () {
            var a = this.group,
                b = this.box;
            b && (this.box = b.destroy());
            a && (this.group = a.destroy())
        },
        positionCheckboxes: function (a) {
            var b = this.group.alignAttr,
                c, d = this.clipHeight || this.legendHeight;
            b && (c = b.translateY, D(this.allItems, function (e) {
                var f = e.checkbox,
                    g;
                f && (g = c + f.y + (a || 0) + 3, I(f, {
                    left: b.translateX + e.checkboxOffset + f.x - 20 + "px",
                    top: g + "px",
                    display: g > c - 6 && g < c + d - 6 ? "" : "none"
                }))
            }))
        },
        renderTitle: function () {
            var a = this.padding,
                b = this.options.title,
                c = 0;
            b.text && (this.title || (this.title = this.chart.renderer.label(b.text, a - 3, a - 4, null, null, null, null, null, "legend-title").attr({
                zIndex: 1
            }).css(b.style).add(this.group)), a = this.title.getBBox(), c = a.height, this.offsetWidth = a.width, this.contentGroup.attr({
                translateY: c
            }));
            this.titleHeight = c
        },
        renderItem: function (a) {
            var b = this.chart,
                c = b.renderer,
                d = this.options,
                e = "horizontal" === d.layout,
                f = this.symbolWidth,
                g = d.symbolPadding,
                h = this.itemStyle,
                m = this.itemHiddenStyle,
                q = this.padding,
                r = e ? p(d.itemDistance, 20) : 0,
                v = !d.rtl,
                z = d.width,
                x = d.itemMarginBottom || 0,
                k = this.itemMarginTop,
                l = this.initialItemX,
                A = a.legendItem,
                F = a.series && a.series.drawLegendSymbol ? a.series : a,
                n = F.options,
                n = this.createCheckboxForItem && n && n.showCheckbox,
                B = d.useHTML;
            A || (a.legendGroup = c.g("legend-item").attr({
                zIndex: 1
            }).add(this.scrollGroup), a.legendItem = A = c.text(d.labelFormat ? t(d.labelFormat, a) : d.labelFormatter.call(a), v ? f + g : -g, this.baseline || 0, B).css(E(a.visible ? h : m)).attr({
                align: v ? "left" : "right",
                zIndex: 2
            }).add(a.legendGroup), this.baseline || (this.baseline = c.fontMetrics(h.fontSize, A).f + 3 + k, A.attr("y", this.baseline)), F.drawLegendSymbol(this, a), this.setItemEvents && this.setItemEvents(a, A, B, h, m), this.colorizeItem(a, a.visible), n && this.createCheckboxForItem(a));
            c = A.getBBox();
            f = a.checkboxOffset = d.itemWidth || a.legendItemWidth || f + g + c.width + r + (n ? 20 : 0);
            this.itemHeight = g = L(a.legendItemHeight || c.height);
            e && this.itemX - l + f > (z || b.chartWidth - 2 * q - l - d.x) && (this.itemX = l, this.itemY += k + this.lastLineHeight + x, this.lastLineHeight = 0);
            this.maxItemWidth = N(this.maxItemWidth, f);
            this.lastItemY = k + this.itemY + x;
            this.lastLineHeight = N(g, this.lastLineHeight);
            a._legendItemPos = [this.itemX, this.itemY];
            e ? this.itemX += f : (this.itemY += k + g + x, this.lastLineHeight = g);
            this.offsetWidth = z || N((e ? this.itemX - l - r : f) + q, this.offsetWidth)
        },
        getAllItems: function () {
            var a = [];
            D(this.chart.series, function (b) {
                var c = b.options;
                p(c.showInLegend, u(c.linkedTo) ? !1 : G, !0) && (a = a.concat(b.legendItems || ("point" === c.legendType ? b.data : b)))
            });
            return a
        },
        render: function () {
            var a = this,
                b = a.chart,
                c = b.renderer,
                d = a.group,
                e, f, g, h, m = a.box,
                q = a.options,
                r = a.padding,
                v = q.borderWidth,
                z = q.backgroundColor;
            a.itemX = a.initialItemX;
            a.itemY = a.initialItemY;
            a.offsetWidth = 0;
            a.lastItemY = 0;
            d || (a.group = d = c.g("legend").attr({
                zIndex: 7
            }).add(), a.contentGroup = c.g().attr({
                zIndex: 1
            }).add(d), a.scrollGroup = c.g().add(a.contentGroup));
            a.renderTitle();
            e = a.getAllItems();
            da(e, function (a, b) {
                return (a.options && a.options.legendIndex || 0) - (b.options && b.options.legendIndex || 0)
            });
            q.reversed && e.reverse();
            a.allItems = e;
            a.display = f = !!e.length;
            D(e, function (b) {
                a.renderItem(b)
            });
            g = q.width || a.offsetWidth;
            h = a.lastItemY + a.lastLineHeight + a.titleHeight;
            h = a.handleOverflow(h);
            if (v || z) g += r, h += r, m ? 0 < g && 0 < h && (m[m.isNew ? "attr" : "animate"](m.crisp({
                width: g,
                height: h
            })), m.isNew = !1) : (a.box = m = c.rect(0, 0, g, h, q.borderRadius, v || 0).attr({
                stroke: q.borderColor,
                "stroke-width": v || 0,
                fill: z || "none"
            }).add(d).shadow(q.shadow), m.isNew = !0), m[f ? "show" : "hide"]();
            a.legendWidth = g;
            a.legendHeight = h;
            D(e, function (b) {
                a.positionItem(b)
            });
            f && d.align(n({
                width: g,
                height: h
            }, q), !0, "spacingBox");
            b.isResizing || this.positionCheckboxes()
        },
        handleOverflow: function (a) {
            var b = this,
                c = this.chart,
                d = c.renderer,
                e = this.options,
                f = e.y,
                f = c.spacingBox.height + ("top" === e.verticalAlign ? -f : f) - this.padding,
                g = e.maxHeight,
                h, m = this.clipRect,
                q = e.navigation,
                r = p(q.animation, !0),
                v = q.arrowSize || 12,
                z = this.nav,
                x = this.pages,
                k, t = this.allItems;
            "horizontal" === e.layout && (f /= 2);
            g && (f = U(f, g));
            x.length = 0;
            a > f && !e.useHTML ? (this.clipHeight = h = N(f - 20 - this.titleHeight - this.padding, 0), this.currentPage = p(this.currentPage, 1), this.fullHeight = a, D(t, function (a, b) {
                var c = a._legendItemPos[1],
                    d = L(a.legendItem.getBBox().height),
                    e = x.length;
                if (!e || c - x[e - 1] > h && (k || c) !== x[e - 1]) x.push(k || c), e++;
                b === t.length - 1 && c + d - x[e - 1] > h && x.push(c);
                c !== k && (k = c)
            }), m || (m = b.clipRect = d.clipRect(0, this.padding, 9999, 0), b.contentGroup.clip(m)), m.attr({
                height: h
            }), z || (this.nav = z = d.g().attr({
                zIndex: 1
            }).add(this.group), this.up = d.symbol("triangle", 0, 0, v, v).on("click", function () {
                b.scroll(-1, r)
            }).add(z), this.pager = d.text("", 15, 10).css(q.style).add(z), this.down = d.symbol("triangle-down", 0, 0, v, v).on("click", function () {
                b.scroll(1, r)
            }).add(z)), b.scroll(0), a = f) : z && (m.attr({
                height: c.chartHeight
            }), z.hide(), this.scrollGroup.attr({
                translateY: 1
            }), this.clipHeight = 0);
            return a
        },
        scroll: function (a, b) {
            var c = this.pages,
                d = c.length,
                e = this.currentPage + a,
                f = this.clipHeight,
                g = this.options.navigation,
                h = g.activeColor,
                g = g.inactiveColor,
                m = this.pager,
                q = this.padding;
            e > d && (e = d);
            0 < e && (b !== G && ta(b, this.chart), this.nav.attr({
                translateX: q,
                translateY: f + this.padding + 7 + this.titleHeight,
                visibility: "visible"
            }), this.up.attr({
                fill: 1 === e ? g : h
            }).css({
                cursor: 1 === e ? "default" : "pointer"
            }), m.attr({
                text: e + "/" + d
            }), this.down.attr({
                x: 18 + this.pager.getBBox().width,
                fill: e === d ? g : h
            }).css({
                cursor: e === d ? "default" : "pointer"
            }), c = -c[e - 1] + this.initialItemY, this.scrollGroup.animate({
                translateY: c
            }), this.currentPage = e, this.positionCheckboxes(c))
        }
    };
    var jb = ga.LegendSymbolMixin = {
        drawRectangle: function (a, b) {
            var c = a.options.symbolHeight || 12;
            b.legendSymbol = this.chart.renderer.rect(0, a.baseline - 5 - c / 2, a.symbolWidth, c, a.options.symbolRadius || 0).attr({
                zIndex: 3
            }).add(b.legendGroup)
        },
        drawLineMarker: function (a) {
            var b = this.options,
                c = b.marker,
                d;
            d = a.symbolWidth;
            var e = this.chart.renderer,
                f = this.legendGroup;
            a = a.baseline - L(.3 * e.fontMetrics(a.options.itemStyle.fontSize, this.legendItem).b);
            var g;
            b.lineWidth && (g = {
                "stroke-width": b.lineWidth
            }, b.dashStyle && (g.dashstyle = b.dashStyle), this.legendLine = e.path(["M", 0, a, "L", d, a]).attr(g).add(f));
            c && !1 !== c.enabled && (b = c.radius, this.legendSymbol = d = e.symbol(this.symbol, d / 2 - b, a - b, 2 * b, 2 * b).add(f), d.isMarker = !0)
        }
    };
    (/Trident\/7\.0/.test(Ma) || cb) && k(ub.prototype, "positionItem", function (a, b) {
        var c = this,
            d = function () {
                b._legendItemPos && a.call(c, b)
            };
        d();
        setTimeout(d)
    });
    na.prototype = {
        init: function (a, b) {
            var c, d = a.series;
            a.series = null;
            c = E(ha, a);
            c.series = a.series = d;
            this.userOptions = a;
            d = c.chart;
            this.margin = this.splashArray("margin", d);
            this.spacing = this.splashArray("spacing", d);
            var e = d.events;
            this.bounds = {
                h: {},
                v: {}
            };
            this.callback = b;
            this.isResizing = 0;
            this.options = c;
            this.axes = [];
            this.series = [];
            this.hasCartesianSeries = d.showAxes;
            var f = this,
                g;
            f.index = sa.length;
            sa.push(f);
            fb++;
            !1 !== d.reflow && W(f, "load", function () {
                f.initReflow()
            });
            if (e)
                for (g in e) W(f, g, e[g]);
            f.xAxis = [];
            f.yAxis = [];
            f.animation = za ? !1 : p(d.animation, !0);
            f.pointCount = f.colorCounter = f.symbolCounter = 0;
            f.firstRender()
        },
        initSeries: function (a) {
            var b = this.options.chart;
            (b = P[a.type || b.type || b.defaultSeriesType]) || Aa(17, !0);
            b = new b;
            b.init(this, a);
            return b
        },
        isInsidePlot: function (a, b, c) {
            var d = c ? b : a;
            a = c ? a : b;
            return 0 <= d && d <= this.plotWidth && 0 <= a && a <= this.plotHeight
        },
        adjustTickAmounts: function () {
            !1 !== this.options.chart.alignTicks && D(this.axes, function (a) {
                a.adjustTickAmount()
            });
            this.maxTicks = null
        },
        redraw: function (a) {
            var b = this.axes,
                c = this.series,
                d = this.pointer,
                e = this.legend,
                f = this.isDirtyLegend,
                g, h, m = this.hasCartesianSeries,
                q = this.isDirtyBox,
                r = c.length,
                v = r,
                z = this.renderer,
                x = z.isHidden(),
                k = [];
            ta(a, this);
            x && this.cloneRenderTo();
            for (this.layOutTitles(); v--;)
                if (a = c[v], a.options.stacking && (g = !0, a.isDirty)) {
                    h = !0;
                    break
                }
            if (h)
                for (v = r; v--;) a = c[v], a.options.stacking && (a.isDirty = !0);
            D(c, function (a) {
                a.isDirty && "point" === a.options.legendType && (f = !0)
            });
            f && e.options.enabled && (e.render(), this.isDirtyLegend = !1);
            g && this.getStacks();
            m && (this.isResizing || (this.maxTicks = null, D(b, function (a) {
                a.setScale()
            })), this.adjustTickAmounts());
            this.getMargins();
            m && (D(b, function (a) {
                a.isDirty && (q = !0)
            }), D(b, function (a) {
                a.isDirtyExtremes && (a.isDirtyExtremes = !1, k.push(function () {
                    ja(a, "afterSetExtremes", n(a.eventArgs, a.getExtremes()));
                    delete a.eventArgs
                }));
                (q || g) && a.redraw()
            }));
            q && this.drawChartBox();
            D(c, function (a) {
                a.isDirty && a.visible && (!a.isCartesian || a.xAxis) && a.redraw()
            });
            d && d.reset(!0);
            z.draw();
            ja(this, "redraw");
            x && this.cloneRenderTo(!0);
            D(k, function (a) {
                a.call()
            })
        },
        get: function (a) {
            var b = this.axes,
                c = this.series,
                d, e;
            for (d = 0; d < b.length; d++)
                if (b[d].options.id === a) return b[d];
            for (d = 0; d < c.length; d++)
                if (c[d].options.id === a) return c[d];
            for (d = 0; d < c.length; d++)
                for (e = c[d].points || [], b = 0; b < e.length; b++)
                    if (e[b].id === a) return e[b];
            return null
        },
        getAxes: function () {
            var a = this,
                b = this.options,
                c = b.xAxis = w(b.xAxis || {}),
                b = b.yAxis = w(b.yAxis || {});
            D(c, function (a, b) {
                a.index = b;
                a.isX = !0
            });
            D(b, function (a, b) {
                a.index = b
            });
            c = c.concat(b);
            D(c, function (b) {
                new T(a, b)
            });
            a.adjustTickAmounts()
        },
        getSelectedPoints: function () {
            var a = [];
            D(this.series, function (b) {
                a = a.concat(rb(b.points || [], function (a) {
                    return a.selected
                }))
            });
            return a
        },
        getSelectedSeries: function () {
            return rb(this.series, function (a) {
                return a.selected
            })
        },
        getStacks: function () {
            var a = this;
            D(a.yAxis, function (a) {
                a.stacks && a.hasVisibleSeries && (a.oldStacks = a.stacks)
            });
            D(a.series, function (b) {
                !b.options.stacking || !0 !== b.visible && !1 !== a.options.chart.ignoreHiddenSeries || (b.stackKey = b.type + p(b.options.stack, ""))
            })
        },
        setTitle: function (a, b, c) {
            var d = this,
                e = d.options,
                f;
            f = e.title = E(e.title, a);
            e = e.subtitle = E(e.subtitle, b);
            D([
                ["title", a, f],
                ["subtitle", b, e]
            ], function (a) {
                var b = a[0],
                    c = d[b],
                    e = a[1];
                a = a[2];
                c && e && (d[b] = c = c.destroy());
                a && a.text && !c && (d[b] = d.renderer.text(a.text, 0, 0, a.useHTML).attr({
                    align: a.align,
                    "class": "highcharts-" + b,
                    zIndex: a.zIndex || 4
                }).css(a.style).add())
            });
            d.layOutTitles(c)
        },
        layOutTitles: function (a) {
            var b = 0,
                c = this.title,
                d = this.subtitle,
                e = this.options,
                f = e.title,
                e = e.subtitle,
                g = this.renderer,
                h = this.spacingBox.width - 44;
            c && (c.css({
                width: (f.width || h) + "px"
            }).align(n({
                y: g.fontMetrics(f.style.fontSize, c).b - 3
            }, f), !1, "spacingBox"), f.floating || f.verticalAlign || (b = c.getBBox().height));
            d && (d.css({
                width: (e.width || h) + "px"
            }).align(n({
                y: b + (f.margin - 13) + g.fontMetrics(f.style.fontSize, d).b
            }, e), !1, "spacingBox"), e.floating || e.verticalAlign || (b = Ya(b + d.getBBox().height)));
            c = this.titleOffset !== b;
            this.titleOffset = b;
            !this.isDirtyBox && c && (this.isDirtyBox = c, this.hasRendered && p(a, !0) && this.isDirtyBox && this.redraw())
        },
        getChartSize: function () {
            var a = this.options.chart,
                b = a.width,
                a = a.height,
                c = this.renderToClone || this.renderTo;
            u(b) || (this.containerWidth = qb(c, "width"));
            u(a) || (this.containerHeight = qb(c, "height"));
            this.chartWidth = N(0, b || this.containerWidth || 600);
            this.chartHeight = N(0, p(a, 19 < this.containerHeight ? this.containerHeight : 400))
        },
        cloneRenderTo: function (a) {
            var b = this.renderToClone,
                c = this.container;
            a ? b && (this.renderTo.appendChild(c), Va(b), delete this.renderToClone) : (c && c.parentNode === this.renderTo && this.renderTo.removeChild(c), this.renderToClone = b = this.renderTo.cloneNode(0), I(b, {
                position: "absolute",
                top: "-9999px",
                display: "block"
            }), b.style.setProperty && b.style.setProperty("display", "block", "important"), Z.body.appendChild(b), c && b.appendChild(c))
        },
        getContainer: function () {
            var a, b = this.options.chart,
                c, d, e;
            this.renderTo = a = b.renderTo;
            e = "highcharts-" + Db++;
            Y(a) && (this.renderTo = a = Z.getElementById(a));
            a || Aa(13, !0);
            c = O(C(a, "data-highcharts-chart"));
            !isNaN(c) && sa[c] && sa[c].hasRendered && sa[c].destroy();
            C(a, "data-highcharts-chart", this.index);
            a.innerHTML = "";
            b.skipClone || a.offsetWidth || this.cloneRenderTo();
            this.getChartSize();
            c = this.chartWidth;
            d = this.chartHeight;
            this.container = a = K("div", {
                className: "highcharts-container" + (b.className ? " " + b.className : ""),
                id: e
            }, n({
                position: "relative",
                overflow: "hidden",
                width: c + "px",
                height: d + "px",
                textAlign: "left",
                lineHeight: "normal",
                zIndex: 0,
                "-webkit-tap-highlight-color": "rgba(0,0,0,0)"
            }, b.style), this.renderToClone || a);
            this._cursor = a.style.cursor;
            this.renderer = b.forExport ? new Ca(a, c, d, b.style, !0) : new Za(a, c, d, b.style);
            za && this.renderer.create(this, a, c, d)
        },
        getMargins: function () {
            var a = this.spacing,
                b, c = this.legend,
                d = this.margin,
                e = this.options.legend,
                f = p(e.margin, 20),
                g = e.x,
                h = e.y,
                m = e.align,
                q = e.verticalAlign,
                r = this.titleOffset;
            this.resetMargins();
            b = this.axisOffset;
            r && !u(d[0]) && (this.plotTop = N(this.plotTop, r + this.options.title.margin + a[0]));
            c.display && !e.floating && ("right" === m ? u(d[1]) || (this.marginRight = N(this.marginRight, c.legendWidth - g + f + a[1])) : "left" === m ? u(d[3]) || (this.plotLeft = N(this.plotLeft, c.legendWidth + g + f + a[3])) : "top" === q ? u(d[0]) || (this.plotTop = N(this.plotTop, c.legendHeight + h + f + a[0])) : "bottom" !== q || u(d[2]) || (this.marginBottom = N(this.marginBottom, c.legendHeight - h + f + a[2])));
            this.extraBottomMargin && (this.marginBottom += this.extraBottomMargin);
            this.extraTopMargin && (this.plotTop += this.extraTopMargin);
            this.hasCartesianSeries && D(this.axes, function (a) {
                a.getOffset()
            });
            u(d[3]) || (this.plotLeft += b[3]);
            u(d[0]) || (this.plotTop += b[0]);
            u(d[2]) || (this.marginBottom += b[2]);
            u(d[1]) || (this.marginRight += b[1]);
            this.setChartSize()
        },
        reflow: function (a) {
            var b = this,
                c = b.options.chart,
                d = b.renderTo,
                e = c.width || qb(d, "width"),
                f = c.height || qb(d, "height"),
                c = a ? a.target : oa,
                d = function () {
                    b.container && (b.setSize(e, f, !1), b.hasUserSize = null)
                };
            if (!b.hasUserSize && e && f && (c === oa || c === Z)) {
                if (e !== b.containerWidth || f !== b.containerHeight) clearTimeout(b.reflowTimeout), a ? b.reflowTimeout = setTimeout(d, 100) : d();
                b.containerWidth = e;
                b.containerHeight = f
            }
        },
        initReflow: function () {
            var a = this,
                b = function (b) {
                    a.reflow(b)
                };
            W(oa, "resize", b);
            W(a, "destroy", function () {
                pa(oa, "resize", b)
            })
        },
        setSize: function (a, b, c) {
            var d = this,
                e, f, g;
            d.isResizing += 1;
            g = function () {
                d && ja(d, "endResize", null, function () {
                    --d.isResizing
                })
            };
            ta(c, d);
            d.oldChartHeight = d.chartHeight;
            d.oldChartWidth = d.chartWidth;
            u(a) && (d.chartWidth = e = N(0, L(a)), d.hasUserSize = !!e);
            u(b) && (d.chartHeight = f = N(0, L(b)));
            (La ? sb : I)(d.container, {
                width: e + "px",
                height: f + "px"
            }, La);
            d.setChartSize(!0);
            d.renderer.setSize(e, f, c);
            d.maxTicks = null;
            D(d.axes, function (a) {
                a.isDirty = !0;
                a.setScale()
            });
            D(d.series, function (a) {
                a.isDirty = !0
            });
            d.isDirtyLegend = !0;
            d.isDirtyBox = !0;
            d.layOutTitles();
            d.getMargins();
            d.redraw(c);
            d.oldChartHeight = null;
            ja(d, "resize");
            !1 === La ? g() : setTimeout(g, La && La.duration || 500)
        },
        setChartSize: function (a) {
            var b = this.inverted,
                c = this.renderer,
                d = this.chartWidth,
                e = this.chartHeight,
                f = this.options.chart,
                g = this.spacing,
                h = this.clipOffset,
                m, q, r, v;
            this.plotLeft = m = L(this.plotLeft);
            this.plotTop = q = L(this.plotTop);
            this.plotWidth = r = N(0, L(d - m - this.marginRight));
            this.plotHeight = v = N(0, L(e - q - this.marginBottom));
            this.plotSizeX = b ? v : r;
            this.plotSizeY = b ? r : v;
            this.plotBorderWidth = f.plotBorderWidth || 0;
            this.spacingBox = c.spacingBox = {
                x: g[3],
                y: g[0],
                width: d - g[3] - g[1],
                height: e - g[0] - g[2]
            };
            this.plotBox = c.plotBox = {
                x: m,
                y: q,
                width: r,
                height: v
            };
            d = 2 * fa(this.plotBorderWidth / 2);
            b = Ya(N(d, h[3]) / 2);
            c = Ya(N(d, h[0]) / 2);
            this.clipBox = {
                x: b,
                y: c,
                width: fa(this.plotSizeX - N(d, h[1]) / 2 - b),
                height: N(0, fa(this.plotSizeY - N(d, h[2]) / 2 - c))
            };
            a || D(this.axes, function (a) {
                a.setAxisSize();
                a.setAxisTranslation()
            })
        },
        resetMargins: function () {
            var a = this.spacing,
                b = this.margin;
            this.plotTop = p(b[0], a[0]);
            this.marginRight = p(b[1], a[1]);
            this.marginBottom = p(b[2], a[2]);
            this.plotLeft = p(b[3], a[3]);
            this.axisOffset = [0, 0, 0, 0];
            this.clipOffset = [0, 0, 0, 0]
        },
        drawChartBox: function () {
            var a = this.options.chart,
                b = this.renderer,
                c = this.chartWidth,
                d = this.chartHeight,
                e = this.chartBackground,
                f = this.plotBackground,
                g = this.plotBorder,
                h = this.plotBGImage,
                m = a.borderWidth || 0,
                q = a.backgroundColor,
                r = a.plotBackgroundColor,
                v = a.plotBackgroundImage,
                z = a.plotBorderWidth || 0,
                x, k = this.plotLeft,
                p = this.plotTop,
                t = this.plotWidth,
                l = this.plotHeight,
                A = this.plotBox,
                n = this.clipRect,
                F = this.clipBox;
            x = m + (a.shadow ? 8 : 0);
            if (m || q) e ? e.animate(e.crisp({
                width: c - x,
                height: d - x
            })) : (e = {
                fill: q || "none"
            }, m && (e.stroke = a.borderColor, e["stroke-width"] = m), this.chartBackground = b.rect(x / 2, x / 2, c - x, d - x, a.borderRadius, m).attr(e).addClass("highcharts-background").add().shadow(a.shadow));
            r && (f ? f.animate(A) : this.plotBackground = b.rect(k, p, t, l, 0).attr({
                fill: r
            }).add().shadow(a.plotShadow));
            v && (h ? h.animate(A) : this.plotBGImage = b.image(v, k, p, t, l).add());
            n ? n.animate({
                width: F.width,
                height: F.height
            }) : this.clipRect = b.clipRect(F);
            z && (g ? g.animate(g.crisp({
                x: k,
                y: p,
                width: t,
                height: l,
                strokeWidth: -z
            })) : this.plotBorder = b.rect(k, p, t, l, 0, -z).attr({
                stroke: a.plotBorderColor,
                "stroke-width": z,
                fill: "none",
                zIndex: 1
            }).add());
            this.isDirtyBox = !1
        },
        propFromSeries: function () {
            var a = this,
                b = a.options.chart,
                c, d = a.options.series,
                e, f;
            D(["inverted", "angular", "polar"], function (g) {
                c = P[b.type || b.defaultSeriesType];
                f = a[g] || b[g] || c && c.prototype[g];
                for (e = d && d.length; !f && e--;)(c = P[d[e].type]) && c.prototype[g] && (f = !0);
                a[g] = f
            })
        },
        linkSeries: function () {
            var a = this,
                b = a.series;
            D(b, function (a) {
                a.linkedSeries.length = 0
            });
            D(b, function (b) {
                var d = b.options.linkedTo;
                Y(d) && (d = ":previous" === d ? a.series[b.index - 1] : a.get(d)) && (d.linkedSeries.push(b), b.linkedParent = d)
            })
        },
        renderSeries: function () {
            D(this.series, function (a) {
                a.translate();
                a.setTooltipPoints && a.setTooltipPoints();
                a.render()
            })
        },
        renderLabels: function () {
            var a = this,
                b = a.options.labels;
            b.items && D(b.items, function (c) {
                var d = n(b.style, c.style),
                    e = O(d.left) + a.plotLeft,
                    f = O(d.top) + a.plotTop + 12;
                delete d.left;
                delete d.top;
                a.renderer.text(c.html, e, f).attr({
                    zIndex: 2
                }).css(d).add()
            })
        },
        render: function () {
            var a = this.axes,
                b = this.renderer,
                c = this.options;
            this.setTitle();
            this.legend = new ub(this, c.legend);
            this.getStacks();
            D(a, function (a) {
                a.setScale()
            });
            this.getMargins();
            this.maxTicks = null;
            D(a, function (a) {
                a.setTickPositions(!0);
                a.setMaxTicks()
            });
            this.adjustTickAmounts();
            this.getMargins();
            this.drawChartBox();
            this.hasCartesianSeries && D(a, function (a) {
                a.render()
            });
            this.seriesGroup || (this.seriesGroup = b.g("series-group").attr({
                zIndex: 3
            }).add());
            this.renderSeries();
            this.renderLabels();
            this.showCredits(c.credits);
            this.hasRendered = !0
        },
        showCredits: function (a) {
            a.enabled && !this.credits && (this.credits = this.renderer.text(a.text, 0, 0).on("click", function () {
                a.href && (location.href = a.href)
            }).attr({
                align: a.position.align,
                zIndex: 8
            }).css(a.style).add().align(a.position))
        },
        destroy: function () {
            var a = this,
                b = a.axes,
                c = a.series,
                d = a.container,
                e, f = d && d.parentNode;
            ja(a, "destroy");
            sa[a.index] = G;
            fb--;
            a.renderTo.removeAttribute("data-highcharts-chart");
            pa(a);
            for (e = b.length; e--;) b[e] = b[e].destroy();
            for (e = c.length; e--;) c[e] = c[e].destroy();
            D("title subtitle chartBackground plotBackground plotBGImage plotBorder seriesGroup clipRect credits pointer scroller rangeSelector legend resetZoomButton tooltip renderer".split(" "), function (b) {
                var c = a[b];
                c && c.destroy && (a[b] = c.destroy())
            });
            d && (d.innerHTML = "", pa(d), f && Va(d));
            for (e in a) delete a[e]
        },
        isReadyToRender: function () {
            var a = this;
            return !wa && oa == oa.top && "complete" !== Z.readyState || za && !oa.canvg ? (za ? Yb.push(function () {
                a.firstRender()
            }, a.options.global.canvasToolsURL) : Z.attachEvent("onreadystatechange", function () {
                Z.detachEvent("onreadystatechange", a.firstRender);
                "complete" === Z.readyState && a.firstRender()
            }), !1) : !0
        },
        firstRender: function () {
            var a = this,
                b = a.options,
                c = a.callback;
            a.isReadyToRender() && (a.getContainer(), ja(a, "init"), a.resetMargins(), a.setChartSize(), a.propFromSeries(), a.getAxes(), D(b.series || [], function (b) {
                a.initSeries(b)
            }), a.linkSeries(), ja(a, "beforeRender"), ga.Pointer && (a.pointer = new Ta(a, b)), a.render(), a.renderer.draw(), c && c.apply(a, [a]), D(a.callbacks, function (b) {
                b.apply(a, [a])
            }), a.cloneRenderTo(!0), ja(a, "load"))
        },
        splashArray: function (a, b) {
            var c = b[a],
                c = Q(c) ? c : [c, c, c, c];
            return [p(b[a + "Top"], c[0]), p(b[a + "Right"], c[1]), p(b[a + "Bottom"], c[2]), p(b[a + "Left"], c[3])]
        }
    };
    na.prototype.callbacks = [];
    var Zb = ga.CenteredSeriesMixin = {
        getCenter: function () {
            var a = this.options,
                b = this.chart,
                c = 2 * (a.slicedOffset || 0),
                d, e = b.plotWidth - 2 * c,
                f = b.plotHeight - 2 * c,
                b = a.center,
                a = [p(b[0], "50%"), p(b[1], "50%"), a.size || "100%", a.innerSize || 0],
                g = U(e, f),
                h;
            return Fa(a, function (a, b) {
                h = /%$/.test(a);
                d = 2 > b || 2 === b && h;
                return (h ? [e, f, g, g][b] * O(a) / 100 : a) + (d ? c : 0)
            })
        }
    }, Da = function () {
    };
    Da.prototype = {
        init: function (a, b, c) {
            this.series = a;
            this.applyOptions(b, c);
            this.pointAttr = {};
            a.options.colorByPoint && (b = a.options.colors || a.chart.options.colors, this.color = this.color || b[a.colorCounter++], a.colorCounter === b.length && (a.colorCounter = 0));
            a.chart.pointCount++;
            return this
        },
        applyOptions: function (a, b) {
            var c = this.series,
                d = c.options.pointValKey || c.pointValKey;
            a = Da.prototype.optionsToObject.call(this, a);
            n(this, a);
            this.options = this.options ? n(this.options, a) : a;
            d && (this.y = this[d]);
            this.x === G && c && (this.x = b === G ? c.autoIncrement() : b);
            return this
        },
        optionsToObject: function (a) {
            var b = {}, c = this.series,
                d = c.pointArrayMap || ["y"],
                e = d.length,
                f = 0,
                g = 0;
            if ("number" === typeof a || null === a) b[d[0]] = a;
            else if (S(a))
                for (a.length > e && (c = typeof a[0], "string" === c ? b.name = a[0] : "number" === c && (b.x = a[0]), f++); g < e;) b[d[g++]] = a[f++];
            else "object" === typeof a && (b = a, a.dataLabels && (c._hasPointLabels = !0), a.marker && (c._hasPointMarkers = !0));
            return b
        },
        destroy: function () {
            var a = this.series.chart,
                b = a.hoverPoints,
                c;
            a.pointCount--;
            b && (this.setState(), y(b, this), b.length || (a.hoverPoints = null));
            if (this === a.hoverPoint) this.onMouseOut();
            if (this.graphic || this.dataLabel) pa(this), this.destroyElements();
            this.legendItem && a.legend.destroyItem(this);
            for (c in this) this[c] = null
        },
        destroyElements: function () {
            for (var a = "graphic dataLabel dataLabelUpper group connector shadowGroup".split(" "), b, c = 6; c--;) b = a[c], this[b] && (this[b] = this[b].destroy())
        },
        getLabelConfig: function () {
            return {
                x: this.category,
                y: this.y,
                key: this.name || this.category,
                series: this.series,
                point: this,
                percentage: this.percentage,
                total: this.total || this.stackTotal
            }
        },
        tooltipFormatter: function (a) {
            var b = this.series,
                c = b.tooltipOptions,
                d = p(c.valueDecimals, ""),
                e = c.valuePrefix || "",
                f = c.valueSuffix || "";
            D(b.pointArrayMap || ["y"], function (b) {
                b = "{point." + b;
                if (e || f) a = a.replace(b + "}", e + b + "}" + f);
                a = a.replace(b + "}", b + ":,." + d + "f}")
            });
            return t(a, {
                point: this,
                series: this.series
            })
        },
        firePointEvent: function (a, b, c) {
            var d = this,
                e = this.series.options;
            (e.point.events[a] || d.options && d.options.events && d.options.events[a]) && this.importEvents();
            "click" === a && e.allowPointSelect && (c = function (a) {
                d.select(null, a.ctrlKey || a.metaKey || a.shiftKey)
            });
            ja(this, a, b, c)
        }
    };
    var V = function () {
    };
    V.prototype = {
        isCartesian: !0,
        type: "line",
        pointClass: Da,
        sorted: !0,
        requireSorting: !0,
        pointAttrToOptions: {
            stroke: "lineColor",
            "stroke-width": "lineWidth",
            fill: "fillColor",
            r: "radius"
        },
        axisTypes: ["xAxis", "yAxis"],
        colorCounter: 0,
        parallelArrays: ["x", "y"],
        init: function (a, b) {
            var c = this,
                d, e, f = a.series,
                g = function (a, b) {
                    return p(a.options.index, a._i) - p(b.options.index, b._i)
                };
            c.chart = a;
            c.options = b = c.setOptions(b);
            c.linkedSeries = [];
            c.bindAxes();
            n(c, {
                name: b.name,
                state: "",
                pointAttr: {},
                visible: !1 !== b.visible,
                selected: !0 === b.selected
            });
            za && (b.animation = !1);
            e = b.events;
            for (d in e) W(c, d, e[d]);
            if (e && e.click || b.point && b.point.events && b.point.events.click || b.allowPointSelect) a.runTrackerClick = !0;
            c.getColor();
            c.getSymbol();
            D(c.parallelArrays, function (a) {
                c[a + "Data"] = []
            });
            c.setData(b.data, !1);
            c.isCartesian && (a.hasCartesianSeries = !0);
            f.push(c);
            c._i = f.length - 1;
            da(f, g);
            this.yAxis && da(this.yAxis.series, g);
            D(f, function (a, b) {
                a.index = b;
                a.name = a.name || "Series " + (b + 1)
            })
        },
        bindAxes: function () {
            var a = this,
                b = a.options,
                c = a.chart,
                d;
            D(a.axisTypes || [], function (e) {
                D(c[e], function (c) {
                    d = c.options;
                    if (b[e] === d.index || b[e] !== G && b[e] === d.id || b[e] === G && 0 === d.index) c.series.push(a), a[e] = c, c.isDirty = !0
                });
                a[e] || a.optionalAxis === e || Aa(18, !0)
            })
        },
        updateParallelArrays: function (a, b) {
            var c = a.series,
                d = arguments;
            D(c.parallelArrays, "number" === typeof b ? function (d) {
                var f = "y" === d && c.toYData ? c.toYData(a) : a[d];
                c[d + "Data"][b] = f
            } : function (a) {
                Array.prototype[b].apply(c[a + "Data"], Array.prototype.slice.call(d, 2))
            })
        },
        autoIncrement: function () {
            var a = this.options,
                b = this.xIncrement,
                b = p(b, a.pointStart, 0);
            this.pointInterval = p(this.pointInterval, a.pointInterval, 1);
            this.xIncrement = b + this.pointInterval;
            return b
        },
        getSegments: function () {
            var a = -1,
                b = [],
                c, d = this.points,
                e = d.length;
            if (e)
                if (this.options.connectNulls) {
                    for (c = e; c--;) null === d[c].y && d.splice(c, 1);
                    d.length && (b = [d])
                } else D(d, function (c, g) {
                    null === c.y ? (g > a + 1 && b.push(d.slice(a + 1, g)), a = g) : g === e - 1 && b.push(d.slice(a + 1, g + 1))
                });
            this.segments = b
        },
        setOptions: function (a) {
            var b = this.chart,
                c = b.options.plotOptions,
                b = b.userOptions || {}, d = b.plotOptions || {}, e = c[this.type];
            this.userOptions = a;
            c = E(e, c.series, a);
            this.tooltipOptions = E(ha.tooltip, ha.plotOptions[this.type].tooltip, b.tooltip, d.series && d.series.tooltip, d[this.type] && d[this.type].tooltip, a.tooltip);
            null === e.marker && delete c.marker;
            return c
        },
        getCyclic: function (a, b, c) {
            var d = this.userOptions,
                e = "_" + a + "Index",
                f = a + "Counter";
            b || (u(d[e]) ? b = d[e] : (d[e] = b = this.chart[f] % c.length, this.chart[f] += 1), b = c[b]);
            this[a] = b
        },
        getColor: function () {
            this.options.colorByPoint || this.getCyclic("color", this.options.color || X[this.type].color, this.chart.options.colors)
        },
        getSymbol: function () {
            var a = this.options.marker;
            this.getCyclic("symbol", a.symbol, this.chart.options.symbols);
            /^url/.test(this.symbol) && (a.radius = 0)
        },
        drawLegendSymbol: jb.drawLineMarker,
        setData: function (a, b, c, d) {
            var e = this,
                f = e.points,
                g = f && f.length || 0,
                h, m = e.options,
                q = e.chart,
                r = null,
                v = e.xAxis,
                z = v && !!v.categories,
                x = e.tooltipPoints,
                k = m.turboThreshold,
                t = this.xData,
                l = this.yData,
                A = (h = e.pointArrayMap) && h.length;
            a = a || [];
            h = a.length;
            b = p(b, !0);
            if (!1 === d || !h || g !== h || e.cropped || e.hasGroupedData) {
                e.xIncrement = null;
                e.pointRange = z ? 1 : m.pointRange;
                e.colorCounter = 0;
                D(this.parallelArrays, function (a) {
                    e[a + "Data"].length = 0
                });
                if (k && h > k) {
                    for (c = 0; null === r && c < h;) r = a[c], c++;
                    if (aa(r)) {
                        z = p(m.pointStart, 0);
                        m = p(m.pointInterval, 1);
                        for (c = 0; c < h; c++) t[c] = z, l[c] = a[c], z += m;
                        e.xIncrement = z
                    } else if (S(r))
                        if (A)
                            for (c = 0; c < h; c++) m = a[c], t[c] = m[0], l[c] = m.slice(1, A + 1);
                        else
                            for (c = 0; c < h; c++) m = a[c], t[c] = m[0], l[c] = m[1];
                    else Aa(12)
                } else
                    for (c = 0; c < h; c++) a[c] !== G && (m = {
                        series: e
                    }, e.pointClass.prototype.applyOptions.apply(m, [a[c]]), e.updateParallelArrays(m, c), z && m.name && (v.names[m.x] = m.name));
                Y(l[0]) && Aa(14, !0);
                e.data = [];
                e.options.data = a;
                for (c = g; c--;) f[c] && f[c].destroy && f[c].destroy();
                x && (x.length = 0);
                v && (v.minRange = v.userMinRange);
                e.isDirty = e.isDirtyData = q.isDirtyBox = !0;
                c = !1
            } else D(a, function (a, b) {
                f[b].update(a, !1, null, !1)
            });
            b && q.redraw(c)
        },
        processData: function (a) {
            var b = this.xData,
                c = this.yData,
                d = b.length,
                e;
            e = 0;
            var f, g, h = this.xAxis,
                m, q = this.options;
            m = q.cropThreshold;
            var r = 0,
                v = this.isCartesian,
                z, x;
            if (v && !this.isDirty && !h.isDirty && !this.yAxis.isDirty && !a) return !1;
            h && (z = h.getExtremes(), x = z.min, z = z.max);
            if (v && this.sorted && (!m || d > m || this.forceCrop))
                if (b[d - 1] < x || b[0] > z) b = [], c = [];
                else if (b[0] < x || b[d - 1] > z) e = this.cropData(this.xData, this.yData, x, z), b = e.xData, c = e.yData, e = e.start, f = !0, r = b.length;
            for (m = b.length - 1; 0 <= m; m--) d = b[m] - b[m - 1], !f && b[m] > x && b[m] < z && r++, 0 < d && (g === G || d < g) ? g = d : 0 > d && this.requireSorting && Aa(15);
            this.cropped = f;
            this.cropStart = e;
            this.processedXData = b;
            this.processedYData = c;
            this.activePointCount = r;
            null === q.pointRange && (this.pointRange = g || 1);
            this.closestPointRange = g
        },
        cropData: function (a, b, c, d) {
            var e = a.length,
                f = 0,
                g = e,
                h = p(this.cropShoulder, 1),
                m;
            for (m = 0; m < e; m++)
                if (a[m] >= c) {
                    f = N(0, m - h);
                    break
                }
            for (; m < e; m++)
                if (a[m] > d) {
                    g = m + h;
                    break
                }
            return {
                xData: a.slice(f, g),
                yData: b.slice(f, g),
                start: f,
                end: g
            }
        },
        generatePoints: function () {
            var a = this.options.data,
                b = this.data,
                c, d = this.processedXData,
                e = this.processedYData,
                f = this.pointClass,
                g = d.length,
                h = this.cropStart || 0,
                m, q = this.hasGroupedData,
                r, v = [],
                z;
            b || q || (b = [], b.length = a.length, b = this.data = b);
            for (z = 0; z < g; z++) m = h + z, q ? v[z] = (new f).init(this, [d[z]].concat(w(e[z]))) : (b[m] ? r = b[m] : a[m] !== G && (b[m] = r = (new f).init(this, a[m], d[z])), v[z] = r), v[z].index = m;
            if (b && (g !== (c = b.length) || q))
                for (z = 0; z < c; z++) z !== h || q || (z += g), b[z] && (b[z].destroyElements(), b[z].plotX = G);
            this.data = b;
            this.points = v
        },
        getExtremes: function (a) {
            var b = this.yAxis,
                c = this.processedXData,
                d, e = [],
                f = 0;
            d = this.xAxis.getExtremes();
            var g = d.min,
                h = d.max,
                m, q, r, v;
            a = a || this.stackedYData || this.processedYData;
            d = a.length;
            for (v = 0; v < d; v++)
                if (q = c[v], r = a[v], m = null !== r && r !== G && (!b.isLog || r.length || 0 < r), q = this.getExtremesFromAll || this.cropped || (c[v + 1] || q) >= g && (c[v - 1] || q) <= h, m && q)
                    if (m = r.length)
                        for (; m--;) null !== r[m] && (e[f++] = r[m]);
                    else e[f++] = r;
            this.dataMin = p(void 0, ea(e));
            this.dataMax = p(void 0, Ia(e))
        },
        translate: function () {
            this.processedXData || this.processData();
            this.generatePoints();
            for (var a = this.options, b = a.stacking, c = this.xAxis, d = c.categories, e = this.yAxis, f = this.points, g = f.length, h = !!this.modifyValue, m = a.pointPlacement, q = "between" === m || aa(m), r = a.threshold, a = 0; a < g; a++) {
                var v = f[a],
                    z = v.x,
                    x = v.y,
                    k = v.low,
                    t = b && e.stacks[(this.negStacks && x < r ? "-" : "") + this.stackKey];
                e.isLog && 0 >= x && (v.y = x = null, Aa(10));
                v.plotX = c.translate(z, 0, 0, 0, 1, m, "flags" === this.type);
                b && this.visible && t && t[z] && (t = t[z], x = t.points[this.index + "," + a], k = x[0], x = x[1], 0 === k && (k = p(r, e.min)), e.isLog && 0 >= k && (k = null), v.total = v.stackTotal = t.total, v.percentage = t.total && v.y / t.total * 100, v.stackY = x, t.setOffset(this.pointXOffset || 0, this.barW || 0));
                v.yBottom = u(k) ? e.translate(k, 0, 1, 0, 1) : null;
                h && (x = this.modifyValue(x, v));
                v.plotY = "number" === typeof x && Infinity !== x ? e.translate(x, 0, 1, 0, 1) : G;
                v.clientX = q ? c.translate(z, 0, 0, 0, 1) : v.plotX;
                v.negative = v.y < (r || 0);
                v.category = d && d[v.x] !== G ? d[v.x] : v.x
            }
            this.getSegments()
        },
        animate: function (a) {
            var b = this.chart,
                c = b.renderer,
                d;
            d = this.options.animation;
            var e = this.clipBox || b.clipBox,
                f = b.inverted,
                g;
            d && !Q(d) && (d = X[this.type].animation);
            g = ["_sharedClip", d.duration, d.easing, e.height].join();
            a ? (a = b[g], d = b[g + "m"], a || (b[g] = a = c.clipRect(n(e, {
                width: 0
            })), b[g + "m"] = d = c.clipRect(-99, f ? -b.plotLeft : -b.plotTop, 99, f ? b.chartWidth : b.chartHeight)), this.group.clip(a), this.markerGroup.clip(d), this.sharedClipKey = g) : ((a = b[g]) && a.animate({
                width: b.plotSizeX
            }, d), b[g + "m"] && b[g + "m"].animate({
                width: b.plotSizeX + 99
            }, d), this.animate = null)
        },
        afterAnimate: function () {
            var a = this.chart,
                b = this.sharedClipKey,
                c = this.group,
                d = this.clipBox;
            c && !1 !== this.options.clip && (b && d || c.clip(d ? a.renderer.clipRect(d) : a.clipRect), this.markerGroup.clip());
            ja(this, "afterAnimate");
            setTimeout(function () {
                b && a[b] && (d || (a[b] = a[b].destroy()), a[b + "m"] && (a[b + "m"] = a[b + "m"].destroy()))
            }, 100)
        },
        drawPoints: function () {
            var a, b = this.points,
                c = this.chart,
                d, e, f, g, h, m, q, r, v = this.options.marker,
                z = this.pointAttr[""],
                x, k, t, l = this.markerGroup,
                A = p(v.enabled, !this.requireSorting || this.activePointCount < .5 * this.xAxis.len / v.radius);
            if (!1 !== v.enabled || this._hasPointMarkers)
                for (f = b.length; f--;) g = b[f], d = fa(g.plotX),
                    e = g.plotY, r = g.graphic, x = g.marker || {}, k = !!g.marker, a = A && x.enabled === G || x.enabled, t = c.isInsidePlot(L(d), e, c.inverted), a && e !== G && !isNaN(e) && null !== g.y ? (a = g.pointAttr[g.selected ? "select" : ""] || z, h = a.r, m = p(x.symbol, this.symbol), q = 0 === m.indexOf("url"), r ? r[t ? "show" : "hide"](!0).animate(n({
                    x: d - h,
                    y: e - h
                }, r.symbolName ? {
                    width: 2 * h,
                    height: 2 * h
                } : {})) : t && (0 < h || q) && (g.graphic = c.renderer.symbol(m, d - h, e - h, 2 * h, 2 * h, k ? x : v).attr(a).add(l))) : r && (g.graphic = r.destroy())
        },
        convertAttribs: function (a, b, c, d) {
            var e = this.pointAttrToOptions,
                f, g, h = {};
            a = a || {};
            b = b || {};
            c = c || {};
            d = d || {};
            for (f in e) g = e[f], h[f] = p(a[g], b[f], c[f], d[f]);
            return h
        },
        getAttribs: function () {
            var a = this,
                b = a.options,
                c = X[a.type].marker ? b.marker : b,
                d = c.states,
                e = d.hover,
                f, g = a.color;
            f = {
                stroke: g,
                fill: g
            };
            var h = a.points || [],
                m, q = [],
                r, v = a.pointAttrToOptions;
            r = a.hasPointSpecificOptions;
            var z = b.negativeColor,
                x = c.lineColor,
                k = c.fillColor;
            m = b.turboThreshold;
            var p;
            b.marker ? (e.radius = e.radius || c.radius + e.radiusPlus, e.lineWidth = e.lineWidth || c.lineWidth + e.lineWidthPlus) : e.color = e.color || Ja(e.color || g).brighten(e.brightness).get();
            q[""] = a.convertAttribs(c, f);
            D(["hover", "select"], function (b) {
                q[b] = a.convertAttribs(d[b], q[""])
            });
            a.pointAttr = q;
            g = h.length;
            if (!m || g < m || r)
                for (; g--;) {
                    m = h[g];
                    (c = m.options && m.options.marker || m.options) && !1 === c.enabled && (c.radius = 0);
                    m.negative && z && (m.color = m.fillColor = z);
                    r = b.colorByPoint || m.color;
                    if (m.options)
                        for (p in v) u(c[v[p]]) && (r = !0);
                    r ? (c = c || {}, r = [], d = c.states || {}, f = d.hover = d.hover || {}, b.marker || (f.color = f.color || !m.options.color && e.color || Ja(m.color).brighten(f.brightness || e.brightness).get()), f = {
                        color: m.color
                    }, k || (f.fillColor = m.color), x || (f.lineColor = m.color), r[""] = a.convertAttribs(n(f, c), q[""]), r.hover = a.convertAttribs(d.hover, q.hover, r[""]), r.select = a.convertAttribs(d.select, q.select, r[""])) : r = q;
                    m.pointAttr = r
                }
        },
        destroy: function () {
            var a = this,
                b = a.chart,
                c = /AppleWebKit\/533/.test(Ma),
                d, e, f = a.data || [],
                g, h, m;
            ja(a, "destroy");
            pa(a);
            D(a.axisTypes || [], function (b) {
                if (m = a[b]) y(m.series, a), m.isDirty = m.forceRedraw = !0
            });
            a.legendItem && a.chart.legend.destroyItem(a);
            for (e = f.length; e--;)(g = f[e]) && g.destroy && g.destroy();
            a.points = null;
            clearTimeout(a.animationTimeout);
            D("area graph dataLabelsGroup group markerGroup tracker graphNeg areaNeg posClip negClip".split(" "), function (b) {
                a[b] && (d = c && "group" === b ? "hide" : "destroy", a[b][d]())
            });
            b.hoverSeries === a && (b.hoverSeries = null);
            y(b.series, a);
            for (h in a) delete a[h]
        },
        getSegmentPath: function (a) {
            var b = this,
                c = [],
                d = b.options.step;
            D(a, function (e, f) {
                var g = e.plotX,
                    h = e.plotY,
                    m;
                b.getPointSpline ? c.push.apply(c, b.getPointSpline(a, e, f)) : (c.push(f ? "L" : "M"), d && f && (m = a[f - 1], "right" === d ? c.push(m.plotX, h) : "center" === d ? c.push((m.plotX + g) / 2, m.plotY, (m.plotX + g) / 2, h) : c.push(g, m.plotY)), c.push(e.plotX, e.plotY))
            });
            return c
        },
        getGraphPath: function () {
            var a = this,
                b = [],
                c, d = [];
            D(a.segments, function (e) {
                c = a.getSegmentPath(e);
                1 < e.length ? b = b.concat(c) : d.push(e[0])
            });
            a.singlePoints = d;
            return a.graphPath = b
        },
        drawGraph: function () {
            var a = this,
                b = this.options,
                c = [
                    ["graph", b.lineColor || this.color]
                ],
                d = b.lineWidth,
                e = b.dashStyle,
                f = "square" !== b.linecap,
                g = this.getGraphPath(),
                h = b.negativeColor;
            h && c.push(["graphNeg", h]);
            D(c, function (c, h) {
                var r = c[0],
                    v = a[r];
                v ? (gb(v), v.animate({
                    d: g
                })) : d && g.length && (v = {
                    stroke: c[1],
                    "stroke-width": d,
                    fill: "none",
                    zIndex: 1
                }, e ? v.dashstyle = e : f && (v["stroke-linecap"] = v["stroke-linejoin"] = "round"), a[r] = a.chart.renderer.path(g).attr(v).add(a.group).shadow(!h && b.shadow))
            })
        },
        clipNeg: function () {
            var a = this.options,
                b = this.chart,
                c = b.renderer,
                d = a.negativeColor || a.negativeFillColor,
                e, f = this.graph,
                g = this.area,
                h = this.posClip,
                m = this.negClip;
            e = b.chartWidth;
            var q = b.chartHeight,
                r = N(e, q),
                v = this.yAxis;
            d && (f || g) && (d = L(v.toPixels(a.threshold || 0, !0)), 0 > d && (r -= d), a = {
                x: 0,
                y: 0,
                width: r,
                height: d
            }, r = {
                x: 0,
                y: d,
                width: r,
                height: r
            }, b.inverted && (a.height = r.y = b.plotWidth - d, c.isVML && (a = {
                x: b.plotWidth - d - b.plotLeft,
                y: 0,
                width: e,
                height: q
            }, r = {
                x: d + b.plotLeft - e,
                y: 0,
                width: b.plotLeft + d,
                height: e
            })), v.reversed ? (b = r, e = a) : (b = a, e = r), h ? (h.animate(b), m.animate(e)) : (this.posClip = h = c.clipRect(b), this.negClip = m = c.clipRect(e), f && this.graphNeg && (f.clip(h), this.graphNeg.clip(m)), g && (g.clip(h), this.areaNeg.clip(m))))
        },
        invertGroups: function () {
            function a() {
                var a = {
                    width: b.yAxis.len,
                    height: b.xAxis.len
                };
                D(["group", "markerGroup"], function (c) {
                    b[c] && b[c].attr(a).invert()
                })
            }

            var b = this,
                c = b.chart;
            b.xAxis && (W(c, "resize", a), W(b, "destroy", function () {
                pa(c, "resize", a)
            }), a(), b.invertGroups = a)
        },
        plotGroup: function (a, b, c, d, e) {
            var f = this[a],
                g = !f;
            g && (this[a] = f = this.chart.renderer.g(b).attr({
                visibility: c,
                zIndex: d || .1
            }).add(e));
            f[g ? "attr" : "animate"](this.getPlotBox());
            return f
        },
        getPlotBox: function () {
            var a = this.chart,
                b = this.xAxis,
                c = this.yAxis;
            a.inverted && (b = c, c = this.xAxis);
            return {
                translateX: b ? b.left : a.plotLeft,
                translateY: c ? c.top : a.plotTop,
                scaleX: 1,
                scaleY: 1
            }
        },
        render: function () {
            var a = this,
                b = a.chart,
                c, d = a.options,
                e = (c = d.animation) && !!a.animate && b.renderer.isSVG && p(c.duration, 500) || 0,
                f = a.visible ? "visible" : "hidden",
                g = d.zIndex,
                h = a.hasRendered,
                m = b.seriesGroup;
            c = a.plotGroup("group", "series", f, g, m);
            a.markerGroup = a.plotGroup("markerGroup", "markers", f, g, m);
            e && a.animate(!0);
            a.getAttribs();
            c.inverted = a.isCartesian ? b.inverted : !1;
            a.drawGraph && (a.drawGraph(), a.clipNeg());
            D(a.points, function (a) {
                a.redraw && a.redraw()
            });
            a.drawDataLabels && a.drawDataLabels();
            a.visible && a.drawPoints();
            a.drawTracker && !1 !== a.options.enableMouseTracking && a.drawTracker();
            b.inverted && a.invertGroups();
            !1 === d.clip || a.sharedClipKey || h || c.clip(b.clipRect);
            e && a.animate();
            h || (e ? a.animationTimeout = setTimeout(function () {
                a.afterAnimate()
            }, e) : a.afterAnimate());
            a.isDirty = a.isDirtyData = !1;
            a.hasRendered = !0
        },
        redraw: function () {
            var a = this.chart,
                b = this.isDirtyData,
                c = this.group,
                d = this.xAxis,
                e = this.yAxis;
            c && (a.inverted && c.attr({
                width: a.plotWidth,
                height: a.plotHeight
            }), c.animate({
                translateX: p(d && d.left, a.plotLeft),
                translateY: p(e && e.top, a.plotTop)
            }));
            this.translate();
            this.setTooltipPoints && this.setTooltipPoints(!0);
            this.render();
            b && ja(this, "updatedData")
        }
    };
    Xa.prototype = {
        destroy: function () {
            ca(this, this.axis)
        },
        render: function (a) {
            var b = this.options,
                c = b.format,
                c = c ? t(c, this) : b.formatter.call(this);
            this.label ? this.label.attr({
                text: c,
                visibility: "hidden"
            }) : this.label = this.axis.chart.renderer.text(c, null, null, b.useHTML).css(b.style).attr({
                align: this.textAlign,
                rotation: b.rotation,
                visibility: "hidden"
            }).add(a)
        },
        setOffset: function (a, b) {
            var c = this.axis,
                d = c.chart,
                e = d.inverted,
                f = this.isNegative,
                g = c.translate(c.usePercentage ? 100 : this.total, 0, 0, 0, 1),
                c = c.translate(0),
                c = ka(g - c),
                h = d.xAxis[0].translate(this.x) + a,
                m = d.plotHeight,
                f = {
                    x: e ? f ? g : g - c : h,
                    y: e ? m - h - b : f ? m - g - c : m - g,
                    width: e ? c : b,
                    height: e ? b : c
                };
            if (e = this.label) e.align(this.alignOptions, null, f), f = e.alignAttr, e[!1 === this.options.crop || d.isInsidePlot(f.x, f.y) ? "show" : "hide"](!0)
        }
    };
    T.prototype.buildStacks = function () {
        var a = this.series,
            b = p(this.options.reversedStacks, !0),
            c = a.length;
        if (!this.isXAxis) {
            for (this.usePercentage = !1; c--;) a[b ? c : a.length - c - 1].setStackedPoints();
            if (this.usePercentage)
                for (c = 0; c < a.length; c++) a[c].setPercentStacks()
        }
    };
    T.prototype.renderStackTotals = function () {
        var a = this.chart,
            b = a.renderer,
            c = this.stacks,
            d, e, f = this.stackTotalGroup;
        f || (this.stackTotalGroup = f = b.g("stack-labels").attr({
            visibility: "visible",
            zIndex: 6
        }).add());
        f.translate(a.plotLeft, a.plotTop);
        for (d in c)
            for (e in a = c[d], a) a[e].render(f)
    };
    V.prototype.setStackedPoints = function () {
        if (this.options.stacking && (!0 === this.visible || !1 === this.chart.options.chart.ignoreHiddenSeries)) {
            var a = this.processedXData,
                b = this.processedYData,
                c = [],
                d = b.length,
                e = this.options,
                f = e.threshold,
                g = e.stack,
                e = e.stacking,
                h = this.stackKey,
                m = "-" + h,
                q = this.negStacks,
                r = this.yAxis,
                v = r.stacks,
                z = r.oldStacks,
                x, k, p, t, l, A;
            for (t = 0; t < d; t++) l = a[t], A = b[t], p = this.index + "," + t, k = (x = q && A < f) ? m : h, v[k] || (v[k] = {}), v[k][l] || (z[k] && z[k][l] ? (v[k][l] = z[k][l], v[k][l].total = null) : v[k][l] = new Xa(r, r.options.stackLabels, x, l, g)), k = v[k][l], k.points[p] = [k.cum || 0], "percent" === e ? (x = x ? h : m, q && v[x] && v[x][l] ? (x = v[x][l], k.total = x.total = N(x.total, k.total) + ka(A) || 0) : k.total = qa(k.total + (ka(A) || 0))) : k.total = qa(k.total + (A || 0)), k.cum = (k.cum || 0) + (A || 0), k.points[p].push(k.cum), c[t] = k.cum;
            "percent" === e && (r.usePercentage = !0);
            this.stackedYData = c;
            r.oldStacks = {}
        }
    };
    V.prototype.setPercentStacks = function () {
        var a = this,
            b = a.stackKey,
            c = a.yAxis.stacks,
            d = a.processedXData;
        D([b, "-" + b], function (b) {
            for (var f = d.length, g, h; f--;)
                if (g = d[f], g = (h = c[b] && c[b][g]) && h.points[a.index + "," + f]) h = h.total ? 100 / h.total : 0, g[0] = qa(g[0] * h), g[1] = qa(g[1] * h), a.stackedYData[f] = g[1]
        })
    };
    n(na.prototype, {
        addSeries: function (a, b, c) {
            var d, e = this;
            a && (b = p(b, !0), ja(e, "addSeries", {
                options: a
            }, function () {
                d = e.initSeries(a);
                e.isDirtyLegend = !0;
                e.linkSeries();
                b && e.redraw(c)
            }));
            return d
        },
        addAxis: function (a, b, c, d) {
            var e = b ? "xAxis" : "yAxis",
                f = this.options;
            new T(this, E(a, {
                index: this[e].length,
                isX: b
            }));
            f[e] = w(f[e] || {});
            f[e].push(a);
            p(c, !0) && this.redraw(d)
        },
        showLoading: function (a) {
            var b = this,
                c = b.options,
                d = b.loadingDiv,
                e = c.loading,
                f = function () {
                    d && I(d, {
                        left: b.plotLeft + "px",
                        top: b.plotTop + "px",
                        width: b.plotWidth + "px",
                        height: b.plotHeight + "px"
                    })
                };
            d || (b.loadingDiv = d = K("div", {
                className: "highcharts-loading"
            }, n(e.style, {
                zIndex: 10,
                display: "none"
            }), b.container), b.loadingSpan = K("span", null, e.labelStyle, d), W(b, "redraw", f));
            b.loadingSpan.innerHTML = a || c.lang.loading;
            b.loadingShown || (I(d, {
                opacity: 0,
                display: ""
            }), sb(d, {
                opacity: e.style.opacity
            }, {
                duration: e.showDuration || 0
            }), b.loadingShown = !0);
            f()
        },
        hideLoading: function () {
            var a = this.options,
                b = this.loadingDiv;
            b && sb(b, {
                opacity: 0
            }, {
                duration: a.loading.hideDuration || 100,
                complete: function () {
                    I(b, {
                        display: "none"
                    })
                }
            });
            this.loadingShown = !1
        }
    });
    n(Da.prototype, {
        update: function (a, b, c, d) {
            function e() {
                f.applyOptions(a);
                Q(a) && !S(a) && (f.redraw = function () {
                    h && (a && a.marker && a.marker.symbol ? f.graphic = h.destroy() : h.attr(f.pointAttr[f.state || ""]));
                    a && a.dataLabels && f.dataLabel && (f.dataLabel = f.dataLabel.destroy());
                    f.redraw = null
                });
                m = f.index;
                g.updateParallelArrays(f, m);
                r.data[m] = f.options;
                g.isDirty = g.isDirtyData = !0;
                !g.fixedBox && g.hasCartesianSeries && (q.isDirtyBox = !0);
                "point" === r.legendType && q.legend.destroyItem(f);
                b && q.redraw(c)
            }

            var f = this,
                g = f.series,
                h = f.graphic,
                m, q = g.chart,
                r = g.options;
            b = p(b, !0);
            !1 === d ? e() : f.firePointEvent("update", {
                options: a
            }, e)
        },
        remove: function (a, b) {
            var c = this,
                d = c.series,
                e = d.points,
                f = d.chart,
                g, h = d.data;
            ta(b, f);
            a = p(a, !0);
            c.firePointEvent("remove", null, function () {
                g = Ra(c, h);
                h.length === e.length && e.splice(g, 1);
                h.splice(g, 1);
                d.options.data.splice(g, 1);
                d.updateParallelArrays(c, "splice", g, 1);
                c.destroy();
                d.isDirty = !0;
                d.isDirtyData = !0;
                a && f.redraw()
            })
        }
    });
    n(V.prototype, {
        addPoint: function (a, b, c, d) {
            var e = this.options,
                f = this.data,
                g = this.graph,
                h = this.area,
                m = this.chart,
                q = this.xAxis && this.xAxis.names,
                r = g && g.shift || 0,
                v = e.data,
                z, k = this.xData;
            ta(d, m);
            c && D([g, h, this.graphNeg, this.areaNeg], function (a) {
                a && (a.shift = r + 1)
            });
            h && (h.isArea = !0);
            b = p(b, !0);
            d = {
                series: this
            };
            this.pointClass.prototype.applyOptions.apply(d, [a]);
            g = d.x;
            h = k.length;
            if (this.requireSorting && g < k[h - 1])
                for (z = !0; h && k[h - 1] > g;) h--;
            this.updateParallelArrays(d, "splice", h, 0, 0);
            this.updateParallelArrays(d, h);
            q && d.name && (q[g] = d.name);
            v.splice(h, 0, a);
            z && (this.data.splice(h, 0, null), this.processData());
            "point" === e.legendType && this.generatePoints();
            c && (f[0] && f[0].remove ? f[0].remove(!1) : (f.shift(), this.updateParallelArrays(d, "shift"), v.shift()));
            this.isDirtyData = this.isDirty = !0;
            b && (this.getAttribs(), m.redraw())
        },
        remove: function (a, b) {
            var c = this,
                d = c.chart;
            a = p(a, !0);
            c.isRemoving || (c.isRemoving = !0, ja(c, "remove", null, function () {
                c.destroy();
                d.isDirtyLegend = d.isDirtyBox = !0;
                d.linkSeries();
                a && d.redraw(b)
            }));
            c.isRemoving = !1
        },
        update: function (a, b) {
            var c = this,
                d = this.chart,
                e = this.userOptions,
                f = this.type,
                g = P[f].prototype,
                h = ["group", "markerGroup", "dataLabelsGroup"],
                m;
            D(h, function (a) {
                h[a] = c[a];
                delete c[a]
            });
            a = E(e, {
                animation: !1,
                index: this.index,
                pointStart: this.xData[0]
            }, {
                data: this.options.data
            }, a);
            this.remove(!1);
            for (m in g) g.hasOwnProperty(m) && (this[m] = G);
            n(this, P[a.type || f].prototype);
            D(h, function (a) {
                c[a] = h[a]
            });
            this.init(d, a);
            d.linkSeries();
            p(b, !0) && d.redraw(!1)
        }
    });
    n(T.prototype, {
        update: function (a, b) {
            var c = this.chart;
            a = c.options[this.coll][this.options.index] = E(this.userOptions, a);
            this.destroy(!0);
            this._addedPlotLB = G;
            this.init(c, n(a, {
                events: G
            }));
            c.isDirtyBox = !0;
            p(b, !0) && c.redraw()
        },
        remove: function (a) {
            for (var b = this.chart, c = this.coll, d = this.series, e = d.length; e--;) d[e] && d[e].remove(!1);
            y(b.axes, this);
            y(b[c], this);
            b.options[c].splice(this.options.index, 1);
            D(b[c], function (a, b) {
                a.options.index = b
            });
            this.destroy();
            b.isDirtyBox = !0;
            p(a, !0) && b.redraw()
        },
        setTitle: function (a, b) {
            this.update({
                title: a
            }, b)
        },
        setCategories: function (a, b) {
            this.update({
                categories: a
            }, b)
        }
    });
    var rc = M(V);
    P.line = rc;
    X.area = E(hb, {
        threshold: 0
    });
    var $b = M(V, {
        type: "area",
        getSegments: function () {
            var a = this,
                b = [],
                c = [],
                d = [],
                e = this.xAxis,
                f = this.yAxis,
                g = f.stacks[this.stackKey],
                h = {}, m, q, r = this.points,
                v = this.options.connectNulls,
                z, k;
            if (this.options.stacking && !this.cropped) {
                for (z = 0; z < r.length; z++) h[r[z].x] = r[z];
                for (k in g) null !== g[k].total && d.push(+k);
                d.sort(function (a, b) {
                    return a - b
                });
                D(d, function (b) {
                    var d = 0,
                        r;
                    if (!v || h[b] && null !== h[b].y)
                        if (h[b]) c.push(h[b]);
                        else {
                            for (z = a.index; z <= f.series.length; z++)
                                if (r = g[b].points[z + "," + b]) {
                                    d = r[1];
                                    break
                                }
                            m = e.translate(b);
                            q = f.toPixels(d, !0);
                            c.push({
                                y: null,
                                plotX: m,
                                clientX: m,
                                plotY: q,
                                yBottom: q,
                                onMouseOver: ma
                            })
                        }
                });
                c.length && b.push(c)
            } else V.prototype.getSegments.call(this), b = this.segments;
            this.segments = b
        },
        getSegmentPath: function (a) {
            var b = V.prototype.getSegmentPath.call(this, a),
                c = [].concat(b),
                d, e = this.options;
            d = b.length;
            var f = this.yAxis.getThreshold(e.threshold),
                g;
            3 === d && c.push("L", b[1], b[2]);
            if (e.stacking && !this.closedStacks)
                for (d = a.length - 1; 0 <= d; d--) g = p(a[d].yBottom, f), d < a.length - 1 && e.step && c.push(a[d + 1].plotX, g), c.push(a[d].plotX, g);
            else this.closeSegment(c, a, f);
            this.areaPath = this.areaPath.concat(c);
            return b
        },
        closeSegment: function (a, b, c) {
            a.push("L", b[b.length - 1].plotX, c, "L", b[0].plotX, c)
        },
        drawGraph: function () {
            this.areaPath = [];
            V.prototype.drawGraph.apply(this);
            var a = this,
                b = this.areaPath,
                c = this.options,
                d = c.negativeColor,
                e = c.negativeFillColor,
                f = [
                    ["area", this.color, c.fillColor]
                ];
            (d || e) && f.push(["areaNeg", d, e]);
            D(f, function (d) {
                var e = d[0],
                    f = a[e];
                f ? f.animate({
                    d: b
                }) : a[e] = a.chart.renderer.path(b).attr({
                    fill: p(d[2], Ja(d[1]).setOpacity(p(c.fillOpacity, .75)).get()),
                    zIndex: 0
                }).add(a.group)
            })
        },
        drawLegendSymbol: jb.drawRectangle
    });
    P.area = $b;
    X.spline = E(hb);
    var ac = M(V, {
        type: "spline",
        getPointSpline: function (a, b, c) {
            var d = b.plotX,
                e = b.plotY,
                f = a[c - 1],
                g = a[c + 1],
                h, m, q, r;
            if (f && g) {
                a = f.plotY;
                q = g.plotX;
                var g = g.plotY,
                    v;
                h = (1.5 * d + f.plotX) / 2.5;
                m = (1.5 * e + a) / 2.5;
                q = (1.5 * d + q) / 2.5;
                r = (1.5 * e + g) / 2.5;
                v = (r - m) * (q - d) / (q - h) + e - r;
                m += v;
                r += v;
                m > a && m > e ? (m = N(a, e), r = 2 * e - m) : m < a && m < e && (m = U(a, e), r = 2 * e - m);
                r > g && r > e ? (r = N(g, e), m = 2 * e - r) : r < g && r < e && (r = U(g, e), m = 2 * e - r);
                b.rightContX = q;
                b.rightContY = r
            }
            c ? (b = ["C", f.rightContX || f.plotX, f.rightContY || f.plotY, h || d, m || e, d, e], f.rightContX = f.rightContY = null) : b = ["M", d, e];
            return b
        }
    });
    P.spline = ac;
    X.areaspline = E(X.area);
    var Kb = $b.prototype,
        sc = M(ac, {
            type: "areaspline",
            closedStacks: !0,
            getSegmentPath: Kb.getSegmentPath,
            closeSegment: Kb.closeSegment,
            drawGraph: Kb.drawGraph,
            drawLegendSymbol: jb.drawRectangle
        });
    P.areaspline = sc;
    X.column = E(hb, {
        borderColor: "#FFFFFF",
        borderRadius: 0,
        groupPadding: .2,
        marker: null,
        pointPadding: .1,
        minPointLength: 0,
        cropThreshold: 50,
        pointRange: null,
        states: {
            hover: {
                brightness: .1,
                shadow: !1,
                halo: !1
            },
            select: {
                color: "#C0C0C0",
                borderColor: "#000000",
                shadow: !1
            }
        },
        dataLabels: {
            align: null,
            verticalAlign: null,
            y: null
        },
        stickyTracking: !1,
        tooltip: {
            distance: 6
        },
        threshold: 0
    });
    var Lb = M(V, {
        type: "column",
        pointAttrToOptions: {
            stroke: "borderColor",
            fill: "color",
            r: "borderRadius"
        },
        cropShoulder: 0,
        trackerGroups: ["group", "dataLabelsGroup"],
        negStacks: !0,
        init: function () {
            V.prototype.init.apply(this, arguments);
            var a = this,
                b = a.chart;
            b.hasRendered && D(b.series, function (b) {
                b.type === a.type && (b.isDirty = !0)
            })
        },
        getColumnMetrics: function () {
            var a = this,
                b = a.options,
                c = a.xAxis,
                d = a.yAxis,
                e = c.reversed,
                f, g = {}, h, m = 0;
            !1 === b.grouping ? m = 1 : D(a.chart.series, function (b) {
                var c = b.options,
                    e = b.yAxis;
                b.type === a.type && b.visible && d.len === e.len && d.pos === e.pos && (c.stacking ? (f = b.stackKey, g[f] === G && (g[f] = m++), h = g[f]) : !1 !== c.grouping && (h = m++), b.columnIndex = h)
            });
            var c = U(ka(c.transA) * (c.ordinalSlope || b.pointRange || c.closestPointRange || c.tickInterval || 1), c.len),
                q = c * b.groupPadding,
                r = (c - 2 * q) / m,
                v = b.pointWidth,
                b = u(v) ? (r - v) / 2 : r * b.pointPadding,
                v = p(v, r - 2 * b);
            return a.columnMetrics = {
                width: v,
                offset: b + (q + ((e ? m - (a.columnIndex || 0) : a.columnIndex) || 0) * r - c / 2) * (e ? -1 : 1)
            }
        },
        translate: function () {
            var a = this,
                b = a.chart,
                c = a.options,
                d = a.borderWidth = p(c.borderWidth, a.activePointCount > .5 * a.xAxis.len ? 0 : 1),
                e = a.yAxis,
                f = a.translatedThreshold = e.getThreshold(c.threshold),
                g = p(c.minPointLength, 5),
                h = a.getColumnMetrics(),
                m = h.width,
                q = a.barW = N(m, 1 + 2 * d),
                r = a.pointXOffset = h.offset,
                v = -(d % 2 ? .5 : 0),
                z = d % 2 ? .5 : 1;
            b.renderer.isVML && b.inverted && (z += 1);
            c.pointPadding && (q = Ya(q));
            V.prototype.translate.apply(a);
            D(a.points, function (c) {
                var d = p(c.yBottom, f),
                    h = U(N(-999 - d, c.plotY), e.len + 999 + d),
                    k = c.plotX + r,
                    t = q,
                    l = U(h, d),
                    A;
                A = N(h, d) - l;
                ka(A) < g && g && (A = g, l = L(ka(l - f) > g ? d - g : f - (e.translate(c.y, 0, 1, 0, 1) <= f ? g : 0)));
                c.barX = k;
                c.pointWidth = m;
                c.tooltipPos = b.inverted ? [e.len - h, a.xAxis.len - k - t / 2] : [k + t / 2, h + e.pos - b.plotTop];
                t = L(k + t) + v;
                k = L(k) + v;
                t -= k;
                d = .5 > ka(l);
                A = L(l + A) + z;
                l = L(l) + z;
                A -= l;
                d && (--l, A += 1);
                c.shapeType = "rect";
                c.shapeArgs = {
                    x: k,
                    y: l,
                    width: t,
                    height: A
                }
            })
        },
        getSymbol: ma,
        drawLegendSymbol: jb.drawRectangle,
        drawGraph: ma,
        drawPoints: function () {
            var a = this,
                b = this.chart,
                c = a.options,
                d = b.renderer,
                e = c.animationLimit || 250,
                f, g;
            D(a.points, function (h) {
                var m = h.plotY,
                    q = h.graphic;
                m === G || isNaN(m) || null === h.y ? q && (h.graphic = q.destroy()) : (f = h.shapeArgs, m = u(a.borderWidth) ? {
                    "stroke-width": a.borderWidth
                } : {}, g = h.pointAttr[h.selected ? "select" : ""] || a.pointAttr[""], q ? (gb(q), q.attr(m)[b.pointCount < e ? "animate" : "attr"](E(f))) : h.graphic = d[h.shapeType](f).attr(g).attr(m).add(a.group).shadow(c.shadow, null, c.stacking && !c.borderRadius))
            })
        },
        animate: function (a) {
            var b = this.yAxis,
                c = this.options,
                d = this.chart.inverted,
                e = {};
            wa && (a ? (e.scaleY = .001, a = U(b.pos + b.len, N(b.pos, b.toPixels(c.threshold))), d ? e.translateX = a - b.len : e.translateY = a, this.group.attr(e)) : (e.scaleY = 1, e[d ? "translateX" : "translateY"] = b.pos, this.group.animate(e, this.options.animation), this.animate = null))
        },
        remove: function () {
            var a = this,
                b = a.chart;
            b.hasRendered && D(b.series, function (b) {
                b.type === a.type && (b.isDirty = !0)
            });
            V.prototype.remove.apply(a, arguments)
        }
    });
    P.column = Lb;
    X.bar = E(X.column);
    var tc = M(Lb, {
        type: "bar",
        inverted: !0
    });
    P.bar = tc;
    X.scatter = E(hb, {
        lineWidth: 0,
        tooltip: {
            headerFormat: '<span style="color:{series.color}">\u25cf</span> <span style="font-size: 10px;"> {series.name}</span><br/>',
            pointFormat: "x: <b>{point.x}</b><br/>y: <b>{point.y}</b><br/>"
        },
        stickyTracking: !1
    });
    var bc = M(V, {
        type: "scatter",
        sorted: !1,
        requireSorting: !1,
        noSharedTooltip: !0,
        trackerGroups: ["markerGroup", "dataLabelsGroup"],
        takeOrdinalPosition: !1,
        singularTooltips: !0,
        drawGraph: function () {
            this.options.lineWidth && V.prototype.drawGraph.call(this)
        }
    });
    P.scatter = bc;
    X.pie = E(hb, {
        borderColor: "#FFFFFF",
        borderWidth: 1,
        center: [null, null],
        clip: !1,
        colorByPoint: !0,
        dataLabels: {
            distance: 30,
            enabled: !0,
            formatter: function () {
                return this.point.name
            }
        },
        ignoreHiddenPoint: !0,
        legendType: "point",
        marker: null,
        size: null,
        showInLegend: !1,
        slicedOffset: 10,
        states: {
            hover: {
                brightness: .1,
                shadow: !1
            }
        },
        stickyTracking: !1,
        tooltip: {
            followPointer: !0
        }
    });
    var Mb = {
        type: "pie",
        isCartesian: !1,
        pointClass: M(Da, {
            init: function () {
                Da.prototype.init.apply(this, arguments);
                var a = this,
                    b;
                0 > a.y && (a.y = null);
                n(a, {
                    visible: !1 !== a.visible,
                    name: p(a.name, "Slice")
                });
                b = function (b) {
                    a.slice("select" === b.type)
                };
                W(a, "select", b);
                W(a, "unselect", b);
                return a
            },
            setVisible: function (a) {
                var b = this,
                    c = b.series,
                    d = c.chart;
                b.visible = b.options.visible = a = a === G ? !b.visible : a;
                c.options.data[Ra(b, c.data)] = b.options;
                D(["graphic", "dataLabel", "connector", "shadowGroup"], function (c) {
                    if (b[c]) b[c][a ? "show" : "hide"](!0)
                });
                b.legendItem && d.legend.colorizeItem(b, a);
                !c.isDirty && c.options.ignoreHiddenPoint && (c.isDirty = !0, d.redraw())
            },
            slice: function (a, b, c) {
                var d = this.series;
                ta(c, d.chart);
                p(b, !0);
                this.sliced = this.options.sliced = a = u(a) ? a : !this.sliced;
                d.options.data[Ra(this, d.data)] = this.options;
                a = a ? this.slicedTranslation : {
                    translateX: 0,
                    translateY: 0
                };
                this.graphic.animate(a);
                this.shadowGroup && this.shadowGroup.animate(a)
            },
            haloPath: function (a) {
                var b = this.shapeArgs,
                    c = this.series.chart;
                return this.sliced || !this.visible ? [] : this.series.chart.renderer.symbols.arc(c.plotLeft + b.x, c.plotTop + b.y, b.r + a, b.r + a, {
                    innerR: this.shapeArgs.r,
                    start: b.start,
                    end: b.end
                })
            }
        }),
        requireSorting: !1,
        noSharedTooltip: !0,
        trackerGroups: ["group", "dataLabelsGroup"],
        axisTypes: [],
        pointAttrToOptions: {
            stroke: "borderColor",
            "stroke-width": "borderWidth",
            fill: "color"
        },
        singularTooltips: !0,
        getColor: ma,
        animate: function (a) {
            var b = this,
                c = b.points,
                d = b.startAngleRad;
            a || (D(c, function (a) {
                var c = a.graphic;
                a = a.shapeArgs;
                c && (c.attr({
                    r: b.center[3] / 2,
                    start: d,
                    end: d
                }), c.animate({
                    r: a.r,
                    start: a.start,
                    end: a.end
                }, b.options.animation))
            }), b.animate = null)
        },
        setData: function (a, b, c, d) {
            V.prototype.setData.call(this, a, !1, c, d);
            this.processData();
            this.generatePoints();
            p(b, !0) && this.chart.redraw(c)
        },
        generatePoints: function () {
            var a, b = 0,
                c, d, e, f = this.options.ignoreHiddenPoint;
            V.prototype.generatePoints.call(this);
            c = this.points;
            d = c.length;
            for (a = 0; a < d; a++) e = c[a], b += f && !e.visible ? 0 : e.y;
            this.total = b;
            for (a = 0; a < d; a++) e = c[a], e.percentage = 0 < b ? e.y / b * 100 : 0, e.total = b
        },
        translate: function (a) {
            this.generatePoints();
            var b = 0,
                c = this.options,
                d = c.slicedOffset,
                e = d + c.borderWidth,
                f, g, h, m = c.startAngle || 0,
                q = this.startAngleRad = Ea / 180 * (m - 90),
                m = (this.endAngleRad = Ea / 180 * (p(c.endAngle, m + 360) - 90)) - q,
                r = this.points,
                v = c.dataLabels.distance,
                c = c.ignoreHiddenPoint,
                z, k = r.length,
                t;
            a || (this.center = a = this.getCenter());
            this.getX = function (b, c) {
                h = la.asin(U((b - a[1]) / (a[2] / 2 + v), 1));
                return a[0] + (c ? -1 : 1) * xa(h) * (a[2] / 2 + v)
            };
            for (z = 0; z < k; z++) {
                t = r[z];
                f = q + b * m;
                if (!c || t.visible) b += t.percentage / 100;
                g = q + b * m;
                t.shapeType = "arc";
                t.shapeArgs = {
                    x: a[0],
                    y: a[1],
                    r: a[2] / 2,
                    innerR: a[3] / 2,
                    start: L(1E3 * f) / 1E3,
                    end: L(1E3 * g) / 1E3
                };
                h = (g + f) / 2;
                h > 1.5 * Ea ? h -= 2 * Ea : h < -Ea / 2 && (h += 2 * Ea);
                t.slicedTranslation = {
                    translateX: L(xa(h) * d),
                    translateY: L(ya(h) * d)
                };
                f = xa(h) * a[2] / 2;
                g = ya(h) * a[2] / 2;
                t.tooltipPos = [a[0] + .7 * f, a[1] + .7 * g];
                t.half = h < -Ea / 2 || h > Ea / 2 ? 1 : 0;
                t.angle = h;
                e = U(e, v / 2);
                t.labelPos = [a[0] + f + xa(h) * v, a[1] + g + ya(h) * v, a[0] + f + xa(h) * e, a[1] + g + ya(h) * e, a[0] + f, a[1] + g, 0 > v ? "center" : t.half ? "right" : "left", h]
            }
        },
        drawGraph: null,
        drawPoints: function () {
            var a = this,
                b = a.chart.renderer,
                c, d, e = a.options.shadow,
                f, g;
            e && !a.shadowGroup && (a.shadowGroup = b.g("shadow").add(a.group));
            D(a.points, function (h) {
                d = h.graphic;
                g = h.shapeArgs;
                f = h.shadowGroup;
                e && !f && (f = h.shadowGroup = b.g("shadow").add(a.shadowGroup));
                c = h.sliced ? h.slicedTranslation : {
                    translateX: 0,
                    translateY: 0
                };
                f && f.attr(c);
                d ? d.animate(n(g, c)) : h.graphic = d = b[h.shapeType](g).setRadialReference(a.center).attr(h.pointAttr[h.selected ? "select" : ""]).attr({
                    "stroke-linejoin": "round"
                }).attr(c).add(a.group).shadow(e, f);
                void 0 !== h.visible && h.setVisible(h.visible)
            })
        },
        sortByAngle: function (a, b) {
            a.sort(function (a, d) {
                return void 0 !== a.angle && (d.angle - a.angle) * b
            })
        },
        drawLegendSymbol: jb.drawRectangle,
        getCenter: Zb.getCenter,
        getSymbol: ma
    }, Mb = M(V, Mb);
    P.pie = Mb;
    V.prototype.drawDataLabels = function () {
        var a = this,
            b = a.options,
            c = b.cursor,
            d = b.dataLabels,
            e = a.points,
            f, g, h = a.hasRendered || 0,
            m, q;
        if (d.enabled || a._hasPointLabels) a.dlProcessOptions && a.dlProcessOptions(d), q = a.plotGroup("dataLabelsGroup", "data-labels", d.defer ? "hidden" : "visible", d.zIndex || 6), p(d.defer, !0) && (q.attr({
            opacity: +h
        }), h || W(a, "afterAnimate", function () {
            a.visible && q.show();
            q[b.animation ? "animate" : "attr"]({
                opacity: 1
            }, {
                duration: 200
            })
        })), g = d, D(e, function (b) {
            var e, h = b.dataLabel,
                k, l, A = b.connector,
                F = !0;
            f = b.options && b.options.dataLabels;
            e = p(f && f.enabled, g.enabled);
            if (h && !e) b.dataLabel = h.destroy();
            else if (e) {
                d = E(g, f);
                e = d.rotation;
                k = b.getLabelConfig();
                m = d.format ? t(d.format, k) : d.formatter.call(k, d);
                d.style.color = p(d.color, d.style.color, a.color, "black");
                if (h) u(m) ? (h.attr({
                    text: m
                }), F = !1) : (b.dataLabel = h = h.destroy(), A && (b.connector = A.destroy()));
                else if (u(m)) {
                    h = {
                        fill: d.backgroundColor,
                        stroke: d.borderColor,
                        "stroke-width": d.borderWidth,
                        r: d.borderRadius || 0,
                        rotation: e,
                        padding: d.padding,
                        zIndex: 1
                    };
                    for (l in h) h[l] === G && delete h[l];
                    h = b.dataLabel = a.chart.renderer[e ? "text" : "label"](m, 0, -999, null, null, null, d.useHTML).attr(h).css(n(d.style, c && {
                            cursor: c
                        })).add(q).shadow(d.shadow)
                }
                h && a.alignDataLabel(b, h, d, null, F)
            }
        })
    };
    V.prototype.alignDataLabel = function (a, b, c, d, e) {
        var f = this.chart,
            g = f.inverted,
            h = p(a.plotX, -999),
            m = p(a.plotY, -999),
            q = b.getBBox();
        if (a = this.visible && (a.series.forceDL || f.isInsidePlot(h, L(m), g) || d && f.isInsidePlot(h, g ? d.x + 1 : d.y + d.height - 1, g))) d = n({
            x: g ? f.plotWidth - m : h,
            y: L(g ? f.plotHeight - h : m),
            width: 0,
            height: 0
        }, d), n(c, {
            width: q.width,
            height: q.height
        }), c.rotation ? b[e ? "attr" : "animate"]({
            x: d.x + c.x + d.width / 2,
            y: d.y + c.y + d.height / 2
        }).attr({
            align: c.align
        }) : (b.align(c, null, d), g = b.alignAttr, "justify" === p(c.overflow, "justify") ? this.justifyDataLabel(b, c, g, q, d, e) : p(c.crop, !0) && (a = f.isInsidePlot(g.x, g.y) && f.isInsidePlot(g.x + q.width, g.y + q.height)));
        a || (b.attr({
            y: -999
        }), b.placed = !1)
    };
    V.prototype.justifyDataLabel = function (a, b, c, d, e, f) {
        var g = this.chart,
            h = b.align,
            m = b.verticalAlign,
            q, r;
        q = c.x;
        0 > q && ("right" === h ? b.align = "left" : b.x = -q, r = !0);
        q = c.x + d.width;
        q > g.plotWidth && ("left" === h ? b.align = "right" : b.x = g.plotWidth - q, r = !0);
        q = c.y;
        0 > q && ("bottom" === m ? b.verticalAlign = "top" : b.y = -q, r = !0);
        q = c.y + d.height;
        q > g.plotHeight && ("top" === m ? b.verticalAlign = "bottom" : b.y = g.plotHeight - q, r = !0);
        r && (a.placed = !f, a.align(b, null, e))
    };
    P.pie && (P.pie.prototype.drawDataLabels = function () {
        var a = this,
            b = a.data,
            c, d = a.chart,
            e = a.options.dataLabels,
            f = p(e.connectorPadding, 10),
            g = p(e.connectorWidth, 1),
            h = d.plotWidth,
            m = d.plotHeight,
            q, r, v = p(e.softConnector, !0),
            k = e.distance,
            x = a.center,
            t = x[2] / 2,
            l = x[1],
            A = 0 < k,
            F, n, B, u = [
                [],
                []
            ],
            R, y, w, J, C, da = [0, 0, 0, 0],
            G = function (a, b) {
                return b.y - a.y
            };
        if (a.visible && (e.enabled || a._hasPointLabels)) {
            V.prototype.drawDataLabels.apply(a);
            D(b, function (a) {
                a.dataLabel && a.visible && u[a.half].push(a)
            });
            for (J = 2; J--;) {
                var E = [],
                    ea = [],
                    I = u[J],
                    K = I.length,
                    ca;
                if (K) {
                    a.sortByAngle(I, J - .5);
                    for (C = b = 0; !b && I[C];) b = I[C] && I[C].dataLabel && (I[C].dataLabel.getBBox().height || 21), C++;
                    if (0 < k) {
                        n = U(l + t + k, d.plotHeight);
                        for (C = N(0, l - t - k); C <= n; C += b) E.push(C);
                        n = E.length;
                        if (K > n) {
                            c = [].concat(I);
                            c.sort(G);
                            for (C = K; C--;) c[C].rank = C;
                            for (C = K; C--;) I[C].rank >= n && I.splice(C, 1);
                            K = I.length
                        }
                        for (C = 0; C < K; C++) {
                            c = I[C];
                            B = c.labelPos;
                            c = 9999;
                            var M, P;
                            for (P = 0; P < n; P++) M = ka(E[P] - B[1]), M < c && (c = M, ca = P);
                            if (ca < C && null !== E[C]) ca = C;
                            else
                                for (n < K - C + ca && null !== E[C] && (ca = n - K + C); null === E[ca];) ca++;
                            ea.push({
                                i: ca,
                                y: E[ca]
                            });
                            E[ca] = null
                        }
                        ea.sort(G)
                    }
                    for (C = 0; C < K; C++) {
                        c = I[C];
                        B = c.labelPos;
                        F = c.dataLabel;
                        w = !1 === c.visible ? "hidden" : "visible";
                        c = B[1];
                        if (0 < k) {
                            if (n = ea.pop(), ca = n.i, y = n.y, c > y && null !== E[ca + 1] || c < y && null !== E[ca - 1]) y = U(N(0, c), d.plotHeight)
                        } else y = c;
                        R = e.justify ? x[0] + (J ? -1 : 1) * (t + k) : a.getX(y === l - t - k || y === l + t + k ? c : y, J);
                        F._attr = {
                            visibility: w,
                            align: B[6]
                        };
                        F._pos = {
                            x: R + e.x + ({
                                left: f,
                                right: -f
                            }[B[6]] || 0),
                            y: y + e.y - 10
                        };
                        F.connX = R;
                        F.connY = y;
                        null === this.options.size && (n = F.width, R - n < f ? da[3] = N(L(n - R + f), da[3]) : R + n > h - f && (da[1] = N(L(R + n - h + f), da[1])), 0 > y - b / 2 ? da[0] = N(L(-y + b / 2), da[0]) : y + b / 2 > m && (da[2] = N(L(y + b / 2 - m), da[2])))
                    }
                }
            }
            if (0 === Ia(da) || this.verifyDataLabelOverflow(da)) this.placeDataLabels(), A && g && D(this.points, function (b) {
                q = b.connector;
                B = b.labelPos;
                (F = b.dataLabel) && F._pos ? (w = F._attr.visibility, R = F.connX, y = F.connY, r = v ? ["M", R + ("left" === B[6] ? 5 : -5), y, "C", R, y, 2 * B[2] - B[4], 2 * B[3] - B[5], B[2], B[3], "L", B[4], B[5]] : ["M", R + ("left" === B[6] ? 5 : -5), y, "L", B[2], B[3], "L", B[4], B[5]], q ? (q.animate({
                    d: r
                }), q.attr("visibility", w)) : b.connector = q = a.chart.renderer.path(r).attr({
                    "stroke-width": g,
                    stroke: e.connectorColor || b.color || "#606060",
                    visibility: w
                }).add(a.dataLabelsGroup)) : q && (b.connector = q.destroy())
            })
        }
    }, P.pie.prototype.placeDataLabels = function () {
        D(this.points, function (a) {
            a = a.dataLabel;
            var b;
            a && ((b = a._pos) ? (a.attr(a._attr), a[a.moved ? "animate" : "attr"](b), a.moved = !0) : a && a.attr({
                y: -999
            }))
        })
    }, P.pie.prototype.alignDataLabel = ma, P.pie.prototype.verifyDataLabelOverflow = function (a) {
        var b = this.center,
            c = this.options,
            d = c.center,
            e = c = c.minSize || 80,
            f;
        null !== d[0] ? e = N(b[2] - N(a[1], a[3]), c) : (e = N(b[2] - a[1] - a[3], c), b[0] += (a[3] - a[1]) / 2);
        null !== d[1] ? e = N(U(e, b[2] - N(a[0], a[2])), c) : (e = N(U(e, b[2] - a[0] - a[2]), c), b[1] += (a[0] - a[2]) / 2);
        e < b[2] ? (b[2] = e, this.translate(b), D(this.points, function (a) {
            a.dataLabel && (a.dataLabel._pos = null)
        }), this.drawDataLabels && this.drawDataLabels()) : f = !0;
        return f
    });
    P.column && (P.column.prototype.alignDataLabel = function (a, b, c, d, e) {
        var f = this.chart,
            g = f.inverted,
            h = a.dlBox || a.shapeArgs,
            m = a.below || a.plotY > p(this.translatedThreshold, f.plotSizeY),
            q = p(c.inside, !!this.options.stacking);
        h && (d = E(h), g && (d = {
            x: f.plotWidth - d.y - d.height,
            y: f.plotHeight - d.x - d.width,
            width: d.height,
            height: d.width
        }), q || (g ? (d.x += m ? 0 : d.width, d.width = 0) : (d.y += m ? d.height : 0, d.height = 0)));
        c.align = p(c.align, !g || q ? "center" : m ? "right" : "left");
        c.verticalAlign = p(c.verticalAlign, g || q ? "middle" : m ? "top" : "bottom");
        V.prototype.alignDataLabel.call(this, a, b, c, d, e)
    });
    var $a = ga.TrackerMixin = {
        drawTrackerPoint: function () {
            var a = this,
                b = a.chart,
                c = b.pointer,
                d = a.options.cursor,
                e = d && {
                        cursor: d
                    }, f = function (c) {
                    var d = c.target,
                        e;
                    if (b.hoverSeries !== a) a.onMouseOver();
                    for (; d && !e;) e = d.point, d = d.parentNode;
                    if (e !== G && e !== b.hoverPoint) e.onMouseOver(c)
                };
            D(a.points, function (a) {
                a.graphic && (a.graphic.element.point = a);
                a.dataLabel && (a.dataLabel.element.point = a)
            });
            a._hasTracking || (D(a.trackerGroups, function (b) {
                if (a[b] && (a[b].addClass("highcharts-tracker").on("mouseover", f).on("mouseout", function (a) {
                        c.onTrackerMouseOut(a)
                    }).css(e), db)) a[b].on("touchstart", f)
            }), a._hasTracking = !0)
        },
        drawTrackerGraph: function () {
            var a = this,
                b = a.options,
                c = b.trackByArea,
                d = [].concat(c ? a.areaPath : a.graphPath),
                e = d.length,
                f = a.chart,
                g = f.pointer,
                h = f.renderer,
                m = f.options.tooltip.snap,
                q = a.tracker,
                r = b.cursor,
                v = r && {
                        cursor: r
                    }, r = a.singlePoints,
                k, x = function () {
                    if (f.hoverSeries !== a) a.onMouseOver()
                }, t = "rgba(192,192,192," + (wa ? 1E-4 : .002) + ")";
            if (e && !c)
                for (k = e + 1; k--;) "M" === d[k] && d.splice(k + 1, 0, d[k + 1] - m, d[k + 2], "L"), (k && "M" === d[k] || k === e) && d.splice(k, 0, "L", d[k - 2] + m, d[k - 1]);
            for (k = 0; k < r.length; k++) e = r[k], d.push("M", e.plotX - m, e.plotY, "L", e.plotX + m, e.plotY);
            q ? q.attr({
                d: d
            }) : (a.tracker = h.path(d).attr({
                "stroke-linejoin": "round",
                visibility: a.visible ? "visible" : "hidden",
                stroke: t,
                fill: c ? t : "none",
                "stroke-width": b.lineWidth + (c ? 0 : 2 * m),
                zIndex: 2
            }).add(a.group), D([a.tracker, a.markerGroup], function (a) {
                a.addClass("highcharts-tracker").on("mouseover", x).on("mouseout", function (a) {
                    g.onTrackerMouseOut(a)
                }).css(v);
                if (db) a.on("touchstart", x)
            }))
        }
    };
    P.column && (Lb.prototype.drawTracker = $a.drawTrackerPoint);
    P.pie && (P.pie.prototype.drawTracker = $a.drawTrackerPoint);
    P.scatter && (bc.prototype.drawTracker = $a.drawTrackerPoint);
    n(ub.prototype, {
        setItemEvents: function (a, b, c, d, e) {
            var f = this;
            (c ? b : a.legendGroup).on("mouseover", function () {
                a.setState("hover");
                b.css(f.options.itemHoverStyle)
            }).on("mouseout", function () {
                b.css(a.visible ? d : e);
                a.setState()
            }).on("click", function (b) {
                var c = function () {
                    a.setVisible()
                };
                b = {
                    browserEvent: b
                };
                a.firePointEvent ? a.firePointEvent("legendItemClick", b, c) : ja(a, "legendItemClick", b, c)
            })
        },
        createCheckboxForItem: function (a) {
            a.checkbox = K("input", {
                type: "checkbox",
                checked: a.selected,
                defaultChecked: a.selected
            }, this.options.itemCheckboxStyle, this.chart.container);
            W(a.checkbox, "click", function (b) {
                ja(a, "checkboxClick", {
                    checked: b.target.checked
                }, function () {
                    a.select()
                })
            })
        }
    });
    ha.legend.itemStyle.cursor = "pointer";
    n(na.prototype, {
        showResetZoom: function () {
            var a = this,
                b = ha.lang,
                c = a.options.chart.resetZoomButton,
                d = c.theme,
                e = d.states,
                f = "chart" === c.relativeTo ? null : "plotBox";
            this.resetZoomButton = a.renderer.button(b.resetZoom, null, null, function () {
                a.zoomOut()
            }, d, e && e.hover).attr({
                align: c.position.align,
                title: b.resetZoomTitle
            }).add().align(c.position, !1, f)
        },
        zoomOut: function () {
            var a = this;
            ja(a, "selection", {
                resetSelection: !0
            }, function () {
                a.zoom()
            })
        },
        zoom: function (a) {
            var b, c = this.pointer,
                d = !1,
                e;
            !a || a.resetSelection ? D(this.axes, function (a) {
                b = a.zoom()
            }) : D(a.xAxis.concat(a.yAxis), function (a) {
                var e = a.axis,
                    h = e.isXAxis;
                if (c[h ? "zoomX" : "zoomY"] || c[h ? "pinchX" : "pinchY"]) b = e.zoom(a.min, a.max), e.displayBtn && (d = !0)
            });
            e = this.resetZoomButton;
            d && !e ? this.showResetZoom() : !d && Q(e) && (this.resetZoomButton = e.destroy());
            b && this.redraw(p(this.options.chart.animation, a && a.animation, 100 > this.pointCount))
        },
        pan: function (a, b) {
            var c = this,
                d = c.hoverPoints,
                e;
            d && D(d, function (a) {
                a.setState()
            });
            D("xy" === b ? [1, 0] : [1], function (b) {
                var d = a[b ? "chartX" : "chartY"],
                    h = c[b ? "xAxis" : "yAxis"][0],
                    m = c[b ? "mouseDownX" : "mouseDownY"],
                    q = (h.pointRange || 0) / 2,
                    r = h.getExtremes(),
                    v = h.toValue(m - d, !0) + q,
                    m = h.toValue(m + c[b ? "plotWidth" : "plotHeight"] - d, !0) - q;
                h.series.length && v > U(r.dataMin, r.min) && m < N(r.dataMax, r.max) && (h.setExtremes(v, m, !1, !1, {
                    trigger: "pan"
                }), e = !0);
                c[b ? "mouseDownX" : "mouseDownY"] = d
            });
            e && c.redraw(!1);
            I(c.container, {
                cursor: "move"
            })
        }
    });
    n(Da.prototype, {
        select: function (a, b) {
            var c = this,
                d = c.series,
                e = d.chart;
            a = p(a, !c.selected);
            c.firePointEvent(a ? "select" : "unselect", {
                accumulate: b
            }, function () {
                c.selected = c.options.selected = a;
                d.options.data[Ra(c, d.data)] = c.options;
                c.setState(a && "select");
                b || D(e.getSelectedPoints(), function (a) {
                    a.selected && a !== c && (a.selected = a.options.selected = !1, d.options.data[Ra(a, d.data)] = a.options, a.setState(""), a.firePointEvent("unselect"))
                })
            })
        },
        onMouseOver: function (a) {
            var b = this.series,
                c = b.chart,
                d = c.tooltip,
                e = c.hoverPoint;
            if (e && e !== this) e.onMouseOut();
            this.firePointEvent("mouseOver");
            !d || d.shared && !b.noSharedTooltip || d.refresh(this, a);
            this.setState("hover");
            c.hoverPoint = this
        },
        onMouseOut: function () {
            var a = this.series.chart,
                b = a.hoverPoints;
            this.firePointEvent("mouseOut");
            b && -1 !== Ra(this, b) || (this.setState(), a.hoverPoint = null)
        },
        importEvents: function () {
            if (!this.hasImportedEvents) {
                var a = E(this.series.options.point, this.options).events,
                    b;
                this.events = a;
                for (b in a) W(this, b, a[b]);
                this.hasImportedEvents = !0
            }
        },
        setState: function (a, b) {
            var c = this.plotX,
                d = this.plotY,
                e = this.series,
                f = e.options.states,
                g = X[e.type].marker && e.options.marker,
                h = g && !g.enabled,
                m = g && g.states[a],
                q = m && !1 === m.enabled,
                r = e.stateMarkerGraphic,
                v = this.marker || {}, k = e.chart,
                t = e.halo,
                p;
            a = a || "";
            p = this.pointAttr[a] || e.pointAttr[a];
            if (!(a === this.state && !b || this.selected && "select" !== a || f[a] && !1 === f[a].enabled || a && (q || h && !1 === m.enabled) || a && v.states && v.states[a] && !1 === v.states[a].enabled)) {
                if (this.graphic) g = g && this.graphic.symbolName && p.r, this.graphic.attr(E(p, g ? {
                    x: c - g,
                    y: d - g,
                    width: 2 * g,
                    height: 2 * g
                } : {})), r && r.hide();
                else {
                    if (a && m)
                        if (g = m.radius, v = v.symbol || e.symbol, r && r.currentSymbol !== v && (r = r.destroy()), r) r[b ? "animate" : "attr"]({
                            x: c - g,
                            y: d - g
                        });
                        else v && (e.stateMarkerGraphic = r = k.renderer.symbol(v, c - g, d - g, 2 * g, 2 * g).attr(p).add(e.markerGroup), r.currentSymbol = v);
                    if (r) r[a && k.isInsidePlot(c, d, k.inverted) ? "show" : "hide"]()
                }
                (c = f[a] && f[a].halo) && c.size ? (t || (e.halo = t = k.renderer.path().add(e.seriesGroup)), t.attr(n({
                    fill: Ja(this.color || e.color).setOpacity(c.opacity).get()
                }, c.attributes))[b ? "animate" : "attr"]({
                    d: this.haloPath(c.size)
                })) : t && t.attr({
                    d: []
                });
                this.state = a
            }
        },
        haloPath: function (a) {
            var b = this.series,
                c = b.chart,
                d = b.getPlotBox(),
                e = c.inverted;
            return c.renderer.symbols.circle(d.translateX + (e ? b.yAxis.len - this.plotY : this.plotX) - a, d.translateY + (e ? b.xAxis.len - this.plotX : this.plotY) - a, 2 * a, 2 * a)
        }
    });
    n(V.prototype, {
        onMouseOver: function () {
            var a = this.chart,
                b = a.hoverSeries;
            if (b && b !== this) b.onMouseOut();
            this.options.events.mouseOver && ja(this, "mouseOver");
            this.setState("hover");
            a.hoverSeries = this
        },
        onMouseOut: function () {
            var a = this.options,
                b = this.chart,
                c = b.tooltip,
                d = b.hoverPoint;
            if (d) d.onMouseOut();
            this && a.events.mouseOut && ja(this, "mouseOut");
            !c || a.stickyTracking || c.shared && !this.noSharedTooltip || c.hide();
            this.setState();
            b.hoverSeries = null
        },
        setState: function (a) {
            var b = this.options,
                c = this.graph,
                d = this.graphNeg,
                e = b.states,
                b = b.lineWidth;
            a = a || "";
            this.state !== a && (this.state = a, e[a] && !1 === e[a].enabled || (a && (b = e[a].lineWidth || b + (e[a].lineWidthPlus || 0)), c && !c.dashstyle && (a = {
                "stroke-width": b
            }, c.attr(a), d && d.attr(a))))
        },
        setVisible: function (a, b) {
            var c = this,
                d = c.chart,
                e = c.legendItem,
                f, g = d.options.chart.ignoreHiddenSeries,
                h = c.visible;
            f = (c.visible = a = c.userOptions.visible = a === G ? !h : a) ? "show" : "hide";
            D(["group", "dataLabelsGroup", "markerGroup", "tracker"], function (a) {
                if (c[a]) c[a][f]()
            });
            if (d.hoverSeries === c) c.onMouseOut();
            e && d.legend.colorizeItem(c, a);
            c.isDirty = !0;
            c.options.stacking && D(d.series, function (a) {
                a.options.stacking && a.visible && (a.isDirty = !0)
            });
            D(c.linkedSeries, function (b) {
                b.setVisible(a, !1)
            });
            g && (d.isDirtyBox = !0);
            !1 !== b && d.redraw();
            ja(c, f)
        },
        setTooltipPoints: function (a) {
            var b = [],
                c, d, e = this.xAxis,
                f = e && e.getExtremes(),
                g = e ? e.tooltipLen || e.len : this.chart.plotSizeX,
                h, m, q = [];
            if (!1 !== this.options.enableMouseTracking && !this.singularTooltips) {
                a && (this.tooltipPoints = null);
                D(this.segments || this.points, function (a) {
                    b = b.concat(a)
                });
                e && e.reversed && (b = b.reverse());
                this.orderTooltipPoints && this.orderTooltipPoints(b);
                a = b.length;
                for (m = 0; m < a; m++)
                    if (e = b[m], c = e.x, c >= f.min && c <= f.max)
                        for (h = b[m + 1], c = d === G ? 0 : d + 1, d = b[m + 1] ? U(N(0, fa((e.clientX + (h ? h.wrappedClientX || h.clientX : g)) / 2)), g) : g; 0 <= c && c <= d;) q[c++] = e;
                this.tooltipPoints = q
            }
        },
        show: function () {
            this.setVisible(!0)
        },
        hide: function () {
            this.setVisible(!1)
        },
        select: function (a) {
            this.selected = a = a === G ? !this.selected : a;
            this.checkbox && (this.checkbox.checked = a);
            ja(this, a ? "select" : "unselect")
        },
        drawTracker: $a.drawTrackerGraph
    });
    k(V.prototype, "init", function (a) {
        var b;
        a.apply(this, Array.prototype.slice.call(arguments, 1));
        (b = this.xAxis) && b.options.ordinal && W(this, "updatedData", function () {
            delete b.ordinalIndex
        })
    });
    k(T.prototype, "getTimeTicks", function (a, b, c, d, e, f, g, h) {
        var m = 0,
            q = 0,
            r, v = {}, k, t, p, l = [],
            A = -Number.MAX_VALUE,
            n = this.options.tickPixelInterval;
        if (!this.options.ordinal || !f || 3 > f.length || c === G) return a.call(this, b, c, d, e);
        for (t = f.length; q < t; q++) {
            p = q && f[q - 1] > d;
            f[q] < c && (m = q);
            if (q === t - 1 || f[q + 1] - f[q] > 5 * g || p) {
                if (f[q] > A) {
                    for (r = a.call(this, b, f[m], f[q], e); r.length && r[0] <= A;) r.shift();
                    r.length && (A = r[r.length - 1]);
                    l = l.concat(r)
                }
                m = q + 1
            }
            if (p) break
        }
        a = r.info;
        if (h && a.unitRange <= ba.hour) {
            q = l.length - 1;
            for (m = 1; m < q; m++)(new ua(l[m] - Pa))[Wa]() !== (new ua(l[m - 1] - Pa))[Wa]() && (v[l[m]] = "day", k = !0);
            k && (v[l[0]] = "day");
            a.higherRanks = v
        }
        l.info = a;
        if (h && u(n)) {
            h = a = l.length;
            var q = [],
                F;
            for (k = []; h--;) m = this.translate(l[h]), F && (k[h] = F - m), q[h] = F = m;
            k.sort();
            k = k[fa(k.length / 2)];
            k < .6 * n && (k = null);
            h = l[a - 1] > d ? a - 1 : a;
            for (F = void 0; h--;) m = q[h], d = F - m, F && d < .8 * n && (null === k || d < .8 * k) ? (v[l[h]] && !v[l[h + 1]] ? (d = h + 1, F = m) : d = h, l.splice(d, 1)) : F = m
        }
        return l
    });
    n(T.prototype, {
        beforeSetTickPositions: function () {
            var a, b = [],
                c = !1,
                d, e = this.getExtremes(),
                f = e.min,
                e = e.max,
                g;
            if (this.options.ordinal) {
                D(this.series, function (c, d) {
                    if (!1 !== c.visible && !1 !== c.takeOrdinalPosition && (b = b.concat(c.processedXData), a = b.length, b.sort(function (a, b) {
                            return a - b
                        }), a))
                        for (d = a - 1; d--;) b[d] === b[d + 1] && b.splice(d, 1)
                });
                a = b.length;
                if (2 < a) {
                    d = b[1] - b[0];
                    for (g = a - 1; g-- && !c;) b[g + 1] - b[g] !== d && (c = !0);
                    !this.options.keepOrdinalPadding && (b[0] - f > d || e - b[b.length - 1] > d) && (c = !0)
                }
                c ? (this.ordinalPositions = b, c = this.val2lin(N(f, b[0]), !0), d = N(this.val2lin(U(e, b[b.length - 1]), !0), 1), this.ordinalSlope = e = (e - f) / (d - c), this.ordinalOffset = f - c * e) : this.ordinalPositions = this.ordinalSlope = this.ordinalOffset = G
            }
            this.groupIntervalFactor = null
        },
        val2lin: function (a, b) {
            var c = this.ordinalPositions;
            if (c) {
                var d = c.length,
                    e, f;
                for (e = d; e--;)
                    if (c[e] === a) {
                        f = e;
                        break
                    }
                for (e = d - 1; e--;)
                    if (a > c[e] || 0 === e) {
                        c = (a - c[e]) / (c[e + 1] - c[e]);
                        f = e + c;
                        break
                    }
                return b ? f : this.ordinalSlope * (f || 0) + this.ordinalOffset
            }
            return a
        },
        lin2val: function (a, b) {
            var c = this.ordinalPositions;
            if (c) {
                var d = this.ordinalSlope,
                    e = this.ordinalOffset,
                    f = c.length - 1,
                    g, h;
                if (b) 0 > a ? a = c[0] : a > f ? a = c[f] : (f = fa(a), h = a - f);
                else
                    for (; f--;)
                        if (g = d * f + e, a >= g) {
                            d = d * (f + 1) + e;
                            h = (a - g) / (d - g);
                            break
                        }
                return h !== G && c[f] !== G ? c[f] + (h ? h * (c[f + 1] - c[f]) : 0) : a
            }
            return a
        },
        getExtendedPositions: function () {
            var a = this.chart,
                b = this.series[0].currentDataGrouping,
                c = this.ordinalIndex,
                d = b ? b.count + b.unitName : "raw",
                e = this.getExtremes(),
                f, g;
            c || (c = this.ordinalIndex = {});
            c[d] || (f = {
                series: [],
                getExtremes: function () {
                    return {
                        min: e.dataMin,
                        max: e.dataMax
                    }
                },
                options: {
                    ordinal: !0
                },
                val2lin: T.prototype.val2lin
            }, D(this.series, function (c) {
                g = {
                    xAxis: f,
                    xData: c.xData,
                    chart: a,
                    destroyGroupedData: ma
                };
                g.options = {
                    dataGrouping: b ? {
                        enabled: !0,
                        forced: !0,
                        approximation: "open",
                        units: [
                            [b.unitName, [b.count]]
                        ]
                    } : {
                        enabled: !1
                    }
                };
                c.processData.apply(g);
                f.series.push(g)
            }), this.beforeSetTickPositions.apply(f), c[d] = f.ordinalPositions);
            return c[d]
        },
        getGroupIntervalFactor: function (a, b, c) {
            var d = 0;
            c = c.processedXData;
            var e = c.length,
                f = [],
                g = this.groupIntervalFactor;
            if (!g) {
                for (; d < e - 1; d++) f[d] = c[d + 1] - c[d];
                f.sort(function (a, b) {
                    return a - b
                });
                d = f[fa(e / 2)];
                a = N(a, c[0]);
                b = U(b, c[e - 1]);
                this.groupIntervalFactor = g = e * d / (b - a)
            }
            return g
        },
        postProcessTickInterval: function (a) {
            var b = this.ordinalSlope;
            return b ? a / (b / this.closestPointRange) : a
        }
    });
    k(na.prototype, "pan", function (a, b) {
        var c = this.xAxis[0],
            d = b.chartX,
            e = !1;
        if (c.options.ordinal && c.series.length) {
            var f = this.mouseDownX,
                g = c.getExtremes(),
                h = g.dataMax,
                m = g.min,
                q = g.max,
                r = this.hoverPoints,
                k = c.closestPointRange,
                f = (f - d) / (c.translationSlope * (c.ordinalSlope || k)),
                t = {
                    ordinalPositions: c.getExtendedPositions()
                },
                k = c.lin2val,
                p = c.val2lin,
                l;
            t.ordinalPositions ? 1 < ka(f) && (r && D(r, function (a) {
                a.setState()
            }), 0 > f ? (r = t, l = c.ordinalPositions ? c : t) : (r = c.ordinalPositions ? c : t, l = t), t = l.ordinalPositions, h > t[t.length - 1] && t.push(h), this.fixedRange = q - m, f = c.toFixedRange(null, null, k.apply(r, [p.apply(r, [m, !0]) + f, !0]), k.apply(l, [p.apply(l, [q, !0]) + f, !0])), f.min >= U(g.dataMin, m) && f.max <= N(h, q) && c.setExtremes(f.min, f.max, !0, !1, {
                trigger: "pan"
            }), this.mouseDownX = d, I(this.container, {
                cursor: "move"
            })) : e = !0
        } else e = !0;
        e && a.apply(this, Array.prototype.slice.call(arguments, 1))
    });
    k(V.prototype, "getSegments", function (a) {
        var b, c = this.options.gapSize,
            d = this.xAxis;
        a.apply(this, Array.prototype.slice.call(arguments, 1));
        c && (b = this.segments, D(b, function (a, f) {
            for (var g = a.length - 1; g--;) a[g + 1].x - a[g].x > d.closestPointRange * c && b.splice(f + 1, 0, a.splice(g + 1, a.length - g))
        }))
    });
    var va = V.prototype,
        cc = Hb.prototype,
        uc = va.processData,
        vc = va.generatePoints,
        wc = va.destroy,
        xc = cc.tooltipHeaderFormatter,
        yc = {
            approximation: "average",
            groupPixelWidth: 2,
            dateTimeLabelFormats: {
                millisecond: ["%A, %b %e, %H:%M:%S.%L", "%A, %b %e, %H:%M:%S.%L", "-%H:%M:%S.%L"],
                second: ["%A, %b %e, %H:%M:%S", "%A, %b %e, %H:%M:%S", "-%H:%M:%S"],
                minute: ["%A, %b %e, %H:%M", "%A, %b %e, %H:%M", "-%H:%M"],
                hour: ["%A, %b %e, %H:%M", "%A, %b %e, %H:%M", "-%H:%M"],
                day: ["%A, %b %e, %Y", "%A, %b %e", "-%A, %b %e, %Y"],
                week: ["Week from %A, %b %e, %Y", "%A, %b %e", "-%A, %b %e, %Y"],
                month: ["%B %Y", "%B", "-%B %Y"],
                year: ["%Y", "%Y", "-%Y"]
            }
        }, dc = {
            line: {},
            spline: {},
            area: {},
            areaspline: {},
            column: {
                approximation: "sum",
                groupPixelWidth: 10
            },
            arearange: {
                approximation: "range"
            },
            areasplinerange: {
                approximation: "range"
            },
            columnrange: {
                approximation: "range",
                groupPixelWidth: 10
            },
            candlestick: {
                approximation: "ohlc",
                groupPixelWidth: 10
            },
            ohlc: {
                approximation: "ohlc",
                groupPixelWidth: 5
            }
        }, ec = [
            ["millisecond", [1, 2, 5, 10, 20, 25, 50, 100, 200, 500]],
            ["second", [1, 2, 5, 10, 15, 30]],
            ["minute", [1, 2, 5, 10, 15, 30]],
            ["hour", [1, 2, 3, 4, 6, 8, 12]],
            ["day", [1]],
            ["week", [1]],
            ["month", [1, 3, 6]],
            ["year", null]
        ],
        Ua = {
            sum: function (a) {
                var b = a.length,
                    c;
                if (!b && a.hasNulls) c = null;
                else if (b)
                    for (c = 0; b--;) c += a[b];
                return c
            },
            average: function (a) {
                var b = a.length;
                a = Ua.sum(a);
                "number" === typeof a && b && (a /= b);
                return a
            },
            open: function (a) {
                return a.length ? a[0] : a.hasNulls ? null : G
            },
            high: function (a) {
                return a.length ? Ia(a) : a.hasNulls ? null : G
            },
            low: function (a) {
                return a.length ? ea(a) : a.hasNulls ? null : G
            },
            close: function (a) {
                return a.length ? a[a.length - 1] : a.hasNulls ? null : G
            },
            ohlc: function (a, b, c, d) {
                a = Ua.open(a);
                b = Ua.high(b);
                c = Ua.low(c);
                d = Ua.close(d);
                if ("number" === typeof a || "number" === typeof b || "number" === typeof c || "number" === typeof d) return [a, b, c, d]
            },
            range: function (a, b) {
                a = Ua.low(a);
                b = Ua.high(b);
                if ("number" === typeof a || "number" === typeof b) return [a, b]
            }
        };
    va.groupData = function (a, b, c, d) {
        var e = this.data,
            f = this.options.data,
            g = [],
            h = [],
            m = a.length,
            q, r, k = !!b,
            t = [
                [],
                [],
                [],
                []
            ];
        d = "function" === typeof d ? d : Ua[d];
        var p = this.pointArrayMap,
            l = p && p.length,
            A;
        for (A = 0; A <= m && !(a[A] >= c[0]); A++);
        for (; A <= m; A++) {
            for (;
                (c[1] !== G && a[A] >= c[1] || A === m) && (q = c.shift(), r = d.apply(0, t), r !== G && (g.push(q), h.push(r)), t[0] = [], t[1] = [], t[2] = [], t[3] = [], A !== m););
            if (A === m) break;
            if (p) {
                q = this.cropStart + A;
                q = e && e[q] || this.pointClass.prototype.applyOptions.apply({
                        series: this
                    }, [f[q]]);
                var F;
                for (r = 0; r < l; r++) F = q[p[r]], "number" === typeof F ? t[r].push(F) : null === F && (t[r].hasNulls = !0)
            } else q = k ? b[A] : null, "number" === typeof q ? t[0].push(q) : null === q && (t[0].hasNulls = !0)
        }
        return [g, h]
    };
    va.processData = function () {
        var a = this.chart,
            b = this.options,
            c = b.dataGrouping,
            d = !1 !== this.allowDG && c && p(c.enabled, a.options._stock),
            e;
        this.forceCrop = d;
        this.groupPixelWidth = null;
        this.hasProcessed = !0;
        if (!1 !== uc.apply(this, arguments) && d) {
            this.destroyGroupedData();
            var f = this.processedXData,
                g = this.processedYData,
                h = a.plotSizeX,
                a = this.xAxis,
                m = a.options.ordinal,
                q = this.groupPixelWidth = a.getGroupPixelWidth && a.getGroupPixelWidth(),
                d = this.pointRange;
            if (q) {
                e = !0;
                this.points = null;
                var r = a.getExtremes(),
                    d = r.min,
                    r = r.max,
                    m = m && a.getGroupIntervalFactor(d, r, this) || 1,
                    h = q * (r - d) / h * m,
                    q = a.getTimeTicks(a.normalizeTimeTickInterval(h, c.units || ec), d, r, a.options.startOfWeek, f, this.closestPointRange),
                    g = va.groupData.apply(this, [f, g, q, c.approximation]),
                    f = g[0],
                    g = g[1];
                if (c.smoothed) {
                    c = f.length - 1;
                    for (f[c] = r; c-- && 0 < c;) f[c] += h / 2;
                    f[0] = d
                }
                this.currentDataGrouping = q.info;
                null === b.pointRange && (this.pointRange = q.info.totalRange);
                this.closestPointRange = q.info.totalRange;
                u(f[0]) && f[0] < a.dataMin && (a.dataMin = f[0]);
                this.processedXData = f;
                this.processedYData = g
            } else this.currentDataGrouping = null, this.pointRange = d;
            this.hasGroupedData = e
        }
    };
    va.destroyGroupedData = function () {
        var a = this.groupedData;
        D(a || [], function (b, c) {
            b && (a[c] = b.destroy ? b.destroy() : null)
        });
        this.groupedData = null
    };
    va.generatePoints = function () {
        vc.apply(this);
        this.destroyGroupedData();
        this.groupedData = this.hasGroupedData ? this.points : null
    };
    cc.tooltipHeaderFormatter = function (a) {
        var b = a.series,
            c = b.tooltipOptions,
            d = b.options.dataGrouping,
            e = c.xDateFormat,
            f, g = b.xAxis,
            h;
        if (g && "datetime" === g.options.type && d && aa(a.key)) {
            b = b.currentDataGrouping;
            d = d.dateTimeLabelFormats;
            if (b) g = d[b.unitName], 1 === b.count ? e = g[0] : (e = g[1], f = g[2]);
            else if (!e && d)
                for (h in ba)
                    if (ba[h] >= g.closestPointRange || ba[h] <= ba.day && 0 < a.key % ba[h]) {
                        e = d[h][0];
                        break
                    }
            e = Ha(e, a.key);
            f && (e += Ha(f, a.key + b.totalRange - 1));
            a = c.headerFormat.replace("{point.key}", e)
        } else a = xc.call(this, a);
        return a
    };
    va.destroy = function () {
        for (var a = this.groupedData || [], b = a.length; b--;) a[b] && a[b].destroy();
        wc.apply(this)
    };
    k(va, "setOptions", function (a, b) {
        var c = a.call(this, b),
            d = this.type,
            e = this.chart.options.plotOptions,
            f = X[d].dataGrouping;
        dc[d] && (f || (f = E(yc, dc[d])), c.dataGrouping = E(f, e.series && e.series.dataGrouping, e[d].dataGrouping, b.dataGrouping));
        this.chart.options._stock && (this.requireSorting = !0);
        return c
    });
    k(T.prototype, "setScale", function (a) {
        a.call(this);
        D(this.series, function (a) {
            a.hasProcessed = !1
        })
    });
    T.prototype.getGroupPixelWidth = function () {
        var a = this.series,
            b = a.length,
            c, d = 0,
            e = !1,
            f;
        for (c = b; c--;)(f = a[c].options.dataGrouping) && (d = N(d, f.groupPixelWidth));
        for (c = b; c--;)(f = a[c].options.dataGrouping) && a[c].hasProcessed && (b = (a[c].processedXData || a[c].data).length, a[c].groupPixelWidth || b > this.chart.plotSizeX / d || b && f.forced) && (e = !0);
        return e ? d : 0
    };
    X.ohlc = E(X.column, {
        lineWidth: 1,
        tooltip: {
            pointFormat: '<span style="color:{series.color}">\u25cf</span> <b> {series.name}</b><br/>Open: {point.open}<br/>High: {point.high}<br/>Low: {point.low}<br/>Close: {point.close}<br/>'
        },
        states: {
            hover: {
                lineWidth: 3
            }
        },
        threshold: null
    });
    var fc = M(P.column, {
        type: "ohlc",
        pointArrayMap: ["open", "high", "low", "close"],
        toYData: function (a) {
            return [a.open, a.high, a.low, a.close]
        },
        pointValKey: "high",
        pointAttrToOptions: {
            stroke: "color",
            "stroke-width": "lineWidth"
        },
        upColorProp: "stroke",
        getAttribs: function () {
            P.column.prototype.getAttribs.apply(this, arguments);
            var a = this.options,
                b = a.states,
                a = a.upColor || this.color,
                c = E(this.pointAttr),
                d = this.upColorProp;
            c[""][d] = a;
            c.hover[d] = b.hover.upColor || a;
            c.select[d] = b.select.upColor || a;
            D(this.points, function (a) {
                a.open < a.close && (a.pointAttr = c)
            })
        },
        translate: function () {
            var a = this.yAxis;
            P.column.prototype.translate.apply(this);
            D(this.points, function (b) {
                null !== b.open && (b.plotOpen = a.translate(b.open, 0, 1, 0, 1));
                null !== b.close && (b.plotClose = a.translate(b.close, 0, 1, 0, 1))
            })
        },
        drawPoints: function () {
            var a = this,
                b = a.chart,
                c, d, e, f, g, h, m, q;
            D(a.points, function (r) {
                r.plotY !== G && (m = r.graphic, c = r.pointAttr[r.selected ? "selected" : ""] || a.pointAttr[""], f = c["stroke-width"] % 2 / 2, q = L(r.plotX) - f, g = L(r.shapeArgs.width / 2), h = ["M", q, L(r.yBottom), "L", q, L(r.plotY)], null !== r.open && (d = L(r.plotOpen) + f, h.push("M", q, d, "L", q - g, d)), null !== r.close && (e = L(r.plotClose) + f, h.push("M", q, e, "L", q + g, e)), m ? m.animate({
                    d: h
                }) : r.graphic = b.renderer.path(h).attr(c).add(a.group))
            })
        },
        animate: null
    });
    P.ohlc = fc;
    X.candlestick = E(X.column, {
        lineColor: "black",
        lineWidth: 1,
        states: {
            hover: {
                lineWidth: 2
            }
        },
        tooltip: X.ohlc.tooltip,
        threshold: null,
        upColor: "white"
    });
    var zc = M(fc, {
        type: "candlestick",
        pointAttrToOptions: {
            fill: "color",
            stroke: "lineColor",
            "stroke-width": "lineWidth"
        },
        upColorProp: "fill",
        getAttribs: function () {
            P.ohlc.prototype.getAttribs.apply(this, arguments);
            var a = this.options,
                b = a.states,
                c = a.upLineColor || a.lineColor,
                d = b.hover.upLineColor || c,
                e = b.select.upLineColor || c;
            D(this.points, function (a) {
                a.open < a.close && (a.pointAttr[""].stroke = c, a.pointAttr.hover.stroke = d, a.pointAttr.select.stroke = e)
            })
        },
        drawPoints: function () {
            var a = this,
                b = a.chart,
                c, d = a.pointAttr[""],
                e, f, g, h, m, q, r, k, t, p, l;
            D(a.points, function (A) {
                t = A.graphic;
                A.plotY !== G && (c = A.pointAttr[A.selected ? "selected" : ""] || d, r = c["stroke-width"] % 2 / 2, k = L(A.plotX) - r, e = A.plotOpen, f = A.plotClose, g = la.min(e, f), h = la.max(e, f), l = L(A.shapeArgs.width / 2), m = L(g) !== L(A.plotY), q = h !== A.yBottom, g = L(g) + r, h = L(h) + r, p = ["M", k - l, h, "L", k - l, g, "L", k + l, g, "L", k + l, h, "Z", "M", k, g, "L", k, m ? L(A.plotY) : g, "M", k, h, "L", k, q ? L(A.yBottom) : h], t ? t.animate({
                    d: p
                }) : A.graphic = b.renderer.path(p).attr(c).add(a.group).shadow(a.options.shadow))
            })
        }
    });
    P.candlestick = zc;
    var vb = Ca.prototype.symbols;
    X.flags = E(X.column, {
        fillColor: "white",
        lineWidth: 1,
        pointRange: 0,
        shape: "flag",
        stackDistance: 12,
        states: {
            hover: {
                lineColor: "black",
                fillColor: "#FCFFC5"
            }
        },
        style: {
            fontSize: "11px",
            fontWeight: "bold",
            textAlign: "center"
        },
        tooltip: {
            pointFormat: "{point.text}<br/>"
        },
        threshold: null,
        y: -30
    });
    P.flags = M(P.column, {
        type: "flags",
        sorted: !1,
        noSharedTooltip: !0,
        allowDG: !1,
        takeOrdinalPosition: !1,
        trackerGroups: ["markerGroup"],
        forceCrop: !0,
        init: V.prototype.init,
        pointAttrToOptions: {
            fill: "fillColor",
            stroke: "color",
            "stroke-width": "lineWidth",
            r: "radius"
        },
        translate: function () {
            P.column.prototype.translate.apply(this);
            var a = this.chart,
                b = this.points,
                c = b.length - 1,
                d, e, f = this.options.onSeries,
                f = (d = f && a.get(f)) && d.options.step,
                g = d && d.points,
                h = g && g.length,
                m = this.xAxis,
                q = m.getExtremes(),
                r, k, t;
            if (d && d.visible && h)
                for (d = d.currentDataGrouping, k = g[h - 1].x + (d ? d.totalRange : 0), b.sort(function (a, b) {
                    return a.x - b.x
                }); h-- && b[c] && !(d = b[c], r = g[h], r.x <= d.x && r.plotY !== G && (d.x <= k && (d.plotY = r.plotY, r.x < d.x && !f && (t = g[h + 1]) && t.plotY !== G && (d.plotY += (d.x - r.x) / (t.x - r.x) * (t.plotY - r.plotY))), c--, h++, 0 > c)););
            D(b, function (c, d) {
                c.plotY === G && (c.x >= q.min && c.x <= q.max ? c.plotY = a.chartHeight - m.bottom - (m.opposite ? m.height : 0) + m.offset - a.plotTop : c.shapeArgs = {});
                (e = b[d - 1]) && e.plotX === c.plotX && (e.stackIndex === G && (e.stackIndex = 0), c.stackIndex = e.stackIndex + 1)
            })
        },
        drawPoints: function () {
            var a, b = this.pointAttr[""],
                c = this.points,
                d = this.chart.renderer,
                e, f, g = this.options,
                h = g.y,
                m, q, r, k, t = g.lineWidth % 2 / 2,
                p, l;
            for (q = c.length; q--;) r = c[q], a = r.plotX > this.xAxis.len, e = r.plotX + (a ? t : -t), k = r.stackIndex, m = r.options.shape || g.shape, f = r.plotY, f !== G && (f = r.plotY + h + t - (k !== G && k * g.stackDistance)), p = k ? G : r.plotX + t, l = k ? G : r.plotY, k = r.graphic, f !== G && 0 <= e && !a ? (a = r.pointAttr[r.selected ? "select" : ""] || b, k ? k.attr({
                x: e,
                y: f,
                r: a.r,
                anchorX: p,
                anchorY: l
            }) : r.graphic = d.label(r.options.title || g.title || "A", e, f, m, p, l, g.useHTML).css(E(g.style, r.style)).attr(a).attr({
                align: "flag" === m ? "left" : "center",
                width: g.width,
                height: g.height
            }).add(this.markerGroup).shadow(g.shadow), r.tooltipPos = [e, f]) : k && (r.graphic = k.destroy())
        },
        drawTracker: function () {
            var a = this.points;
            $a.drawTrackerPoint.apply(this);
            D(a, function (b) {
                var c = b.graphic;
                c && W(c.element, "mouseover", function () {
                    0 < b.stackIndex && !b.raised && (b._y = c.y, c.attr({
                        y: b._y - 8
                    }), b.raised = !0);
                    D(a, function (a) {
                        a !== b && a.raised && a.graphic && (a.graphic.attr({
                            y: a._y
                        }), a.raised = !1)
                    })
                })
            })
        },
        animate: ma
    });
    vb.flag = function (a, b, c, d, e) {
        var f = e && e.anchorX || a;
        e = e && e.anchorY || b;
        return ["M", f, e, "L", a, b + d, a, b, a + c, b, a + c, b + d, a, b + d, "M", f, e, "Z"]
    };
    D(["circle", "square"], function (a) {
        vb[a + "pin"] = function (b, c, d, e, f) {
            var g = f && f.anchorX;
            f = f && f.anchorY;
            b = vb[a](b, c, d, e);
            g && f && b.push("M", g, c > f ? c : c + e, "L", g, f);
            return b
        }
    });
    Za === ga.VMLRenderer && D(["flag", "circlepin", "squarepin"], function (a) {
        ib.prototype.symbols[a] = vb[a]
    });
    var Nb = [].concat(ec),
        wb = function (a) {
            return Math[a].apply(0, rb(arguments, function (a) {
                return "number" === typeof a
            }))
        };
    Nb[4] = ["day", [1, 2, 3, 4]];
    Nb[5] = ["week", [1, 2, 3]];
    n(ha, {
        navigator: {
            handles: {
                backgroundColor: "#ebe7e8",
                borderColor: "#b2b1b6"
            },
            height: 40,
            margin: 25,
            maskFill: "rgba(128,179,236,0.3)",
            maskInside: !0,
            outlineColor: "#b2b1b6",
            outlineWidth: 1,
            series: {
                type: P.areaspline === G ? "line" : "areaspline",
                color: "#4572A7",
                compare: null,
                fillOpacity: .05,
                dataGrouping: {
                    approximation: "average",
                    enabled: !0,
                    groupPixelWidth: 2,
                    smoothed: !0,
                    units: Nb
                },
                dataLabels: {
                    enabled: !1,
                    zIndex: 2
                },
                id: "highcharts-navigator-series",
                lineColor: "#4572A7",
                lineWidth: 1,
                marker: {
                    enabled: !1
                },
                pointRange: 0,
                shadow: !1,
                threshold: null
            },
            xAxis: {
                tickWidth: 0,
                lineWidth: 0,
                gridLineColor: "#EEE",
                gridLineWidth: 1,
                tickPixelInterval: 200,
                labels: {
                    align: "left",
                    style: {
                        color: "#888"
                    },
                    x: 3,
                    y: -4
                },
                crosshair: !1
            },
            yAxis: {
                gridLineWidth: 0,
                startOnTick: !1,
                endOnTick: !1,
                minPadding: .1,
                maxPadding: .1,
                labels: {
                    enabled: !1
                },
                crosshair: !1,
                title: {
                    text: null
                },
                tickWidth: 0
            }
        },
        scrollbar: {
            height: eb ? 20 : 14,
            barBackgroundColor: "#bfc8d1",
            barBorderRadius: 0,
            barBorderWidth: 1,
            barBorderColor: "#bfc8d1",
            buttonArrowColor: "#666",
            buttonBackgroundColor: "#ebe7e8",
            buttonBorderColor: "#bbb",
            buttonBorderRadius: 0,
            buttonBorderWidth: 1,
            minWidth: 6,
            rifleColor: "#666",
            trackBackgroundColor: "#eeeeee",
            trackBorderColor: "#eeeeee",
            trackBorderWidth: 1,
            liveRedraw: wa && !eb
        }
    });
    ab.prototype = {
        drawHandle: function (a, b) {
            var c = this.chart,
                d = c.renderer,
                e = this.elementsToDestroy,
                f = this.handles,
                g = this.navigatorOptions.handles,
                g = {
                    fill: g.backgroundColor,
                    stroke: g.borderColor,
                    "stroke-width": 1
                }, h;
            this.rendered || (f[b] = d.g("navigator-handle-" + ["left", "right"][b]).css({
                cursor: "e-resize"
            }).attr({
                zIndex: 4 - b
            }).add(), h = d.rect(-4.5, 0, 9, 16, 0, 1).attr(g).add(f[b]), e.push(h), h = d.path(["M", -1.5, 4, "L", -1.5, 12, "M", .5, 4, "L", .5, 12]).attr(g).add(f[b]), e.push(h));
            f[b][c.isResizing ? "animate" : "attr"]({
                translateX: this.scrollerLeft + this.scrollbarHeight + parseInt(a, 10),
                translateY: this.top + this.height / 2 - 8
            })
        },
        drawScrollbarButton: function (a) {
            var b = this.chart.renderer,
                c = this.elementsToDestroy,
                d = this.scrollbarButtons,
                e = this.scrollbarHeight,
                f = this.scrollbarOptions,
                g;
            this.rendered || (d[a] = b.g().add(this.scrollbarGroup), g = b.rect(-.5, -.5, e + 1, e + 1, f.buttonBorderRadius, f.buttonBorderWidth).attr({
                stroke: f.buttonBorderColor,
                "stroke-width": f.buttonBorderWidth,
                fill: f.buttonBackgroundColor
            }).add(d[a]), c.push(g), g = b.path(["M", e / 2 + (a ? -1 : 1), e / 2 - 3, "L", e / 2 + (a ? -1 : 1), e / 2 + 3, e / 2 + (a ? 2 : -2), e / 2]).attr({
                fill: f.buttonArrowColor
            }).add(d[a]), c.push(g));
            a && d[a].attr({
                translateX: this.scrollerWidth - e
            })
        },
        render: function (a, b, c, d) {
            var e = this.chart,
                f = e.renderer,
                g, h, m, q, r = this.scrollbarGroup,
                k = this.navigatorGroup,
                t = this.scrollbar,
                k = this.xAxis,
                l = this.scrollbarTrack,
                A = this.scrollbarHeight,
                F = this.scrollbarEnabled,
                n = this.navigatorOptions,
                B = this.scrollbarOptions,
                u = B.minWidth,
                D = this.height,
                R = this.top,
                y = this.navigatorEnabled,
                C = n.outlineWidth,
                w = C / 2,
                J = 0,
                da = this.outlineHeight,
                E = B.barBorderRadius,
                G = B.barBorderWidth,
                I = R + w,
                ea;
            if (!isNaN(a)) {
                this.navigatorLeft = g = p(k.left, e.plotLeft + A);
                this.navigatorWidth = h = p(k.len, e.plotWidth - 2 * A);
                this.scrollerLeft = m = g - A;
                this.scrollerWidth = q = q = h + 2 * A;
                k.getExtremes && (ea = this.getUnionExtremes(!0), !ea || ea.dataMin === k.min && ea.dataMax === k.max || k.setExtremes(ea.dataMin, ea.dataMax, !0, !1));
                c = p(c, k.translate(a));
                d = p(d, k.translate(b));
                if (isNaN(c) || Infinity === ka(c)) c = 0, d = q;
                if (!(k.translate(d, !0) - k.translate(c, !0) < e.xAxis[0].minRange)) {
                    this.zoomedMax = U(N(c, d), h);
                    this.zoomedMin = N(this.fixedWidth ? this.zoomedMax - this.fixedWidth : U(c, d), 0);
                    this.range = this.zoomedMax - this.zoomedMin;
                    c = L(this.zoomedMax);
                    b = L(this.zoomedMin);
                    a = c - b;
                    this.rendered || (y && (this.navigatorGroup = k = f.g("navigator").attr({
                        zIndex: 3
                    }).add(), this.leftShade = f.rect().attr({
                        fill: n.maskFill
                    }).add(k), n.maskInside || (this.rightShade = f.rect().attr({
                        fill: n.maskFill
                    }).add(k)), this.outline = f.path().attr({
                        "stroke-width": C,
                        stroke: n.outlineColor
                    }).add(k)), F && (this.scrollbarGroup = r = f.g("scrollbar").add(), t = B.trackBorderWidth, this.scrollbarTrack = l = f.rect().attr({
                        x: 0,
                        y: -t % 2 / 2,
                        fill: B.trackBackgroundColor,
                        stroke: B.trackBorderColor,
                        "stroke-width": t,
                        r: B.trackBorderRadius || 0,
                        height: A
                    }).add(r), this.scrollbar = t = f.rect().attr({
                        y: -G % 2 / 2,
                        height: A,
                        fill: B.barBackgroundColor,
                        stroke: B.barBorderColor,
                        "stroke-width": G,
                        r: E
                    }).add(r), this.scrollbarRifles = f.path().attr({
                        stroke: B.rifleColor,
                        "stroke-width": 1
                    }).add(r)));
                    e = e.isResizing ? "animate" : "attr";
                    if (y) {
                        this.leftShade[e](n.maskInside ? {
                            x: g + b,
                            y: R,
                            width: c - b,
                            height: D
                        } : {
                            x: g,
                            y: R,
                            width: b,
                            height: D
                        });
                        if (this.rightShade) this.rightShade[e]({
                            x: g + c,
                            y: R,
                            width: h - c,
                            height: D
                        });
                        this.outline[e]({
                            d: ["M", m, I, "L", g + b + w, I, g + b + w, I + da, "L", g + c - w, I + da, "L", g + c - w, I, m + q, I].concat(n.maskInside ? ["M", g + b + w, I, "L", g + c - w, I] : [])
                        });
                        this.drawHandle(b + w, 0);
                        this.drawHandle(c + w, 1)
                    }
                    F && r && (this.drawScrollbarButton(0), this.drawScrollbarButton(1), r[e]({
                        translateX: m,
                        translateY: L(I + D)
                    }), l[e]({
                        width: q
                    }), g = A + b, h = a - G, h < u && (J = (u - h) / 2, h = u, g -= J), this.scrollbarPad = J, t[e]({
                        x: fa(g) + G % 2 / 2,
                        width: h
                    }), u = A + b + a / 2 - .5, this.scrollbarRifles.attr({
                        visibility: 12 < a ? "visible" : "hidden"
                    })[e]({
                        d: ["M",
                            u - 3, A / 4, "L", u - 3, 2 * A / 3, "M", u, A / 4, "L", u, 2 * A / 3, "M", u + 3, A / 4, "L", u + 3, 2 * A / 3
                        ]
                    }));
                    this.scrollbarPad = J;
                    this.rendered = !0
                }
            }
        },
        addEvents: function () {
            var a = this.chart.container,
                b = this.mouseDownHandler,
                c = this.mouseMoveHandler,
                d = this.mouseUpHandler,
                e;
            e = [
                [a, "mousedown", b],
                [a, "mousemove", c],
                [document, "mouseup", d]
            ];
            db && e.push([a, "touchstart", b], [a, "touchmove", c], [document, "touchend", d]);
            D(e, function (a) {
                W.apply(null, a)
            });
            this._events = e
        },
        removeEvents: function () {
            D(this._events, function (a) {
                pa.apply(null, a)
            });
            this._events = G;
            this.navigatorEnabled && this.baseSeries && pa(this.baseSeries, "updatedData", this.updatedDataHandler)
        },
        init: function () {
            var a = this,
                b = a.chart,
                c, d, e = a.scrollbarHeight,
                f = a.navigatorOptions,
                g = a.height,
                h = a.top,
                m, q, r = document.body.style,
                v, t = a.baseSeries;
            a.mouseDownHandler = function (d) {
                d = b.pointer.normalize(d);
                var e = a.zoomedMin,
                    f = a.zoomedMax,
                    h = a.top,
                    q = a.scrollbarHeight,
                    k = a.scrollerLeft,
                    t = a.scrollerWidth,
                    p = a.navigatorLeft,
                    l = a.navigatorWidth,
                    A = a.scrollbarPad,
                    x = a.range,
                    z = d.chartX,
                    F = d.chartY;
                d = b.xAxis[0];
                var n,
                    B = eb ? 10 : 7;
                F > h && F < h + g + q && ((h = !a.scrollbarEnabled || F < h + g) && la.abs(z - e - p) < B ? (a.grabbedLeft = !0, a.otherHandlePos = f, a.fixedExtreme = d.max, b.fixedRange = null) : h && la.abs(z - f - p) < B ? (a.grabbedRight = !0, a.otherHandlePos = e, a.fixedExtreme = d.min, b.fixedRange = null) : z > p + e - A && z < p + f + A ? (a.grabbedCenter = z, a.fixedWidth = x, b.renderer.isSVG && (v = r.cursor, r.cursor = "ew-resize"), m = z - e) : z > k && z < k + t && (f = h ? z - p - x / 2 : z < p ? e - .2 * x : z > k + t - q ? e + .2 * x : z < p + e ? e - x : f, 0 > f ? f = 0 : f + x >= l && (f = l - x, n = c.dataMax), f !== e && (a.fixedWidth = x, e = c.toFixedRange(f, f + x, null, n), d.setExtremes(e.min, e.max, !0, !1, {
                    trigger: "navigator"
                }))))
            };
            a.mouseMoveHandler = function (c) {
                var d = a.scrollbarHeight,
                    e = a.navigatorLeft,
                    f = a.navigatorWidth,
                    g = a.scrollerLeft,
                    h = a.scrollerWidth,
                    r = a.range,
                    k;
                0 !== c.pageX && (c = b.pointer.normalize(c), k = c.chartX, k < e ? k = e : k > g + h - d && (k = g + h - d), a.grabbedLeft ? (q = !0, a.render(0, 0, k - e, a.otherHandlePos)) : a.grabbedRight ? (q = !0, a.render(0, 0, a.otherHandlePos, k - e)) : a.grabbedCenter && (q = !0, k < m ? k = m : k > f + m - r && (k = f + m - r), a.render(0, 0, k - m, k - m + r)), q && a.scrollbarOptions.liveRedraw && setTimeout(function () {
                    a.mouseUpHandler(c)
                }, 0))
            };
            a.mouseUpHandler = function (d) {
                var e, f;
                q && (a.zoomedMin === a.otherHandlePos ? e = a.fixedExtreme : a.zoomedMax === a.otherHandlePos && (f = a.fixedExtreme), e = c.toFixedRange(a.zoomedMin, a.zoomedMax, e, f), b.xAxis[0].setExtremes(e.min, e.max, !0, !1, {
                    trigger: "navigator",
                    triggerOp: "navigator-drag",
                    DOMEvent: d
                }));
                "mousemove" !== d.type && (a.grabbedLeft = a.grabbedRight = a.grabbedCenter = a.fixedWidth = a.fixedExtreme = a.otherHandlePos = q = m = null, r.cursor = v || "")
            };
            var l = b.xAxis.length,
                A = b.yAxis.length;
            b.extraBottomMargin = a.outlineHeight + f.margin;
            a.navigatorEnabled ? (a.xAxis = c = new T(b, E({
                ordinal: t && t.xAxis.options.ordinal
            }, f.xAxis, {
                id: "navigator-x-axis",
                isX: !0,
                type: "datetime",
                index: l,
                height: g,
                offset: 0,
                offsetLeft: e,
                offsetRight: -e,
                keepOrdinalPadding: !0,
                startOnTick: !1,
                endOnTick: !1,
                minPadding: 0,
                maxPadding: 0,
                zoomEnabled: !1
            })), a.yAxis = d = new T(b, E(f.yAxis, {
                id: "navigator-y-axis",
                alignTicks: !1,
                height: g,
                offset: 0,
                index: A,
                zoomEnabled: !1
            })), t || f.series.data ? a.addBaseSeries() : 0 === b.series.length && k(b, "redraw", function (c, d) {
                0 < b.series.length && !a.series && (a.setBaseSeries(), b.redraw = c);
                c.call(b, d)
            })) : a.xAxis = c = {
                translate: function (a, c) {
                    var d = b.xAxis[0],
                        f = d.getExtremes(),
                        g = b.plotWidth - 2 * e,
                        h = wb("min", d.options.min, f.dataMin),
                        d = wb("max", d.options.max, f.dataMax) - h;
                    return c ? a * d / g + h : g * (a - h) / d
                },
                toFixedRange: T.prototype.toFixedRange
            };
            k(b, "getMargins", function (b) {
                var e = this.legend,
                    f = e.options;
                b.call(this);
                a.top = h = a.navigatorOptions.top || this.chartHeight - a.height - a.scrollbarHeight - this.spacing[2] - ("bottom" === f.verticalAlign && f.enabled && !f.floating ? e.legendHeight + p(f.margin, 10) : 0);
                c && d && (c.options.top = d.options.top = h, c.setAxisSize(), d.setAxisSize())
            });
            a.addEvents()
        },
        getUnionExtremes: function (a) {
            var b = this.chart.xAxis[0],
                c = this.xAxis,
                d = c.options,
                e = b.options;
            if (!a || null !== b.dataMin) return {
                dataMin: wb("min", d && d.min, e.min, b.dataMin, c.dataMin),
                dataMax: wb("max", d && d.max, e.max, b.dataMax, c.dataMax)
            }
        },
        setBaseSeries: function (a) {
            var b = this.chart;
            a = a || b.options.navigator.baseSeries;
            this.series && this.series.remove();
            this.baseSeries = b.series[a] || "string" === typeof a && b.get(a) || b.series[0];
            this.xAxis && this.addBaseSeries()
        },
        addBaseSeries: function () {
            var a = this.baseSeries,
                b = a ? a.options : {}, c = b.data,
                d = this.navigatorOptions.series,
                e;
            e = d.data;
            this.hasNavigatorData = !!e;
            b = E(b, d, {
                enableMouseTracking: !1,
                group: "nav",
                padXAxis: !1,
                xAxis: "navigator-x-axis",
                yAxis: "navigator-y-axis",
                name: "Navigator",
                showInLegend: !1,
                isInternal: !0,
                visible: !0
            });
            b.data = e || c;
            this.series = this.chart.initSeries(b);
            a && !1 !== this.navigatorOptions.adaptToUpdatedData && (W(a, "updatedData", this.updatedDataHandler), a.userOptions.events = n(a.userOptions.event, {
                updatedData: this.updatedDataHandler
            }))
        },
        updatedDataHandler: function () {
            var a = this.chart.scroller,
                b = a.baseSeries,
                c = b.xAxis,
                d = c.getExtremes(),
                e = d.min,
                f = d.max,
                g = d.dataMin,
                d = d.dataMax,
                h = f - e,
                m, q, r, k, t, p = a.series;
            m = p.xData;
            var l = !!c.setExtremes;
            q = f >= m[m.length - 1] - (this.closestPointRange || 0);
            m = e <= g;
            a.hasNavigatorData || (p.options.pointStart = b.xData[0], p.setData(b.options.data, !1), t = !0);
            m && (k = g, r = k + h);
            q && (r = d, m || (k = N(r - h, p.xData[0])));
            l && (m || q) ? isNaN(k) || c.setExtremes(k, r, !0, !1, {
                trigger: "updatedData"
            }) : (t && this.chart.redraw(!1), a.render(N(e, g), U(f, d)))
        },
        destroy: function () {
            this.removeEvents();
            D([this.xAxis, this.yAxis, this.leftShade, this.rightShade, this.outline, this.scrollbarTrack, this.scrollbarRifles, this.scrollbarGroup, this.scrollbar], function (a) {
                a && a.destroy && a.destroy()
            });
            this.xAxis = this.yAxis = this.leftShade = this.rightShade = this.outline = this.scrollbarTrack = this.scrollbarRifles = this.scrollbarGroup = this.scrollbar = null;
            D([this.scrollbarButtons,
                this.handles, this.elementsToDestroy
            ], function (a) {
                ca(a)
            })
        }
    };
    ga.Scroller = ab;
    k(T.prototype, "zoom", function (a, b, c) {
        var d = this.chart,
            e = d.options,
            f = e.chart.zoomType,
            g = e.navigator,
            e = e.rangeSelector,
            h;
        this.isXAxis && (g && g.enabled || e && e.enabled) && ("x" === f ? d.resetZoomButton = "blocked" : "y" === f ? h = !1 : "xy" === f && (d = this.previousZoom, u(b) ? this.previousZoom = [this.min, this.max] : d && (b = d[0], c = d[1], delete this.previousZoom)));
        return h !== G ? h : a.call(this, b, c)
    });
    k(na.prototype, "init", function (a, b, c) {
        W(this, "beforeRender", function () {
            var a = this.options;
            if (a.navigator.enabled || a.scrollbar.enabled) this.scroller = new ab(this)
        });
        a.call(this, b, c)
    });
    k(V.prototype, "addPoint", function (a, b, c, d, e) {
        var f = this.options.turboThreshold;
        f && this.xData.length > f && Q(b) && !S(b) && this.chart.scroller && Aa(20, !0);
        a.call(this, b, c, d, e)
    });
    n(ha, {
        rangeSelector: {
            buttonTheme: {
                width: 28,
                height: 18,
                fill: "#f7f7f7",
                padding: 2,
                r: 0,
                "stroke-width": 0,
                style: {
                    color: "#444",
                    cursor: "pointer",
                    fontWeight: "normal"
                },
                zIndex: 7,
                states: {
                    hover: {
                        fill: "#e7e7e7"
                    },
                    select: {
                        fill: "#e7f0f9",
                        style: {
                            color: "black",
                            fontWeight: "bold"
                        }
                    }
                }
            },
            inputPosition: {
                align: "right"
            },
            labelStyle: {
                color: "#666"
            }
        }
    });
    ha.lang = E(ha.lang, {
        rangeSelectorZoom: "Zoom",
        rangeSelectorFrom: "From",
        rangeSelectorTo: "To"
    });
    bb.prototype = {
        clickButton: function (a, b) {
            var c = this,
                d = c.selected,
                e = c.chart,
                f = c.buttons,
                g = c.buttonOptions[a],
                h = e.xAxis[0],
                m = e.scroller && e.scroller.getUnionExtremes() || h || {}, q = m.dataMin,
                r = m.dataMax,
                k, t = h && L(U(h.max, p(r, h.max))),
                l = new ua(t),
                A = g.type,
                F = g.count,
                m = g._range,
                n;
            if (null !== q && null !== r && a !== c.selected) {
                if ("month" === A || "year" === A) k = {
                    month: "Month",
                    year: "FullYear"
                }[A], l["set" + k](l["get" + k]() - F), k = l.getTime(), q = p(q, Number.MIN_VALUE), isNaN(k) || k < q ? (k = q, t = U(k + m, r)) : m = t - k;
                else if (m) k = N(t - m, q), t = U(k + m, r);
                else if ("ytd" === A)
                    if (h) r === G && (q = Number.MAX_VALUE, r = Number.MIN_VALUE, D(e.series, function (a) {
                        a = a.xData;
                        q = U(a[0], q);
                        r = N(a[a.length - 1], r)
                    }), b = !1), t = new ua(r), n = t.getFullYear(), k = n = N(q || 0, ua.UTC(n, 0, 1)), t = t.getTime(), t = U(r || t, t);
                    else {
                        W(e, "beforeRender", function () {
                            c.clickButton(a)
                        });
                        return
                    } else "all" === A && h && (k = q, t = r);
                f[d] && f[d].setState(0);
                f[a] && f[a].setState(2);
                e.fixedRange = m;
                h ? h.setExtremes(k, t, p(b, 1), 0, {
                    trigger: "rangeSelectorButton",
                    rangeSelectorButton: g
                }) : (d = e.options.xAxis, d[0] = E(d[0], {
                    range: m,
                    min: n
                }));
                c.setSelected(a)
            }
        },
        setSelected: function (a) {
            this.selected = this.options.selected = a
        },
        defaultButtons: [{
            type: "month",
            count: 1,
            text: "1m"
        }, {
            type: "month",
            count: 3,
            text: "3m"
        }, {
            type: "month",
            count: 6,
            text: "6m"
        }, {
            type: "ytd",
            text: "YTD"
        }, {
            type: "year",
            count: 1,
            text: "1y"
        }, {
            type: "all",
            text: "All"
        }],
        init: function (a) {
            var b = this,
                c = a.options.rangeSelector,
                d = c.buttons || [].concat(b.defaultButtons),
                e = c.selected,
                f = b.blurInputs = function () {
                    var a = b.minInput,
                        c = b.maxInput;
                    a && a.blur && ja(a, "blur");
                    c && c.blur && ja(c, "blur")
                };
            b.chart = a;
            b.options = c;
            b.buttons = [];
            a.extraTopMargin = 35;
            b.buttonOptions = d;
            W(a.container, "mousedown", f);
            W(a, "resize", f);
            D(d, b.computeButtonRange);
            e !== G && d[e] && this.clickButton(e, !1);
            W(a, "load", function () {
                W(a.xAxis[0], "afterSetExtremes", function () {
                    b.updateButtonStates(!0)
                })
            })
        },
        updateButtonStates: function (a) {
            var b = this,
                c = this.chart,
                d = c.xAxis[0],
                e = c.scroller && c.scroller.getUnionExtremes() || d,
                f = e.dataMin,
                g = e.dataMax,
                h = b.selected,
                m = b.options.allButtonsEnabled,
                q = b.buttons;
            a && c.fixedRange !== L(d.max - d.min) && (q[h] && q[h].setState(0), b.setSelected(null));
            D(b.buttonOptions, function (a, c) {
                var e = a._range,
                    k = e > g - f,
                    t = e < d.minRange,
                    p = "all" === a.type && d.max - d.min >= g - f && 2 !== q[c].state,
                    l = "ytd" === a.type && Ha("%Y", f) === Ha("%Y", g);
                e === L(d.max - d.min) && c !== h ? (b.setSelected(c), q[c].setState(2)) : !m && (k || t || p || l) ? q[c].setState(3) : 3 === q[c].state && q[c].setState(0)
            })
        },
        computeButtonRange: function (a) {
            var b = a.type,
                c = a.count || 1,
                d = {
                    millisecond: 1,
                    second: 1E3,
                    minute: 6E4,
                    hour: 36E5,
                    day: 864E5,
                    week: 6048E5
                };
            if (d[b]) a._range = d[b] * c;
            else if ("month" === b || "year" === b) a._range = 864E5 * {
                    month: 30,
                    year: 365
                }[b] * c
        },
        setInputValue: function (a, b) {
            var c = this.chart.options.rangeSelector;
            u(b) && (this[a + "Input"].HCTime = b);
            this[a + "Input"].value = Ha(c.inputEditDateFormat || "%Y-%m-%d", this[a + "Input"].HCTime);
            this[a + "DateBox"].attr({
                text: Ha(c.inputDateFormat || "%b %e, %Y", this[a + "Input"].HCTime)
            })
        },
        drawInput: function (a) {
            var b = this,
                c = b.chart,
                d = c.renderer.style,
                e = c.renderer,
                f = c.options.rangeSelector,
                g = b.div,
                h = "min" === a,
                m, q, r, k = this.inputGroup;
            this[a + "Label"] = q = e.label(ha.lang[h ? "rangeSelectorFrom" : "rangeSelectorTo"], this.inputGroup.offset).attr({
                padding: 2
            }).css(E(d, f.labelStyle)).add(k);
            k.offset += q.width + 5;
            this[a + "DateBox"] = r = e.label("", k.offset).attr({
                padding: 2,
                width: f.inputBoxWidth || 90,
                height: f.inputBoxHeight || 17,
                stroke: f.inputBoxBorderColor || "silver",
                "stroke-width": 1
            }).css(E({
                textAlign: "center",
                color: "#444"
            }, d, f.inputStyle)).on("click", function () {
                b[a + "Input"].focus()
            }).add(k);
            k.offset += r.width + (h ? 10 : 0);
            this[a + "Input"] = m = K("input", {
                name: a,
                className: "highcharts-range-selector",
                type: "text"
            }, n({
                position: "absolute",
                border: 0,
                width: "1px",
                height: "1px",
                padding: 0,
                textAlign: "center",
                fontSize: d.fontSize,
                fontFamily: d.fontFamily,
                top: c.plotTop + "px"
            }, f.inputStyle), g);
            m.onfocus = function () {
                I(this, {
                    left: k.translateX + r.x + "px",
                    top: k.translateY + "px",
                    width: r.width - 2 + "px",
                    height: r.height - 2 + "px",
                    border: "2px solid silver"
                })
            };
            m.onblur = function () {
                I(this, {
                    border: 0,
                    width: "1px",
                    height: "1px"
                });
                b.setInputValue(a)
            };
            m.onchange = function () {
                var a = m.value,
                    d = (f.inputDateParser || ua.parse)(a),
                    e = c.xAxis[0],
                    g = e.dataMin,
                    q = e.dataMax;
                isNaN(d) && (d = a.split("-"), d = ua.UTC(O(d[0]), O(d[1]) - 1, O(d[2])));
                isNaN(d) || (ha.global.useUTC || (d += 6E4 * (new ua).getTimezoneOffset()), h ? d > b.maxInput.HCTime ? d = G : d < g && (d = g) : d < b.minInput.HCTime ? d = G : d > q && (d = q), d !== G && c.xAxis[0].setExtremes(h ? d : e.min, h ? e.max : d, G, G, {
                    trigger: "rangeSelectorInput"
                }))
            }
        },
        render: function (a, b) {
            var c = this,
                d = c.chart,
                e = d.renderer,
                f = d.container,
                g = d.options,
                h = g.exporting && g.navigation && g.navigation.buttonOptions,
                m = g.rangeSelector,
                q = c.buttons,
                g = ha.lang,
                r = c.div,
                r = c.inputGroup,
                k = m.buttonTheme,
                t = !1 !== m.inputEnabled,
                l = k && k.states,
                A = d.plotLeft,
                F;
            c.rendered || (c.zoomText = e.text(g.rangeSelectorZoom, A, d.plotTop - 20).css(m.labelStyle).add(), F = A + c.zoomText.getBBox().width + 5, D(c.buttonOptions, function (a, b) {
                q[b] = e.button(a.text, F, d.plotTop - 35, function () {
                    c.clickButton(b);
                    c.isActive = !0
                }, k, l && l.hover, l && l.select).css({
                    textAlign: "center"
                }).add();
                F += q[b].width + p(m.buttonSpacing, 5);
                c.selected === b && q[b].setState(2)
            }), c.updateButtonStates(), t && (c.div = r = K("div", null, {
                position: "relative",
                height: 0,
                zIndex: 1
            }), f.parentNode.insertBefore(r, f), c.inputGroup = r = e.g("input-group").add(), r.offset = 0, c.drawInput("min"), c.drawInput("max")));
            t && (f = d.plotTop - 45, r.align(n({
                y: f,
                width: r.offset,
                x: h && f < (h.y || 0) + h.height - d.spacing[0] ? -40 : 0
            }, m.inputPosition), !0, d.spacingBox), c.setInputValue("min", a), c.setInputValue("max", b));
            c.rendered = !0
        },
        destroy: function () {
            var a = this.minInput,
                b = this.maxInput,
                c = this.chart,
                d = this.blurInputs,
                e;
            pa(c.container, "mousedown", d);
            pa(c, "resize", d);
            ca(this.buttons);
            a && (a.onfocus = a.onblur = a.onchange = null);
            b && (b.onfocus = b.onblur = b.onchange = null);
            for (e in this) this[e] && "chart" !== e && (this[e].destroy ? this[e].destroy() : this[e].nodeType && Va(this[e])), this[e] = null
        }
    };
    T.prototype.toFixedRange = function (a, b, c, d) {
        var e = this.chart && this.chart.fixedRange;
        a = p(c, this.translate(a, !0));
        b = p(d, this.translate(b, !0));
        c = e && (b - a) / e;
        .7 < c && 1.3 > c && (d ? a = b - e : b = a + e);
        return {
            min: a,
            max: b
        }
    };
    k(na.prototype, "init", function (a, b, c) {
        W(this, "init", function () {
            this.options.rangeSelector.enabled && (this.rangeSelector = new bb(this))
        });
        a.call(this, b, c)
    });
    ga.RangeSelector = bb;
    na.prototype.callbacks.push(function (a) {
        function b() {
            f = a.xAxis[0].getExtremes();
            g.render(f.min, f.max)
        }

        function c() {
            f = a.xAxis[0].getExtremes();
            isNaN(f.min) || h.render(f.min, f.max)
        }

        function d(a) {
            "navigator-drag" !== a.triggerOp && g.render(a.min, a.max)
        }

        function e(a) {
            h.render(a.min, a.max)
        }

        var f, g = a.scroller,
            h = a.rangeSelector;
        g && (W(a.xAxis[0], "afterSetExtremes", d), k(a, "drawChartBox", function (a) {
            var c = this.isDirtyBox;
            a.call(this);
            c && b()
        }), b());
        h && (W(a.xAxis[0], "afterSetExtremes", e), W(a, "resize", c), c());
        W(a, "destroy", function () {
            g && pa(a.xAxis[0], "afterSetExtremes", d);
            h && (pa(a, "resize", c), pa(a.xAxis[0], "afterSetExtremes", e))
        })
    });
    ga.StockChart = function (a, b) {
        var c = a.series,
            d, e = p(a.navigator && a.navigator.enabled, !0) ? {
                startOnTick: !1,
                endOnTick: !1
            } : null,
            f = {
                marker: {
                    enabled: !1,
                    radius: 2
                },
                states: {
                    hover: {
                        lineWidth: 2
                    }
                }
            }, g = {
                shadow: !1,
                borderWidth: 0
            };
        a.xAxis = Fa(w(a.xAxis || {}), function (a) {
            return E({
                minPadding: 0,
                maxPadding: 0,
                ordinal: !0,
                title: {
                    text: null
                },
                labels: {
                    overflow: "justify"
                },
                showLastLabel: !0
            }, a, {
                type: "datetime",
                categories: null
            }, e)
        });
        a.yAxis = Fa(w(a.yAxis || {}), function (a) {
            d = p(a.opposite, !0);
            return E({
                labels: {
                    y: -2
                },
                opposite: d,
                showLastLabel: !1,
                title: {
                    text: null
                }
            }, a)
        });
        a.series = null;
        a = E({
            chart: {
                panning: !0,
                pinchType: "x"
            },
            navigator: {
                enabled: !0
            },
            scrollbar: {
                enabled: !0
            },
            rangeSelector: {
                enabled: !0
            },
            title: {
                text: null,
                style: {
                    fontSize: "16px"
                }
            },
            tooltip: {
                shared: !0,
                crosshairs: !0
            },
            legend: {
                enabled: !1
            },
            plotOptions: {
                line: f,
                spline: f,
                area: f,
                areaspline: f,
                arearange: f,
                areasplinerange: f,
                column: g,
                columnrange: g,
                candlestick: g,
                ohlc: g
            }
        }, a, {
            _stock: !0,
            chart: {
                inverted: !1
            }
        });
        a.series = c;
        return new na(a, b)
    };
    k(Ta.prototype, "init", function (a, b, c) {
        var d = c.chart.pinchType || "";
        a.call(this, b, c);
        this.pinchX = this.pinchHor = -1 !== d.indexOf("x");
        this.pinchY = this.pinchVert = -1 !== d.indexOf("y");
        this.hasZoom = this.hasZoom || this.pinchHor || this.pinchVert
    });
    k(T.prototype, "autoLabelAlign", function (a) {
        var b = this.chart,
            c = this.options,
            b = b._labelPanes = b._labelPanes || {}, d = this.options.labels;
        return this.chart.options._stock && "yAxis" === this.coll && (c = c.top + "," + c.height, !b[c] && d.enabled) ? (15 === d.x && (d.x = 0), void 0 === d.align && (d.align = "right"), b[c] = 1, "right") : a.call(this, [].slice.call(arguments, 1))
    });
    T.prototype.getPlotLinePath = function (a, b, c, d, e) {
        var f = this,
            g = this.isLinked && !this.series ? this.linkedParent.series : this.series,
            h = f.chart,
            m = h.renderer,
            q = f.left,
            r = f.top,
            k, t, l, A, F = [],
            n, B;
        if ("xAxis" === f.coll || "yAxis" === f.coll) n = f.isXAxis ? u(f.options.yAxis) ? [h.yAxis[f.options.yAxis]] : Fa(g, function (a) {
            return a.yAxis
        }) : u(f.options.xAxis) ? [h.xAxis[f.options.xAxis]] : Fa(g, function (a) {
            return a.xAxis
        });
        D(f.isXAxis ? h.yAxis : h.xAxis, function (a) {
            if (u(a.options.id) ? -1 === a.options.id.indexOf("navigator") : 1) {
                var b = a.isXAxis ? "yAxis" : "xAxis",
                    b = u(a.options[b]) ? h[b][a.options[b]] : h[b][0];
                f === b && n.push(a)
            }
        });
        B = n.length ? [] : [f];
        D(n, function (a) {
            -1 === Ra(a, B) && B.push(a)
        });
        e = p(e, f.translate(a, null, null, c));
        isNaN(e) || (f.horiz ? D(B, function (a) {
            t = a.top;
            A = t + a.len;
            k = l = L(e + f.transB);
            (k >= q && k <= q + f.width || d) && F.push("M", k, t, "L", l, A)
        }) : D(B, function (a) {
            k = a.left;
            l = k + a.width;
            t = A = L(r + f.height - e);
            (t >= r && t <= r + f.height || d) && F.push("M", k, t, "L", l, A)
        }));
        if (0 < F.length) return m.crispPolyLine(F, b || 1)
    };
    T.prototype.getPlotBandPath = function (a, b) {
        var c = this.getPlotLinePath(b),
            d = this.getPlotLinePath(a),
            e = [],
            f;
        if (d && c)
            for (f = 0; f < d.length; f += 6) e.push("M", d[f + 1], d[f + 2], "L", d[f + 4], d[f + 5], c[f + 4], c[f + 5], c[f + 1], c[f + 2]);
        else e = null;
        return e
    };
    Ca.prototype.crispPolyLine = function (a, b) {
        var c;
        for (c = 0; c < a.length; c += 6) a[c + 1] === a[c + 4] && (a[c + 1] = a[c + 4] = L(a[c + 1]) - b % 2 / 2), a[c + 2] === a[c + 5] && (a[c + 2] = a[c + 5] = L(a[c + 2]) + b % 2 / 2);
        return a
    };
    Za === ga.VMLRenderer && (ib.prototype.crispPolyLine = Ca.prototype.crispPolyLine);
    k(T.prototype, "hideCrosshair", function (a, b) {
        a.call(this, b);
        u(this.crossLabelArray) && (u(b) ? this.crossLabelArray[b] && this.crossLabelArray[b].hide() : D(this.crossLabelArray, function (a) {
            a.hide()
        }))
    });
    k(T.prototype, "drawCrosshair", function (a, b, c) {
        var d, e;
        a.call(this, b, c);
        if (u(this.crosshair.label) && this.crosshair.label.enabled && u(c)) {
            e = this.chart;
            var f = this.options.crosshair.label,
                g = this.isXAxis ? "x" : "y";
            d = this.horiz;
            var h = this.opposite,
                m = this.left,
                q = this.top;
            a = this.crossLabel;
            var k, l = f.format,
                A = "";
            a || (a = this.crossLabel = e.renderer.label().attr({
                align: f.align || (d ? "center" : h ? "right" === this.labelAlign ? "right" : "left" : "left" === this.labelAlign ? "left" : "center"),
                zIndex: 12,
                height: d ? 16 : G,
                fill: f.backgroundColor || this.series[0] && this.series[0].color || "gray",
                padding: p(f.padding, 2),
                stroke: f.borderColor || null,
                "stroke-width": f.borderWidth || 0
            }).css(n({
                color: "white",
                fontWeight: "normal",
                fontSize: "11px",
                textAlign: "center"
            }, f.style)).add());
            d ? (b = c.plotX + m, k = q + (h ? 0 : this.height)) : (b = h ? this.width + m : 0, k = c.plotY + q);
            if (k < q || k > q + this.height) this.hideCrosshair();
            else {
                l || f.formatter || (this.isDatetimeAxis && (A = "%b %d, %Y"), l = "{value" + (A ? ":" + A : "") + "}");
                a.attr({
                    text: l ? t(l, {
                        value: c[g]
                    }) : f.formatter.call(this, c[g]),
                    x: b,
                    y: k,
                    visibility: "visible"
                });
                c = a.getBBox();
                if (d) {
                    if ("inside" === this.options.tickPosition && !h || "inside" !== this.options.tickPosition && h) k = a.y - c.height
                } else k = a.y - c.height / 2;
                d ? (d = m - c.x, e = m + this.width - c.x) : (d = "left" === this.labelAlign ? m : 0, e = "right" === this.labelAlign ? m + this.width : e.chartWidth);
                a.translateX < d && (b += d - a.translateX);
                a.translateX + c.width >= e && (b -= a.translateX + c.width - e);
                a.attr({
                    x: b,
                    y: k,
                    visibility: "visible"
                })
            }
        }
    });
    var Ac = va.init,
        Bc = va.processData,
        Cc = Da.prototype.tooltipFormatter;
    va.init = function () {
        Ac.apply(this, arguments);
        this.setCompare(this.options.compare)
    };
    va.setCompare = function (a) {
        this.modifyValue = "value" === a || "percent" === a ? function (b, c) {
            var d = this.compareValue;
            b !== G && (b = "value" === a ? b - d : b = b / d * 100 - 100, c && (c.change = b));
            return b
        } : null;
        this.chart.hasRendered && (this.isDirty = !0)
    };
    va.processData = function () {
        var a = 0,
            b, c, d;
        Bc.apply(this, arguments);
        if (this.xAxis && this.processedYData)
            for (b = this.processedXData, c = this.processedYData, d = c.length; a < d; a++)
                if ("number" === typeof c[a] && b[a] >= this.xAxis.min) {
                    this.compareValue = c[a];
                    break
                }
    };
    k(va, "getExtremes", function (a) {
        a.apply(this, [].slice.call(arguments, 1));
        this.modifyValue && (this.dataMax = this.modifyValue(this.dataMax), this.dataMin = this.modifyValue(this.dataMin))
    });
    T.prototype.setCompare = function (a, b) {
        this.isXAxis || (D(this.series, function (b) {
            b.setCompare(a)
        }), p(b, !0) && this.chart.redraw())
    };
    Da.prototype.tooltipFormatter = function (a) {
        a = a.replace("{point.change}", (0 < this.change ? "+" : "") + J(this.change, p(this.series.tooltipOptions.changeDecimals, 2)));
        return Cc.apply(this, [a])
    };
    k(V.prototype, "render", function (a) {
        this.chart.options._stock && (!this.clipBox && this.animate && -1 !== this.animate.toString().indexOf("sharedClip") ? (this.clipBox = E(this.chart.clipBox), this.clipBox.width = this.xAxis.len, this.clipBox.height = this.yAxis.len) : this.chart[this.sharedClipKey] && this.chart[this.sharedClipKey].attr({
            width: this.xAxis.len,
            height: this.yAxis.len
        }));
        a.call(this)
    });
    n(Ub.prototype, {
        init: function (a, b, c) {
            var d = this,
                e = d.defaultOptions;
            d.chart = b;
            b.angular && (e.background = {});
            d.options = a = E(e, a);
            (a = a.background) && D([].concat(w(a)).reverse(), function (a) {
                var b = a.backgroundColor,
                    e = c.userOptions;
                a = E(d.defaultBackgroundOptions, a);
                b && (a.backgroundColor = b);
                a.color = a.backgroundColor;
                c.options.plotBands.unshift(a);
                e.plotBands = e.plotBands || [];
                e.plotBands.unshift(a)
            })
        },
        defaultOptions: {
            center: ["50%", "50%"],
            size: "85%",
            startAngle: 0
        },
        defaultBackgroundOptions: {
            shape: "circle",
            borderWidth: 1,
            borderColor: "silver",
            backgroundColor: {
                linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops: [
                    [0, "#FFF"],
                    [1, "#DDD"]
                ]
            },
            from: -Number.MAX_VALUE,
            innerRadius: 0,
            to: Number.MAX_VALUE,
            outerRadius: "105%"
        }
    });
    var xb = T.prototype,
        Ob = ra.prototype,
        Dc = {
            getOffset: ma,
            redraw: function () {
                this.isDirty = !1
            },
            render: function () {
                this.isDirty = !1
            },
            setScale: ma,
            setCategories: ma,
            setTitle: ma
        }, gc = {
            isRadial: !0,
            defaultRadialGaugeOptions: {
                labels: {
                    align: "center",
                    x: 0,
                    y: null
                },
                minorGridLineWidth: 0,
                minorTickInterval: "auto",
                minorTickLength: 10,
                minorTickPosition: "inside",
                minorTickWidth: 1,
                tickLength: 10,
                tickPosition: "inside",
                tickWidth: 2,
                title: {
                    rotation: 0
                },
                zIndex: 2
            },
            defaultRadialXOptions: {
                gridLineWidth: 1,
                labels: {
                    align: null,
                    distance: 15,
                    x: 0,
                    y: null
                },
                maxPadding: 0,
                minPadding: 0,
                showLastLabel: !1,
                tickLength: 0
            },
            defaultRadialYOptions: {
                gridLineInterpolation: "circle",
                labels: {
                    align: "right",
                    x: -3,
                    y: -2
                },
                showLastLabel: !1,
                title: {
                    x: 4,
                    text: null,
                    rotation: 90
                }
            },
            setOptions: function (a) {
                a = this.options = E(this.defaultOptions, this.defaultRadialOptions, a);
                a.plotBands || (a.plotBands = [])
            },
            getOffset: function () {
                xb.getOffset.call(this);
                this.chart.axisOffset[this.side] = 0;
                this.center = this.pane.center = Zb.getCenter.call(this.pane)
            },
            getLinePath: function (a, b) {
                var c = this.center;
                b = p(b, c[2] / 2 - this.offset);
                return this.chart.renderer.symbols.arc(this.left + c[0], this.top + c[1], b, b, {
                    start: this.startAngleRad,
                    end: this.endAngleRad,
                    open: !0,
                    innerR: 0
                })
            },
            setAxisTranslation: function () {
                xb.setAxisTranslation.call(this);
                this.center && (this.transA = this.isCircular ? (this.endAngleRad - this.startAngleRad) / (this.max - this.min || 1) : this.center[2] / 2 / (this.max - this.min || 1), this.minPixelPadding = this.isXAxis ? this.transA * this.minPointOffset : 0)
            },
            beforeSetTickPositions: function () {
                this.autoConnect && (this.max += this.categories && 1 || this.pointRange || this.closestPointRange || 0)
            },
            setAxisSize: function () {
                xb.setAxisSize.call(this);
                this.isRadial && (this.center = this.pane.center = ga.CenteredSeriesMixin.getCenter.call(this.pane), this.isCircular && (this.sector = this.endAngleRad - this.startAngleRad), this.len = this.width = this.height = this.center[2] * p(this.sector, 1) / 2)
            },
            getPosition: function (a, b) {
                return this.postTranslate(this.isCircular ? this.translate(a) : 0, p(this.isCircular ? b : this.translate(a), this.center[2] / 2) - this.offset)
            },
            postTranslate: function (a, b) {
                var c = this.chart,
                    d = this.center;
                a = this.startAngleRad + a;
                return {
                    x: c.plotLeft + d[0] + Math.cos(a) * b,
                    y: c.plotTop + d[1] + Math.sin(a) * b
                }
            },
            getPlotBandPath: function (a, b, c) {
                var d = this.center,
                    e = this.startAngleRad,
                    f = d[2] / 2,
                    g = [p(c.outerRadius, "100%"), c.innerRadius, p(c.thickness, 10)],
                    h = /%$/,
                    m, q = this.isCircular;
                "polygon" === this.options.gridLineInterpolation ? d = this.getPlotLinePath(a).concat(this.getPlotLinePath(b, !0)) : (a = Math.max(a, this.min), b = Math.min(b, this.max), q || (g[0] = this.translate(a), g[1] = this.translate(b)), g = Fa(g, function (a) {
                    h.test(a) && (a = O(a, 10) * f / 100);
                    return a
                }), "circle" !== c.shape && q ? (a = e + this.translate(a), b = e + this.translate(b)) : (a = -Math.PI / 2, b = 1.5 * Math.PI, m = !0), d = this.chart.renderer.symbols.arc(this.left + d[0], this.top + d[1], g[0], g[0], {
                    start: Math.min(a, b),
                    end: Math.max(a, b),
                    innerR: p(g[1], g[0] - g[2]),
                    open: m
                }));
                return d
            },
            getPlotLinePath: function (a, b) {
                var c = this,
                    d = c.center,
                    e = c.chart,
                    f = c.getPosition(a),
                    g, h, m;
                c.isCircular ? m = ["M", d[0] + e.plotLeft, d[1] + e.plotTop, "L", f.x, f.y] : "circle" === c.options.gridLineInterpolation ? (a = c.translate(a)) && (m = c.getLinePath(0, a)) : (D(e.xAxis, function (a) {
                    a.pane === c.pane && (g = a)
                }), m = [], a = c.translate(a), d = g.tickPositions, g.autoConnect && (d = d.concat([d[0]])), b && (d = [].concat(d).reverse()), D(d, function (b, c) {
                    h = g.getPosition(b, a);
                    m.push(c ? "L" : "M", h.x, h.y)
                }));
                return m
            },
            getTitlePosition: function () {
                var a = this.center,
                    b = this.chart,
                    c = this.options.title;
                return {
                    x: b.plotLeft + a[0] + (c.x || 0),
                    y: b.plotTop + a[1] - {
                        high: .5,
                        middle: .25,
                        low: 0
                    }[c.align] * a[2] + (c.y || 0)
                }
            }
        };
    k(xb, "init", function (a, b, c) {
        var d = b.angular,
            e = b.polar,
            f = c.isX,
            g = d && f,
            h, m;
        m = b.options;
        var q = c.pane || 0;
        if (d) {
            if (n(this, g ? Dc : gc), h = !f) this.defaultRadialOptions = this.defaultRadialGaugeOptions
        } else e && (n(this, gc), this.defaultRadialOptions = (h = f) ? this.defaultRadialXOptions : E(this.defaultYAxisOptions, this.defaultRadialYOptions));
        a.call(this, b, c);
        g || !d && !e || (a = this.options, b.panes || (b.panes = []), this.pane = q = b.panes[q] = b.panes[q] || new Ub(w(m.pane)[q], b, this), q = q.options, b.inverted = !1, m.chart.zoomType = null, this.startAngleRad = b = (q.startAngle - 90) * Math.PI / 180, this.endAngleRad = m = (p(q.endAngle, q.startAngle + 360) - 90) * Math.PI / 180, this.offset = a.offset || 0, (this.isCircular = h) && c.max === G && m - b === 2 * Math.PI && (this.autoConnect = !0))
    });
    k(Ob, "getPosition", function (a, b, c, d, e) {
        var f = this.axis;
        return f.getPosition ? f.getPosition(c) : a.call(this, b, c, d, e)
    });
    k(Ob, "getLabelPosition", function (a, b, c, d, e, f, g, h, m) {
        var q = this.axis,
            k = f.y,
            t = 20,
            l = f.align,
            A = (q.translate(this.pos) + q.startAngleRad + Math.PI / 2) / Math.PI * 180 % 360;
        q.isRadial ? (a = q.getPosition(this.pos, q.center[2] / 2 + p(f.distance, -25)), "auto" === f.rotation ? d.attr({
            rotation: A
        }) : null === k && (k = q.chart.renderer.fontMetrics(d.styles.fontSize).b - d.getBBox().height / 2), null === l && (q.isCircular ? (this.label.getBBox().width > q.len * q.tickInterval / (q.max - q.min) && (t = 0), l = A > t && A < 180 - t ? "left" : A > 180 + t && A < 360 - t ? "right" : "center") : l = "center", d.attr({
            align: l
        })), a.x += f.x, a.y += k) : a = a.call(this, b, c, d, e, f, g, h, m);
        return a
    });
    k(Ob, "getMarkPath", function (a, b, c, d, e, f, g) {
        var h = this.axis;
        h.isRadial ? (a = h.getPosition(this.pos, h.center[2] / 2 + d), b = ["M", b, c, "L", a.x, a.y]) : b = a.call(this, b, c, d, e, f, g);
        return b
    });
    X.arearange = E(X.area, {
        lineWidth: 1,
        marker: null,
        threshold: null,
        tooltip: {
            pointFormat: '<span style="color:{series.color}">\u25cf</span> {series.name}: <b>{point.low}</b> - <b>{point.high}</b><br/>'
        },
        trackByArea: !0,
        dataLabels: {
            align: null,
            verticalAlign: null,
            xLow: 0,
            xHigh: 0,
            yLow: 0,
            yHigh: 0
        },
        states: {
            hover: {
                halo: !1
            }
        }
    });
    P.arearange = M(P.area, {
        type: "arearange",
        pointArrayMap: ["low", "high"],
        toYData: function (a) {
            return [a.low, a.high]
        },
        pointValKey: "low",
        deferTranslatePolar: !0,
        highToXY: function (a) {
            var b = this.chart,
                c = this.xAxis.postTranslate(a.rectPlotX, this.yAxis.len - a.plotHigh);
            a.plotHighX = c.x - b.plotLeft;
            a.plotHigh = c.y - b.plotTop
        },
        getSegments: function () {
            var a = this;
            D(a.points, function (b) {
                a.options.connectNulls || null !== b.low && null !== b.high ? null === b.low && null !== b.high && (b.y = b.high) : b.y = null
            });
            V.prototype.getSegments.call(this)
        },
        translate: function () {
            var a = this,
                b = a.yAxis;
            P.area.prototype.translate.apply(a);
            D(a.points, function (a) {
                var d = a.low,
                    e = a.high,
                    f = a.plotY;
                null === e && null === d ? a.y = null : null === d ? (a.plotLow = a.plotY = null, a.plotHigh = b.translate(e, 0, 1, 0, 1)) : null === e ? (a.plotLow = f, a.plotHigh = null) : (a.plotLow = f, a.plotHigh = b.translate(e, 0, 1, 0, 1))
            });
            this.chart.polar && D(this.points, function (b) {
                a.highToXY(b)
            })
        },
        getSegmentPath: function (a) {
            var b,
                c = [],
                d = a.length,
                e = V.prototype.getSegmentPath,
                f, g;
            g = this.options;
            var h = g.step;
            for (b = HighchartsAdapter.grep(a, function (a) {
                return null !== a.plotLow
            }); d--;) f = a[d], null !== f.plotHigh && c.push({
                plotX: f.plotHighX || f.plotX,
                plotY: f.plotHigh
            });
            a = e.call(this, b);
            h && (!0 === h && (h = "left"), g.step = {
                left: "right",
                center: "center",
                right: "left"
            }[h]);
            c = e.call(this, c);
            g.step = h;
            g = [].concat(a, c);
            this.chart.polar || (c[0] = "L");
            this.areaPath = this.areaPath.concat(a, c);
            return g
        },
        drawDataLabels: function () {
            var a = this.data,
                b = a.length,
                c, d = [],
                e = V.prototype,
                f = this.options.dataLabels,
                g = f.align,
                h, m = this.chart.inverted;
            if (f.enabled || this._hasPointLabels) {
                for (c = b; c--;) h = a[c], h.y = h.high, h._plotY = h.plotY, h.plotY = h.plotHigh, d[c] = h.dataLabel, h.dataLabel = h.dataLabelUpper, h.below = !1, m ? (g || (f.align = "left"), f.x = f.xHigh) : f.y = f.yHigh;
                e.drawDataLabels && e.drawDataLabels.apply(this, arguments);
                for (c = b; c--;) h = a[c], h.dataLabelUpper = h.dataLabel, h.dataLabel = d[c], h.y = h.low, h.plotY = h._plotY, h.below = !0, m ? (g || (f.align = "right"), f.x = f.xLow) : f.y = f.yLow;
                e.drawDataLabels && e.drawDataLabels.apply(this, arguments)
            }
            f.align = g
        },
        alignDataLabel: function () {
            P.column.prototype.alignDataLabel.apply(this, arguments)
        },
        setStackedPoints: ma,
        getSymbol: ma,
        drawPoints: ma
    });
    X.areasplinerange = E(X.arearange);
    P.areasplinerange = M(P.arearange, {
        type: "areasplinerange",
        getPointSpline: P.spline.prototype.getPointSpline
    });
    (function () {
        var a = P.column.prototype;
        X.columnrange = E(X.column, X.arearange, {
            lineWidth: 1,
            pointRange: null
        });
        P.columnrange = M(P.arearange, {
            type: "columnrange",
            translate: function () {
                var b = this,
                    c = b.yAxis,
                    d;
                a.translate.apply(b);
                D(b.points, function (a) {
                    var f = a.shapeArgs,
                        g = b.options.minPointLength,
                        h;
                    a.tooltipPos = null;
                    a.plotHigh = d = c.translate(a.high, 0, 1, 0, 1);
                    a.plotLow = a.plotY;
                    h = d;
                    a = a.plotY - d;
                    a < g && (g -= a, a += g, h -= g / 2);
                    f.height = a;
                    f.y = h
                })
            },
            trackerGroups: ["group", "dataLabelsGroup"],
            drawGraph: ma,
            pointAttrToOptions: a.pointAttrToOptions,
            drawPoints: a.drawPoints,
            drawTracker: a.drawTracker,
            animate: a.animate,
            getColumnMetrics: a.getColumnMetrics
        })
    })();
    X.gauge = E(X.line, {
        dataLabels: {
            enabled: !0,
            defer: !1,
            y: 15,
            borderWidth: 1,
            borderColor: "silver",
            borderRadius: 3,
            crop: !1,
            verticalAlign: "top",
            zIndex: 2
        },
        dial: {},
        pivot: {},
        tooltip: {
            headerFormat: ""
        },
        showInLegend: !1
    });
    var Ec = {
        type: "gauge",
        pointClass: M(Da, {
            setState: function (a) {
                this.state = a
            }
        }),
        angular: !0,
        drawGraph: ma,
        fixedBox: !0,
        forceDL: !0,
        trackerGroups: ["group", "dataLabelsGroup"],
        translate: function () {
            var a = this.yAxis,
                b = this.options,
                c = a.center;
            this.generatePoints();
            D(this.points, function (d) {
                var e = E(b.dial, d.dial),
                    f = O(p(e.radius, 80)) * c[2] / 200,
                    g = O(p(e.baseLength, 70)) * f / 100,
                    h = O(p(e.rearLength, 10)) * f / 100,
                    m = e.baseWidth || 3,
                    k = e.topWidth || 1,
                    r = b.overshoot,
                    t = a.startAngleRad + a.translate(d.y, null, null, null, !0);
                r && "number" === typeof r ? (r = r / 180 * Math.PI, t = Math.max(a.startAngleRad - r, Math.min(a.endAngleRad + r, t))) : !1 === b.wrap && (t = Math.max(a.startAngleRad, Math.min(a.endAngleRad, t)));
                t = 180 * t / Math.PI;
                d.shapeType = "path";
                d.shapeArgs = {
                    d: e.path || ["M", -h, -m / 2, "L", g, -m / 2, f, -k / 2, f, k / 2, g, m / 2, -h, m / 2, "z"],
                    translateX: c[0],
                    translateY: c[1],
                    rotation: t
                };
                d.plotX = c[0];
                d.plotY = c[1]
            })
        },
        drawPoints: function () {
            var a = this,
                b = a.yAxis.center,
                c = a.pivot,
                d = a.options,
                e = d.pivot,
                f = a.chart.renderer;
            D(a.points, function (b) {
                var c = b.graphic,
                    e = b.shapeArgs,
                    k = e.d,
                    r = E(d.dial, b.dial);
                c ? (c.animate(e), e.d = k) : b.graphic = f[b.shapeType](e).attr({
                    stroke: r.borderColor || "none",
                    "stroke-width": r.borderWidth || 0,
                    fill: r.backgroundColor || "black",
                    rotation: e.rotation
                }).add(a.group)
            });
            c ? c.animate({
                translateX: b[0],
                translateY: b[1]
            }) : a.pivot = f.circle(0, 0, p(e.radius, 5)).attr({
                "stroke-width": e.borderWidth || 0,
                stroke: e.borderColor || "silver",
                fill: e.backgroundColor || "black"
            }).translate(b[0], b[1]).add(a.group)
        },
        animate: function (a) {
            var b = this;
            a || (D(b.points, function (a) {
                var d = a.graphic;
                d && (d.attr({
                    rotation: 180 * b.yAxis.startAngleRad / Math.PI
                }), d.animate({
                    rotation: a.shapeArgs.rotation
                }, b.options.animation))
            }), b.animate = null)
        },
        render: function () {
            this.group = this.plotGroup("group", "series", this.visible ? "visible" : "hidden", this.options.zIndex, this.chart.seriesGroup);
            V.prototype.render.call(this);
            this.group.clip(this.chart.clipRect)
        },
        setData: function (a, b) {
            V.prototype.setData.call(this, a, !1);
            this.processData();
            this.generatePoints();
            p(b, !0) && this.chart.redraw()
        },
        drawTracker: $a && $a.drawTrackerPoint
    };
    P.gauge = M(P.line, Ec);
    X.boxplot = E(X.column, {
        fillColor: "#FFFFFF",
        lineWidth: 1,
        medianWidth: 2,
        states: {
            hover: {
                brightness: -.3
            }
        },
        threshold: null,
        tooltip: {
            pointFormat: '<span style="color:{point.color}">\u25cf</span> <b> {series.name}</b><br/>Maximum: {point.high}<br/>Upper quartile: {point.q3}<br/>Median: {point.median}<br/>Lower quartile: {point.q1}<br/>Minimum: {point.low}<br/>'
        },
        whiskerLength: "50%",
        whiskerWidth: 2
    });
    P.boxplot = M(P.column, {
        type: "boxplot",
        pointArrayMap: ["low", "q1", "median", "q3", "high"],
        toYData: function (a) {
            return [a.low, a.q1, a.median, a.q3, a.high]
        },
        pointValKey: "high",
        pointAttrToOptions: {
            fill: "fillColor",
            stroke: "color",
            "stroke-width": "lineWidth"
        },
        drawDataLabels: ma,
        translate: function () {
            var a = this.yAxis,
                b = this.pointArrayMap;
            P.column.prototype.translate.apply(this);
            D(this.points, function (c) {
                D(b, function (b) {
                    null !== c[b] && (c[b + "Plot"] = a.translate(c[b], 0, 1, 0, 1))
                })
            })
        },
        drawPoints: function () {
            var a = this,
                b = a.points,
                c = a.options,
                d = a.chart.renderer,
                e, f, g, h, m, k, r, t, l, A, F, n, B, u, R, y, w, C, J, da, E, I, ea = !1 !== a.doQuartiles,
                ca = parseInt(a.options.whiskerLength, 10) / 100;
            D(b, function (b) {
                l = b.graphic;
                E = b.shapeArgs;
                F = {};
                u = {};
                y = {};
                I = b.color || a.color;
                b.plotY !== G && (e = b.pointAttr[b.selected ? "selected" : ""], w = E.width, C = fa(E.x), J = C + w, da = L(w / 2), f = fa(ea ? b.q1Plot : b.lowPlot), g = fa(ea ? b.q3Plot : b.lowPlot), h = fa(b.highPlot), m = fa(b.lowPlot), F.stroke = b.stemColor || c.stemColor || I, F["stroke-width"] = p(b.stemWidth, c.stemWidth, c.lineWidth), F.dashstyle = b.stemDashStyle || c.stemDashStyle, u.stroke = b.whiskerColor || c.whiskerColor || I, u["stroke-width"] = p(b.whiskerWidth, c.whiskerWidth, c.lineWidth), y.stroke = b.medianColor || c.medianColor || I, y["stroke-width"] = p(b.medianWidth, c.medianWidth, c.lineWidth), r = F["stroke-width"] % 2 / 2, t = C + da + r, A = ["M", t, g, "L", t, h, "M", t, f, "L", t, m], ea && (r = e["stroke-width"] % 2 / 2, t = fa(t) + r, f = fa(f) + r, g = fa(g) + r, C += r, J += r, n = ["M", C, g, "L", C, f, "L", J, f, "L", J, g, "L", C, g, "z"]), ca && (r = u["stroke-width"] % 2 / 2, h += r, m += r, B = ["M", t - da * ca, h, "L", t + da * ca, h, "M", t - da * ca, m, "L", t + da * ca, m]), r = y["stroke-width"] % 2 / 2, k = L(b.medianPlot) + r, R = ["M", C, k, "L", J, k], l ? (b.stem.animate({
                    d: A
                }), ca && b.whiskers.animate({
                    d: B
                }), ea && b.box.animate({
                    d: n
                }), b.medianShape.animate({
                    d: R
                })) : (b.graphic = l = d.g().add(a.group), b.stem = d.path(A).attr(F).add(l), ca && (b.whiskers = d.path(B).attr(u).add(l)), ea && (b.box = d.path(n).attr(e).add(l)), b.medianShape = d.path(R).attr(y).add(l)))
            })
        }
    });
    X.errorbar = E(X.boxplot, {
        color: "#000000",
        grouping: !1,
        linkedTo: ":previous",
        tooltip: {
            pointFormat: '<span style="color:{point.color}">\u25cf</span> {series.name}: <b>{point.low}</b> - <b>{point.high}</b><br/>'
        },
        whiskerWidth: null
    });
    P.errorbar = M(P.boxplot, {
        type: "errorbar",
        pointArrayMap: ["low", "high"],
        toYData: function (a) {
            return [a.low, a.high]
        },
        pointValKey: "high",
        doQuartiles: !1,
        drawDataLabels: P.arearange ? P.arearange.prototype.drawDataLabels : ma,
        getColumnMetrics: function () {
            return this.linkedParent && this.linkedParent.columnMetrics || P.column.prototype.getColumnMetrics.call(this)
        }
    });
    X.waterfall = E(X.column, {
        lineWidth: 1,
        lineColor: "#333",
        dashStyle: "dot",
        borderColor: "#333",
        dataLabels: {
            inside: !0
        },
        states: {
            hover: {
                lineWidthPlus: 0
            }
        }
    });
    P.waterfall = M(P.column, {
        type: "waterfall",
        upColorProp: "fill",
        pointArrayMap: ["low", "y"],
        pointValKey: "y",
        translate: function () {
            var a = this.options,
                b = this.yAxis,
                c, d, e, f, g, h, m, k, r, t = a.threshold,
                l = a.stacking;
            P.column.prototype.translate.apply(this);
            m = k = t;
            d = this.points;
            c = 0;
            for (a = d.length; c < a; c++) e = d[c], h = this.processedYData[c], f = e.shapeArgs, r = (g = l && b.stacks[(this.negStacks && h < t ? "-" : "") + this.stackKey]) ? g[e.x].points[this.index + "," + c] : [0, h], e.isSum ? e.y = h : e.isIntermediateSum && (e.y = h - k), g = N(m, m + e.y) + r[0], f.y = b.translate(g, 0, 1), e.isSum ? (f.y = b.translate(r[1], 0, 1), f.height = b.translate(r[0], 0, 1) - f.y) : e.isIntermediateSum ? (f.y = b.translate(r[1], 0, 1), f.height = b.translate(k, 0, 1) - f.y, k = r[1]) : (0 !== m && (f.height = 0 < h ? b.translate(m, 0, 1) - f.y : b.translate(m, 0, 1) - b.translate(m - h, 0, 1)), m += h), e.plotY = f.y = L(f.y) - this.borderWidth % 2 / 2, f.height = N(L(f.height), .001), e.yBottom = f.y + f.height, f = e.plotY + (e.negative ? f.height : 0), this.chart.inverted ? e.tooltipPos[0] = b.len - f : e.tooltipPos[1] = f
        },
        processData: function (a) {
            var b = this.yData,
                c = this.options.data,
                d, e = b.length,
                f, g, h, m, k, r;
            g = f = h = m = this.options.threshold || 0;
            for (r = 0; r < e; r++) k = b[r], d = c && c[r] ? c[r] : {}, "sum" === k || d.isSum ? b[r] = g : "intermediateSum" === k || d.isIntermediateSum ? b[r] = f : (g += k, f += k), h = Math.min(g, h), m = Math.max(g, m);
            V.prototype.processData.call(this, a);
            this.dataMin = h;
            this.dataMax = m
        },
        toYData: function (a) {
            return a.isSum ? 0 === a.x ? null : "sum" : a.isIntermediateSum ? 0 === a.x ? null : "intermediateSum" : a.y
        },
        getAttribs: function () {
            P.column.prototype.getAttribs.apply(this, arguments);
            var a = this,
                b = a.options,
                c = b.states,
                d = b.upColor || a.color,
                b = ga.Color(d).brighten(.1).get(),
                e = E(a.pointAttr),
                f = a.upColorProp;
            e[""][f] = d;
            e.hover[f] = c.hover.upColor || b;
            e.select[f] = c.select.upColor || d;
            D(a.points, function (b) {
                b.options.color || (0 < b.y ? (b.pointAttr = e, b.color = d) : b.pointAttr = a.pointAttr)
            })
        },
        getGraphPath: function () {
            var a = this.data,
                b = a.length,
                c = L(this.options.lineWidth + this.borderWidth) % 2 / 2,
                d = [],
                e, f, g;
            for (g = 1; g < b; g++) f = a[g].shapeArgs, e = a[g - 1].shapeArgs, f = ["M", e.x + e.width, e.y + c, "L", f.x, e.y + c], 0 > a[g - 1].y && (f[2] += e.height, f[5] += e.height), d = d.concat(f);
            return d
        },
        getExtremes: ma,
        drawGraph: V.prototype.drawGraph
    });
    X.bubble = E(X.scatter, {
        dataLabels: {
            formatter: function () {
                return this.point.z
            },
            inside: !0,
            verticalAlign: "middle"
        },
        marker: {
            lineColor: null,
            lineWidth: 1
        },
        minSize: 8,
        maxSize: "20%",
        states: {
            hover: {
                halo: {
                    size: 5
                }
            }
        },
        tooltip: {
            pointFormat: "({point.x}, {point.y}), Size: {point.z}"
        },
        turboThreshold: 0,
        zThreshold: 0,
        zoneAxis: "z"
    });
    var Fc = M(Da, {
        haloPath: function () {
            return Da.prototype.haloPath.call(this, this.shapeArgs.r + this.series.options.states.hover.halo.size)
        },
        ttBelow: !1
    });
    P.bubble = M(P.scatter, {
        type: "bubble",
        pointClass: Fc,
        pointArrayMap: ["y", "z"],
        parallelArrays: ["x", "y", "z"],
        trackerGroups: ["group", "dataLabelsGroup"],
        bubblePadding: !0,
        zoneAxis: "z",
        pointAttrToOptions: {
            stroke: "lineColor",
            "stroke-width": "lineWidth",
            fill: "fillColor"
        },
        applyOpacity: function (a) {
            var b = this.options.marker,
                c = p(b.fillOpacity, .5);
            a = a || b.fillColor || this.color;
            1 !== c && (a = Ja(a).setOpacity(c).get("rgba"));
            return a
        },
        convertAttribs: function () {
            var a = V.prototype.convertAttribs.apply(this, arguments);
            a.fill = this.applyOpacity(a.fill);
            return a
        },
        getRadii: function (a, b, c, d) {
            var e, f, g, h = this.zData,
                m = [],
                k = "width" !== this.options.sizeBy;
            f = 0;
            for (e = h.length; f < e; f++) g = b - a, g = 0 < g ? (h[f] - a) / (b - a) : .5, k && 0 <= g && (g = Math.sqrt(g)), m.push(la.ceil(c + g * (d - c)) / 2);
            this.radii = m
        },
        animate: function (a) {
            var b = this.options.animation;
            a || (D(this.points, function (a) {
                var d = a.graphic;
                a = a.shapeArgs;
                d && a && (d.attr("r", 1), d.animate({
                    r: a.r
                }, b))
            }), this.animate = null)
        },
        translate: function () {
            var a, b = this.data,
                c, d, e = this.radii;
            P.scatter.prototype.translate.call(this);
            for (a = b.length; a--;) c = b[a], d = e ? e[a] : 0, d >= this.minPxSize / 2 ? (c.shapeType = "circle", c.shapeArgs = {
                x: c.plotX,
                y: c.plotY,
                r: d
            }, c.dlBox = {
                x: c.plotX - d,
                y: c.plotY - d,
                width: 2 * d,
                height: 2 * d
            }) : c.shapeArgs = c.plotY = c.dlBox = G
        },
        drawLegendSymbol: function (a, b) {
            var c = O(a.itemStyle.fontSize) / 2;
            b.legendSymbol = this.chart.renderer.circle(c, a.baseline - c, c).attr({
                zIndex: 3
            }).add(b.legendGroup);
            b.legendSymbol.isMarker = !0
        },
        drawPoints: P.column.prototype.drawPoints,
        alignDataLabel: P.column.prototype.alignDataLabel,
        buildKDTree: ma,
        applyZones: ma
    });
    T.prototype.beforePadding = function () {
        var a = this,
            b = this.len,
            c = this.chart,
            d = 0,
            e = b,
            f = this.isXAxis,
            g = f ? "xData" : "yData",
            h = this.min,
            m = {}, k = la.min(c.plotWidth, c.plotHeight),
            r = Number.MAX_VALUE,
            t = -Number.MAX_VALUE,
            l = this.max - h,
            A = b / l,
            F = [];
        D(this.series, function (b) {
            var d = b.options;
            !b.bubblePadding || !b.visible && c.options.chart.ignoreHiddenSeries || (a.allowZoomOutside = !0, F.push(b), f && (D(["minSize", "maxSize"], function (a) {
                var b = d[a],
                    c = /%$/.test(b),
                    b = O(b);
                m[a] = c ? k * b / 100 : b
            }), b.minPxSize = m.minSize, b = b.zData, b.length && (r = p(d.zMin, la.min(r, la.max(ea(b), !1 === d.displayNegative ? d.zThreshold : -Number.MAX_VALUE))), t = p(d.zMax, la.max(t, Ia(b))))))
        });
        D(F, function (a) {
            var b = a[g],
                c = b.length,
                k;
            f && a.getRadii(r, t, m.minSize, m.maxSize);
            if (0 < l)
                for (; c--;) "number" === typeof b[c] && (k = a.radii[c], d = Math.min((b[c] - h) * A - k, d), e = Math.max((b[c] - h) * A + k, e))
        });
        F.length && 0 < l && p(this.options.min, this.userMin) === G && p(this.options.max, this.userMax) === G && (e -= b, A *= (b + d - e) / b, this.min += d / A, this.max += e / A)
    };
    (function () {
        function a(a, b, c) {
            a.call(this, b, c);
            this.chart.polar && (this.closeSegment = function (a) {
                var b = this.xAxis.center;
                a.push("L", b[0], b[1])
            }, this.closedStacks = !0)
        }

        function b(a, b) {
            var c = this.chart,
                d = this.options.animation,
                e = this.group,
                k = this.markerGroup,
                t = this.xAxis.center,
                l = c.plotLeft,
                p = c.plotTop;
            c.polar ? c.renderer.isSVG && (!0 === d && (d = {}), b ? (c = {
                translateX: t[0] + l,
                translateY: t[1] + p,
                scaleX: .001,
                scaleY: .001
            }, e.attr(c), k && k.attr(c)) : (c = {
                translateX: l,
                translateY: p,
                scaleX: 1,
                scaleY: 1
            }, e.animate(c, d), k && k.animate(c, d), this.animate = null)) : a.call(this, b)
        }

        var c = V.prototype,
            d = Ta.prototype,
            e;
        c.searchPolarPoint = function (a) {
            var b = this.chart,
                c = this.xAxis.pane.center,
                d = a.chartX - c[0] - b.plotLeft;
            a = a.chartY - c[1] - b.plotTop;
            this.kdAxisArray = ["clientX"];
            a = {
                clientX: 180 + Math.atan2(d, a) * (-180 / Math.PI)
            };
            return this.searchKDTree(a)
        };
        k(c, "buildKDTree", function (a) {
            this.chart.polar && (this.kdAxisArray = ["clientX"]);
            a.apply(this)
        });
        k(c, "searchPoint", function (a, b) {
            return this.chart.polar ? this.searchPolarPoint(b) : a.call(this, b)
        });
        c.toXY = function (a) {
            var b, c = this.chart,
                d = a.plotX;
            b = a.plotY;
            a.rectPlotX = d;
            a.rectPlotY = b;
            d = (d / Math.PI * 180 + this.xAxis.pane.options.startAngle) % 360;
            0 > d && (d += 360);
            a.clientX = d;
            b = this.xAxis.postTranslate(a.plotX, this.yAxis.len - b);
            a.plotX = a.polarPlotX = b.x - c.plotLeft;
            a.plotY = a.polarPlotY = b.y - c.plotTop
        };
        P.area && k(P.area.prototype, "init", a);
        P.areaspline && k(P.areaspline.prototype, "init", a);
        P.spline && k(P.spline.prototype, "getPointSpline", function (a, b, c, d) {
            var e, k, t, l, p, A, F;
            this.chart.polar ? (e = c.plotX, k = c.plotY, a = b[d - 1], t = b[d + 1], this.connectEnds && (a || (a = b[b.length - 2]), t || (t = b[1])), a && t && (l = a.plotX, p = a.plotY, b = t.plotX, A = t.plotY, l = (1.5 * e + l) / 2.5, p = (1.5 * k + p) / 2.5, t = (1.5 * e + b) / 2.5, F = (1.5 * k + A) / 2.5, b = Math.sqrt(Math.pow(l - e, 2) + Math.pow(p - k, 2)), A = Math.sqrt(Math.pow(t - e, 2) + Math.pow(F - k, 2)), l = Math.atan2(p - k, l - e), p = Math.atan2(F - k, t - e), F = Math.PI / 2 + (l + p) / 2, Math.abs(l - F) > Math.PI / 2 && (F -= Math.PI), l = e + Math.cos(F) * b, p = k + Math.sin(F) * b, t = e + Math.cos(Math.PI + F) * A, F = k + Math.sin(Math.PI + F) * A, c.rightContX = t, c.rightContY = F), d ? (c = ["C", a.rightContX || a.plotX, a.rightContY || a.plotY, l || e, p || k, e, k], a.rightContX = a.rightContY = null) : c = ["M", e, k]) : c = a.call(this, b, c, d);
            return c
        });
        k(c, "translate", function (a) {
            a.call(this);
            if (this.chart.polar && !this.preventPostTranslate) {
                a = this.points;
                for (var b = a.length; b--;) this.toXY(a[b])
            }
        });
        k(c, "getSegmentPath", function (a, b) {
            var c = this.points;
            this.chart.polar && !1 !== this.options.connectEnds && b[b.length - 1] === c[c.length - 1] && null !== c[0].y && (this.connectEnds = !0, b = [].concat(b, [c[0]]));
            return a.call(this, b)
        });
        k(c, "animate", b);
        P.column && (e = P.column.prototype, k(e, "animate", b), k(e, "translate", function (a) {
            var b = this.xAxis,
                c = this.yAxis.len,
                d = b.center,
                e = b.startAngleRad,
                k = this.chart.renderer,
                t, l;
            this.preventPostTranslate = !0;
            a.call(this);
            if (b.isRadial)
                for (b = this.points, l = b.length; l--;) t = b[l], a = t.barX + e, t.shapeType = "path", t.shapeArgs = {
                    d: k.symbols.arc(d[0], d[1], c - t.plotY, null, {
                        start: a,
                        end: a + t.pointWidth,
                        innerR: c - p(t.yBottom, c)
                    })
                }, this.toXY(t), t.tooltipPos = [t.plotX, t.plotY], t.ttBelow = t.plotY > d[1]
        }), k(e, "alignDataLabel", function (a, b, d, e, k, r) {
            this.chart.polar ? (a = b.rectPlotX / Math.PI * 180, null === e.align && (e.align = 20 < a && 160 > a ? "left" : 200 < a && 340 > a ? "right" : "center"), null === e.verticalAlign && (e.verticalAlign = 45 > a || 315 < a ? "bottom" : 135 < a && 225 > a ? "top" : "middle"), c.alignDataLabel.call(this, b, d, e, k, r)) : a.call(this, b, d, e, k, r)
        }));
        k(d, "getCoordinates", function (a, b) {
            var c = this.chart,
                d = {
                    xAxis: [],
                    yAxis: []
                };
            c.polar ? D(c.axes, function (a) {
                var e = a.isXAxis,
                    f = a.center,
                    k = b.chartX - f[0] - c.plotLeft,
                    f = b.chartY - f[1] - c.plotTop;
                d[e ? "xAxis" : "yAxis"].push({
                    axis: a,
                    value: a.translate(e ? Math.PI - Math.atan2(k, f) : Math.sqrt(Math.pow(k, 2) + Math.pow(f, 2)), !0)
                })
            }) : d = a.call(this, b);
            return d
        })
    })();
    n(ga, {
        Axis: T,
        Chart: na,
        Color: Ja,
        Point: Da,
        Tick: ra,
        Renderer: Za,
        Series: V,
        SVGElement: ia,
        SVGRenderer: Ca,
        arrayMin: ea,
        arrayMax: Ia,
        charts: sa,
        dateFormat: Ha,
        format: t,
        pathAnim: Eb,
        getOptions: function () {
            return ha
        },
        hasBidiBug: hc,
        isTouchDevice: eb,
        numberFormat: J,
        seriesTypes: P,
        setOptions: function (a) {
            ha = E(!0, ha, a);
            Pb();
            return ha
        },
        addEvent: W,
        removeEvent: pa,
        createElement: K,
        discardElement: Va,
        css: I,
        each: D,
        extend: n,
        map: Fa,
        merge: E,
        pick: p,
        splat: w,
        extendClass: M,
        pInt: O,
        wrap: k,
        svg: wa,
        canvas: za,
        vml: !wa && !za,
        product: "Highcharts 4.0.4",
        version: "/Highstock 2.0.4"
    })
})();
(function (n) {
    var E = n.getOptions(),
        O = E.plotOptions,
        Y = n.seriesTypes,
        Q = n.merge,
        S = function () {
        }, aa = n.each,
        B = n.pick;
    O.funnel = Q(O.pie, {
        animation: !1,
        center: ["50%", "50%"],
        width: "90%",
        neckWidth: "30%",
        height: "100%",
        neckHeight: "25%",
        reversed: !1,
        dataLabels: {
            connectorWidth: 1,
            connectorColor: "#606060"
        },
        size: !0,
        states: {
            select: {
                color: "#C0C0C0",
                borderColor: "#000000",
                shadow: !1
            }
        }
    });
    Y.funnel = n.extendClass(Y.pie, {
        type: "funnel",
        animate: S,
        translate: function () {
            var l = function (k, t) {
                    return /%$/.test(k) ? t * parseInt(k, 10) / 100 : parseInt(k, 10)
                }, n = 0,
                B = this.chart,
                C = this.options,
                w = C.reversed,
                p = B.plotWidth,
                I = B.plotHeight,
                E = 0,
                B = C.center,
                M = l(B[0], p),
                J = l(B[1], I),
                A = l(C.width, p),
                k, t, F = l(C.height, I),
                R = l(C.neckWidth, p),
                da = l(C.neckHeight, I),
                ea = F - da,
                l = this.data,
                O, ca, Q = "left" === C.dataLabels.position ? 1 : 0,
                qa, ta, Y, ia, ra, T, na;
            this.getWidthAt = t = function (k) {
                return k > F - da || F === da ? R : R + (F - da - k) / (F - da) * (A - R)
            };
            this.getX = function (k, l) {
                return M + (l ? -1 : 1) * (t(w ? I - k : k) / 2 + C.dataLabels.distance)
            };
            this.center = [M, J, F];
            this.centerX = M;
            aa(l, function (k) {
                n += k.y
            });
            aa(l, function (l) {
                na = null;
                ca = n ? l.y / n : 0;
                ta = J - F / 2 + E * F;
                ra = ta + ca * F;
                k = t(ta);
                qa = M - k / 2;
                Y = qa + k;
                k = t(ra);
                ia = M - k / 2;
                T = ia + k;
                ta > ea ? (qa = ia = M - R / 2, Y = T = M + R / 2) : ra > ea && (na = ra, k = t(ea), ia = M - k / 2, T = ia + k, ra = ea);
                w && (ta = F - ta, ra = F - ra, na = na ? F - na : null);
                O = ["M", qa, ta, "L", Y, ta, T, ra];
                na && O.push(T, na, ia, na);
                O.push(ia, ra, "Z");
                l.shapeType = "path";
                l.shapeArgs = {
                    d: O
                };
                l.percentage = 100 * ca;
                l.plotX = M;
                l.plotY = (ta + (na || ra)) / 2;
                l.tooltipPos = [M, l.plotY];
                l.slice = S;
                l.half = Q;
                E += ca
            })
        },
        drawPoints: function () {
            var l = this,
                n = l.options,
                u = l.chart.renderer;
            aa(l.data, function (C) {
                var w = C.options,
                    p = C.graphic,
                    E = C.shapeArgs;
                p ? p.animate(E) : C.graphic = u.path(E).attr({
                    fill: C.color,
                    stroke: B(w.borderColor, n.borderColor),
                    "stroke-width": B(w.borderWidth, n.borderWidth)
                }).add(l.group)
            })
        },
        sortByAngle: function (l) {
            l.sort(function (l, n) {
                return l.plotY - n.plotY
            })
        },
        drawDataLabels: function () {
            var l = this.data,
                n = this.options.dataLabels.distance,
                B, C, w, p = l.length,
                E, K;
            for (this.center[2] -= 2 * n; p--;) w = l[p], C = (B = w.half) ? 1 : -1, K = w.plotY, E = this.getX(K, B), w.labelPos = [0, K, E + (n - 5) * C, K, E + n * C, K, B ? "right" : "left", 0];
            Y.pie.prototype.drawDataLabels.call(this)
        }
    });
    E.plotOptions.pyramid = n.merge(E.plotOptions.funnel, {
        neckWidth: "0%",
        neckHeight: "0%",
        reversed: !0
    });
    n.seriesTypes.pyramid = n.extendClass(n.seriesTypes.funnel, {
        type: "pyramid"
    })
})(Highcharts);
(function (n) {
    var E = n.Chart,
        O = n.addEvent,
        Y = n.removeEvent,
        Q = HighchartsAdapter.fireEvent,
        S = n.createElement,
        aa = n.discardElement,
        B = n.css,
        l = n.merge,
        y = n.each,
        u = n.extend,
        C = n.splat,
        w = Math.max,
        p = document,
        I = window,
        K = n.isTouchDevice,
        M = n.Renderer.prototype.symbols,
        J = n.getOptions(),
        A;
    u(J.lang, {
        printChart: "Print chart",
        downloadPNG: "Download PNG image",
        downloadJPEG: "Download JPEG image",
        downloadPDF: "Download PDF document",
        downloadSVG: "Download SVG vector image",
        contextButtonTitle: "Chart context menu"
    });
    J.navigation = {
        menuStyle: {
            border: "1px solid #A0A0A0",
            background: "#FFFFFF",
            padding: "5px 0"
        },
        menuItemStyle: {
            padding: "0 10px",
            background: "none",
            color: "#303030",
            fontSize: K ? "14px" : "11px"
        },
        menuItemHoverStyle: {
            background: "#4572A5",
            color: "#FFFFFF"
        },
        buttonOptions: {
            symbolFill: "#E0E0E0",
            symbolSize: 14,
            symbolStroke: "#666",
            symbolStrokeWidth: 3,
            symbolX: 12.5,
            symbolY: 10.5,
            align: "right",
            buttonSpacing: 3,
            height: 22,
            theme: {
                fill: "white",
                stroke: "none"
            },
            verticalAlign: "top",
            width: 24
        }
    };
    J.exporting = {
        type: "image/png",
        url: "http://export.highcharts.com/",
        buttons: {
            contextButton: {
                menuClassName: "highcharts-contextmenu",
                symbol: "menu",
                _titleKey: "contextButtonTitle",
                menuItems: [{
                    textKey: "printChart",
                    onclick: function () {
                        this.print()
                    }
                }, {
                    separator: !0
                }, {
                    textKey: "downloadPNG",
                    onclick: function () {
                        this.exportChart()
                    }
                }, {
                    textKey: "downloadJPEG",
                    onclick: function () {
                        this.exportChart({
                            type: "image/jpeg"
                        })
                    }
                }, {
                    textKey: "downloadPDF",
                    onclick: function () {
                        this.exportChart({
                            type: "application/pdf"
                        })
                    }
                }, {
                    textKey: "downloadSVG",
                    onclick: function () {
                        this.exportChart({
                            type: "image/svg+xml"
                        })
                    }
                }]
            }
        }
    };
    n.post = function (k, t, A) {
        var n;
        k = S("form", l({
            method: "post",
            action: k,
            enctype: "multipart/form-data"
        }, A), {
            display: "none"
        }, p.body);
        for (n in t) S("input", {
            type: "hidden",
            name: n,
            value: t[n]
        }, null, k);
        k.submit();
        aa(k)
    };
    u(E.prototype, {
        sanitizeSVG: function (k) {
            return k.replace(/zIndex="[^"]+"/g, "").replace(/isShadow="[^"]+"/g, "").replace(/symbolName="[^"]+"/g, "").replace(/jQuery[0-9]+="[^"]+"/g, "").replace(/url\([^#]+#/g, "url(#").replace(/<svg /, '<svg xmlns:xlink="http://www.w3.org/1999/xlink" ').replace(/ (NS[0-9]+\:)?href=/g, " xlink:href=").replace(/\n/, " ").replace(/<\/svg>.*?$/, "</svg>").replace(/(fill|stroke)="rgba\(([ 0-9]+,[ 0-9]+,[ 0-9]+),([ 0-9\.]+)\)"/g, '$1="rgb($2)" $1-opacity="$3"').replace(/(text-shadow:)([^;"]+)([;"])/g, function (k, l, p, A) {
                p = p.replace(/\([^\)]+\)/g, function (k) {
                    return k.replace(/,/g, "|")
                });
                p = p.split(",")[0];
                p = p.replace(/\([^\)]+\)/g, function (k) {
                    return k.replace(/\|/g, ",")
                });
                return l + p + A
            }).replace(/&nbsp;/g, "\u00a0").replace(/&shy;/g, "\u00ad").replace(/<IMG /g, "<image ").replace(/height=([^" ]+)/g, 'height="$1"').replace(/width=([^" ]+)/g, 'width="$1"').replace(/hc-svg-href="([^"]+)">/g, 'xlink:href="$1"/>').replace(/id=([^" >]+)/g, 'id="$1"').replace(/class=([^" >]+)/g, 'class="$1"').replace(/ transform /g, " ").replace(/:(path|rect)/g, "$1").replace(/style="([^"]+)"/g, function (k) {
                return k.toLowerCase()
            })
        },
        getSVG: function (k) {
            var t = this,
                A, B, w, J, E, I = l(t.options, k);
            p.createElementNS || (p.createElementNS = function (k, t) {
                return p.createElement(t)
            });
            B = S("div", null, {
                position: "absolute",
                top: "-9999em",
                width: t.chartWidth + "px",
                height: t.chartHeight + "px"
            }, p.body);
            w = t.renderTo.style.width;
            E = t.renderTo.style.height;
            w = I.exporting.sourceWidth || I.chart.width || /px$/.test(w) && parseInt(w, 10) || 600;
            E = I.exporting.sourceHeight || I.chart.height || /px$/.test(E) && parseInt(E, 10) || 400;
            u(I.chart, {
                animation: !1,
                renderTo: B,
                forExport: !0,
                width: w,
                height: E
            });
            I.exporting.enabled = !1;
            delete I.data;
            I.series = [];
            y(t.series, function (k) {
                J = l(k.options, {
                    animation: !1,
                    enableMouseTracking: !1,
                    showCheckbox: !1,
                    visible: k.visible
                });
                J.isInternal || I.series.push(J)
            });
            k && y(["xAxis", "yAxis"], function (t) {
                y(C(k[t]), function (k, p) {
                    I[t][p] = l(I[t][p], k)
                })
            });
            A = new n.Chart(I, t.callback);
            y(["xAxis", "yAxis"], function (k) {
                y(t[k], function (t, l) {
                    var p = A[k][l],
                        n = t.getExtremes(),
                        B = n.userMin,
                        n = n.userMax;
                    !p || void 0 === B && void 0 === n || p.setExtremes(B, n, !0, !1)
                })
            });
            w = A.container.innerHTML;
            I = null;
            A.destroy();
            aa(B);
            w = this.sanitizeSVG(w);
            return w = w.replace(/(url\(#highcharts-[0-9]+)&quot;/g, "$1").replace(/&quot;/g, "'")
        },
        getSVGForExport: function (k, t) {
            var p = this.options.exporting;
            return this.getSVG(l({
                chart: {
                    borderRadius: 0
                }
            }, p.chartOptions, t, {
                exporting: {
                    sourceWidth: k && k.sourceWidth || p.sourceWidth,
                    sourceHeight: k && k.sourceHeight || p.sourceHeight
                }
            }))
        },
        exportChart: function (k, t) {
            var p = this.getSVGForExport(k, t);
            k = l(this.options.exporting, k);
            n.post(k.url, {
                filename: k.filename || "chart",
                type: k.type,
                width: k.width || 0,
                scale: k.scale || 2,
                svg: p
            }, k.formAttributes)
        },
        print: function () {
            var k = this,
                t = k.container,
                l = [],
                A = t.parentNode,
                n = p.body,
                B = n.childNodes;
            k.isPrinting || (k.isPrinting = !0, Q(k, "beforePrint"), y(B, function (k, t) {
                1 === k.nodeType && (l[t] = k.style.display, k.style.display = "none")
            }), n.appendChild(t), I.focus(), I.print(), setTimeout(function () {
                A.appendChild(t);
                y(B, function (k, t) {
                    1 === k.nodeType && (k.style.display = l[t])
                });
                k.isPrinting = !1;
                Q(k, "afterPrint")
            }, 1E3))
        },
        contextMenu: function (k, t, l, p, A, n, C) {
            var J = this,
                E = J.options.navigation,
                I = E.menuItemStyle,
                K = J.chartWidth,
                M = J.chartHeight,
                aa = "cache-" + k,
                Q = J[aa],
                T = w(A, n),
                na, Xa, ab, bb = function (t) {
                    J.pointer.inClass(t.target, k) || Xa()
                };
            Q || (J[aa] = Q = S("div", {
                className: k
            }, {
                position: "absolute",
                zIndex: 1E3,
                padding: T + "px"
            }, J.container), na = S("div", null, u({
                MozBoxShadow: "3px 3px 10px #888",
                WebkitBoxShadow: "3px 3px 10px #888",
                boxShadow: "3px 3px 10px #888"
            }, E.menuStyle), Q), Xa = function () {
                B(Q, {
                    display: "none"
                });
                C && C.setState(0);
                J.openMenu = !1
            }, O(Q, "mouseleave", function () {
                ab = setTimeout(Xa, 500)
            }), O(Q, "mouseenter", function () {
                clearTimeout(ab)
            }), O(document, "mouseup", bb), O(J, "destroy", function () {
                Y(document, "mouseup", bb)
            }), y(t, function (k) {
                if (k) {
                    var t = k.separator ? S("hr", null, null, na) : S("div", {
                        onmouseover: function () {
                            B(this, E.menuItemHoverStyle)
                        },
                        onmouseout: function () {
                            B(this, I)
                        },
                        onclick: function () {
                            Xa();
                            k.onclick && k.onclick.apply(J, arguments)
                        },
                        innerHTML: k.text || J.options.lang[k.textKey]
                    }, u({
                        cursor: "pointer"
                    }, I), na);
                    J.exportDivElements.push(t)
                }
            }), J.exportDivElements.push(na, Q), J.exportMenuWidth = Q.offsetWidth, J.exportMenuHeight = Q.offsetHeight);
            t = {
                display: "block"
            };
            l + J.exportMenuWidth > K ? t.right = K - l - A - T + "px" : t.left = l - T + "px";
            p + n + J.exportMenuHeight > M && "top" !== C.alignOptions.verticalAlign ? t.bottom = M - p - T + "px" : t.top = p + n - T + "px";
            B(Q, t);
            J.openMenu = !0
        },
        addButton: function (k) {
            var t = this,
                p = t.renderer,
                B = l(t.options.navigation.buttonOptions, k),
                J = B.onclick,
                w = B.menuItems,
                C, y, E = {
                    stroke: B.symbolStroke,
                    fill: B.symbolFill
                }, I = B.symbolSize || 12;
            t.btnCount || (t.btnCount = 0);
            t.exportDivElements || (t.exportDivElements = [], t.exportSVGElements = []);
            if (!1 !== B.enabled) {
                var K = B.theme,
                    M = K.states,
                    aa = M && M.hover,
                    M = M && M.select,
                    O;
                delete K.states;
                J ? O = function () {
                    J.apply(t, arguments)
                } : w && (O = function () {
                    t.contextMenu(y.menuClassName, w, y.translateX, y.translateY, y.width, y.height, y);
                    y.setState(2)
                });
                B.text && B.symbol ? K.paddingLeft = n.pick(K.paddingLeft, 25) : B.text || u(K, {
                    width: B.width,
                    height: B.height,
                    padding: 0
                });
                y = p.button(B.text, 0, 0, O, K, aa, M).attr({
                    title: t.options.lang[B._titleKey],
                    "stroke-linecap": "round"
                });
                y.menuClassName = k.menuClassName || "highcharts-menu-" + t.btnCount++;
                B.symbol && (C = p.symbol(B.symbol, B.symbolX - I / 2, B.symbolY - I / 2, I, I).attr(u(E, {
                    "stroke-width": B.symbolStrokeWidth || 1,
                    zIndex: 1
                })).add(y));
                y.add().align(u(B, {
                    width: y.width,
                    x: n.pick(B.x, A)
                }), !0, "spacingBox");
                A += (y.width + B.buttonSpacing) * ("right" === B.align ? -1 : 1);
                t.exportSVGElements.push(y, C)
            }
        },
        destroyExport: function (k) {
            k = k.target;
            var t, l;
            for (t = 0; t < k.exportSVGElements.length; t++)
                if (l = k.exportSVGElements[t]) l.onclick = l.ontouchstart = null, k.exportSVGElements[t] = l.destroy();
            for (t = 0; t < k.exportDivElements.length; t++) l = k.exportDivElements[t], Y(l, "mouseleave"), k.exportDivElements[t] = l.onmouseout = l.onmouseover = l.ontouchstart = l.onclick = null, aa(l)
        }
    });
    M.menu = function (k, t, l, p) {
        return ["M", k, t + 2.5, "L", k + l, t + 2.5, "M", k, t + p / 2 + .5, "L", k + l, t + p / 2 + .5, "M", k, t + p - 1.5, "L", k + l, t + p - 1.5]
    };
    E.prototype.callbacks.push(function (k) {
        var t, l = k.options.exporting,
            p = l.buttons;
        A = 0;
        if (!1 !== l.enabled) {
            for (t in p) k.addButton(p[t]);
            O(k, "destroy", k.destroyExport)
        }
    })
})(Highcharts);
(function (n) {
    var E = n.each,
        O = n.pick,
        Y = HighchartsAdapter.inArray,
        Q = n.splat,
        S, aa = function (n, l) {
            this.init(n, l)
        };
    n.extend(aa.prototype, {
        init: function (n, l) {
            this.options = n;
            this.chartOptions = l;
            this.columns = n.columns || this.rowsToColumns(n.rows) || [];
            this.firstRowAsNames = O(n.firstRowAsNames, !0);
            this.decimalRegex = n.decimalPoint && new RegExp("^([0-9]+)" + n.decimalPoint + "([0-9]+)$");
            this.rawColumns = [];
            this.columns.length ? this.dataFound() : (this.parseCSV(), this.parseTable(), this.parseGoogleSpreadsheet())
        },
        getColumnDistribution: function () {
            var B = this.chartOptions,
                l = this.options,
                y = [],
                u = function (l) {
                    return (n.seriesTypes[l || "line"].prototype.pointArrayMap || [0]).length
                }, C = B && B.chart && B.chart.type,
                w = [],
                p = [],
                I = 0,
                K;
            E(B && B.series || [], function (l) {
                w.push(u(l.type || C))
            });
            E(l && l.seriesMapping || [], function (l) {
                y.push(l.x || 0)
            });
            0 === y.length && y.push(0);
            E(l && l.seriesMapping || [], function (l) {
                var J = new S,
                    A, k = w[I] || u(C),
                    t = n.seriesTypes[((B && B.series || [])[I] || {}).type || C || "line"].prototype.pointArrayMap || ["y"];
                J.addColumnReader(l.x, "x");
                for (A in l) l.hasOwnProperty(A) && "x" !== A && J.addColumnReader(l[A], A);
                for (K = 0; K < k; K++) J.hasReader(t[K]) || J.addColumnReader(void 0, t[K]);
                p.push(J);
                I++
            });
            l = n.seriesTypes[C || "line"].prototype.pointArrayMap;
            void 0 === l && (l = ["y"]);
            this.valueCount = {
                global: u(C),
                xColumns: y,
                individual: w,
                seriesBuilders: p,
                globalPointArrayMap: l
            }
        },
        dataFound: function () {
            this.options.switchRowsAndColumns && (this.columns = this.rowsToColumns(this.columns));
            this.getColumnDistribution();
            this.parseTypes();
            !1 !== this.parsed() && this.complete()
        },
        parseCSV: function () {
            var n = this,
                l = this.options,
                y = l.csv,
                u = this.columns,
                C = l.startRow || 0,
                w = l.endRow || Number.MAX_VALUE,
                p = l.startColumn || 0,
                I = l.endColumn || Number.MAX_VALUE,
                K, M, J = 0;
            y && (M = y.replace(/\r\n/g, "\n").replace(/\r/g, "\n").split(l.lineDelimiter || "\n"), K = l.itemDelimiter || (-1 !== y.indexOf("\t") ? "\t" : ","), E(M, function (l, k) {
                var t = n.trim(l),
                    F = 0 === t.indexOf("#");
                k >= C && k <= w && !F && "" !== t && (t = l.split(K), E(t, function (k, t) {
                    t >= p && t <= I && (u[t - p] || (u[t - p] = []), u[t - p][J] = k)
                }), J += 1)
            }), this.dataFound())
        },
        parseTable: function () {
            var n = this.options,
                l = n.table,
                y = this.columns,
                u = n.startRow || 0,
                C = n.endRow || Number.MAX_VALUE,
                w = n.startColumn || 0,
                p = n.endColumn || Number.MAX_VALUE;
            l && ("string" === typeof l && (l = document.getElementById(l)), E(l.getElementsByTagName("tr"), function (l, n) {
                n >= u && n <= C && E(l.children, function (l, B) {
                    ("TD" === l.tagName || "TH" === l.tagName) && B >= w && B <= p && (y[B - w] || (y[B - w] = []), y[B - w][n - u] = l.innerHTML)
                })
            }), this.dataFound())
        },
        parseGoogleSpreadsheet: function () {
            var n = this,
                l = this.options,
                y = l.googleSpreadsheetKey,
                u = this.columns,
                C = l.startRow || 0,
                w = l.endRow || Number.MAX_VALUE,
                p = l.startColumn || 0,
                E = l.endColumn || Number.MAX_VALUE,
                K, M;
            y && jQuery.ajax({
                dataType: "json",
                url: "https://spreadsheets.google.com/feeds/cells/" + y + "/" + (l.googleSpreadsheetWorksheet || "od6") + "/public/values?alt=json-in-script&callback=?",
                error: l.error,
                success: function (l) {
                    l = l.feed.entry;
                    var A, k = l.length,
                        t = 0,
                        F = 0,
                        y;
                    for (y = 0; y < k; y++) A = l[y], t = Math.max(t, A.gs$cell.col), F = Math.max(F, A.gs$cell.row);
                    for (y = 0; y < t; y++) y >= p && y <= E && (u[y - p] = [], u[y - p].length = Math.min(F, w - C));
                    for (y = 0; y < k; y++) A = l[y], K = A.gs$cell.row - 1, M = A.gs$cell.col - 1, M >= p && M <= E && K >= C && K <= w && (u[M - p][K - C] = A.content.$t);
                    n.dataFound()
                }
            })
        },
        trim: function (n, l) {
            "string" === typeof n && (n = n.replace(/^\s+|\s+$/g, ""), l && /^[0-9\s]+$/.test(n) && (n = n.replace(/\s/g, "")), this.decimalRegex && (n = n.replace(this.decimalRegex, "$1.$2")));
            return n
        },
        parseTypes: function () {
            for (var n = this.columns, l = n.length; l--;) this.parseColumn(n[l], l)
        },
        parseColumn: function (n, l) {
            var y = this.rawColumns,
                u = this.columns,
                C = n.length,
                w, p, E, K, M = this.firstRowAsNames,
                J = -1 !== Y(l, this.valueCount.xColumns),
                A = [],
                k = this.chartOptions,
                t, F = (this.options.columnTypes || [])[l],
                k = J && (k && k.xAxis && "category" === Q(k.xAxis)[0].type || "string" === F);
            for (y[l] || (y[l] = []); C--;) w = A[C] || n[C], E = this.trim(w), K = this.trim(w, !0), p = parseFloat(K), void 0 === y[l][C] && (y[l][C] = E), k || 0 === C && M ? n[C] = E : +K === p ? (n[C] = p, 31536E6 < p && "float" !== F ? n.isDatetime = !0 : n.isNumeric = !0, void 0 !== n[C + 1] && (t = p > n[C + 1])) : (p = this.parseDate(w), J && "number" === typeof p && !isNaN(p) && "float" !== F ? (A[C] = w, n[C] = p, n.isDatetime = !0, void 0 !== n[C + 1] && (w = p > n[C + 1], w !== t && void 0 !== t && (this.alternativeFormat ? (this.dateFormat = this.alternativeFormat, C = n.length, this.alternativeFormat = this.dateFormats[this.dateFormat].alternative) : n.unsorted = !0), t = w)) : (n[C] = "" === E ? null : E, 0 !== C && (n.isDatetime || n.isNumeric) && (n.mixed = !0)));
            J && n.mixed && (u[l] = y[l]);
            if (J && t && this.options.sort)
                for (l = 0; l < u.length; l++) u[l].reverse(), M && u[l].unshift(u[l].pop())
        },
        dateFormats: {
            "YYYY-mm-dd": {
                regex: /^([0-9]{4})[\-\/\.]([0-9]{2})[\-\/\.]([0-9]{2})$/,
                parser: function (n) {
                    return Date.UTC(+n[1], n[2] - 1, +n[3])
                }
            },
            "dd/mm/YYYY": {
                regex: /^([0-9]{1,2})[\-\/\.]([0-9]{1,2})[\-\/\.]([0-9]{4})$/,
                parser: function (n) {
                    return Date.UTC(+n[3], n[2] - 1, +n[1])
                },
                alternative: "mm/dd/YYYY"
            },
            "mm/dd/YYYY": {
                regex: /^([0-9]{1,2})[\-\/\.]([0-9]{1,2})[\-\/\.]([0-9]{4})$/,
                parser: function (n) {
                    return Date.UTC(+n[3], n[1] - 1, +n[2])
                }
            },
            "dd/mm/YY": {
                regex: /^([0-9]{1,2})[\-\/\.]([0-9]{1,2})[\-\/\.]([0-9]{2})$/,
                parser: function (n) {
                    return Date.UTC(+n[3] + 2E3, n[2] - 1, +n[1])
                },
                alternative: "mm/dd/YY"
            },
            "mm/dd/YY": {
                regex: /^([0-9]{1,2})[\-\/\.]([0-9]{1,2})[\-\/\.]([0-9]{2})$/,
                parser: function (n) {
                    return Date.UTC(+n[3] + 2E3, n[1] - 1, +n[2])
                }
            }
        },
        parseDate: function (n) {
            var l = this.options.parseDate,
                y, u, C = this.options.dateFormat || this.dateFormat,
                w;
            l && (y = l(n));
            if ("string" === typeof n) {
                if (C) l = this.dateFormats[C], (w = n.match(l.regex)) && (y = l.parser(w));
                else
                    for (u in this.dateFormats)
                        if (l = this.dateFormats[u], w = n.match(l.regex)) {
                            this.dateFormat = u;
                            this.alternativeFormat = l.alternative;
                            y = l.parser(w);
                            break
                        }
                w || (w = Date.parse(n), "object" === typeof w && null !== w && w.getTime ? y = w.getTime() - 6E4 * w.getTimezoneOffset() : "number" !== typeof w || isNaN(w) || (y = w - 6E4 * (new Date(w)).getTimezoneOffset()))
            }
            return y
        },
        rowsToColumns: function (n) {
            var l, y, u, C, w;
            if (n)
                for (w = [], y = n.length, l = 0; l < y; l++)
                    for (C = n[l].length, u = 0; u < C; u++) w[u] || (w[u] = []), w[u][l] = n[l][u];
            return w
        },
        parsed: function () {
            if (this.options.parsed) return this.options.parsed.call(this, this.columns)
        },
        getFreeIndexes: function (n, l) {
            var y, u, C = [],
                w = [],
                p;
            for (u = 0; u < n; u += 1) C.push(!0);
            for (y = 0; y < l.length; y += 1)
                for (p = l[y].getReferencedColumnIndexes(), u = 0; u < p.length; u += 1) C[p[u]] = !1;
            for (u = 0; u < C.length; u += 1) C[u] && w.push(u);
            return w
        },
        complete: function () {
            var n = this.columns,
                l, y = this.options,
                u, C, w, p, E = [],
                K;
            if (y.complete || y.afterComplete) {
                for (w = 0; w < n.length; w++) this.firstRowAsNames && (n[w].name = n[w].shift());
                u = [];
                C = this.getFreeIndexes(n.length, this.valueCount.seriesBuilders);
                for (w = 0; w < this.valueCount.seriesBuilders.length; w++) K = this.valueCount.seriesBuilders[w], K.populateColumns(C) && E.push(K);
                for (; 0 < C.length;) {
                    K = new S;
                    K.addColumnReader(0, "x");
                    w = Y(0, C);
                    -1 !== w && C.splice(w, 1);
                    for (w = 0; w < this.valueCount.global; w++) K.addColumnReader(void 0, this.valueCount.globalPointArrayMap[w]);
                    K.populateColumns(C) && E.push(K)
                }
                0 < E.length && 0 < E[0].readers.length && (K = n[E[0].readers[0].columnIndex], void 0 !== K && (K.isDatetime ? l = "datetime" : K.isNumeric || (l = "category")));
                if ("category" === l)
                    for (w = 0; w < E.length; w++)
                        for (K = E[w], C = 0; C < K.readers.length; C++) "x" === K.readers[C].configName && (K.readers[C].configName = "name");
                for (w = 0; w < E.length; w++) {
                    K = E[w];
                    C = [];
                    for (p = 0; p < n[0].length; p++) C[p] = K.read(n, p);
                    u[w] = {
                        data: C
                    };
                    K.name && (u[w].name = K.name);
                    "category" === l && (u[w].turboThreshold = 0)
                }
                n = {
                    series: u
                };
                l && (n.xAxis = {
                    type: l
                });
                y.complete && y.complete(n);
                y.afterComplete && y.afterComplete(n)
            }
        }
    });
    n.Data = aa;
    n.data = function (n, l) {
        return new aa(n, l)
    };
    n.wrap(n.Chart.prototype, "init", function (B, l, y) {
        var u = this;
        l && l.data ? n.data(n.extend(l.data, {
            afterComplete: function (C) {
                var w, p;
                if (l.hasOwnProperty("series"))
                    if ("object" === typeof l.series)
                        for (w = Math.max(l.series.length, C.series.length); w--;) p = l.series[w] || {}, l.series[w] = n.merge(p, C.series[w]);
                    else delete l.series;
                l = n.merge(C, l);
                B.call(u, l, y)
            }
        }), l) : B.call(u, l, y)
    });
    S = function () {
        this.readers = [];
        this.pointIsArray = !0
    };
    S.prototype.populateColumns = function (n) {
        var l = !0;
        E(this.readers, function (l) {
            void 0 === l.columnIndex && (l.columnIndex = n.shift())
        });
        E(this.readers, function (n) {
            void 0 === n.columnIndex && (l = !1)
        });
        return l
    };
    S.prototype.read = function (n, l) {
        var y = this.pointIsArray,
            u = y ? [] : {}, C;
        E(this.readers, function (w) {
            var p = n[w.columnIndex][l];
            y ? u.push(p) : u[w.configName] = p
        });
        void 0 === this.name && 2 <= this.readers.length && (C = this.getReferencedColumnIndexes(), 2 <= C.length && (C.shift(), C.sort(), this.name = n[C.shift()].name));
        return u
    };
    S.prototype.addColumnReader = function (n, l) {
        this.readers.push({
            columnIndex: n,
            configName: l
        });
        "x" !== l && "y" !== l && void 0 !== l && (this.pointIsArray = !1)
    };
    S.prototype.getReferencedColumnIndexes = function () {
        var n, l = [],
            y;
        for (n = 0; n < this.readers.length; n += 1) y = this.readers[n], void 0 !== y.columnIndex && l.push(y.columnIndex);
        return l
    };
    S.prototype.hasReader = function (n) {
        var l, y;
        for (l = 0; l < this.readers.length; l += 1)
            if (y = this.readers[l], y.configName === n) return !0
    }
})(Highcharts);
(function (n) {
    function E() {
        return !!this.points.length
    }

    function O() {
        this.hasData() ? this.hideNoData() : this.showNoData()
    }

    var Y = n.seriesTypes,
        Q = n.Chart.prototype,
        S = n.getOptions(),
        aa = n.extend,
        B = n.each;
    aa(S.lang, {
        noData: "No data to display"
    });
    S.noData = {
        position: {
            x: 0,
            y: 0,
            align: "center",
            verticalAlign: "middle"
        },
        attr: {},
        style: {
            fontWeight: "bold",
            fontSize: "12px",
            color: "#60606a"
        }
    };
    B(["pie", "gauge", "waterfall", "bubble"], function (l) {
        Y[l] && (Y[l].prototype.hasData = E)
    });
    n.Series.prototype.hasData = function () {
        return this.visible && void 0 !== this.dataMax && void 0 !== this.dataMin
    };
    Q.showNoData = function (l) {
        var n = this.options;
        l = l || n.lang.noData;
        n = n.noData;
        this.noDataLabel || (this.noDataLabel = this.renderer.label(l, 0, 0, null, null, null, null, null, "no-data").attr(n.attr).css(n.style).add(), this.noDataLabel.align(aa(this.noDataLabel.getBBox(), n.position), !1, "plotBox"))
    };
    Q.hideNoData = function () {
        this.noDataLabel && (this.noDataLabel = this.noDataLabel.destroy())
    };
    Q.hasData = function () {
        for (var l = this.series, n = l.length; n--;)
            if (l[n].hasData() && !l[n].options.isInternal) return !0;
        return !1
    };
    Q.callbacks.push(function (l) {
        n.addEvent(l, "load", O);
        n.addEvent(l, "redraw", O)
    })
})(Highcharts);
(function (n) {
    function E(l, k, t) {
        var n;
        l = l.rgba;
        k = k.rgba;
        n = 1 !== k[3] || 1 !== l[3];
        k.length && l.length || Highcharts.error(23);
        return (n ? "rgba(" : "rgb(") + Math.round(k[0] + (l[0] - k[0]) * (1 - t)) + "," + Math.round(k[1] + (l[1] - k[1]) * (1 - t)) + "," + Math.round(k[2] + (l[2] - k[2]) * (1 - t)) + (n ? "," + (k[3] + (l[3] - k[3]) * (1 - t)) : "") + ")"
    }

    var O = function () {
        }, Y = n.getOptions(),
        Q = n.each,
        S = n.extend,
        aa = n.format,
        B = n.pick,
        l = n.wrap,
        y = n.Chart,
        u = n.seriesTypes,
        C = u.pie,
        w = u.column,
        p = HighchartsAdapter.fireEvent,
        I = HighchartsAdapter.inArray,
        K = [],
        M = 1;
    Q(["fill", "stroke"], function (l) {
        HighchartsAdapter.addAnimSetter(l, function (k) {
            k.elem.attr(l, E(n.Color(k.start), n.Color(k.end), k.pos))
        })
    });
    S(Y.lang, {
        drillUpText: "\u25c1 Back to {series.name}"
    });
    Y.drilldown = {
        activeAxisLabelStyle: {
            cursor: "pointer",
            color: "#0d233a",
            fontWeight: "bold",
            textDecoration: "underline"
        },
        activeDataLabelStyle: {
            cursor: "pointer",
            color: "#0d233a",
            fontWeight: "bold",
            textDecoration: "underline"
        },
        animation: {
            duration: 500
        },
        drillUpButton: {
            position: {
                align: "right",
                x: -10,
                y: 10
            }
        }
    };
    n.SVGRenderer.prototype.Element.prototype.fadeIn = function (l) {
        this.attr({
            opacity: .1,
            visibility: "inherit"
        }).animate({
            opacity: B(this.newOpacity, 1)
        }, l || {
                duration: 250
            })
    };
    y.prototype.addSeriesAsDrilldown = function (l, k) {
        this.addSingleSeriesAsDrilldown(l, k);
        this.applyDrilldown()
    };
    y.prototype.addSingleSeriesAsDrilldown = function (l, k) {
        var t = l.series,
            n = t.xAxis,
            p = t.yAxis,
            u;
        u = l.color || t.color;
        var w, y = [],
            C = [],
            B;
        B = t.options._levelNumber || 0;
        k = S({
            color: u,
            _ddSeriesId: M++
        }, k);
        w = I(l, t.points);
        Q(t.chart.series, function (k) {
            k.xAxis === n && (y.push(k), k.options._ddSeriesId = k.options._ddSeriesId || M++, k.options._colorIndex = k.userOptions._colorIndex, C.push(k.options), k.options._levelNumber = k.options._levelNumber || B)
        });
        u = {
            levelNumber: B,
            seriesOptions: t.options,
            levelSeriesOptions: C,
            levelSeries: y,
            shapeArgs: l.shapeArgs,
            bBox: l.graphic ? l.graphic.getBBox() : {},
            color: u,
            lowerSeriesOptions: k,
            pointOptions: t.options.data[w],
            pointIndex: w,
            oldExtremes: {
                xMin: n && n.userMin,
                xMax: n && n.userMax,
                yMin: p && p.userMin,
                yMax: p && p.userMax
            }
        };
        this.drilldownLevels || (this.drilldownLevels = []);
        this.drilldownLevels.push(u);
        u = u.lowerSeries = this.addSeries(k, !1);
        u.options._levelNumber = B + 1;
        n && (n.oldPos = n.pos, n.userMin = n.userMax = null, p.userMin = p.userMax = null);
        t.type === u.type && (u.animate = u.animateDrilldown || O, u.options.animation = !0)
    };
    y.prototype.applyDrilldown = function () {
        var l = this.drilldownLevels,
            k;
        l && 0 < l.length && (k = l[l.length - 1].levelNumber, Q(this.drilldownLevels, function (l) {
            l.levelNumber === k && Q(l.levelSeries, function (l) {
                l.options && l.options._levelNumber === k && l.remove(!1)
            })
        }));
        this.redraw();
        this.showDrillUpButton()
    };
    y.prototype.getDrilldownBackText = function () {
        var l = this.drilldownLevels;
        if (l && 0 < l.length) return l = l[l.length - 1], l.series = l.seriesOptions, aa(this.options.lang.drillUpText, l)
    };
    y.prototype.showDrillUpButton = function () {
        var l = this,
            k = this.getDrilldownBackText(),
            t = l.options.drilldown.drillUpButton,
            n, p;
        this.drillUpButton ? this.drillUpButton.attr({
            text: k
        }).align() : (p = (n = t.theme) && n.states, this.drillUpButton = this.renderer.button(k, null, null, function () {
            l.drillUp()
        }, n, p && p.hover, p && p.select).attr({
            align: t.position.align,
            zIndex: 9
        }).add().align(t.position, !1, t.relativeTo || "plotBox"))
    };
    y.prototype.drillUp = function () {
        for (var l = this, k = l.drilldownLevels, t = k[k.length - 1].levelNumber, n = k.length, u = l.series, w, B, y, C, J = function (k) {
            var t;
            Q(u, function (l) {
                l.options._ddSeriesId === k._ddSeriesId && (t = l)
            });
            t = t || l.addSeries(k, !1);
            t.type === y.type && t.animateDrillupTo && (t.animate = t.animateDrillupTo);
            k === B.seriesOptions && (C = t)
        }; n--;)
            if (B = k[n], B.levelNumber === t) {
                k.pop();
                y = B.lowerSeries;
                if (!y.chart)
                    for (w = u.length; w--;)
                        if (u[w].options.id === B.lowerSeriesOptions.id) {
                            y = u[w];
                            break
                        }
                y.xData = [];
                Q(B.levelSeriesOptions, J);
                p(l, "drillup", {
                    seriesOptions: B.seriesOptions
                });
                C.type === y.type && (C.drilldownLevel = B, C.options.animation = l.options.drilldown.animation, y.animateDrillupFrom && y.chart && y.animateDrillupFrom(B));
                C.options._levelNumber = t;
                y.remove(!1);
                C.xAxis && (w = B.oldExtremes, C.xAxis.setExtremes(w.xMin, w.xMax, !1), C.yAxis.setExtremes(w.yMin, w.yMax, !1))
            }
        this.redraw();
        0 === this.drilldownLevels.length ? this.drillUpButton = this.drillUpButton.destroy() : this.drillUpButton.attr({
            text: this.getDrilldownBackText()
        }).align();
        K.length = []
    };
    w.prototype.supportsDrilldown = !0;
    w.prototype.animateDrillupTo = function (l) {
        if (!l) {
            var k = this,
                t = k.drilldownLevel;
            Q(this.points, function (k) {
                k.graphic && k.graphic.hide();
                k.dataLabel && k.dataLabel.hide();
                k.connector && k.connector.hide()
            });
            setTimeout(function () {
                k.points && Q(k.points, function (k, l) {
                    var n = l === (t && t.pointIndex) ? "show" : "fadeIn",
                        p = "show" === n ? !0 : void 0;
                    if (k.graphic) k.graphic[n](p);
                    if (k.dataLabel) k.dataLabel[n](p);
                    if (k.connector) k.connector[n](p)
                })
            }, Math.max(this.chart.options.drilldown.animation.duration - 50, 0));
            this.animate = O
        }
    };
    w.prototype.animateDrilldown = function (l) {
        var k = this,
            t = this.chart.drilldownLevels,
            n, p = this.chart.options.drilldown.animation,
            u = this.xAxis;
        l || (Q(t, function (l) {
            k.options._ddSeriesId === l.lowerSeriesOptions._ddSeriesId && (n = l.shapeArgs, n.fill = l.color)
        }), n.x += B(u.oldPos, u.pos) - u.pos, Q(this.points, function (k) {
            k.graphic && k.graphic.attr(n).animate(S(k.shapeArgs, {
                fill: k.color
            }), p);
            k.dataLabel && k.dataLabel.fadeIn(p)
        }), this.animate = null)
    };
    w.prototype.animateDrillupFrom = function (l) {
        var k = this.chart.options.drilldown.animation,
            t = this.group,
            p = this;
        Q(p.trackerGroups, function (k) {
            if (p[k]) p[k].on("mouseover")
        });
        delete this.group;
        Q(this.points, function (p) {
            var u = p.graphic,
                w = function () {
                    u.destroy();
                    t && (t = t.destroy())
                };
            u && (delete p.graphic, k ? u.animate(S(l.shapeArgs, {
                fill: l.color
            }), n.merge(k, {
                complete: w
            })) : (u.attr(l.shapeArgs), w()))
        })
    };
    C && S(C.prototype, {
        supportsDrilldown: !0,
        animateDrillupTo: w.prototype.animateDrillupTo,
        animateDrillupFrom: w.prototype.animateDrillupFrom,
        animateDrilldown: function (l) {
            var k = this.chart.drilldownLevels[this.chart.drilldownLevels.length - 1],
                t = this.chart.options.drilldown.animation,
                p = k.shapeArgs,
                u = p.start,
                w = (p.end - u) / this.points.length;
            l || (Q(this.points, function (l, A) {
                l.graphic.attr(n.merge(p, {
                    start: u + A * w,
                    end: u + (A + 1) * w,
                    fill: k.color
                }))[t ? "animate" : "attr"](S(l.shapeArgs, {
                    fill: l.color
                }), t)
            }), this.animate = null)
        }
    });
    n.Point.prototype.doDrilldown = function (l, k) {
        for (var t = this.series.chart, n = t.options.drilldown, u = (n.series || []).length, w; u-- && !w;) n.series[u].id === this.drilldown && -1 === I(this.drilldown, K) && (w = n.series[u], K.push(this.drilldown));
        p(t, "drilldown", {
            point: this,
            seriesOptions: w,
            category: k,
            points: void 0 !== k && this.series.xAxis.ticks[k].label.ddPoints.slice(0)
        });
        w && (l ? t.addSingleSeriesAsDrilldown(this, w) : t.addSeriesAsDrilldown(this, w))
    };
    n.Axis.prototype.drilldownCategory = function (l) {
        Q(this.ticks[l].label.ddPoints, function (k) {
            k.series && k.series.visible && k.doDrilldown && k.doDrilldown(!0, l)
        });
        this.chart.applyDrilldown()
    };
    l(n.Point.prototype, "init", function (l, k, t, p) {
        var u = l.call(this, k, t, p);
        l = k.chart;
        if (t = (t = k.xAxis && k.xAxis.ticks[p]) && t.label) t.ddPoints || (t.ddPoints = []), t.levelNumber !== k.options._levelNumber && (t.ddPoints.length = 0);
        u.drilldown ? (n.addEvent(u, "click", function () {
            u.doDrilldown()
        }), t && (t.basicStyles || (t.basicStyles = n.merge(t.styles)), t.addClass("highcharts-drilldown-axis-label").css(l.options.drilldown.activeAxisLabelStyle).on("click", function () {
            k.xAxis.drilldownCategory(p)
        }), t.ddPoints.push(u), t.levelNumber = k.options._levelNumber)) : t && t.basicStyles && t.levelNumber !== k.options._levelNumber && (t.styles = {}, t.css(t.basicStyles), t.on("click", null));
        return u
    });
    l(n.Series.prototype, "drawDataLabels", function (l) {
        var k = this.chart.options.drilldown.activeDataLabelStyle;
        l.call(this);
        Q(this.points, function (l) {
            if (l.drilldown && l.dataLabel) l.dataLabel.attr({
                "class": "highcharts-drilldown-data-label"
            }).css(k).on("click", function () {
                l.doDrilldown()
            })
        })
    });
    var J, Y = function (l) {
        l.call(this);
        Q(this.points, function (k) {
            k.drilldown && k.graphic && k.graphic.attr({
                "class": "highcharts-drilldown-point"
            }).css({
                cursor: "pointer"
            })
        })
    };
    for (J in u) u[J].prototype.supportsDrilldown && l(u[J].prototype, "drawTracker", Y)
})(Highcharts);
(function (n) {
    var E = n.getOptions().plotOptions,
        O = n.pInt,
        Y = n.pick,
        Q = n.each,
        S;
    E.solidgauge = n.merge(E.gauge, {
        colorByPoint: !0
    });
    S = {
        initDataClasses: function (E) {
            var B = this,
                l = this.chart,
                y, u = 0,
                C = this.options;
            this.dataClasses = y = [];
            Q(E.dataClasses, function (w, p) {
                var I;
                w = n.merge(w);
                y.push(w);
                w.color || ("category" === C.dataClassColor ? (I = l.options.colors, w.color = I[u++], u === I.length && (u = 0)) : w.color = B.tweenColors(n.Color(C.minColor), n.Color(C.maxColor), p / (E.dataClasses.length - 1)))
            })
        },
        initStops: function (E) {
            this.stops = E.stops || [
                    [0, this.options.minColor],
                    [1, this.options.maxColor]
                ];
            Q(this.stops, function (B) {
                B.color = n.Color(B[1])
            })
        },
        toColor: function (n, B) {
            var l, y = this.stops,
                u, C = this.dataClasses,
                w, p;
            if (C)
                for (p = C.length; p--;) {
                    if (w = C[p], u = w.from, y = w.to, (void 0 === u || n >= u) && (void 0 === y || n <= y)) {
                        l = w.color;
                        B && (B.dataClass = p);
                        break
                    }
                } else {
                this.isLog && (n = this.val2lin(n));
                l = 1 - (this.max - n) / (this.max - this.min);
                for (p = y.length; p-- && !(l > y[p][0]););
                u = y[p] || y[p + 1];
                y = y[p + 1] || u;
                l = 1 - (y[0] - l) / (y[0] - u[0] || 1);
                l = this.tweenColors(u.color, y.color, l)
            }
            return l
        },
        tweenColors: function (n, B, l) {
            var y = 1 !== B.rgba[3] || 1 !== n.rgba[3];
            return 0 === n.rgba.length || 0 === B.rgba.length ? "none" : (y ? "rgba(" : "rgb(") + Math.round(B.rgba[0] + (n.rgba[0] - B.rgba[0]) * (1 - l)) + "," + Math.round(B.rgba[1] + (n.rgba[1] - B.rgba[1]) * (1 - l)) + "," + Math.round(B.rgba[2] + (n.rgba[2] - B.rgba[2]) * (1 - l)) + (y ? "," + (B.rgba[3] + (n.rgba[3] - B.rgba[3]) * (1 - l)) : "") + ")"
        }
    };
    Q(["fill", "stroke"], function (E) {
        HighchartsAdapter.addAnimSetter(E, function (B) {
            B.elem.attr(E, S.tweenColors(n.Color(B.start), n.Color(B.end), B.pos))
        })
    });
    n.seriesTypes.solidgauge = n.extendClass(n.seriesTypes.gauge, {
        type: "solidgauge",
        bindAxes: function () {
            var E;
            n.seriesTypes.gauge.prototype.bindAxes.call(this);
            E = this.yAxis;
            n.extend(E, S);
            E.options.dataClasses && E.initDataClasses(E.options);
            E.initStops(E.options)
        },
        drawPoints: function () {
            var E = this,
                B = E.yAxis,
                l = B.center,
                y = E.options,
                u = E.radius = O(Y(y.radius, 100)) * l[2] / 200,
                C = E.chart.renderer,
                w = y.overshoot,
                p = w && "number" === typeof w ? w / 180 * Math.PI : 0;
            n.each(E.points, function (n) {
                var w = n.graphic,
                    M = B.startAngleRad + B.translate(n.y, null, null, null, !0),
                    J = O(Y(y.innerRadius, 60)) * l[2] / 200,
                    A = B.toColor(n.y, n);
                "none" === A && (A = n.color || E.color || "none");
                "none" !== A && (n.color = A);
                M = Math.max(B.startAngleRad - p, Math.min(B.endAngleRad + p, M));
                !1 === y.wrap && (M = Math.max(B.startAngleRad, Math.min(B.endAngleRad, M)));
                var M = 180 * M / Math.PI,
                    k = M / (180 / Math.PI),
                    t = B.startAngleRad,
                    M = Math.min(k, t),
                    k = Math.max(k, t);
                k - M > 2 * Math.PI && (k = M + 2 * Math.PI);
                n.shapeArgs = J = {
                    x: l[0],
                    y: l[1],
                    r: u,
                    innerR: J,
                    start: M,
                    end: k,
                    fill: A
                };
                w ? (n = J.d, w.animate(J), J.d = n) : n.graphic = C.arc(J).attr({
                    stroke: y.borderColor || "none",
                    "stroke-width": y.borderWidth || 0,
                    fill: A,
                    "sweep-flag": 0
                }).add(E.group)
            })
        },
        animate: function (E) {
            this.center = this.yAxis.center;
            this.center[3] = 2 * this.radius;
            this.startAngleRad = this.yAxis.startAngleRad;
            n.seriesTypes.pie.prototype.animate.call(this, E)
        }
    })
})(Highcharts);
(function (n) {
    var E = n.Axis,
        O = n.Chart,
        Y = n.Color,
        Q = n.Legend,
        S = n.LegendSymbolMixin,
        aa = n.Series,
        B = n.getOptions(),
        l = n.each,
        y = n.extend,
        u = n.extendClass,
        C = n.merge,
        w = n.pick,
        p = n.seriesTypes,
        I = n.wrap,
        K = function () {
        }, M = n.ColorAxis = function () {
            this.isColorAxis = !0;
            this.init.apply(this, arguments)
        };
    y(M.prototype, E.prototype);
    y(M.prototype, {
        defaultColorAxisOptions: {
            lineWidth: 0,
            gridLineWidth: 1,
            tickPixelInterval: 72,
            startOnTick: !0,
            endOnTick: !0,
            offset: 0,
            marker: {
                animation: {
                    duration: 50
                },
                color: "gray",
                width: .01
            },
            labels: {
                overflow: "justify"
            },
            minColor: "#EFEFFF",
            maxColor: "#003875",
            tickLength: 5
        },
        init: function (l, n) {
            var k = "vertical" !== l.options.legend.layout,
                t;
            t = C(this.defaultColorAxisOptions, {
                side: k ? 2 : 1,
                reversed: !k
            }, n, {
                isX: k,
                opposite: !k,
                showEmpty: !1,
                title: null,
                isColor: !0
            });
            E.prototype.init.call(this, l, t);
            n.dataClasses && this.initDataClasses(n);
            this.initStops(n);
            this.isXAxis = !0;
            this.horiz = k;
            this.zoomEnabled = !1
        },
        tweenColors: function (l, p, k) {
            var t;
            l = l.rgba;
            p = p.rgba;
            t = 1 !== p[3] || 1 !== l[3];
            p.length && l.length || n.error(23);
            return (t ? "rgba(" : "rgb(") + Math.round(p[0] + (l[0] - p[0]) * (1 - k)) + "," + Math.round(p[1] + (l[1] - p[1]) * (1 - k)) + "," + Math.round(p[2] + (l[2] - p[2]) * (1 - k)) + (t ? "," + (p[3] + (l[3] - p[3]) * (1 - k)) : "") + ")"
        },
        initDataClasses: function (n) {
            var p = this,
                k = this.chart,
                t, u = 0,
                w = this.options,
                B = n.dataClasses.length;
            this.dataClasses = t = [];
            this.legendItems = [];
            l(n.dataClasses, function (l, n) {
                var y;
                l = C(l);
                t.push(l);
                l.color || ("category" === w.dataClassColor ? (y = k.options.colors, l.color = y[u++], u === y.length && (u = 0)) : l.color = p.tweenColors(Y(w.minColor), Y(w.maxColor), 2 > B ? .5 : n / (B - 1)))
            })
        },
        initStops: function (n) {
            this.stops = n.stops || [
                    [0, this.options.minColor],
                    [1, this.options.maxColor]
                ];
            l(this.stops, function (l) {
                l.color = Y(l[1])
            })
        },
        setOptions: function (l) {
            E.prototype.setOptions.call(this, l);
            this.options.crosshair = this.options.marker;
            this.coll = "colorAxis"
        },
        setAxisSize: function () {
            var l = this.legendSymbol,
                n = this.chart,
                k, t, p;
            l && (this.left = k = l.attr("x"), this.top = t = l.attr("y"), this.width = p = l.attr("width"), this.height = l = l.attr("height"), this.right = n.chartWidth - k - p, this.bottom = n.chartHeight - t - l, this.len = this.horiz ? p : l, this.pos = this.horiz ? k : t)
        },
        toColor: function (l, n) {
            var k, t = this.stops,
                p, u = this.dataClasses,
                w, y;
            if (u)
                for (y = u.length; y--;) {
                    if (w = u[y], p = w.from, t = w.to, (void 0 === p || l >= p) && (void 0 === t || l <= t)) {
                        k = w.color;
                        n && (n.dataClass = y);
                        break
                    }
                } else {
                this.isLog && (l = this.val2lin(l));
                k = 1 - (this.max - l) / (this.max - this.min || 1);
                for (y = t.length; y-- && !(k > t[y][0]););
                p = t[y] || t[y + 1];
                t = t[y + 1] || p;
                k = 1 - (t[0] - k) / (t[0] - p[0] || 1);
                k = this.tweenColors(p.color, t.color, k)
            }
            return k
        },
        getOffset: function () {
            var l = this.legendGroup,
                n = this.chart.axisOffset[this.side];
            l && (E.prototype.getOffset.call(this), this.axisGroup.parentGroup || (this.axisGroup.add(l), this.gridGroup.add(l), this.labelGroup.add(l), this.added = !0, this.labelLeft = 0, this.labelRight = this.width), this.chart.axisOffset[this.side] = n)
        },
        setLegendColor: function () {
            var l, n = this.options;
            l = this.reversed;
            l = this.horiz ? [+l, 0, +!l, 0] : [0, +!l, 0, +l];
            this.legendColor = {
                linearGradient: {
                    x1: l[0],
                    y1: l[1],
                    x2: l[2],
                    y2: l[3]
                },
                stops: n.stops || [
                    [0, n.minColor],
                    [1, n.maxColor]
                ]
            }
        },
        drawLegendSymbol: function (l, n) {
            var k = l.padding,
                t = l.options,
                p = this.horiz,
                u = w(t.symbolWidth, p ? 200 : 12),
                y = w(t.symbolHeight, p ? 12 : 200),
                B = w(t.labelPadding, p ? 16 : 30),
                t = w(t.itemDistance, 10);
            this.setLegendColor();
            n.legendSymbol = this.chart.renderer.rect(0, l.baseline - 11, u, y).attr({
                zIndex: 1
            }).add(n.legendGroup);
            n.legendSymbol.getBBox();
            this.legendItemWidth = u + k + (p ? t : B);
            this.legendItemHeight = y + k + (p ? B : 0)
        },
        setState: K,
        visible: !0,
        setVisible: K,
        getSeriesExtremes: function () {
            var l;
            this.series.length && (l = this.series[0], this.dataMin = l.valueMin, this.dataMax = l.valueMax)
        },
        drawCrosshair: function (l, n) {
            var k = n && n.plotX,
                t = n && n.plotY,
                p, u = this.pos,
                w = this.len;
            n && (p = this.toPixels(n[n.series.colorKey]), p < u ? p = u - 2 : p > u + w && (p = u + w + 2), n.plotX = p, n.plotY = this.len - p, E.prototype.drawCrosshair.call(this, l, n), n.plotX = k, n.plotY = t, this.cross && this.cross.attr({
                fill: this.crosshair.color
            }).add(this.legendGroup))
        },
        getPlotLinePath: function (l, n, k, t, p) {
            return p ? this.horiz ? ["M", p - 4, this.top - 6, "L", p + 4, this.top - 6, p, this.top, "Z"] : ["M", this.left, p, "L", this.left - 6, p + 6, this.left - 6, p - 6, "Z"] : E.prototype.getPlotLinePath.call(this, l, n, k, t)
        },
        update: function (n, p) {
            l(this.series, function (k) {
                k.isDirtyData = !0
            });
            E.prototype.update.call(this, n, p);
            this.legendItem && (this.setLegendColor(), this.chart.legend.colorizeItem(this, !0))
        },
        getDataClassLegendSymbols: function () {
            var p = this,
                u = this.chart,
                k = this.legendItems,
                t = u.options.legend,
                w = t.valueDecimals,
                B = t.valueSuffix || "",
                C;
            k.length || l(this.dataClasses, function (t, E) {
                var I = !0,
                    M = t.from,
                    O = t.to;
                C = "";
                void 0 === M ? C = "< " : void 0 === O && (C = "> ");
                void 0 !== M && (C += n.numberFormat(M, w) + B);
                void 0 !== M && void 0 !== O && (C += " - ");
                void 0 !== O && (C += n.numberFormat(O, w) + B);
                k.push(y({
                    chart: u,
                    name: C,
                    options: {},
                    drawLegendSymbol: S.drawRectangle,
                    visible: !0,
                    setState: K,
                    setVisible: function () {
                        I = this.visible = !I;
                        l(p.series, function (k) {
                            l(k.points, function (k) {
                                k.dataClass === E && k.setVisible(I)
                            })
                        });
                        u.legend.colorizeItem(this, I)
                    }
                }, t))
            });
            return k
        },
        name: ""
    });
    l(["fill", "stroke"], function (l) {
        HighchartsAdapter.addAnimSetter(l, function (n) {
            n.elem.attr(l, M.prototype.tweenColors(Y(n.start), Y(n.end), n.pos))
        })
    });
    I(O.prototype, "getAxes", function (l) {
        var n = this.options.colorAxis;
        l.call(this);
        this.colorAxis = [];
        n && new M(this, n)
    });
    I(Q.prototype, "getAllItems", function (n) {
        var p = [],
            k = this.chart.colorAxis[0];
        k && (k.options.dataClasses ? p = p.concat(k.getDataClassLegendSymbols()) : p.push(k), l(k.series, function (k) {
            k.options.showInLegend = !1
        }));
        return p.concat(n.call(this))
    });
    O = {
        pointAttrToOptions: {
            stroke: "borderColor",
            "stroke-width": "borderWidth",
            fill: "color",
            dashstyle: "dashStyle"
        },
        pointArrayMap: ["value"],
        axisTypes: ["xAxis", "yAxis", "colorAxis"],
        optionalAxis: "colorAxis",
        trackerGroups: ["group", "markerGroup", "dataLabelsGroup"],
        getSymbol: K,
        parallelArrays: ["x", "y", "value"],
        colorKey: "value",
        translateColors: function () {
            var n = this,
                p = this.options.nullColor,
                k = this.colorAxis,
                t = this.colorKey;
            l(this.data, function (l) {
                var u = l[t];
                if (u = null === u ? p : k && void 0 !== u ? k.toColor(u, l) : l.color || n.color) l.color = u
            })
        }
    };
    B.plotOptions.heatmap = C(B.plotOptions.scatter, {
        animation: !1,
        borderWidth: 0,
        nullColor: "#F8F8F8",
        dataLabels: {
            formatter: function () {
                return this.point.value
            },
            inside: !0,
            verticalAlign: "middle",
            crop: !1,
            overflow: !1,
            padding: 0
        },
        marker: null,
        tooltip: {
            pointFormat: "{point.x}, {point.y}: {point.value}<br/>"
        },
        states: {
            normal: {
                animation: !0
            },
            hover: {
                halo: !1,
                brightness: .2
            }
        }
    });
    p.heatmap = u(p.scatter, C(O, {
        type: "heatmap",
        pointArrayMap: ["y", "value"],
        hasPointSpecificOptions: !0,
        supportsDrilldown: !0,
        getExtremesFromAll: !0,
        init: function () {
            p.scatter.prototype.init.apply(this, arguments);
            this.pointRange = this.options.colsize || 1;
            this.yAxis.axisPointRange = this.options.rowsize || 1
        },
        translate: function () {
            var n = this.options,
                p = this.xAxis,
                k = this.yAxis;
            this.generatePoints();
            l(this.points, function (l) {
                var u = (n.colsize || 1) / 2,
                    w = (n.rowsize || 1) / 2,
                    y = Math.round(p.len - p.translate(l.x - u, 0, 1, 0, 1)),
                    u = Math.round(p.len - p.translate(l.x + u, 0, 1, 0, 1)),
                    B = Math.round(k.translate(l.y - w, 0, 1, 0, 1)),
                    w = Math.round(k.translate(l.y + w, 0, 1, 0, 1));
                l.plotX = (y + u) / 2;
                l.plotY = (B + w) / 2;
                l.shapeType = "rect";
                l.shapeArgs = {
                    x: Math.min(y, u),
                    y: Math.min(B, w),
                    width: Math.abs(u - y),
                    height: Math.abs(w - B)
                }
            });
            this.translateColors();
            this.chart.hasRendered && l(this.points, function (k) {
                k.shapeArgs.fill = k.options.color || k.color
            })
        },
        drawPoints: p.column.prototype.drawPoints,
        animate: K,
        getBox: K,
        drawLegendSymbol: S.drawRectangle,
        getExtremes: function () {
            aa.prototype.getExtremes.call(this, this.valueData);
            this.valueMin = this.dataMin;
            this.valueMax = this.dataMax;
            aa.prototype.getExtremes.call(this)
        }
    }))
})(Highcharts);