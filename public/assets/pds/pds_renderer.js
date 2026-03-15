/**
 * pds_renderer.js  —  v16
 *
 * Changes from v15:
 *  - Added "dual_citizenship_type" checkbox group for "By Birth" / "By Naturalization"
 *    sub-options that appear when Dual Citizenship is selected.
 *
 * DIAGNOSIS: PDS_CONFIG is not defined, causing all previous versions to
 * silently abort. This version has ZERO dependency on PDS_CONFIG.
 *
 * DATA SOURCE: window._pdsCellsBySheet (set by pds_page.js after its AJAX call)
 * We intercept that assignment via Object.defineProperty.
 *
 * LOAD ORDER: pds_page.js runs first (synchronously injects SHEETS['C1']),
 * then pds_renderer.js runs. Both scripts' $(document).ready handlers fire
 * after DOM is ready, in registration order.
 *
 * Cell offsets (verified from pds_page.js HTML source):
 *  SEX AT BIRTH:          label td text="SEX AT BIRTH",          skip 2 siblings → value td
 *  CIVIL STATUS:          label td text="CIVIL STATUS",           skip 1 sibling  → value td
 *  CITIZENSHIP:           label td text="16. CITIZENSHIP",        skip 3 siblings → value td
 *  DUAL CITIZENSHIP TYPE: label td text="By Birth",               skip 1 sibling  → value td
 *                         (shares same td as "by naturalization" sub-label)
 */

(function () {
    "use strict";

    /* ═══════════════════════════════════════════════════════════
       CELL COLORS
    ═══════════════════════════════════════════════════════════ */
    var CELL_COLORS = { "C1": { "1,1": "#969696", "9,1": "#969696", "10,1": "#C0C0C0", "10,2": "#C0C0C0", "11,1": "#C0C0C0", "11,2": "#C0C0C0", "11,12": "#EAEAEA", "12,1": "#C0C0C0", "12,2": "#C0C0C0", "13,1": "#C0C0C0", "13,2": "#C0C0C0", "13,7": "#C0C0C0", "13,8": "#C0C0C0", "13,9": "#C0C0C0", "13,10": "#FFFFFF", "14,1": "#C0C0C0", "14,2": "#C0C0C0", "14,3": "#C0C0C0", "14,7": "#C0C0C0", "14,8": "#C0C0C0", "14,9": "#C0C0C0", "14,10": "#FFFFFF", "14,11": "#FFFFFF", "14,12": "#FFFFFF", "14,13": "#FFFFFF", "14,14": "#FFFFFF", "15,1": "#C0C0C0", "15,2": "#C0C0C0", "15,3": "#C0C0C0", "15,7": "#EAEAEA", "15,10": "#FFFFFF", "15,11": "#FFFFFF", "15,12": "#FFFFFF", "16,1": "#C0C0C0", "16,2": "#C0C0C0", "16,3": "#C0C0C0", "16,7": "#EAEAEA", "17,1": "#C0C0C0", "17,2": "#C0C0C0", "17,7": "#C0C0C0", "17,8": "#C0C0C0", "18,7": "#C0C0C0", "18,8": "#C0C0C0", "18,9": "#FFFFFF", "18,12": "#FFFFFF", "19,1": "#C0C0C0", "19,2": "#C0C0C0", "19,3": "#C0C0C0", "19,7": "#C0C0C0", "19,8": "#C0C0C0", "20,1": "#C0C0C0", "20,2": "#C0C0C0", "20,3": "#C0C0C0", "20,7": "#C0C0C0", "20,8": "#C0C0C0", "21,2": "#C0C0C0", "21,3": "#C0C0C0", "21,7": "#C0C0C0", "21,8": "#C0C0C0", "21,12": "#FFFFFF", "22,1": "#C0C0C0", "22,2": "#C0C0C0", "22,7": "#C0C0C0", "22,8": "#C0C0C0", "23,7": "#C0C0C0", "23,8": "#C0C0C0", "23,12": "#FFFFFF", "24,1": "#C0C0C0", "24,2": "#C0C0C0", "24,7": "#C0C0C0", "25,1": "#C0C0C0", "25,2": "#C0C0C0", "25,7": "#C0C0C0", "25,8": "#C0C0C0", "26,7": "#C0C0C0", "26,8": "#C0C0C0", "26,9": "#FFFFFF", "26,12": "#FFFFFF", "27,1": "#C0C0C0", "27,2": "#C0C0C0", "27,7": "#C0C0C0", "27,8": "#C0C0C0", "28,7": "#C0C0C0", "28,8": "#C0C0C0", "28,12": "#FFFFFF", "29,1": "#C0C0C0", "29,2": "#C0C0C0", "29,7": "#C0C0C0", "29,8": "#C0C0C0", "30,7": "#C0C0C0", "30,8": "#C0C0C0", "31,1": "#C0C0C0", "31,2": "#C0C0C0", "31,3": "#C0C0C0", "31,7": "#C0C0C0", "31,12": "#FFFFFF", "32,1": "#C0C0C0", "32,2": "#C0C0C0", "32,3": "#C0C0C0", "32,7": "#C0C0C0", "32,8": "#C0C0C0", "33,1": "#C0C0C0", "33,7": "#EAEAEA", "33,8": "#EAEAEA", "34,1": "#C0C0C0", "34,2": "#C0C0C0", "34,3": "#EAEAEA", "34,7": "#C0C0C0", "34,8": "#C0C0C0", "35,1": "#969696", "35,2": "#969696", "35,3": "#969696", "35,4": "#969696", "35,5": "#969696", "35,6": "#969696", "35,7": "#969696", "35,8": "#969696", "35,9": "#969696", "35,10": "#969696", "35,11": "#969696", "35,12": "#969696", "35,13": "#969696", "35,14": "#969696", "36,1": "#C0C0C0", "36,2": "#C0C0C0", "36,3": "#C0C0C0", "36,9": "#C0C0C0", "36,13": "#C0C0C0", "37,1": "#C0C0C0", "37,2": "#C0C0C0", "37,3": "#C0C0C0", "37,7": "#C0C0C0", "38,1": "#C0C0C0", "38,2": "#C0C0C0", "38,3": "#C0C0C0", "39,1": "#C0C0C0", "39,2": "#C0C0C0", "39,3": "#C0C0C0", "40,1": "#C0C0C0", "40,2": "#C0C0C0", "40,3": "#C0C0C0", "41,1": "#C0C0C0", "41,2": "#C0C0C0", "41,3": "#C0C0C0", "42,1": "#C0C0C0", "42,2": "#C0C0C0", "42,3": "#C0C0C0", "43,1": "#C0C0C0", "43,2": "#C0C0C0", "43,3": "#C0C0C0", "44,1": "#C0C0C0", "44,2": "#C0C0C0", "44,3": "#C0C0C0", "44,7": "#C0C0C0", "45,1": "#C0C0C0", "45,2": "#C0C0C0", "45,3": "#C0C0C0", "46,1": "#C0C0C0", "46,2": "#C0C0C0", "47,1": "#C0C0C0", "47,2": "#C0C0C0", "47,3": "#C0C0C0", "47,4": "#FFFFFF", "48,1": "#C0C0C0", "48,2": "#C0C0C0", "48,3": "#C0C0C0", "48,4": "#FFFFFF", "49,1": "#C0C0C0", "49,2": "#C0C0C0", "49,3": "#C0C0C0", "49,9": "#C0C0C0", "50,1": "#969696", "50,2": "#969696", "50,3": "#969696", "50,4": "#969696", "50,5": "#969696", "50,6": "#969696", "50,7": "#969696", "50,8": "#969696", "50,9": "#969696", "51,1": "#C0C0C0", "51,2": "#C0C0C0", "51,4": "#C0C0C0", "51,7": "#C0C0C0", "51,10": "#C0C0C0", "51,12": "#C0C0C0", "51,13": "#C0C0C0", "51,14": "#C0C0C0", "53,1": "#C0C0C0", "53,10": "#C0C0C0", "53,11": "#C0C0C0", "54,1": "#C0C0C0", "54,2": "#C0C0C0", "54,3": "#C0C0C0", "55,1": "#C0C0C0", "55,2": "#C0C0C0", "55,3": "#C0C0C0", "56,1": "#C0C0C0", "56,2": "#C0C0C0", "56,3": "#C0C0C0", "57,1": "#C0C0C0", "57,2": "#C0C0C0", "57,3": "#C0C0C0", "58,1": "#C0C0C0", "58,2": "#C0C0C0", "58,3": "#C0C0C0", "59,1": "#C0C0C0", "60,1": "#C0C0C0", "60,10": "#C0C0C0", "61,1": "#FFFFFF" }, "C2": { "1,1": "#969696", "2,1": "#969696", "3,1": "#C0C0C0", "3,2": "#C0C0C0", "3,6": "#C0C0C0", "3,7": "#C0C0C0", "3,9": "#C0C0C0", "3,10": "#C0C0C0", "4,1": "#C0C0C0", "4,10": "#C0C0C0", "4,11": "#C0C0C0", "12,1": "#C0C0C0", "13,1": "#969696", "14,1": "#969696", "14,2": "#969696", "14,3": "#969696", "14,4": "#969696", "14,5": "#969696", "14,6": "#969696", "14,7": "#969696", "14,8": "#969696", "14,9": "#969696", "14,10": "#969696", "14,11": "#969696", "15,1": "#C0C0C0", "15,2": "#C0C0C0", "15,4": "#C0C0C0", "15,7": "#C0C0C0", "15,10": "#C0C0C0", "15,11": "#C0C0C0", "16,1": "#C0C0C0", "17,1": "#C0C0C0", "17,3": "#C0C0C0", "46,1": "#C0C0C0", "47,1": "#C0C0C0", "47,9": "#C0C0C0", "48,1": "#FFFFFF", "48,12": "#FFFFFF" }, "C3": { "1,1": "#969696", "2,1": "#969696", "3,1": "#C0C0C0", "3,2": "#C0C0C0", "3,5": "#C0C0C0", "3,7": "#C0C0C0", "3,8": "#C0C0C0", "5,1": "#C0C0C0", "5,2": "#C0C0C0", "5,5": "#C0C0C0", "5,6": "#C0C0C0", "13,1": "#C0C0C0", "14,1": "#969696", "15,1": "#C0C0C0", "15,2": "#C0C0C0", "15,5": "#C0C0C0", "15,7": "#C0C0C0", "15,8": "#C0C0C0", "15,9": "#C0C0C0", "17,1": "#C0C0C0", "17,5": "#C0C0C0", "17,6": "#C0C0C0", "39,1": "#C0C0C0", "40,1": "#969696", "41,1": "#C0C0C0", "41,2": "#C0C0C0", "41,3": "#C0C0C0", "41,4": "#C0C0C0", "41,9": "#C0C0C0", "41,10": "#C0C0C0", "49,1": "#C0C0C0", "50,1": "#C0C0C0", "50,7": "#EAEAEA" }, "C4": { "1,1": "#969696", "2,1": "#C0C0C0", "2,3": "#C0C0C0", "3,1": "#C0C0C0", "3,2": "#C0C0C0", "3,3": "#C0C0C0", "4,1": "#C0C0C0", "4,2": "#C0C0C0", "4,3": "#C0C0C0", "5,1": "#C0C0C0", "5,2": "#C0C0C0", "5,3": "#C0C0C0", "6,1": "#C0C0C0", "6,2": "#C0C0C0", "6,3": "#C0C0C0", "7,1": "#C0C0C0", "7,2": "#C0C0C0", "7,3": "#C0C0C0", "7,4": "#C0C0C0", "7,5": "#C0C0C0", "7,6": "#C0C0C0", "8,1": "#C0C0C0", "8,2": "#C0C0C0", "8,3": "#C0C0C0", "9,1": "#C0C0C0", "9,2": "#C0C0C0", "9,3": "#C0C0C0", "9,4": "#C0C0C0", "9,5": "#C0C0C0", "9,6": "#C0C0C0", "10,1": "#C0C0C0", "10,2": "#C0C0C0", "10,3": "#C0C0C0", "11,1": "#C0C0C0", "11,2": "#C0C0C0", "11,3": "#C0C0C0", "12,1": "#C0C0C0", "12,2": "#C0C0C0", "12,3": "#C0C0C0", "13,1": "#C0C0C0", "13,3": "#C0C0C0", "14,1": "#C0C0C0", "14,2": "#C0C0C0", "15,1": "#C0C0C0", "15,2": "#C0C0C0", "16,1": "#C0C0C0", "16,2": "#C0C0C0", "17,1": "#C0C0C0", "17,2": "#C0C0C0", "17,3": "#C0C0C0", "17,4": "#C0C0C0", "17,5": "#C0C0C0", "17,6": "#C0C0C0", "18,1": "#C0C0C0", "18,2": "#C0C0C0", "18,3": "#C0C0C0", "19,1": "#C0C0C0", "19,2": "#C0C0C0", "20,1": "#C0C0C0", "20,2": "#C0C0C0", "21,1": "#C0C0C0", "21,2": "#C0C0C0", "22,1": "#C0C0C0", "22,2": "#C0C0C0", "23,1": "#C0C0C0", "23,3": "#C0C0C0", "24,1": "#C0C0C0", "24,2": "#C0C0C0", "25,1": "#C0C0C0", "25,2": "#C0C0C0", "26,1": "#C0C0C0", "26,2": "#C0C0C0", "27,1": "#C0C0C0", "27,3": "#C0C0C0", "28,1": "#C0C0C0", "28,2": "#C0C0C0", "29,1": "#C0C0C0", "29,2": "#C0C0C0", "30,1": "#C0C0C0", "30,2": "#C0C0C0", "31,1": "#C0C0C0", "31,3": "#C0C0C0", "32,1": "#C0C0C0", "32,2": "#C0C0C0", "33,1": "#C0C0C0", "33,2": "#C0C0C0", "33,3": "#C0C0C0", "33,4": "#C0C0C0", "33,5": "#C0C0C0", "33,6": "#C0C0C0", "34,1": "#C0C0C0", "34,2": "#C0C0C0", "34,3": "#C0C0C0", "35,1": "#C0C0C0", "35,2": "#C0C0C0", "36,1": "#C0C0C0", "36,2": "#C0C0C0", "37,1": "#C0C0C0", "37,3": "#C0C0C0", "38,1": "#C0C0C0", "38,2": "#C0C0C0", "39,1": "#C0C0C0", "39,2": "#C0C0C0", "40,1": "#C0C0C0", "40,2": "#C0C0C0", "41,1": "#C0C0C0", "41,3": "#C0C0C0", "42,1": "#C0C0C0", "42,2": "#C0C0C0", "43,1": "#C0C0C0", "43,2": "#C0C0C0", "43,3": "#C0C0C0", "44,1": "#C0C0C0", "44,2": "#C0C0C0", "45,1": "#C0C0C0", "45,2": "#C0C0C0", "45,3": "#C0C0C0", "46,1": "#C0C0C0", "46,2": "#C0C0C0", "47,1": "#C0C0C0", "47,2": "#C0C0C0", "47,3": "#C0C0C0", "47,5": "#C0C0C0", "47,6": "#C0C0C0", "48,1": "#C0C0C0", "50,1": "#C0C0C0", "50,3": "#C0C0C0", "50,4": "#C0C0C0", "50,5": "#C0C0C0", "50,6": "#C0C0C0", "50,7": "#C0C0C0", "50,8": "#C0C0C0", "50,9": "#C0C0C0", "51,1": "#C0C0C0", "51,6": "#C0C0C0", "51,7": "#C0C0C0", "55,1": "#C0C0C0", "55,3": "#C0C0C0", "55,9": "#C0C0C0", "56,1": "#C0C0C0", "56,2": "#C0C0C0", "56,9": "#C0C0C0", "57,1": "#C0C0C0", "57,2": "#C0C0C0", "57,9": "#C0C0C0", "58,1": "#EAEAEA", "58,2": "#EAEAEA", "58,3": "#C0C0C0", "58,4": "#C0C0C0", "58,5": "#C0C0C0", "58,6": "#C0C0C0", "58,7": "#C0C0C0", "58,8": "#C0C0C0", "58,9": "#C0C0C0", "60,2": "#C0C0C0", "63,6": "#C0C0C0", "65,6": "#C0C0C0", "65,11": "#C0C0C0", "69,5": "#C0C0C0" } };

    /* ═══════════════════════════════════════════════════════════
       CHECKBOX DEFINITIONS
    ═══════════════════════════════════════════════════════════ */
    var CHECKBOX_DEFS = [
        {
            id: 'sex',
            labelText: 'SEX AT BIRTH',
            skip: 2,
            options: [
                { label: 'Male', match: 'male' },
                { label: 'Female', match: 'female' }
            ]
        },
        {
            id: 'civil_status',
            labelText: 'CIVIL STATUS',
            skip: 1,
            options: [
                { label: 'Single', match: 'single' },
                { label: 'Married', match: 'married' },
                { label: 'Widowed', match: 'widowed' },
                { label: 'Separated', match: 'separated' },
                { label: 'Other/s:', match: 'other' }
            ]
        },
        {
            id: 'citizenship',
            labelText: '16. CITIZENSHIP',
            skip: 3,
            options: [
                { label: 'Filipino', match: 'filipino' },
                { label: 'Dual Citizenship', match: 'dual citizenship' }
            ]
        },
        {
            /**
             * "By Birth" / "By Naturalization" sub-checkboxes.
             *
             * The rendered HTML has a single td whose textContent contains BOTH
             * "by birth" and "by naturalization" as plain labels (no separate
             * value td next to it).  We find that td via its "by birth" text
             * and render the checkboxes DIRECTLY INSIDE IT (skip:0), replacing
             * the plain text labels with ticked/unticked boxes.
             *
             * labelText uses the combined string so findLabelTd matches the td
             * that starts with "by birth" (the first line of the merged cell).
             */
            id: 'dual_citizenship_type',
            labelText: 'by birth',
            skip: 0,
            options: [
                { label: 'By Birth', match: 'by birth' },
                { label: 'By Naturalization', match: 'by naturalization' }
            ]
        }
    ];

    /* ═══════════════════════════════════════════════════════════
       HELPERS
    ═══════════════════════════════════════════════════════════ */
    function findLabelTd(tbl, labelText) {
        var t = labelText.toLowerCase().trim();
        for (var r = 0; r < tbl.rows.length; r++) {
            var cells = tbl.rows[r].cells;
            for (var c = 0; c < cells.length; c++) {
                var txt = cells[c].textContent.toLowerCase().trim();
                if (txt === t || txt.indexOf(t) === 0) return cells[c];
            }
        }
        return null;
    }

    function nthSibling(el, n) {
        for (var i = 0; i < n; i++) el = el ? el.nextElementSibling : null;
        return el;
    }

    /* ═══════════════════════════════════════════════════════════
   RENDER DUAL CITIZENSHIP COUNTRY LABEL
═══════════════════════════════════════════════════════════ */
    function renderDualCountry(tbl) {
        if (!tbl) return;

        // Find "Pls. indicate country:" label td
        var labelTd = findLabelTd(tbl, 'pls. indicate country:');
        if (!labelTd) return;

        // Restore label to italic text
        labelTd.innerHTML =
            '<span style="font-family:Arial Narrow,Arial,sans-serif;font-size:7.5px;' +
            'font-style:italic;color:#000;">Pls. indicate country:</span>';

        // Read country from the dedicated non-grid key
        var countryVal = '';
        if (window._pdsCellsBySheet && window._pdsCellsBySheet['C1']) {
            var entry = window._pdsCellsBySheet['C1']['__dual_country__'];
            if (entry) {
                countryVal = ((entry.v !== undefined) ? entry.v : entry).toString().trim();
            }
        }

        if (!countryVal) return;

        // Find the td directly below the label using buildCellMap for logical positioning
        var cellMap = buildCellMap(tbl);
        var labelLogicalRow = -1, labelLogicalCol = -1;
        Object.keys(cellMap).forEach(function (key) {
            if (cellMap[key] === labelTd) {
                var parts = key.split(',');
                labelLogicalRow = parseInt(parts[0], 10);
                labelLogicalCol = parseInt(parts[1], 10);
            }
        });

        if (labelLogicalRow < 0) return;

        var targetTd = cellMap[(labelLogicalRow + 1) + ',' + labelLogicalCol] || null;
        if (!targetTd) return;

        // Clear anything that may be in this cell
        targetTd.textContent = '';
        targetTd.classList.remove('pds-filled');
        targetTd.style.backgroundColor = '';

        targetTd.innerHTML =
            '<div style="font-family:Arial Narrow,Arial,sans-serif;font-size:8px;' +
            'font-weight:bold;color:#000;text-align:center;padding:1px 3px;">' +
            countryVal + '</div>';
        targetTd.style.backgroundColor = '#d0e8f8';
    }
    /* ═══════════════════════════════════════════════════════════
       RENDER CHECKBOX GROUP
    ═══════════════════════════════════════════════════════════ */
function renderGroup(td, options, value, groupId) {
        if (!td) return;
        var val = (value || '').toLowerCase().trim();

        td.innerHTML = '';
        td.classList.remove('pds-filled');

        // For dual_citizenship_type the td is narrow — use inline content, not block flex
        var isInline = (groupId === 'dual_citizenship_type');

        td.style.textAlign = 'center';
        td.style.verticalAlign = 'middle';
        td.style.overflow = 'visible';
        td.style.whiteSpace = 'nowrap';

        var wrap = document.createElement(isInline ? 'span' : 'div');
        if (isInline) {
            wrap.style.cssText = 'display:inline;white-space:nowrap;';
            // Force the parent td to center inline content
            td.style.textAlign = 'center';
        } else {
            wrap.style.cssText = 'display:flex;width:100%;flex-direction:row;align-items:center;justify-content:center;flex-wrap:nowrap;gap:4px;white-space:nowrap;';
        }
        var anyChecked = false;
        options.forEach(function (opt) {
            var matched = val && val === opt.match;
            if (matched) anyChecked = true;

            var item = document.createElement('span');
            item.style.cssText = 'display:inline-flex;align-items:center;gap:2px;white-space:nowrap;';

            var box = document.createElement('span');
            box.style.cssText = 'display:inline-flex;align-items:center;justify-content:center;width:9px;height:9px;min-width:9px;min-height:9px;border:1px solid #444;background:#fff;font-size:8px;font-weight:900;color:#000;line-height:1;flex-shrink:0;box-sizing:border-box;';
            if (matched) box.textContent = '✔';

            var lbl = document.createElement('span');
            lbl.style.cssText = 'font-family:Arial Narrow,Arial,sans-serif;font-size:7.5px;color:#000;vertical-align:middle;';
            lbl.textContent = opt.label;

            item.appendChild(box);
            item.appendChild(lbl);
            wrap.appendChild(item);
        });

        td.appendChild(wrap);
        if (anyChecked) td.style.backgroundColor = '#d0e8f8';
    }

    /* ═══════════════════════════════════════════════════════════
       APPLY CHECKBOXES — reads value from the td text if no map given
    ═══════════════════════════════════════════════════════════ */
    function applyCheckboxes(tbl, valueMap) {
        if (!tbl) return;
        valueMap = valueMap || {};
        CHECKBOX_DEFS.forEach(function (def) {
            var labelTd = findLabelTd(tbl, def.labelText);
            if (!labelTd) {
                console.warn('[PDS renderer] Label not found:', def.labelText);
                return;
            }

            // skip:0 → render directly inside the label td (it IS the value cell)
            // skip:N → step N siblings right to reach the value cell
            var valueTd = (def.skip === 0) ? labelTd : nthSibling(labelTd, def.skip);
            if (!valueTd) {
                console.warn('[PDS renderer] Value cell missing for:', def.id);
                return;
            }

            // For skip:0 the td's own textContent is a static label, not data.
            // Always use the mapped value (empty string if not yet known).
            var val;
            if (def.skip === 0) {
                val = valueMap[def.id] !== undefined ? valueMap[def.id] : '';
            } else {
                val = valueMap[def.id] !== undefined
                    ? valueMap[def.id]
                    : valueTd.textContent.trim();
            }

            console.log('[PDS renderer] checkbox', def.id, '→', val || '(empty)');
            renderGroup(valueTd, def.options, val, def.id);
        });
    }

    /* ═══════════════════════════════════════════════════════════
       EXTRACT checkbox values from _pdsCellsBySheet
    ═══════════════════════════════════════════════════════════ */
    function extractVals(bySheet) {
        var v = {}, c1 = bySheet['C1'] || {};
        Object.keys(c1).forEach(function (addr) {
            var d = c1[addr];
            var raw = ((d && d.v !== undefined) ? d.v : (d || '')).toString().trim().toLowerCase();

            if (!v.sex && /^(male|female)$/.test(raw))
                v.sex = raw;

            if (!v.civil_status && /^(single|married|widowed|separated)$/.test(raw))
                v.civil_status = raw;
            if (!v.civil_status && /^other/.test(raw))
                v.civil_status = 'other';

            if (!v.citizenship && raw === 'filipino')
                v.citizenship = 'filipino';
            if (!v.citizenship && /^dual/.test(raw))
                v.citizenship = 'dual citizenship';

            // Dual citizenship sub-type: "by birth" or "by naturalization"
            if (!v.dual_citizenship_type && raw === 'by birth')
                v.dual_citizenship_type = 'by birth';
            if (!v.dual_citizenship_type && /^by naturalization/.test(raw))
                v.dual_citizenship_type = 'by naturalization';
        });
        return v;
    }

    /* ═══════════════════════════════════════════════════════════
       COLORS
    ═══════════════════════════════════════════════════════════ */
    function buildCellMap(t) {
        var map = {}, occ = {}, rows = t.rows;
        for (var r = 0; r < rows.length; r++) {
            var cur = 1, cells = rows[r].cells;
            for (var c = 0; c < cells.length; c++) {
                while (occ[(r + 1) + ',' + cur]) cur++;
                var td = cells[c], rs = td.rowSpan || 1, cs = td.colSpan || 1;
                map[(r + 1) + ',' + cur] = td;
                for (var dr = 0; dr < rs; dr++)
                    for (var dc = 0; dc < cs; dc++)
                        if (dr || dc) occ[(r + 1 + dr) + ',' + (cur + dc)] = true;
                cur += cs;
            }
        }
        return map;
    }

    function colorSheet(name) {
        var tbl = document.getElementById('sheet-' + name);
        if (!tbl) return;
        var cm = CELL_COLORS[name]; if (!cm) return;
        var map = buildCellMap(tbl);
        Object.keys(map).forEach(function (k) {
            var td = map[k], color = cm[k];
            if (color && color !== '#FFFFFF') {
                td.style.backgroundColor = color;
                if (color === '#969696') {
                    td.style.color = '#fff';
                    td.style.fontWeight = 'bold';
                    td.style.fontStyle = 'italic';
                }
            }
        });
    }

    /* ═══════════════════════════════════════════════════════════
       MUTATIONOBSERVER — re-run after tab switches rebuild the HTML
    ═══════════════════════════════════════════════════════════ */
    function observeSheetContent() {
        var container = document.getElementById('sheetContent');
        if (!container) return;
        new MutationObserver(function () {
            var tbl = document.getElementById('sheet-C1');
            if (tbl) {
                colorSheet('C1');
                var vals = window._pdsCellsBySheet
                    ? extractVals(window._pdsCellsBySheet)
                    : {};
                applyCheckboxes(tbl, vals);
                renderDualCountry(tbl);          // ← add
            }
        }).observe(container, { childList: true });
    }

    /* ═══════════════════════════════════════════════════════════
       INTERCEPT _pdsCellsBySheet assignment
    ═══════════════════════════════════════════════════════════ */
    var _stored = undefined;
    try {
        Object.defineProperty(window, '_pdsCellsBySheet', {
            get: function () { return _stored; },
            set: function (v) {
                _stored = v;
                console.log('[PDS renderer] _pdsCellsBySheet intercepted — ticking checkboxes');
                setTimeout(function () {
                    var tbl = document.getElementById('sheet-C1');
                    if (tbl && v && v['C1']) {
                        applyCheckboxes(tbl, extractVals(v));
                        renderDualCountry(tbl);          // ← add
                    }
                }, 0);
            },
            configurable: true
        });
        console.log('[PDS renderer] defineProperty hook installed');
    } catch (e) {
        console.warn('[PDS renderer] defineProperty failed:', e.message);
    }

    /* ═══════════════════════════════════════════════════════════
       BOOT
    ═══════════════════════════════════════════════════════════ */
    $(document).ready(function () {
        console.log('[PDS renderer] boot — sheet-C1 exists:', !!document.getElementById('sheet-C1'));

        colorSheet('C1');
        var tbl = document.getElementById('sheet-C1');
        // In $(document).ready boot:
        applyCheckboxes(tbl, {});
        renderDualCountry(tbl);          // ← add

        observeSheetContent();

        if (_stored && _stored['C1']) {
            console.log('[PDS renderer] data already available — ticking now');
            // In the "data already available" block:
            applyCheckboxes(tbl, extractVals(_stored));
            renderDualCountry(tbl);          // ← add
        }
    });

})();