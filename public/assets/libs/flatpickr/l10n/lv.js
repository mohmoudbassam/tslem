/* flatpickr v4.5.2, @license MIT */
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
    typeof define === 'function' && define.amd ? define(['exports'], factory) :
    (factory((global.lv = {})));
}(this, (function (exports) { 'use strict';

    const fp = typeof window !== "undefined" && window.flatpickr !== undefined
        ? window.flatpickr
        : {
            l10ns: {},
        };
    const Latvian = {
        firstDayOfWeek: 1,
        weekdays: {
            shorthand: ["Sv", "Pr", "Ot", "Tr", "Ce", "Pk", "Se"],
            longhand: [
                "Svētdiena",
                "Pirmdiena",
                "Otrdiena",
                "Trešdiena",
                "Ceturtdiena",
                "Piektdiena",
                "Sestdiena",
            ],
        },
        months: {
            shorthand: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "Mai",
                "Jūn",
                "Jūl",
                "Aug",
                "Sep",
                "Okt",
                "Nov",
                "Dec",
            ],
            longhand: [
                "Janvāris",
                "Februāris",
                "Marts",
                "Aprīlis",
                "Maijs",
                "Jūnijs",
                "Jūlijs",
                "Augusts",
                "Septembris",
                "Oktobris",
                "Novembris",
                "Decembris",
            ],
        },
        rangeSeparator: " līdz ",
    };
    fp.l10ns.lv = Latvian;
    var lv = fp.l10ns;

    exports.Latvian = Latvian;
    exports.default = lv;

    Object.defineProperty(exports, '__esModule', { value: true });

})));
