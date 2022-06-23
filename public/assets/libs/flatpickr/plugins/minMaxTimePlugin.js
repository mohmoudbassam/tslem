/* flatpickr v4.5.2, @license MIT */
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    (global.minMaxTimePlugin = factory());
}(this, (function () { 'use strict';

    const pad = (number) => `0${number}`.slice(-2);
    const int = (bool) => (bool === true ? 1 : 0);

    const DAYS_IN_GR_MONTH = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    const gFirstRefForUAQ = new Date(1882, 10, 12, 0, 0, 0, 0);
    const gLastRefForUAQ = new Date(2174, 10, 25, 23, 59, 59, 999);
    const UAQ_MONTH_LENGTH = [
        "101010101010",
        "110101010100",
        "111011001001",
        "011011010100",
        "011011101010",
        "001101101100",
        "101010101101",
        "010101010101",
        "011010101001",
        "011110010010",
        "101110101001",
        "010111010100",
        "101011011010",
        "010101011100",
        "110100101101",
        "011010010101",
        "011101001010",
        "101101010100",
        "101101101010",
        "010110101101",
        "010010101110",
        "101001001111",
        "010100010111",
        "011010001011",
        "011010100101",
        "101011010101",
        "001011010110",
        "100101011011",
        "010010011101",
        "101001001101",
        "110100100110",
        "110110010101",
        "010110101100",
        "100110110110",
        "001010111010",
        "101001011011",
        "010100101011",
        "101010010101",
        "011011001010",
        "101011101001",
        "001011110100",
        "100101110110",
        "001010110110",
        "100101010110",
        "101011001010",
        "101110100100",
        "101111010010",
        "010111011001",
        "001011011100",
        "100101101101",
        "010101001101",
        "101010100101",
        "101101010010",
        "101110100101",
        "010110110100",
        "100110110110",
        "010101010111",
        "001010010111",
        "010101001011",
        "011010100011",
        "011101010010",
        "101101100101",
        "010101101010",
        "101010101011",
        "010100101011",
        "110010010101",
        "110101001010",
        "110110100101",
        "010111001010",
        "101011010110",
        "100101010111",
        "010010101011",
        "100101001011",
        "101010100101",
        "101101010010",
        "101101101010",
        "010101110101",
        "001001110110",
        "100010110111",
        "010001011011",
        "010101010101",
        "010110101001",
        "010110110100",
        "100111011010",
        "010011011101",
        "001001101110",
        "100100110110",
        "101010101010",
        "110101010100",
        "110110110010",
        "010111010101",
        "001011011010",
        "100101011011",
        "010010101011",
        "101001010101",
        "101101001001",
        "101101100100",
        "101101110001",
        "010110110100",
        "101010110101",
        "101001010101",
        "110100100101",
        "111010010010",
        "111011001001",
        "011011010100",
        "101011101001",
        "100101101011",
        "010010101011",
        "101010010011",
        "110101001001",
        "110110100100",
        "110110110010",
        "101010111001",
        "010010111010",
        "101001011011",
        "010100101011",
        "101010010101",
        "101100101010",
        "101101010101",
        "010101011100",
        "010010111101",
        "001000111101",
        "100100011101",
        "101010010101",
        "101101001010",
        "101101011010",
        "010101101101",
        "001010110110",
        "100100111011",
        "010010011011",
        "011001010101",
        "011010101001",
        "011101010100",
        "101101101010",
        "010101101100",
        "101010101101",
        "010101010101",
        "101100101001",
        "101110010010",
        "101110101001",
        "010111010100",
        "101011011010",
        "010101011010",
        "101010101011",
        "010110010101",
        "011101001001",
        "011101100100",
        "101110101010",
        "010110110101",
        "001010110110",
        "101001010110",
        "111001001101",
        "101100100101",
        "101101010010",
        "101101101010",
        "010110101101",
        "001010101110",
        "100100101111",
        "010010010111",
        "011001001011",
        "011010100101",
        "011010101100",
        "101011010110",
        "010101011101",
        "010010011101",
        "101001001101",
        "110100010110",
        "110110010101",
        "010110101010",
        "010110110101",
        "001011011010",
        "100101011011",
        "010010101101",
        "010110010101",
        "011011001010",
        "011011100100",
        "101011101010",
        "010011110101",
        "001010110110",
        "100101010110",
        "101010101010",
        "101101010100",
        "101111010010",
        "010111011001",
        "001011101010",
        "100101101101",
        "010010101101",
        "101010010101",
        "101101001010",
        "101110100101",
        "010110110010",
        "100110110101",
        "010011010110",
        "101010010111",
        "010101000111",
        "011010010011",
        "011101001001",
        "101101010101",
        "010101101010",
        "101001101011",
        "010100101011",
        "101010001011",
        "110101000110",
        "110110100011",
        "010111001010",
        "101011010110",
        "010011011011",
        "001001101011",
        "100101001011",
        "101010100101",
        "101101010010",
        "101101101001",
        "010101110101",
        "000101110110",
        "100010110111",
        "001001011011",
        "010100101011",
        "010101100101",
        "010110110100",
        "100111011010",
        "010011101101",
        "000101101101",
        "100010110110",
        "101010100110",
        "110101010010",
        "110110101001",
        "010111010100",
        "101011011010",
        "100101011011",
        "010010101011",
        "011001010011",
        "011100101001",
        "011101100010",
        "101110101001",
        "010110110010",
        "101010110101",
        "010101010101",
        "101100100101",
        "110110010010",
        "111011001001",
        "011011010010",
        "101011101001",
        "010101101011",
        "010010101011",
        "101001010101",
        "110100101001",
        "110101010100",
        "110110101010",
        "100110110101",
        "010010111010",
        "101000111011",
        "010010011011",
        "101001001101",
        "101010101010",
        "101011010101",
        "001011011010",
        "100101011101",
        "010001011110",
        "101000101110",
        "110010011010",
        "110101010101",
        "011010110010",
        "011010111001",
        "010010111010",
        "101001011101",
        "010100101101",
        "101010010101",
        "101101010010",
        "101110101000",
        "101110110100",
        "010110111001",
        "001011011010",
        "100101011010",
        "101101001010",
        "110110100100",
        "111011010001",
        "011011101000",
        "101101101010",
        "010101101101",
        "010100110101",
        "011010010101",
        "110101001010",
        "110110101000",
        "110111010100",
        "011011011010",
        "010101011011",
        "001010011101",
        "011000101011",
        "101100010101",
        "101101001010",
        "101110010101",
        "010110101010",
        "101010101110",
        "100100101110",
        "110010001111",
        "010100100111",
        "011010010101",
        "011010101010",
        "101011010110",
        "010101011101",
        "001010011101",
    ];
    function convertToNational(gDate, type) {
        if (type === "none" || gDate === undefined) {
            return gDate;
        }
        const CIVIL_EPOC = 1948439.5, ASTRONOMICAL_EPOC = 1948438.5, GREGORIAN_EPOCH = 1721425.5;
        const year = gDate.getFullYear(), month = gDate.getMonth(), day = gDate.getDate();
        var nYear, nMonth, nDay, julianDay, days;
        var isLeapYear = function (gYear) {
            return (gYear % 4 === 0 && gYear % 100 !== 0) || gYear % 400 === 0;
        };
        var startYear = function (gYear) {
            return (gYear - 1) * 354 + Math.floor((3 + 11 * gYear) / 30.0);
        };
        var startMonth = function (gYear, gMonth) {
            return (Math.ceil(29.5 * gMonth) +
                (gYear - 1) * 354 +
                Math.floor((3 + 11 * gYear) / 30.0));
        };
        var checkDiapason = function (date) {
            if (date.getTime() < gFirstRefForUAQ.getTime() ||
                date.getTime() > gLastRefForUAQ.getTime()) {
                console.log("You operate with the dates not suitable for current implementation of 'Umm al-Qura' calendar.\nCalendar is switched to 'Civil'");
                return false;
            }
            return true;
        };
        var getDiff = function (gDate) {
            var i;
            var days2 = 50;
            for (i = 1883; i < gDate.getFullYear(); i++) {
                days2 += isLeapYear(i) ? 366 : 365;
            }
            for (i = 0; i < gDate.getMonth(); i++) {
                days2 += DAYS_IN_GR_MONTH[i];
                if (i == 1 && isLeapYear(gDate.getFullYear())) {
                    days2++;
                }
            }
            days2 += gDate.getDate();
            return days2;
        };
        if (type === "civil" || type === "tabular") {
            julianDay =
                Math.floor(GREGORIAN_EPOCH -
                    1 +
                    365 * (year - 1) +
                    Math.floor((year - 1) / 4) +
                    -Math.floor((year - 1) / 100) +
                    Math.floor((year - 1) / 400) +
                    Math.floor((367 * (month + 1) - 362) / 12 +
                        (month + 1 <= 2 ? 0 : isLeapYear(year) ? -1 : -2) +
                        day)) + 0.5;
            if (type === "tabular") {
                days = julianDay - ASTRONOMICAL_EPOC;
            }
            else {
                days = julianDay - CIVIL_EPOC;
            }
            nYear = Math.floor((30 * days + 10646) / 10631.0);
            nMonth = Math.ceil((days - 29 - startYear(nYear)) / 29.5);
            nMonth = Math.min(nMonth, 11);
            nDay = Math.ceil(days - startMonth(nYear, nMonth) + 1);
        }
        else if (type === "Umm al-Qura") {
            if (!checkDiapason(gDate)) {
                return convertToNational(gDate, "civil");
            }
            var diff = getDiff(gDate);
            nYear = 1300;
            nDay = 0;
            nMonth = 0;
            var stop = false;
            for (var i = 0; i < UAQ_MONTH_LENGTH.length; i++, nYear++) {
                for (var j = 0; j < 12; j++) {
                    days = parseInt(UAQ_MONTH_LENGTH[i][j]) + 29;
                    if (diff <= days) {
                        nDay = diff;
                        if (nDay > days) {
                            nDay = 1;
                            j++;
                        }
                        if (j > 11) {
                            j = 0;
                            nYear++;
                        }
                        nMonth = j;
                        stop = true;
                        break;
                    }
                    diff -= days;
                }
                if (stop) {
                    break;
                }
            }
        }
        var nDate = new Date(0);
        nDate.setTime(gDate.getTime());
        nDate = saveNationalDate(nDate, nYear, nMonth, nDay);
        return nDate;
    }
    function saveNationalDate(date, year, month, day) {
        var gDate = new Date(0);
        gDate.setTime(date.getTime());
        return {
            date: gDate,
            nYear: year,
            nMonth: month,
            nDay: day,
        };
    }

    const monthToStr = (monthNumber, shorthand, locale, typeCalendar) => !typeCalendar || typeCalendar === "none"
        ? locale.months[shorthand ? "shorthand" : "longhand"][monthNumber]
        : locale.monthsHijri[shorthand ? "shorthand" : "longhand"][monthNumber];
    const formats = {
        Z: (date) => date.toISOString(),
        D: function (date, locale, options) {
            return locale.weekdays.shorthand[formats.w(date, locale, options)];
        },
        F: function (date, locale, options) {
            if (!options.typeCalendar || options.typeCalendar === "none") {
                return monthToStr(formats.n(date, locale, options) - 1, false, locale);
            }
            else {
                const nDate = convertToNational(date, options.typeCalendar);
                return monthToStr(nDate.nMonth, false, locale, options.typeCalendar);
            }
        },
        G: function (date, locale, options) {
            return pad(formats.h(date, locale, options));
        },
        H: (date) => pad(date.getHours()),
        J: function (date, _, options) {
            if (!options.typeCalendar || options.typeCalendar === "none") {
                return locale.ordinal !== undefined
                    ? date.getDate() + locale.ordinal(date.getDate())
                    : date.getDate();
            }
            else {
                const nDate = convertToNational(date, options.typeCalendar);
                return locale.ordinal !== undefined
                    ? nDate.nDay + locale.ordinal(nDate.nDay)
                    : nDate.nDay;
            }
        },
        K: (date, locale) => locale.amPM[int(date.getHours() > 11)],
        M: function (date, locale, options) {
            if (!options.typeCalendar || options.typeCalendar === "none") {
                return monthToStr(date.getMonth(), true, locale);
            }
            else {
                const nDate = convertToNational(date, options.typeCalendar);
                return monthToStr(nDate.nMonth, true, locale, options.typeCalendar);
            }
        },
        S: (date) => pad(date.getSeconds()),
        U: (date) => date.getTime() / 1000,
        W: function (date, _, options) {
            return options.getWeek(date);
        },
        Y: function (date, _, options) {
            if (!options.typeCalendar || options.typeCalendar === "none") {
                return date.getFullYear();
            }
            else {
                const nDate = convertToNational(date, options.typeCalendar);
                return nDate.nYear;
            }
        },
        d: function (date, _, options) {
            if (!options.typeCalendar || options.typeCalendar === "none") {
                return pad(date.getDate());
            }
            else {
                const nDate = convertToNational(date, options.typeCalendar);
                return pad(nDate.nDay);
            }
        },
        h: (date) => (date.getHours() % 12 ? date.getHours() % 12 : 12),
        i: (date) => pad(date.getMinutes()),
        j: function (date, _, options) {
            if (!options.typeCalendar || options.typeCalendar === "none") {
                return date.getDate();
            }
            else {
                const nDate = convertToNational(date, options.typeCalendar);
                return nDate.nDay;
            }
        },
        l: function (date, locale) {
            return locale.weekdays.longhand[date.getDay()];
        },
        m: function (date, _, options) {
            if (!options.typeCalendar || options.typeCalendar === "none") {
                pad(date.getMonth() + 1);
            }
            else {
                const nDate = convertToNational(date, options.typeCalendar);
                return pad(nDate.nMonth + 1);
            }
        },
        n: function (date, _, options) {
            if (!options.typeCalendar || options.typeCalendar === "none") {
                return date.getMonth() + 1;
            }
            else {
                const nDate = convertToNational(date, options.typeCalendar);
                return nDate.nMonth + 1;
            }
        },
        s: (date) => date.getSeconds(),
        w: (date) => date.getDay(),
        y: function (date, _, options) {
            if (!options.typeCalendar || options.typeCalendar === "none") {
                return String(date.getFullYear()).substring(2);
            }
            else {
                const nDate = convertToNational(date, options.typeCalendar);
                return String(nDate.nYear).substring(2);
            }
        },
    };

    const defaults = {
        _disable: [],
        _enable: [],
        allowInput: false,
        altFormat: "F j, Y",
        altInput: false,
        altInputClass: "form-control input",
        animate: typeof window === "object" &&
            window.navigator.userAgent.indexOf("MSIE") === -1,
        ariaDateFormat: "F j, Y",
        clickOpens: true,
        closeOnSelect: true,
        conjunction: ", ",
        dateFormat: "Y-m-d",
        defaultHour: 12,
        defaultMinute: 0,
        defaultSeconds: 0,
        disable: [],
        disableMobile: false,
        enable: [],
        enableSeconds: false,
        enableTime: false,
        errorHandler: (err) => typeof console !== "undefined" && console.warn(err),
        getWeek,
        hourIncrement: 1,
        ignoredFocusElements: [],
        inline: false,
        locale: "default",
        minuteIncrement: 5,
        mode: "single",
        nextArrow: "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z' /></svg>",
        noCalendar: false,
        now: new Date(),
        onChange: [],
        onClose: [],
        onDayCreate: [],
        onDestroy: [],
        onKeyDown: [],
        onMonthChange: [],
        onOpen: [],
        onParseConfig: [],
        onReady: [],
        onValueUpdate: [],
        onYearChange: [],
        onPreCalendarPosition: [],
        plugins: [],
        position: "auto",
        positionElement: undefined,
        prevArrow: "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z' /></svg>",
        shorthandCurrentMonth: false,
        showMonths: 1,
        static: false,
        time_24hr: false,
        typeCalendar: "none",
        weekNumbers: false,
        wrap: false,
    };

    const english = {
        weekdays: {
            shorthand: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            longhand: [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
            ],
        },
        months: {
            shorthand: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
            longhand: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ],
        },
        monthsHijri: {
            shorthand: [
                "Muh.",
                "Saf.",
                "Rab. 1",
                "Rab. 2",
                "Jum. 1",
                "Jum. 2",
                "Raj.",
                "Shab.",
                "Ramad.",
                "Shaw.",
                "Dhu. 1",
                "Dhu. 2",
            ],
            longhand: [
                "Muharram",
                "Safar",
                "Rabi al-Avval",
                "Rabi ath-thani",
                "Jumada al-thani",
                "Jumada al-thula",
                "Rajab",
                "Shaban",
                "Ramadan",
                "Shawwal",
                "Dhu al-Qadah",
                "Dhu al-Hijjan",
            ],
        },
        daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
        firstDayOfWeek: 0,
        ordinal: (nth) => {
            const s = nth % 100;
            if (s > 3 && s < 21)
                return "th";
            switch (s % 10) {
                case 1:
                    return "st";
                case 2:
                    return "nd";
                case 3:
                    return "rd";
                default:
                    return "th";
            }
        },
        rangeSeparator: " to ",
        weekAbbreviation: "Wk",
        scrollTitle: "Scroll to increment",
        toggleTitle: "Click to toggle",
        amPM: ["AM", "PM"],
        yearAriaLabel: "Year",
    };

    const createDateFormatter = ({ config = defaults, l10n = english, }) => (dateObj, frmt, overrideLocale) => {
        const locale = overrideLocale || l10n;
        if (config.formatDate !== undefined) {
            return config.formatDate(dateObj, frmt, locale);
        }
        return frmt
            .split("")
            .map((c, i, arr) => formats[c] && arr[i - 1] !== "\\"
            ? formats[c](dateObj, locale, config)
            : c !== "\\"
                ? c
                : "")
            .join("");
    };
    function compareDates(date1, date2, timeless = true) {
        if (timeless !== false) {
            return (new Date(date1.getTime()).setHours(0, 0, 0, 0) -
                new Date(date2.getTime()).setHours(0, 0, 0, 0));
        }
        return date1.getTime() - date2.getTime();
    }
    function compareTimes(date1, date2) {
        return (3600 * (date1.getHours() - date2.getHours()) +
            60 * (date1.getMinutes() - date2.getMinutes()) +
            date1.getSeconds() -
            date2.getSeconds());
    }
    const getWeek = (givenDate) => {
        const date = new Date(givenDate.getTime());
        date.setHours(0, 0, 0, 0);
        date.setDate(date.getDate() + 3 - ((date.getDay() + 6) % 7));
        var week1 = new Date(date.getFullYear(), 0, 4);
        return (1 +
            Math.round(((date.getTime() - week1.getTime()) / 86400000 -
                3 +
                ((week1.getDay() + 6) % 7)) /
                7));
    };

    function minMaxTimePlugin(config = {}) {
        const state = {
            formatDate: createDateFormatter({}),
            tableDateFormat: config.tableDateFormat || "Y-m-d",
            defaults: {
                minTime: undefined,
                maxTime: undefined,
            },
        };
        function findDateTimeLimit(date) {
            if (config.table !== undefined) {
                return config.table[state.formatDate(date, state.tableDateFormat)];
            }
            return config.getTimeLimits && config.getTimeLimits(date);
        }
        return function (fp) {
            return {
                onReady() {
                    state.formatDate = this.formatDate;
                    state.defaults = {
                        minTime: this.config.minTime && state.formatDate(this.config.minTime, "H:i"),
                        maxTime: this.config.maxTime && state.formatDate(this.config.maxTime, "H:i"),
                    };
                },
                onChange() {
                    const latest = this.latestSelectedDateObj;
                    const matchingTimeLimit = latest && findDateTimeLimit(latest);
                    if (latest && matchingTimeLimit !== undefined) {
                        this.set(matchingTimeLimit);
                        fp.config.minTime.setFullYear(latest.getFullYear());
                        fp.config.maxTime.setFullYear(latest.getFullYear());
                        fp.config.minTime.setMonth(latest.getMonth());
                        fp.config.maxTime.setMonth(latest.getMonth());
                        fp.config.minTime.setDate(latest.getDate());
                        fp.config.maxTime.setDate(latest.getDate());
                        if (compareDates(latest, fp.config.maxTime, false) > 0) {
                            fp.setDate(new Date(latest.getTime()).setHours(fp.config.maxTime.getHours(), fp.config.maxTime.getMinutes(), fp.config.maxTime.getSeconds(), fp.config.maxTime.getMilliseconds()), false);
                        }
                        else if (compareDates(latest, fp.config.minTime, false) < 0)
                            fp.setDate(new Date(latest.getTime()).setHours(fp.config.minTime.getHours(), fp.config.minTime.getMinutes(), fp.config.minTime.getSeconds(), fp.config.minTime.getMilliseconds()), false);
                    }
                    else {
                        const newMinMax = state.defaults || {
                            minTime: undefined,
                            maxTime: undefined,
                        };
                        this.set(newMinMax);
                        if (!latest)
                            return;
                        const { minTime, maxTime } = fp.config;
                        if (minTime && compareTimes(latest, minTime) < 0) {
                            fp.setDate(new Date(latest.getTime()).setHours(minTime.getHours(), minTime.getMinutes(), minTime.getSeconds(), minTime.getMilliseconds()), false);
                        }
                        else if (maxTime && compareTimes(latest, maxTime) > 0) {
                            fp.setDate(new Date(latest.getTime()).setHours(maxTime.getHours(), maxTime.getMinutes(), maxTime.getSeconds(), maxTime.getMilliseconds()));
                        }
                    }
                },
            };
        };
    }

    return minMaxTimePlugin;

})));
