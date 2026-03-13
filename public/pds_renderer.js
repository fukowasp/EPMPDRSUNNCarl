/**
 * pds_renderer.js  —  v2 (XLSX via URL + API employee overlay)
 * ─────────────────────────────────────────────────────────────────────
 * Flow:
 *   1. ExcelJS fetches the XLSX template from PDS_CONFIG.templateUrl
 *   2. Employee data (values + optional styles) fetched from PDS_CONFIG.apiBase
 *   3. Employee values are written into the ExcelJS workbook in-memory
 *   4. Each sheet is rendered as an HTML <table> using ExcelJS cell data
 *
 * Global constants injected by PHP view:
 *   PDS_CONFIG = { templateUrl, apiBase, employeeId }
 * ─────────────────────────────────────────────────────────────────────
 */

(function () {
    "use strict";

    /* ── State ── */
    let workbook = null;
    let employeeCells = {};   // "SheetName:Addr" → { v, bg?, bold?, color?, ha? }
    const sheetCache = {};   // sheetName → rendered HTML string

    /* ── Expose tab-switcher globally (called from onclick in HTML) ── */
    window.switchTab = switchTab;

    /* ── Boot ── */
    init();

    async function init() {
        try {
            showLoading();

            // Fetch both in parallel
            const [wb, empData] = await Promise.all([
                loadWorkbook(),
                fetchEmployeeData(),
            ]);

            workbook = wb;
            employeeCells = empData;

            // Apply employee values into the ExcelJS workbook (in-memory)
            applyEmployeeData();

            // Render first sheet
            renderSheet("C1");
            showContent();

        } catch (err) {
            console.error("PDS init error:", err);
            showError(err.message);
        }
    }

    /* ────────────────────────────────────────────────────────────────
       1. LOAD XLSX FROM SERVER URL
    ──────────────────────────────────────────────────────────────── */
    async function loadWorkbook() {
        const res = await fetch(PDS_CONFIG.templateUrl, { cache: "force-cache" });
        if (!res.ok) throw new Error(`Template fetch failed (${res.status})`);

        const buffer = await res.arrayBuffer();
        const wb = new ExcelJS.Workbook();
        await wb.xlsx.load(buffer);
        return wb;
    }

    /* ────────────────────────────────────────────────────────────────
       2. FETCH EMPLOYEE DATA FROM API
    ──────────────────────────────────────────────────────────────── */
    async function fetchEmployeeData() {
        if (!PDS_CONFIG.employeeId) return {};

        // employee_id is resolved server-side via session — no need to pass in URL
        const url = `${PDS_CONFIG.apiBase}/employee-data`;
        const res = await fetch(url, { credentials: "same-origin" });
        if (!res.ok) throw new Error(`Employee API error (${res.status})`);

        const json = await res.json();
        return json.cells || {};
    }

    /* ────────────────────────────────────────────────────────────────
       3. APPLY EMPLOYEE DATA INTO ExcelJS WORKBOOK (in-memory)
       Each key in employeeCells: "SheetName:CellAddr"  e.g. "C1:D4"
    ──────────────────────────────────────────────────────────────── */
    function applyEmployeeData() {
        Object.entries(employeeCells).forEach(([key, data]) => {
            const colon = key.indexOf(":");
            if (colon === -1) return;

            const sheetName = key.substring(0, colon);
            const addr = key.substring(colon + 1);

            const ws = workbook.getWorksheet(sheetName);
            if (!ws) return;

            const cell = ws.getCell(addr);

            // ── Value ──
            if (data.v !== undefined && data.v !== null) {
                cell.value = data.v === "" ? null : data.v;
            }

            // ── Style overrides — clone before mutating ──
            const existing = cell.style ? JSON.parse(JSON.stringify(cell.style)) : {};

            if (data.bg) {
                existing.fill = {
                    type: "pattern",
                    pattern: "solid",
                    fgColor: { argb: "FF" + data.bg.replace("#", "") },
                };
            }

            if (data.bold !== undefined) {
                existing.font = existing.font || {};
                existing.font.bold = !!data.bold;
            }

            if (data.color) {
                existing.font = existing.font || {};
                existing.font.color = { argb: "FF" + data.color.replace("#", "") };
            }

            if (data.ha) {
                existing.alignment = existing.alignment || {};
                existing.alignment.horizontal = data.ha;
            }

            cell.style = existing;
        });
    }

    /* ────────────────────────────────────────────────────────────────
       4. RENDER SHEET → HTML TABLE (ExcelJS-driven)
    ──────────────────────────────────────────────────────────────── */
    function renderSheet(sheetName) {
        if (!workbook) return;

        if (sheetCache[sheetName]) {
            document.getElementById("sheetContent").innerHTML = sheetCache[sheetName];
            updateFooter(sheetName);
            return;
        }

        const ws = workbook.getWorksheet(sheetName);
        if (!ws) {
            document.getElementById("sheetContent").innerHTML =
                `<div class="p-4 text-muted">Sheet "${sheetName}" not found in template.</div>`;
            return;
        }

        /* ── Merged cell lookup ── */
        const mergedTL = {};
        const mergedSkip = new Set();

        (ws.model?.merges || []).forEach(addr => {
            const [tl, br] = addr.split(":");
            const tlRef = cellRefToRC(tl);
            const brRef = cellRefToRC(br);

            if (tlRef.c > 14) return; // skip merged regions starting after column N

            const rs = brRef.r - tlRef.r + 1;
            const cs = Math.min(brRef.c, 14) - tlRef.c + 1; // truncate if merges go past N
            mergedTL[`${tlRef.r},${tlRef.c}`] = { rs, cs };
            for (let r = tlRef.r; r <= brRef.r; r++)
                for (let c = tlRef.c; c <= Math.min(brRef.c, 14); c++)
                    if (r !== tlRef.r || c !== tlRef.c)
                        mergedSkip.add(`${r},${c}`);
        });

        /* ── Column widths ── */
        const colWidths = {};
        ws.columns.forEach((col, idx) => {
            colWidths[idx + 1] = col.width
                ? Math.max(20, Math.round(col.width * 6.8))
                : 52;
        });

        const maxCol = Math.min(ws.columnCount || 26, 14); // 14 = column N
        const maxRow = ws.rowCount || 100;

        /* ── Build <table> ── */
        let html = `<table class="pds-table"><colgroup>`;
        for (let c = 1; c <= maxCol; c++) {
            html += `<col style="width:${colWidths[c] || 52}px">`;
        }
        html += `</colgroup>`;

        for (let r = 1; r <= maxRow; r++) {
            const row = ws.getRow(r);
            const rh = row.height ? Math.max(14, Math.round(row.height * 1.34)) : 18;
            html += `<tr style="height:${rh}px;">`;

            for (let c = 1; c <= maxCol; c++) {
                const key = `${r},${c}`;
                if (mergedSkip.has(key)) continue;

                const addr = colIndexToLetter(c) + r;
                const cell = ws.getCell(addr);
                const merge = mergedTL[key];

                const rsAttr = merge ? ` rowspan="${merge.rs}"` : "";
                const csAttr = merge ? ` colspan="${merge.cs}"` : "";
                const style = buildCellStyle(cell);
                const val = getCellText(cell);

                // Mark cells that received employee data
                const isFilled = employeeCells.hasOwnProperty(`${sheetName}:${addr}`);
                const cls = isFilled ? ` class="pds-filled"` : "";

                html += `<td${rsAttr}${csAttr}${cls} style="${style}">${escHtml(val)}</td>`;
            }
            html += `</tr>`;
        }
        html += `</table>`;

        sheetCache[sheetName] = html;
        document.getElementById("sheetContent").innerHTML = html;
        updateFooter(sheetName);
    }

    /* ────────────────────────────────────────────────────────────────
       TAB SWITCHING
    ──────────────────────────────────────────────────────────────── */
    function switchTab(name, el) {
        document.querySelectorAll(".pds-tab")
            .forEach(t => t.classList.remove("active"));
        el.classList.add("active");
        renderSheet(name);
    }

    /* ────────────────────────────────────────────────────────────────
       HELPERS
    ──────────────────────────────────────────────────────────────── */

    /** ExcelJS cell → CSS inline style string */
    function buildCellStyle(cell) {
        const s = cell.style || {};
        const fnt = s.font || {};
        const aln = s.alignment || {};
        const fil = s.fill || {};
        const bdr = s.border || {};

        let css = "";

        // Background fill
        if (fil.fgColor?.argb) {
            const hex = fil.fgColor.argb.length === 8
                ? fil.fgColor.argb.substring(2)   // strip alpha byte
                : fil.fgColor.argb;
            if (!["FFFFFF", "000000", "ffffff", "000000"].includes(hex)) {
                css += `background:#${hex};`;
            }
        }

        // Font
        if (fnt.bold) css += "font-weight:bold;";
        if (fnt.italic) css += "font-style:italic;";
        if (fnt.size) css += `font-size:${Math.round(fnt.size * 0.88)}px;`;
        if (fnt.color?.argb) {
            const fc = fnt.color.argb.length === 8
                ? fnt.color.argb.substring(2)
                : fnt.color.argb;
            if (!["000000", "000000"].includes(fc))
                css += `color:#${fc};`;
        }

        // Alignment
        const hMap = {
            center: "center", right: "right", left: "left",
            justify: "justify", distributed: "center"
        };
        const vMap = {
            middle: "middle", top: "top", bottom: "bottom",
            distributed: "middle"
        };
        if (aln.horizontal && hMap[aln.horizontal])
            css += `text-align:${hMap[aln.horizontal]};`;
        if (aln.vertical && vMap[aln.vertical])
            css += `vertical-align:${vMap[aln.vertical]};`;
        if (aln.wrapText) css += "white-space:pre-wrap;";

        // Borders
        const sides = {
            top: "border-top", bottom: "border-bottom",
            left: "border-left", right: "border-right"
        };
        const bdrMap = {
            thin: "1px solid #aaa",
            medium: "2px solid #555",
            thick: "3px solid #222",
            hair: "1px solid #ddd",
            dashed: "1px dashed #bbb",
            dotted: "1px dotted #bbb",
            double: "3px double #888",
            dashDot: "1px dashed #bbb",
            mediumDashDot: "2px dashed #777",
            slantDashDot: "1px dashed #bbb",
        };
        Object.entries(sides).forEach(([side, prop]) => {
            const b = bdr[side];
            if (b?.style && bdrMap[b.style])
                css += `${prop}:${bdrMap[b.style]};`;
        });

        return css;
    }

    /** Get display text from an ExcelJS cell */
    function getCellText(cell) {
        const v = cell.value;
        if (v === null || v === undefined) return "";
        if (typeof v === "object") {
            if (v instanceof Date) return formatDate(v);
            if (v.richText) return v.richText.map(r => r.text).join("");
            if (v.text) return String(v.text);
            if (v.result !== undefined) return String(v.result); // formula
        }
        return String(v);
    }

    function formatDate(d) {
        const mm = String(d.getMonth() + 1).padStart(2, "0");
        const dd = String(d.getDate()).padStart(2, "0");
        return `${mm}/${dd}/${d.getFullYear()}`;
    }

    /** "AB12" → { r: 12, c: 28 } */
    function cellRefToRC(addr) {
        const m = addr.match(/^([A-Z]+)(\d+)$/);
        if (!m) return { r: 1, c: 1 };
        const c = m[1].split("").reduce((acc, ch) => acc * 26 + (ch.charCodeAt(0) - 64), 0);
        return { r: parseInt(m[2], 10), c };
    }

    /** 1-based column index → letter(s) */
    function colIndexToLetter(n) {
        let s = "";
        while (n > 0) {
            const rem = (n - 1) % 26;
            s = String.fromCharCode(65 + rem) + s;
            n = Math.floor((n - 1) / 26);
        }
        return s;
    }

    function escHtml(s) {
        return s.replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/\n/g, "<br>");
    }

    /* ── UI helpers ── */
    function updateFooter(sheetName) {
        const ws = workbook?.getWorksheet(sheetName);
        if (!ws) return;
        document.getElementById("cellCount").textContent =
            `${ws.rowCount} rows · ${ws.columnCount} columns · ` +
            `${(ws.model?.merges || []).length} merged regions`;
    }

    function showLoading() {
        document.getElementById("pdsLoading").style.display = "flex";
        document.getElementById("sheetContent").style.display = "none";
        document.getElementById("pdsError").classList.add("d-none");
    }

    function showContent() {
        document.getElementById("pdsLoading").style.display = "none";
        document.getElementById("sheetContent").style.display = "block";
        document.getElementById("pdsError").classList.add("d-none");
    }

    function showError(msg) {
        document.getElementById("pdsLoading").style.display = "none";
        document.getElementById("sheetContent").style.display = "none";
        const errEl = document.getElementById("pdsError");
        errEl.classList.remove("d-none");
        const msgEl = errEl.querySelector(".err-msg");
        if (msgEl && msg) msgEl.textContent = msg;
    }

})();