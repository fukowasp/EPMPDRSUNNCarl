/**
 * pds_renderer.js  —  v7
 * Applies employee data AND exact Excel cell background colors to the PDS tables.
 * Cell color map extracted directly from PDS-Form-212-2025.xlsx via openpyxl.
 */

(function () {
    "use strict";

    /* ── Excel cell background color map (extracted from xlsx) ───
       Keys: "row,col"  Values: hex color
       Only cells with non-default (non-white) fills are listed.
       White (#FFFFFF) cells are listed explicitly where Excel sets them.
       All unlisted cells = white (#FFFFFF) background.
    ─────────────────────────────────────────────────────────────── */
    var CELL_COLORS = {"C1":{"1,1":"#969696","9,1":"#969696","10,1":"#C0C0C0","10,2":"#C0C0C0","11,1":"#C0C0C0","11,2":"#C0C0C0","11,12":"#EAEAEA","12,1":"#C0C0C0","12,2":"#C0C0C0","13,1":"#C0C0C0","13,2":"#C0C0C0","13,7":"#C0C0C0","13,8":"#C0C0C0","13,9":"#C0C0C0","13,10":"#FFFFFF","14,1":"#C0C0C0","14,2":"#C0C0C0","14,3":"#C0C0C0","14,7":"#C0C0C0","14,8":"#C0C0C0","14,9":"#C0C0C0","14,10":"#FFFFFF","14,11":"#FFFFFF","14,12":"#FFFFFF","14,13":"#FFFFFF","14,14":"#FFFFFF","15,1":"#C0C0C0","15,2":"#C0C0C0","15,3":"#C0C0C0","15,7":"#EAEAEA","15,10":"#FFFFFF","15,11":"#FFFFFF","15,12":"#FFFFFF","16,1":"#C0C0C0","16,2":"#C0C0C0","16,3":"#C0C0C0","16,7":"#EAEAEA","17,1":"#C0C0C0","17,2":"#C0C0C0","17,7":"#C0C0C0","17,8":"#C0C0C0","18,7":"#C0C0C0","18,8":"#C0C0C0","18,9":"#FFFFFF","18,12":"#FFFFFF","19,1":"#C0C0C0","19,2":"#C0C0C0","19,3":"#C0C0C0","19,7":"#C0C0C0","19,8":"#C0C0C0","20,1":"#C0C0C0","20,2":"#C0C0C0","20,3":"#C0C0C0","20,7":"#C0C0C0","20,8":"#C0C0C0","21,2":"#C0C0C0","21,3":"#C0C0C0","21,7":"#C0C0C0","21,8":"#C0C0C0","21,12":"#FFFFFF","22,1":"#C0C0C0","22,2":"#C0C0C0","22,7":"#C0C0C0","22,8":"#C0C0C0","23,7":"#C0C0C0","23,8":"#C0C0C0","23,12":"#FFFFFF","24,1":"#C0C0C0","24,2":"#C0C0C0","24,7":"#C0C0C0","25,1":"#C0C0C0","25,2":"#C0C0C0","25,7":"#C0C0C0","25,8":"#C0C0C0","26,7":"#C0C0C0","26,8":"#C0C0C0","26,9":"#FFFFFF","26,12":"#FFFFFF","27,1":"#C0C0C0","27,2":"#C0C0C0","27,7":"#C0C0C0","27,8":"#C0C0C0","28,7":"#C0C0C0","28,8":"#C0C0C0","28,12":"#FFFFFF","29,1":"#C0C0C0","29,2":"#C0C0C0","29,7":"#C0C0C0","29,8":"#C0C0C0","30,7":"#C0C0C0","30,8":"#C0C0C0","31,1":"#C0C0C0","31,2":"#C0C0C0","31,3":"#C0C0C0","31,7":"#C0C0C0","31,12":"#FFFFFF","32,1":"#C0C0C0","32,2":"#C0C0C0","32,3":"#C0C0C0","32,7":"#C0C0C0","32,8":"#C0C0C0","33,1":"#C0C0C0","33,7":"#EAEAEA","33,8":"#EAEAEA","34,1":"#C0C0C0","34,2":"#C0C0C0","34,3":"#EAEAEA","34,7":"#C0C0C0","34,8":"#C0C0C0","35,1":"#969696","35,2":"#969696","35,3":"#969696","35,4":"#969696","35,5":"#969696","35,6":"#969696","35,7":"#969696","35,8":"#969696","35,9":"#969696","35,10":"#969696","35,11":"#969696","35,12":"#969696","35,13":"#969696","35,14":"#969696","36,1":"#C0C0C0","36,2":"#C0C0C0","36,3":"#C0C0C0","36,9":"#C0C0C0","36,13":"#C0C0C0","37,1":"#C0C0C0","37,2":"#C0C0C0","37,3":"#C0C0C0","37,7":"#C0C0C0","38,1":"#C0C0C0","38,2":"#C0C0C0","38,3":"#C0C0C0","39,1":"#C0C0C0","39,2":"#C0C0C0","39,3":"#C0C0C0","40,1":"#C0C0C0","40,2":"#C0C0C0","40,3":"#C0C0C0","41,1":"#C0C0C0","41,2":"#C0C0C0","41,3":"#C0C0C0","42,1":"#C0C0C0","42,2":"#C0C0C0","42,3":"#C0C0C0","43,1":"#C0C0C0","43,2":"#C0C0C0","43,3":"#C0C0C0","44,1":"#C0C0C0","44,2":"#C0C0C0","44,3":"#C0C0C0","44,7":"#C0C0C0","45,1":"#C0C0C0","45,2":"#C0C0C0","45,3":"#C0C0C0","46,1":"#C0C0C0","46,2":"#C0C0C0","47,1":"#C0C0C0","47,2":"#C0C0C0","47,3":"#C0C0C0","47,4":"#FFFFFF","48,1":"#C0C0C0","48,2":"#C0C0C0","48,3":"#C0C0C0","48,4":"#FFFFFF","49,1":"#C0C0C0","49,2":"#C0C0C0","49,3":"#C0C0C0","49,9":"#C0C0C0","50,1":"#969696","50,2":"#969696","50,3":"#969696","50,4":"#969696","50,5":"#969696","50,6":"#969696","50,7":"#969696","50,8":"#969696","50,9":"#969696","51,1":"#C0C0C0","51,2":"#C0C0C0","51,4":"#C0C0C0","51,7":"#C0C0C0","51,10":"#C0C0C0","51,12":"#C0C0C0","51,13":"#C0C0C0","51,14":"#C0C0C0","53,1":"#C0C0C0","53,10":"#C0C0C0","53,11":"#C0C0C0","54,1":"#C0C0C0","54,2":"#C0C0C0","54,3":"#C0C0C0","55,1":"#C0C0C0","55,2":"#C0C0C0","55,3":"#C0C0C0","56,1":"#C0C0C0","56,2":"#C0C0C0","56,3":"#C0C0C0","57,1":"#C0C0C0","57,2":"#C0C0C0","57,3":"#C0C0C0","58,1":"#C0C0C0","58,2":"#C0C0C0","58,3":"#C0C0C0","59,1":"#C0C0C0","60,1":"#C0C0C0","60,10":"#C0C0C0","61,1":"#FFFFFF"},"C2":{"1,1":"#969696","2,1":"#969696","3,1":"#C0C0C0","3,2":"#C0C0C0","3,6":"#C0C0C0","3,7":"#C0C0C0","3,9":"#C0C0C0","3,10":"#C0C0C0","4,1":"#C0C0C0","4,10":"#C0C0C0","4,11":"#C0C0C0","12,1":"#C0C0C0","13,1":"#969696","14,1":"#969696","14,2":"#969696","14,3":"#969696","14,4":"#969696","14,5":"#969696","14,6":"#969696","14,7":"#969696","14,8":"#969696","14,9":"#969696","14,10":"#969696","14,11":"#969696","15,1":"#C0C0C0","15,2":"#C0C0C0","15,4":"#C0C0C0","15,7":"#C0C0C0","15,10":"#C0C0C0","15,11":"#C0C0C0","16,1":"#C0C0C0","17,1":"#C0C0C0","17,3":"#C0C0C0","46,1":"#C0C0C0","47,1":"#C0C0C0","47,9":"#C0C0C0","48,1":"#FFFFFF","48,12":"#FFFFFF"},"C3":{"1,1":"#969696","2,1":"#969696","3,1":"#C0C0C0","3,2":"#C0C0C0","3,5":"#C0C0C0","3,7":"#C0C0C0","3,8":"#C0C0C0","5,1":"#C0C0C0","5,2":"#C0C0C0","5,5":"#C0C0C0","5,6":"#C0C0C0","13,1":"#C0C0C0","14,1":"#969696","15,1":"#C0C0C0","15,2":"#C0C0C0","15,5":"#C0C0C0","15,7":"#C0C0C0","15,8":"#C0C0C0","15,9":"#C0C0C0","17,1":"#C0C0C0","17,5":"#C0C0C0","17,6":"#C0C0C0","39,1":"#C0C0C0","40,1":"#969696","41,1":"#C0C0C0","41,2":"#C0C0C0","41,3":"#C0C0C0","41,4":"#C0C0C0","41,9":"#C0C0C0","41,10":"#C0C0C0","49,1":"#C0C0C0","50,1":"#C0C0C0","50,7":"#EAEAEA"},"C4":{"1,1":"#969696","2,1":"#C0C0C0","2,3":"#C0C0C0","3,1":"#C0C0C0","3,2":"#C0C0C0","3,3":"#C0C0C0","4,1":"#C0C0C0","4,2":"#C0C0C0","4,3":"#C0C0C0","5,1":"#C0C0C0","5,2":"#C0C0C0","5,3":"#C0C0C0","6,1":"#C0C0C0","6,2":"#C0C0C0","6,3":"#C0C0C0","7,1":"#C0C0C0","7,2":"#C0C0C0","7,3":"#C0C0C0","7,4":"#C0C0C0","7,5":"#C0C0C0","7,6":"#C0C0C0","8,1":"#C0C0C0","8,2":"#C0C0C0","8,3":"#C0C0C0","9,1":"#C0C0C0","9,2":"#C0C0C0","9,3":"#C0C0C0","9,4":"#C0C0C0","9,5":"#C0C0C0","9,6":"#C0C0C0","10,1":"#C0C0C0","10,2":"#C0C0C0","10,3":"#C0C0C0","11,1":"#C0C0C0","11,2":"#C0C0C0","11,3":"#C0C0C0","12,1":"#C0C0C0","12,2":"#C0C0C0","12,3":"#C0C0C0","13,1":"#C0C0C0","13,3":"#C0C0C0","14,1":"#C0C0C0","14,2":"#C0C0C0","15,1":"#C0C0C0","15,2":"#C0C0C0","16,1":"#C0C0C0","16,2":"#C0C0C0","17,1":"#C0C0C0","17,2":"#C0C0C0","17,3":"#C0C0C0","17,4":"#C0C0C0","17,5":"#C0C0C0","17,6":"#C0C0C0","18,1":"#C0C0C0","18,2":"#C0C0C0","18,3":"#C0C0C0","19,1":"#C0C0C0","19,2":"#C0C0C0","20,1":"#C0C0C0","20,2":"#C0C0C0","21,1":"#C0C0C0","21,2":"#C0C0C0","22,1":"#C0C0C0","22,2":"#C0C0C0","23,1":"#C0C0C0","23,3":"#C0C0C0","24,1":"#C0C0C0","24,2":"#C0C0C0","25,1":"#C0C0C0","25,2":"#C0C0C0","26,1":"#C0C0C0","26,2":"#C0C0C0","27,1":"#C0C0C0","27,3":"#C0C0C0","28,1":"#C0C0C0","28,2":"#C0C0C0","29,1":"#C0C0C0","29,2":"#C0C0C0","30,1":"#C0C0C0","30,2":"#C0C0C0","31,1":"#C0C0C0","31,3":"#C0C0C0","32,1":"#C0C0C0","32,2":"#C0C0C0","33,1":"#C0C0C0","33,2":"#C0C0C0","33,3":"#C0C0C0","33,4":"#C0C0C0","33,5":"#C0C0C0","33,6":"#C0C0C0","34,1":"#C0C0C0","34,2":"#C0C0C0","34,3":"#C0C0C0","35,1":"#C0C0C0","35,2":"#C0C0C0","36,1":"#C0C0C0","36,2":"#C0C0C0","37,1":"#C0C0C0","37,3":"#C0C0C0","38,1":"#C0C0C0","38,2":"#C0C0C0","39,1":"#C0C0C0","39,2":"#C0C0C0","40,1":"#C0C0C0","40,2":"#C0C0C0","41,1":"#C0C0C0","41,3":"#C0C0C0","42,1":"#C0C0C0","42,2":"#C0C0C0","43,1":"#C0C0C0","43,2":"#C0C0C0","43,3":"#C0C0C0","44,1":"#C0C0C0","44,2":"#C0C0C0","45,1":"#C0C0C0","45,2":"#C0C0C0","45,3":"#C0C0C0","46,1":"#C0C0C0","46,2":"#C0C0C0","47,1":"#C0C0C0","47,2":"#C0C0C0","47,3":"#C0C0C0","47,5":"#C0C0C0","47,6":"#C0C0C0","48,1":"#C0C0C0","50,1":"#C0C0C0","50,3":"#C0C0C0","50,4":"#C0C0C0","50,5":"#C0C0C0","50,6":"#C0C0C0","50,7":"#C0C0C0","50,8":"#C0C0C0","50,9":"#C0C0C0","51,1":"#C0C0C0","51,6":"#C0C0C0","51,7":"#C0C0C0","55,1":"#C0C0C0","55,3":"#C0C0C0","55,9":"#C0C0C0","56,1":"#C0C0C0","56,2":"#C0C0C0","56,9":"#C0C0C0","57,1":"#C0C0C0","57,2":"#C0C0C0","57,9":"#C0C0C0","58,1":"#EAEAEA","58,2":"#EAEAEA","58,3":"#C0C0C0","58,4":"#C0C0C0","58,5":"#C0C0C0","58,6":"#C0C0C0","58,7":"#C0C0C0","58,8":"#C0C0C0","58,9":"#C0C0C0","60,2":"#C0C0C0","63,6":"#C0C0C0","65,6":"#C0C0C0","65,11":"#C0C0C0","69,5":"#C0C0C0"}};

    /* ── helpers ─────────────────────────────────────────────── */
    function colToIdx(letters) {
        return letters.toUpperCase().split('').reduce(function (n, ch) {
            return n * 26 + (ch.charCodeAt(0) - 64);
        }, 0);
    }
    function parseAddr(addr) {
        var m = addr.match(/^([A-Za-z]+)(\d+)$/);
        if (!m) return null;
        return { col: colToIdx(m[1]), row: parseInt(m[2], 10) };
    }

    /* ── build logical grid ──────────────────────────────────── */
    function buildCellMap(tableEl) {
        var map = {}, occupied = {}, rows = tableEl.rows;
        for (var r = 0; r < rows.length; r++) {
            var cur = 1, cells = rows[r].cells;
            for (var c = 0; c < cells.length; c++) {
                while (occupied[(r+1)+','+cur]) cur++;
                var td = cells[c], rs = td.rowSpan||1, cs = td.colSpan||1;
                map[(r+1)+','+cur] = td;
                for (var dr=0;dr<rs;dr++)
                    for (var dc=0;dc<cs;dc++)
                        if(dr||dc) occupied[(r+1+dr)+','+(cur+dc)]=true;
                cur += cs;
            }
        }
        return map;
    }

    /* ── apply Excel background colors to a table ────────────── */
    function applySheetColors(tableEl, sheetName) {
        var colorMap = CELL_COLORS[sheetName];
        if (!colorMap) return;

        var cellMap = buildCellMap(tableEl);

        Object.keys(cellMap).forEach(function (key) {
            var td = cellMap[key];
            var color = colorMap[key];
            if (color && color !== '#FFFFFF') {
                // Only apply non-white fills; white is already default
                td.style.backgroundColor = color;
                // Section headers: white text
                if (color === '#969696') {
                    td.style.color = '#ffffff';
                    td.style.fontWeight = 'bold';
                    td.style.fontStyle = 'italic';
                }
            }
            // EAEAEA cells: keep inline background from HTML too
        });
    }

    /* ── write value into td ─────────────────────────────────── */
    function writeCell(td, value) {
        if (!td || value === null || value === undefined || value === '') return;
        td.textContent = String(value);
        td.classList.add('pds-filled');
    }

    /* ── apply data cells ────────────────────────────────────── */
    function applyToDOM(cells) {
        var bySheet = {};
        Object.keys(cells).forEach(function (key) {
            var i = key.indexOf(':');
            if (i < 0) return;
            var sh = key.slice(0, i), ad = key.slice(i+1);
            (bySheet[sh] = bySheet[sh]||{})[ad] = cells[key];
        });
        Object.keys(bySheet).forEach(function (sh) {
            var tbl = document.getElementById('sheet-'+sh);
            if (tbl) applySheet(tbl, bySheet[sh]);
        });
        window._pdsEmployeeCells = cells;
    }

    function applySheet(tbl, sheetCells) {
        var map = buildCellMap(tbl);
        Object.keys(sheetCells).forEach(function (addr) {
            var d = sheetCells[addr], val = (d&&d.v!==undefined)?d.v:d;
            if (val===''||val==null) return;
            var rc = parseAddr(addr);
            if (!rc) return;
            writeCell(map[rc.row+','+rc.col], val);
        });
    }

    /* ── photo ───────────────────────────────────────────────── */
    function renderPhoto(src) {
        if (!src) return;
        var tbl = document.getElementById('sheet-C4');
        if (!tbl) return;
        var map = buildCellMap(tbl);
        var td  = map['50,10'];
        if (!td) return;
        var imgSrc = (src.startsWith('data:')||src.startsWith('http')||src.startsWith('/'))
            ? src : 'data:image/jpeg;base64,'+src;
        td.innerHTML = '';
        td.style.cssText += ';padding:0;overflow:hidden;';
        var img = document.createElement('img');
        img.src = imgSrc; img.alt = 'Employee Photo';
        img.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block;';
        td.appendChild(img);
    }

    /* ── color current visible sheet ─────────────────────────── */
    function colorSheet(name) {
        var tbl = document.getElementById('sheet-'+name);
        if (tbl) applySheetColors(tbl, name);
    }

    /* ── tab switch hook ─────────────────────────────────────── */
    var _orig = window.switchTab;
    window.switchTab = function (name, el) {
        if (typeof _orig === 'function') _orig(name, el);
        colorSheet(name);
        if (window._pdsEmployeeCells) {
            var prefix = name+':', sheet = {};
            Object.keys(window._pdsEmployeeCells).forEach(function(k){
                if (k.indexOf(prefix)===0) sheet[k.slice(prefix.length)] = window._pdsEmployeeCells[k];
            });
            var tbl = document.getElementById('sheet-'+name);
            if (tbl) applySheet(tbl, sheet);
        }
        if (name==='C4'&&window._pdsPhotoSrc)
            setTimeout(function(){renderPhoto(window._pdsPhotoSrc);}, 60);
    };

    /* ── fetch from API ──────────────────────────────────────── */
    async function fetchAndApply() {
        if (!window.PDS_CONFIG||!PDS_CONFIG.apiBase) return;
        try {
            var res = await fetch(PDS_CONFIG.apiBase+'/employee-data',{credentials:'same-origin'});
            if (!res.ok) throw new Error('HTTP '+res.status);
            var json = await res.json();
            if (!json.success) throw new Error(json.message||'API error');
            applyToDOM(json.cells||{});
            if (json.photo) {
                window._pdsPhotoSrc = json.photo;
                if (document.getElementById('sheet-C4')) renderPhoto(json.photo);
            }
            console.log('[PDS] Applied',Object.keys(json.cells||{}).length,'cells');
        } catch(err){ console.error('[PDS] fetch error:',err); }
    }

    /* ── download XLSX ───────────────────────────────────────── */
    async function downloadXlsx() {
        if (!window.PDS_CONFIG||!PDS_CONFIG.templateUrl) return;
        var btn = document.querySelector('.btn-dl');
        if (btn){btn.disabled=true;btn.textContent='⏳ Preparing…';}
        try {
            var res = await fetch(PDS_CONFIG.templateUrl,{cache:'force-cache'});
            if (!res.ok) throw new Error('Template fetch failed');
            var ExcelJS = window.ExcelJS;
            if (!ExcelJS) throw new Error('ExcelJS not loaded');
            var wb = new ExcelJS.Workbook();
            await wb.xlsx.load(await res.arrayBuffer());
            Object.keys(window._pdsEmployeeCells||{}).forEach(function(key){
                var i=key.indexOf(':'); if(i<0)return;
                var ws=wb.getWorksheet(key.slice(0,i)); if(!ws)return;
                var d=window._pdsEmployeeCells[key], val=(d&&d.v!==undefined)?d.v:'';
                ws.getCell(key.slice(i+1)).value=val||null;
            });
            var blob=new Blob([await wb.xlsx.writeBuffer()],
                {type:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
            var a=document.createElement('a');
            a.href=URL.createObjectURL(blob); a.download='PDS-Form-212-2025.xlsx';
            a.click(); URL.revokeObjectURL(a.href);
        } catch(err){console.error('[PDS] download error:',err);alert('Download failed: '+err.message);}
        finally{if(btn){btn.disabled=false;btn.textContent='⬇ Download XLSX';}}
    }

    /* ── boot ────────────────────────────────────────────────── */
    function boot() {
        var dlBtn = document.querySelector('.btn-dl');
        if (dlBtn) dlBtn.addEventListener('click', downloadXlsx);
        // Apply colors to the initial C1 tab immediately
        colorSheet('C1');
        fetchAndApply();
    }

    document.readyState==='loading'
        ? document.addEventListener('DOMContentLoaded', boot)
        : boot();
})();