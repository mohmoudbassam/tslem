/* flatpickr v4.5.2, @license MIT */
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
    typeof define === 'function' && define.amd ? define(['exports'], factory) :
    (factory((global.is = {})));
}(this, (function (exports) { 'use strict';

    const fp = typeof window !== "undefined" && window.flatpickr !== undefined
        ? window.flatpickr
        : {
            l10ns: {},
        };
    const Icelandic = {
        weekdays: {
            shorthand: ["Sun", "Mán", "Þri", "Mið", "Fim", "Fös", "Lau"],
            longhand: [
                "Sunnudagur",
                "Mánudagur",
                "Þriðjudagur",
                "Miðvikudagur",
                "Fimmtudagur",
                "Föstudagur",
                "Laugardagur",
            ],
        },
        months: {
            shorthand: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "Maí",
                "Jún",
                "Júl",
                "Ágú",
                "Sep",
                "Okt",
                "Nóv",
                "Des",
            ],
            longhand: [
                "Janúar",
                "Febrúar",
                "Mars",
                "Apríl",
                "Maí",
                "Júní",
                "Júlí",
                "Ágúst",
                "September",
                "Október",
                "Nóvember",
                "Desember",
            ],
        },
        ordinal: () => {
            return ".";
        },
        firstDayOfWeek: 1,
        rangeSeparator: " til ",
        weekAbbreviation: "vika",
        yearAriaLabel: "Ár",
    };
    fp.l10ns.is = Icelandic;
    var is = fp.l10ns;

    exports.Icelandic = Icelandic;
    exports.default = is;

    Object.defineProperty(exports, '__esModule', { value: true });

})));
