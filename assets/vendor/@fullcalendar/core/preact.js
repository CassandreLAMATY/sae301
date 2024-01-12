/**
 * Bundled by jsDelivr using Rollup v2.79.1 and Terser v5.19.2.
 * Original file: /npm/@fullcalendar/core@6.1.10/preact.js
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
import*as e from"preact";import{Component as t,createElement as r,isValidElement as o,Fragment as n}from"preact";export*from"preact";export{createPortal}from"preact/compat";const i=[],c=new Map;function l(e,t){const{sheet:r}=e,o=r.cssRules.length;t.split("}").forEach(((e,t)=>{(e=e.trim())&&r.insertRule(e+"}",o+t)}))}let s;"undefined"!=typeof document&&function(e){let t=c.get(e);if(!t||!t.isConnected){if(t=e.querySelector("style[data-fullcalendar]"),!t){t=document.createElement("style"),t.setAttribute("data-fullcalendar","");const r=(void 0===s&&(s=function(){const e=document.querySelector('meta[name="csp-nonce"]');if(e&&e.hasAttribute("content"))return e.getAttribute("content");const t=document.querySelector("script[nonce]");return t&&t.nonce||""}()),s);r&&(t.nonce=r);const o=e===document?document.head:e,n=e===document?o.querySelector("script,link[rel=stylesheet],link[as=style],style"):o.firstChild;o.insertBefore(t,n)}c.set(e,t),function(e){for(const t of i)l(e,t)}(t)}}(document);var A;function a(e){e.parentNode&&e.parentNode.removeChild(e)}A=':root{--fc-small-font-size:.85em;--fc-page-bg-color:#fff;--fc-neutral-bg-color:hsla(0,0%,82%,.3);--fc-neutral-text-color:grey;--fc-border-color:#ddd;--fc-button-text-color:#fff;--fc-button-bg-color:#2c3e50;--fc-button-border-color:#2c3e50;--fc-button-hover-bg-color:#1e2b37;--fc-button-hover-border-color:#1a252f;--fc-button-active-bg-color:#1a252f;--fc-button-active-border-color:#151e27;--fc-event-bg-color:#3788d8;--fc-event-border-color:#3788d8;--fc-event-text-color:#fff;--fc-event-selected-overlay-color:rgba(0,0,0,.25);--fc-more-link-bg-color:#d0d0d0;--fc-more-link-text-color:inherit;--fc-event-resizer-thickness:8px;--fc-event-resizer-dot-total-width:8px;--fc-event-resizer-dot-border-width:1px;--fc-non-business-color:hsla(0,0%,84%,.3);--fc-bg-event-color:#8fdf82;--fc-bg-event-opacity:0.3;--fc-highlight-color:rgba(188,232,241,.3);--fc-today-bg-color:rgba(255,220,40,.15);--fc-now-indicator-color:red}.fc-not-allowed,.fc-not-allowed .fc-event{cursor:not-allowed}.fc{display:flex;flex-direction:column;font-size:1em}.fc,.fc *,.fc :after,.fc :before{box-sizing:border-box}.fc table{border-collapse:collapse;border-spacing:0;font-size:1em}.fc th{text-align:center}.fc td,.fc th{padding:0;vertical-align:top}.fc a[data-navlink]{cursor:pointer}.fc a[data-navlink]:hover{text-decoration:underline}.fc-direction-ltr{direction:ltr;text-align:left}.fc-direction-rtl{direction:rtl;text-align:right}.fc-theme-standard td,.fc-theme-standard th{border:1px solid var(--fc-border-color)}.fc-liquid-hack td,.fc-liquid-hack th{position:relative}@font-face{font-family:fcicons;font-style:normal;font-weight:400;src:url("data:application/x-font-ttf;charset=utf-8;base64,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") format("truetype")}.fc-icon{speak:none;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;display:inline-block;font-family:fcicons!important;font-style:normal;font-variant:normal;font-weight:400;height:1em;line-height:1;text-align:center;text-transform:none;-webkit-user-select:none;-moz-user-select:none;user-select:none;width:1em}.fc-icon-chevron-left:before{content:"\\e900"}.fc-icon-chevron-right:before{content:"\\e901"}.fc-icon-chevrons-left:before{content:"\\e902"}.fc-icon-chevrons-right:before{content:"\\e903"}.fc-icon-minus-square:before{content:"\\e904"}.fc-icon-plus-square:before{content:"\\e905"}.fc-icon-x:before{content:"\\e906"}.fc .fc-button{border-radius:0;font-family:inherit;font-size:inherit;line-height:inherit;margin:0;overflow:visible;text-transform:none}.fc .fc-button:focus{outline:1px dotted;outline:5px auto -webkit-focus-ring-color}.fc .fc-button{-webkit-appearance:button}.fc .fc-button:not(:disabled){cursor:pointer}.fc .fc-button{background-color:transparent;border:1px solid transparent;border-radius:.25em;display:inline-block;font-size:1em;font-weight:400;line-height:1.5;padding:.4em .65em;text-align:center;-webkit-user-select:none;-moz-user-select:none;user-select:none;vertical-align:middle}.fc .fc-button:hover{text-decoration:none}.fc .fc-button:focus{box-shadow:0 0 0 .2rem rgba(44,62,80,.25);outline:0}.fc .fc-button:disabled{opacity:.65}.fc .fc-button-primary{background-color:var(--fc-button-bg-color);border-color:var(--fc-button-border-color);color:var(--fc-button-text-color)}.fc .fc-button-primary:hover{background-color:var(--fc-button-hover-bg-color);border-color:var(--fc-button-hover-border-color);color:var(--fc-button-text-color)}.fc .fc-button-primary:disabled{background-color:var(--fc-button-bg-color);border-color:var(--fc-button-border-color);color:var(--fc-button-text-color)}.fc .fc-button-primary:focus{box-shadow:0 0 0 .2rem rgba(76,91,106,.5)}.fc .fc-button-primary:not(:disabled).fc-button-active,.fc .fc-button-primary:not(:disabled):active{background-color:var(--fc-button-active-bg-color);border-color:var(--fc-button-active-border-color);color:var(--fc-button-text-color)}.fc .fc-button-primary:not(:disabled).fc-button-active:focus,.fc .fc-button-primary:not(:disabled):active:focus{box-shadow:0 0 0 .2rem rgba(76,91,106,.5)}.fc .fc-button .fc-icon{font-size:1.5em;vertical-align:middle}.fc .fc-button-group{display:inline-flex;position:relative;vertical-align:middle}.fc .fc-button-group>.fc-button{flex:1 1 auto;position:relative}.fc .fc-button-group>.fc-button.fc-button-active,.fc .fc-button-group>.fc-button:active,.fc .fc-button-group>.fc-button:focus,.fc .fc-button-group>.fc-button:hover{z-index:1}.fc-direction-ltr .fc-button-group>.fc-button:not(:first-child){border-bottom-left-radius:0;border-top-left-radius:0;margin-left:-1px}.fc-direction-ltr .fc-button-group>.fc-button:not(:last-child){border-bottom-right-radius:0;border-top-right-radius:0}.fc-direction-rtl .fc-button-group>.fc-button:not(:first-child){border-bottom-right-radius:0;border-top-right-radius:0;margin-right:-1px}.fc-direction-rtl .fc-button-group>.fc-button:not(:last-child){border-bottom-left-radius:0;border-top-left-radius:0}.fc .fc-toolbar{align-items:center;display:flex;justify-content:space-between}.fc .fc-toolbar.fc-header-toolbar{margin-bottom:1.5em}.fc .fc-toolbar.fc-footer-toolbar{margin-top:1.5em}.fc .fc-toolbar-title{font-size:1.75em;margin:0}.fc-direction-ltr .fc-toolbar>*>:not(:first-child){margin-left:.75em}.fc-direction-rtl .fc-toolbar>*>:not(:first-child){margin-right:.75em}.fc-direction-rtl .fc-toolbar-ltr{flex-direction:row-reverse}.fc .fc-scroller{-webkit-overflow-scrolling:touch;position:relative}.fc .fc-scroller-liquid{height:100%}.fc .fc-scroller-liquid-absolute{bottom:0;left:0;position:absolute;right:0;top:0}.fc .fc-scroller-harness{direction:ltr;overflow:hidden;position:relative}.fc .fc-scroller-harness-liquid{height:100%}.fc-direction-rtl .fc-scroller-harness>.fc-scroller{direction:rtl}.fc-theme-standard .fc-scrollgrid{border:1px solid var(--fc-border-color)}.fc .fc-scrollgrid,.fc .fc-scrollgrid table{table-layout:fixed;width:100%}.fc .fc-scrollgrid table{border-left-style:hidden;border-right-style:hidden;border-top-style:hidden}.fc .fc-scrollgrid{border-bottom-width:0;border-collapse:separate;border-right-width:0}.fc .fc-scrollgrid-liquid{height:100%}.fc .fc-scrollgrid-section,.fc .fc-scrollgrid-section table,.fc .fc-scrollgrid-section>td{height:1px}.fc .fc-scrollgrid-section-liquid>td{height:100%}.fc .fc-scrollgrid-section>*{border-left-width:0;border-top-width:0}.fc .fc-scrollgrid-section-footer>*,.fc .fc-scrollgrid-section-header>*{border-bottom-width:0}.fc .fc-scrollgrid-section-body table,.fc .fc-scrollgrid-section-footer table{border-bottom-style:hidden}.fc .fc-scrollgrid-section-sticky>*{background:var(--fc-page-bg-color);position:sticky;z-index:3}.fc .fc-scrollgrid-section-header.fc-scrollgrid-section-sticky>*{top:0}.fc .fc-scrollgrid-section-footer.fc-scrollgrid-section-sticky>*{bottom:0}.fc .fc-scrollgrid-sticky-shim{height:1px;margin-bottom:-1px}.fc-sticky{position:sticky}.fc .fc-view-harness{flex-grow:1;position:relative}.fc .fc-view-harness-active>.fc-view{bottom:0;left:0;position:absolute;right:0;top:0}.fc .fc-col-header-cell-cushion{display:inline-block;padding:2px 4px}.fc .fc-bg-event,.fc .fc-highlight,.fc .fc-non-business{bottom:0;left:0;position:absolute;right:0;top:0}.fc .fc-non-business{background:var(--fc-non-business-color)}.fc .fc-bg-event{background:var(--fc-bg-event-color);opacity:var(--fc-bg-event-opacity)}.fc .fc-bg-event .fc-event-title{font-size:var(--fc-small-font-size);font-style:italic;margin:.5em}.fc .fc-highlight{background:var(--fc-highlight-color)}.fc .fc-cell-shaded,.fc .fc-day-disabled{background:var(--fc-neutral-bg-color)}a.fc-event,a.fc-event:hover{text-decoration:none}.fc-event.fc-event-draggable,.fc-event[href]{cursor:pointer}.fc-event .fc-event-main{position:relative;z-index:2}.fc-event-dragging:not(.fc-event-selected){opacity:.75}.fc-event-dragging.fc-event-selected{box-shadow:0 2px 7px rgba(0,0,0,.3)}.fc-event .fc-event-resizer{display:none;position:absolute;z-index:4}.fc-event-selected .fc-event-resizer,.fc-event:hover .fc-event-resizer{display:block}.fc-event-selected .fc-event-resizer{background:var(--fc-page-bg-color);border-color:inherit;border-radius:calc(var(--fc-event-resizer-dot-total-width)/2);border-style:solid;border-width:var(--fc-event-resizer-dot-border-width);height:var(--fc-event-resizer-dot-total-width);width:var(--fc-event-resizer-dot-total-width)}.fc-event-selected .fc-event-resizer:before{bottom:-20px;content:"";left:-20px;position:absolute;right:-20px;top:-20px}.fc-event-selected,.fc-event:focus{box-shadow:0 2px 5px rgba(0,0,0,.2)}.fc-event-selected:before,.fc-event:focus:before{bottom:0;content:"";left:0;position:absolute;right:0;top:0;z-index:3}.fc-event-selected:after,.fc-event:focus:after{background:var(--fc-event-selected-overlay-color);bottom:-1px;content:"";left:-1px;position:absolute;right:-1px;top:-1px;z-index:1}.fc-h-event{background-color:var(--fc-event-bg-color);border:1px solid var(--fc-event-border-color);display:block}.fc-h-event .fc-event-main{color:var(--fc-event-text-color)}.fc-h-event .fc-event-main-frame{display:flex}.fc-h-event .fc-event-time{max-width:100%;overflow:hidden}.fc-h-event .fc-event-title-container{flex-grow:1;flex-shrink:1;min-width:0}.fc-h-event .fc-event-title{display:inline-block;left:0;max-width:100%;overflow:hidden;right:0;vertical-align:top}.fc-h-event.fc-event-selected:before{bottom:-10px;top:-10px}.fc-direction-ltr .fc-daygrid-block-event:not(.fc-event-start),.fc-direction-rtl .fc-daygrid-block-event:not(.fc-event-end){border-bottom-left-radius:0;border-left-width:0;border-top-left-radius:0}.fc-direction-ltr .fc-daygrid-block-event:not(.fc-event-end),.fc-direction-rtl .fc-daygrid-block-event:not(.fc-event-start){border-bottom-right-radius:0;border-right-width:0;border-top-right-radius:0}.fc-h-event:not(.fc-event-selected) .fc-event-resizer{bottom:0;top:0;width:var(--fc-event-resizer-thickness)}.fc-direction-ltr .fc-h-event:not(.fc-event-selected) .fc-event-resizer-start,.fc-direction-rtl .fc-h-event:not(.fc-event-selected) .fc-event-resizer-end{cursor:w-resize;left:calc(var(--fc-event-resizer-thickness)*-.5)}.fc-direction-ltr .fc-h-event:not(.fc-event-selected) .fc-event-resizer-end,.fc-direction-rtl .fc-h-event:not(.fc-event-selected) .fc-event-resizer-start{cursor:e-resize;right:calc(var(--fc-event-resizer-thickness)*-.5)}.fc-h-event.fc-event-selected .fc-event-resizer{margin-top:calc(var(--fc-event-resizer-dot-total-width)*-.5);top:50%}.fc-direction-ltr .fc-h-event.fc-event-selected .fc-event-resizer-start,.fc-direction-rtl .fc-h-event.fc-event-selected .fc-event-resizer-end{left:calc(var(--fc-event-resizer-dot-total-width)*-.5)}.fc-direction-ltr .fc-h-event.fc-event-selected .fc-event-resizer-end,.fc-direction-rtl .fc-h-event.fc-event-selected .fc-event-resizer-start{right:calc(var(--fc-event-resizer-dot-total-width)*-.5)}.fc .fc-popover{box-shadow:0 2px 6px rgba(0,0,0,.15);position:absolute;z-index:9999}.fc .fc-popover-header{align-items:center;display:flex;flex-direction:row;justify-content:space-between;padding:3px 4px}.fc .fc-popover-title{margin:0 2px}.fc .fc-popover-close{cursor:pointer;font-size:1.1em;opacity:.65}.fc-theme-standard .fc-popover{background:var(--fc-page-bg-color);border:1px solid var(--fc-border-color)}.fc-theme-standard .fc-popover-header{background:var(--fc-neutral-bg-color)}',i.push(A),c.forEach((e=>{l(e,A)}));let f=0;function d(e,t){let r=String(e);return"000".substr(0,t-r.length)+r}function u(e){let t=e.querySelector(".fc-scrollgrid-shrink-frame"),r=e.querySelector(".fc-scrollgrid-shrink-cushion");if(!t)throw new Error("needs fc-scrollgrid-shrink-frame className");if(!r)throw new Error("needs fc-scrollgrid-shrink-cushion className");return e.getBoundingClientRect().width-t.getBoundingClientRect().width+r.getBoundingClientRect().width}const h=/^(-?)(?:(\d+)\.)?(\d+):(\d\d)(?::(\d\d)(?:\.(\d\d\d))?)?/;function g(e,t){return"string"==typeof e?function(e){let t=h.exec(e);if(t){let e=t[1]?-1:1;return{years:0,months:0,days:e*(t[2]?parseInt(t[2],10):0),milliseconds:e*(60*(t[3]?parseInt(t[3],10):0)*60*1e3+60*(t[4]?parseInt(t[4],10):0)*1e3+1e3*(t[5]?parseInt(t[5],10):0)+(t[6]?parseInt(t[6],10):0))}}return null}(e):"object"==typeof e&&e?p(e):"number"==typeof e?p({[t||"milliseconds"]:e}):null}function p(e){let t={years:e.years||e.year||0,months:e.months||e.month||0,days:e.days||e.day||0,milliseconds:60*(e.hours||e.hour||0)*60*1e3+60*(e.minutes||e.minute||0)*1e3+1e3*(e.seconds||e.second||0)+(e.milliseconds||e.millisecond||e.ms||0)},r=e.weeks||e.week;return r&&(t.days+=7*r,t.specifiedWeeks=!0),t}function m(e,t,r){if(e===t)return!0;let o,n=e.length;if(n!==t.length)return!1;for(o=0;o<n;o+=1)if(!(r?r(e[o],t[o]):e[o]===t[o]))return!1;return!0}function b(e){return[e.getUTCFullYear(),e.getUTCMonth(),e.getUTCDate(),e.getUTCHours(),e.getUTCMinutes(),e.getUTCSeconds(),e.getUTCMilliseconds()]}function v(e){return 1===e.length&&(e=e.concat([0])),new Date(Date.UTC(...e))}function w(e){return 1e3*e.getUTCHours()*60*60+1e3*e.getUTCMinutes()*60+1e3*e.getUTCSeconds()+e.getUTCMilliseconds()}function y(e,t=!1){let r=e<0?"-":"+",o=Math.abs(e),n=Math.floor(o/60),i=Math.round(o%60);return t?`${r+d(n,2)}:${d(i,2)}`:`GMT${r}${n}${i?`:${d(i,2)}`:""}`}function B(e,t,r){let o,n;return function(...i){if(o){if(!m(o,i)){r&&r(n);let o=e.apply(this,i);t&&t(o,n)||(n=o)}}else n=e.apply(this,i);return o=i,n}}const Q={week:3,separator:0,omitZeroMinute:0,meridiem:0,omitCommas:0},C={timeZoneName:7,era:6,year:5,month:4,day:2,weekday:2,hour:1,minute:1,second:1},x=/\s*([ap])\.?m\.?/i,M=/,/g,k=/\s+/g,D=/\u200e/g,E=/UTC|GMT/;class N{constructor(e){let t={},r={},o=0;for(let n in e)n in Q?(r[n]=e[n],o=Math.max(Q[n],o)):(t[n]=e[n],n in C&&(o=Math.max(C[n],o)));this.standardDateProps=t,this.extendedSettings=r,this.severity=o,this.buildFormattingFunc=B(I)}format(e,t){return this.buildFormattingFunc(this.standardDateProps,this.extendedSettings,t)(e)}formatRange(e,t,r,o){let{standardDateProps:n,extendedSettings:i}=this,c=function(e,t,r){if(r.getMarkerYear(e)!==r.getMarkerYear(t))return 5;if(r.getMarkerMonth(e)!==r.getMarkerMonth(t))return 4;if(r.getMarkerDay(e)!==r.getMarkerDay(t))return 2;if(w(e)!==w(t))return 1;return 0}(e.marker,t.marker,r.calendarSystem);if(!c)return this.format(e,r);let l=c;!(l>1)||"numeric"!==n.year&&"2-digit"!==n.year||"numeric"!==n.month&&"2-digit"!==n.month||"numeric"!==n.day&&"2-digit"!==n.day||(l=1);let s=this.format(e,r),A=this.format(t,r);if(s===A)return s;let a=I(function(e,t){let r={};for(let o in e)(!(o in C)||C[o]<=t)&&(r[o]=e[o]);return r}(n,l),i,r),f=a(e),d=a(t),u=function(e,t,r,o){let n=0;for(;n<e.length;){let i=e.indexOf(t,n);if(-1===i)break;let c=e.substr(0,i);n=i+t.length;let l=e.substr(n),s=0;for(;s<r.length;){let e=r.indexOf(o,s);if(-1===e)break;let t=r.substr(0,e);s=e+o.length;let n=r.substr(s);if(c===t&&l===n)return{before:c,after:l}}}return null}(s,f,A,d),h=i.separator||o||r.defaultSeparator||"";return u?u.before+f+h+d+u.after:s+h+A}getLargestUnit(){switch(this.severity){case 7:case 6:case 5:return"year";case 4:return"month";case 3:return"week";case 2:return"day";default:return"time"}}}function I(e,t,r){let o=Object.keys(e).length;return 1===o&&"short"===e.timeZoneName?e=>y(e.timeZoneOffset):0===o&&t.week?e=>function(e,t,r,o,n){let i=[];"long"===n?i.push(r):"short"!==n&&"narrow"!==n||i.push(t);"long"!==n&&"short"!==n||i.push(" ");i.push(o.simpleNumberFormat.format(e)),"rtl"===o.options.direction&&i.reverse();return i.join("")}(r.computeWeekNumber(e.marker),r.weekText,r.weekTextLong,r.locale,t.week):function(e,t,r){e=Object.assign({},e),t=Object.assign({},t),function(e,t){e.timeZoneName&&(e.hour||(e.hour="2-digit"),e.minute||(e.minute="2-digit"));"long"===e.timeZoneName&&(e.timeZoneName="short");t.omitZeroMinute&&(e.second||e.millisecond)&&delete t.omitZeroMinute}(e,t),e.timeZone="UTC";let o,n=new Intl.DateTimeFormat(r.locale.codes,e);if(t.omitZeroMinute){let t=Object.assign({},e);delete t.minute,o=new Intl.DateTimeFormat(r.locale.codes,t)}return i=>{let c,{marker:l}=i;return c=o&&!l.getUTCMinutes()?o:n,function(e,t,r,o,n){e=e.replace(D,""),"short"===r.timeZoneName&&(e=function(e,t){let r=!1;e=e.replace(E,(()=>(r=!0,t))),r||(e+=` ${t}`);return e}(e,"UTC"===n.timeZone||null==t.timeZoneOffset?"UTC":y(t.timeZoneOffset)));o.omitCommas&&(e=e.replace(M,"").trim());o.omitZeroMinute&&(e=e.replace(":00",""));!1===o.meridiem?e=e.replace(x,"").trim():"narrow"===o.meridiem?e=e.replace(x,((e,t)=>t.toLocaleLowerCase())):"short"===o.meridiem?e=e.replace(x,((e,t)=>`${t.toLocaleLowerCase()}m`)):"lowercase"===o.meridiem&&(e=e.replace(x,(e=>e.toLocaleLowerCase())));return e=e.replace(k," "),e=e.trim(),e}(c.format(l),i,e,t,r)}}(e,t,r)}function S(e,t){let r=t.markerToArray(e.marker);return{marker:e.marker,timeZoneOffset:e.timeZoneOffset,array:r,year:r[0],month:r[1],day:r[2],hour:r[3],minute:r[4],second:r[5],millisecond:r[6]}}function R(e,t,r,o){let n=S(e,r.calendarSystem);return{date:n,start:n,end:t?S(t,r.calendarSystem):null,timeZone:r.timeZone,localeCodes:r.locale.codes,defaultSeparator:o||r.defaultSeparator}}class z{constructor(e){this.cmdStr=e}format(e,t,r){return t.cmdFormatter(this.cmdStr,R(e,null,t,r))}formatRange(e,t,r,o){return r.cmdFormatter(this.cmdStr,R(e,t,r,o))}}class U{constructor(e){this.func=e}format(e,t,r){return this.func(R(e,null,t,r))}formatRange(e,t,r,o){return this.func(R(e,t,r,o))}}function F(e){return"object"==typeof e&&e?new N(e):"string"==typeof e?new z(e):"function"==typeof e?new U(e):null}function j(e){return e}const{hasOwnProperty:O}=Object.prototype;function T(e,t){if(e===t)return!0;for(let r in e)if(O.call(e,r)&&!(r in t))return!1;for(let r in t)if(O.call(t,r)&&e[r]!==t[r])return!1;return!0}const G=/^on[A-Z]/;function Y(e,t){let r=[];for(let o in e)O.call(e,o)&&(o in t||r.push(o));for(let o in t)O.call(t,o)&&e[o]!==t[o]&&r.push(o);return r}function H(e,t,r={}){if(e===t)return!0;for(let o in t)if(!(o in e)||!q(e[o],t[o],r[o]))return!1;for(let r in e)if(!(r in t))return!1;return!0}function q(e,t,r){return e===t||!0===r||!!r&&r(e,t)}function Z(t){t();let r=e.options.debounceRendering,o=[];for(e.options.debounceRendering=function(e){o.push(e)},e.render(e.createElement(W,{}),document.createElement("div"));o.length;)o.shift()();e.options.debounceRendering=r}class W extends e.Component{render(){return e.createElement("div",{})}componentDidMount(){this.setState({})}}function L(t){let r=e.createContext(t),o=r.Provider;return r.Provider=function(){let e=!this.getChildContext,t=o.apply(this,arguments);if(e){let e=[];this.shouldComponentUpdate=t=>{this.props.value!==t.value&&e.forEach((e=>{e.context=t.value,e.forceUpdate()}))},this.sub=t=>{e.push(t);let r=t.componentWillUnmount;t.componentWillUnmount=()=>{e.splice(e.indexOf(t),1),r&&r.call(t)}}}return t},r}const J=L({});class V extends t{shouldComponentUpdate(e,t){return this.debug&&console.log(Y(e,this.props),Y(t,this.state)),!H(this.props,e,this.propEquality)||!H(this.state,t,this.stateEquality)}safeSetState(e){H(this.state,Object.assign(Object.assign({},this.state),e),this.stateEquality)||this.setState(e)}}V.addPropsEquality=function(e){let t=Object.create(this.prototype.propEquality);Object.assign(t,e),this.prototype.propEquality=t},V.addStateEquality=function(e){let t=Object.create(this.prototype.stateEquality);Object.assign(t,e),this.prototype.stateEquality=t},V.contextType=J,V.prototype.propEquality={},V.prototype.stateEquality={};class P extends V{}function X(e,t){"function"==typeof e?e(t):e&&(e.current=t)}P.contextType=J;class $ extends P{constructor(){super(...arguments),this.id=(f+=1,String(f)),this.queuedDomNodes=[],this.currentDomNodes=[],this.handleEl=e=>{const{options:t}=this.context,{generatorName:r}=this.props;t.customRenderingReplaces&&K(r,t)||this.updateElRef(e)},this.updateElRef=e=>{this.props.elRef&&X(this.props.elRef,e)}}render(){const{props:e,context:t}=this,{options:n}=t,{customGenerator:i,defaultGenerator:c,renderProps:l}=e,s=_(e,[],this.handleEl);let A,a,f=!1,d=[];if(null!=i){const e="function"==typeof i?i(l,r):i;if(!0===e)f=!0;else{const t=e&&"object"==typeof e;t&&"html"in e?s.dangerouslySetInnerHTML={__html:e.html}:t&&"domNodes"in e?d=Array.prototype.slice.call(e.domNodes):(t?o(e):"function"!=typeof e)?A=e:a=e}}else f=!K(e.generatorName,n);return f&&c&&(A=c(l)),this.queuedDomNodes=d,this.currentGeneratorMeta=a,r(e.elTag,s,A)}componentDidMount(){this.applyQueueudDomNodes(),this.triggerCustomRendering(!0)}componentDidUpdate(){this.applyQueueudDomNodes(),this.triggerCustomRendering(!0)}componentWillUnmount(){this.triggerCustomRendering(!1)}triggerCustomRendering(e){var t;const{props:r,context:o}=this,{handleCustomRendering:n,customRenderingMetaMap:i}=o.options;if(n){const o=null!==(t=this.currentGeneratorMeta)&&void 0!==t?t:null==i?void 0:i[r.generatorName];o&&n(Object.assign(Object.assign({id:this.id,isActive:e,containerEl:this.base,reportNewContainerEl:this.updateElRef,generatorMeta:o},r),{elClasses:(r.elClasses||[]).filter(ee)}))}}applyQueueudDomNodes(){const{queuedDomNodes:e,currentDomNodes:t}=this,r=this.base;if(!m(e,t)){t.forEach(a);for(let t of e)r.appendChild(t);this.currentDomNodes=e}}}function K(e,t){var r;return Boolean(t.handleCustomRendering&&e&&(null===(r=t.customRenderingMetaMap)||void 0===r?void 0:r[e]))}function _(e,t,r){const o=Object.assign(Object.assign({},e.elAttrs),{ref:r});return(e.elClasses||t)&&(o.className=(e.elClasses||[]).concat(t||[]).concat(o.className||[]).filter(Boolean).join(" ")),e.elStyle&&(o.style=e.elStyle),o}function ee(e){return Boolean(e)}$.addPropsEquality({elClasses:m,elStyle:T,elAttrs:function(e,t){const r=Y(e,t);for(let e of r)if(!G.test(e))return!1;return!0},renderProps:T});const te=L(0);function re(e,t){const o=e.props;return r($,Object.assign({renderProps:o.renderProps,generatorName:o.generatorName,customGenerator:o.customGenerator,defaultGenerator:o.defaultGenerator,renderId:e.context},t))}(class extends t{constructor(){super(...arguments),this.InnerContent=re.bind(void 0,this),this.handleEl=e=>{this.el=e,this.props.elRef&&(X(this.props.elRef,e),e&&this.didMountMisfire&&this.componentDidMount())}}render(){const{props:e}=this,t=function(e,t){const r="function"==typeof e?e(t):e||[];return"string"==typeof r?[r]:r}(e.classNameGenerator,e.renderProps);if(e.children){const o=_(e,t,this.handleEl),n=e.children(this.InnerContent,e.renderProps,o);return e.elTag?r(e.elTag,o,n):n}return r($,Object.assign(Object.assign({},e),{elRef:this.handleEl,elTag:e.elTag||"div",elClasses:(e.elClasses||[]).concat(t),renderId:this.context}))}componentDidMount(){var e,t;this.el?null===(t=(e=this.props).didMount)||void 0===t||t.call(e,Object.assign(Object.assign({},this.props.renderProps),{el:this.el})):this.didMountMisfire=!0}componentWillUnmount(){var e,t;null===(t=(e=this.props).willUnmount)||void 0===t||t.call(e,Object.assign(Object.assign({},this.props.renderProps),{el:this.el}))}}).contextType=te;const oe={id:String,groupId:String,title:String,url:String,interactive:Boolean},ne={start:j,end:j,date:j,allDay:Boolean};let ie,ce;function le(){return null==ie&&(ie=function(){if("undefined"==typeof document)return!0;let e=document.createElement("div");e.style.position="absolute",e.style.top="0px",e.style.left="0px",e.innerHTML="<table><tr><td><div></div></td></tr></table>",e.querySelector("table").style.height="100px",e.querySelector("div").style.height="100%",document.body.appendChild(e);let t=e.querySelector("div").offsetHeight>0;return document.body.removeChild(e),t}()),ie}function se(){return ce||(ce=function(){let e=document.createElement("div");e.style.overflow="scroll",e.style.position="absolute",e.style.top="-9999px",e.style.left="-9999px",document.body.appendChild(e);let t=function(e){return{x:e.offsetHeight-e.clientHeight,y:e.offsetWidth-e.clientWidth}}(e);return document.body.removeChild(e),t}()),ce}Object.assign(Object.assign(Object.assign({},oe),ne),{extendedProps:j}),F({year:"numeric",month:"long",day:"numeric"}),F({week:"long"}),F({weekday:"long"});function Ae(e){let t=v([(r=e).getUTCFullYear(),r.getUTCMonth(),r.getUTCDate()]);var r;let o=function(e,t){let r=b(e);return r[2]+=t,v(r)}(t,1);return{start:t,end:o}}(class extends t{constructor(e,t){var r,o;super(e,t),this.initialNowDate=(r=t.options.now,o=t.dateEnv,"function"==typeof r&&(r=r()),null==r?o.createNowMarker():o.createMarker(r)),this.initialNowQueriedMs=(new Date).valueOf(),this.state=this.computeTiming().currentState}render(){let{props:e,state:t}=this;return e.children(t.nowDate,t.todayRange)}componentDidMount(){this.setTimeout()}componentDidUpdate(e){e.unit!==this.props.unit&&(this.clearTimeout(),this.setTimeout())}componentWillUnmount(){this.clearTimeout()}computeTiming(){let{props:e,context:t}=this,r=function(e,t){let r=b(e);return r[6]+=t,v(r)}(this.initialNowDate,(new Date).valueOf()-this.initialNowQueriedMs),o=t.dateEnv.startOf(r,e.unit),n=t.dateEnv.add(o,g(1,e.unit)),i=n.valueOf()-r.valueOf();return i=Math.min(864e5,i),{currentState:{nowDate:o,todayRange:Ae(o)},nextState:{nowDate:n,todayRange:Ae(n)},waitMs:i}}setTimeout(){let{nextState:e,waitMs:t}=this.computeTiming();this.timeoutId=setTimeout((()=>{this.setState(e,(()=>{this.setTimeout()}))}),t)}clearTimeout(){this.timeoutId&&clearTimeout(this.timeoutId)}}).contextType=J;const ae=/^(visible|hidden)$/;class fe extends P{constructor(){super(...arguments),this.handleEl=e=>{this.el=e,X(this.props.elRef,e)}}render(){let{props:e}=this,{liquid:t,liquidIsAbsolute:o}=e,n=t&&o,i=["fc-scroller"];return t&&(o?i.push("fc-scroller-liquid-absolute"):i.push("fc-scroller-liquid")),r("div",{ref:this.handleEl,className:i.join(" "),style:{overflowX:e.overflowX,overflowY:e.overflowY,left:n&&-(e.overcomeLeft||0)||"",right:n&&-(e.overcomeRight||0)||"",bottom:n&&-(e.overcomeBottom||0)||"",marginLeft:!n&&-(e.overcomeLeft||0)||"",marginRight:!n&&-(e.overcomeRight||0)||"",marginBottom:!n&&-(e.overcomeBottom||0)||"",maxHeight:e.maxHeight||""}},e.children)}needsXScrolling(){if(ae.test(this.props.overflowX))return!1;let{el:e}=this,t=this.el.getBoundingClientRect().width-this.getYScrollbarWidth(),{children:r}=e;for(let e=0;e<r.length;e+=1){if(r[e].getBoundingClientRect().width>t)return!0}return!1}needsYScrolling(){if(ae.test(this.props.overflowY))return!1;let{el:e}=this,t=this.el.getBoundingClientRect().height-this.getXScrollbarWidth(),{children:r}=e;for(let e=0;e<r.length;e+=1){if(r[e].getBoundingClientRect().height>t)return!0}return!1}getXScrollbarWidth(){return ae.test(this.props.overflowX)?0:this.el.offsetHeight-this.el.clientHeight}getYScrollbarWidth(){return ae.test(this.props.overflowY)?0:this.el.offsetWidth-this.el.clientWidth}}class de{constructor(e){this.masterCallback=e,this.currentMap={},this.depths={},this.callbackMap={},this.handleValue=(e,t)=>{let{depths:r,currentMap:o}=this,n=!1,i=!1;null!==e?(n=t in o,o[t]=e,r[t]=(r[t]||0)+1,i=!0):(r[t]-=1,r[t]||(delete o[t],delete this.callbackMap[t],n=!0)),this.masterCallback&&(n&&this.masterCallback(null,String(t)),i&&this.masterCallback(e,String(t)))}}createRef(e){let t=this.callbackMap[e];return t||(t=this.callbackMap[e]=t=>{this.handleValue(t,String(e))}),t}collect(e,t,r){return function(e,t=0,r,o=1){let n=[];null==r&&(r=Object.keys(e).length);for(let i=t;i<r;i+=o){let t=e[i];void 0!==t&&n.push(t)}return n}(this.currentMap,e,t,r)}getAll(){return function(e){let t=[];for(let r in e)t.push(e[r]);return t}(this.currentMap)}}function ue(e){let t=function(e,t){let r=e instanceof HTMLElement?[e]:e,o=[];for(let e=0;e<r.length;e+=1){let n=r[e].querySelectorAll(t);for(let e=0;e<n.length;e+=1)o.push(n[e])}return o}(e,".fc-scrollgrid-shrink"),r=0;for(let e of t)r=Math.max(r,u(e));return Math.ceil(r)}function he(e,t){return e.liquid&&t.liquid}function ge(e,t){return m(e,t,T)}function pe(e,t){let o=[];for(let n of e){let e=n.span||1;for(let i=0;i<e;i+=1)o.push(r("col",{style:{width:"shrink"===n.width?me(t):n.width||"",minWidth:n.minWidth||""}}))}return r("colgroup",{},...o)}function me(e){return null==e?4:e}function be(e,t){let r=["fc-scrollgrid-section",`fc-scrollgrid-section-${e.type}`,e.className];return t&&e.liquid&&null==e.maxHeight&&r.push("fc-scrollgrid-section-liquid"),e.isSticky&&r.push("fc-scrollgrid-section-sticky"),r}(class extends P{constructor(){super(...arguments),this.processCols=B((e=>e),ge),this.renderMicroColGroup=B(pe),this.scrollerRefs=new de,this.scrollerElRefs=new de(this._handleScrollerEl.bind(this)),this.state={shrinkWidth:null,forceYScrollbars:!1,scrollerClientWidths:{},scrollerClientHeights:{}},this.handleSizing=()=>{this.safeSetState(Object.assign({shrinkWidth:this.computeShrinkWidth()},this.computeScrollerDims()))}}render(){let{props:e,state:t,context:o}=this,n=e.sections||[],i=this.processCols(e.cols),c=this.renderMicroColGroup(i,t.shrinkWidth),l=function(e,t){let r=["fc-scrollgrid",t.theme.getClass("table")];return e&&r.push("fc-scrollgrid-liquid"),r}(e.liquid,o);e.collapsibleWidth&&l.push("fc-scrollgrid-collapsible");let s,A=n.length,a=0,f=[],d=[],u=[];for(;a<A&&"header"===(s=n[a]).type;)f.push(this.renderSection(s,c,!0)),a+=1;for(;a<A&&"body"===(s=n[a]).type;)d.push(this.renderSection(s,c,!1)),a+=1;for(;a<A&&"footer"===(s=n[a]).type;)u.push(this.renderSection(s,c,!0)),a+=1;let h=!le();const g={role:"rowgroup"};return r("table",{role:"grid",className:l.join(" "),style:{height:e.height}},Boolean(!h&&f.length)&&r("thead",g,...f),Boolean(!h&&d.length)&&r("tbody",g,...d),Boolean(!h&&u.length)&&r("tfoot",g,...u),h&&r("tbody",g,...f,...d,...u))}renderSection(e,t,o){return"outerContent"in e?r(n,{key:e.key},e.outerContent):r("tr",{key:e.key,role:"presentation",className:be(e,this.props.liquid).join(" ")},this.renderChunkTd(e,t,e.chunk,o))}renderChunkTd(e,t,o,n){if("outerContent"in o)return o.outerContent;let{props:i}=this,{forceYScrollbars:c,scrollerClientWidths:l,scrollerClientHeights:s}=this.state,A=function(e,t){return null!=t.maxHeight||he(e,t)}(i,e),a=he(i,e),f=i.liquid?c?"scroll":A?"auto":"hidden":"visible",d=e.key,u=function(e,t,o,n){let{expandRows:i}=o;return"function"==typeof t.content?t.content(o):r("table",{role:"presentation",className:[t.tableClassName,e.syncRowHeights?"fc-scrollgrid-sync-table":""].join(" "),style:{minWidth:o.tableMinWidth,width:o.clientWidth,height:i?o.clientHeight:""}},o.tableColGroupNode,r(n?"thead":"tbody",{role:"presentation"},"function"==typeof t.rowContent?t.rowContent(o):t.rowContent))}(e,o,{tableColGroupNode:t,tableMinWidth:"",clientWidth:i.collapsibleWidth||void 0===l[d]?null:l[d],clientHeight:void 0!==s[d]?s[d]:null,expandRows:e.expandRows,syncRowHeights:!1,rowSyncHeights:[],reportRowHeightChange:()=>{}},n);return r(n?"th":"td",{ref:o.elRef,role:"presentation"},r("div",{className:"fc-scroller-harness"+(a?" fc-scroller-harness-liquid":"")},r(fe,{ref:this.scrollerRefs.createRef(d),elRef:this.scrollerElRefs.createRef(d),overflowY:f,overflowX:i.liquid?"hidden":"visible",maxHeight:e.maxHeight,liquid:a,liquidIsAbsolute:!0},u)))}_handleScrollerEl(e,t){let r=function(e,t){for(let r of e)if(r.key===t)return r;return null}(this.props.sections,t);r&&X(r.chunk.scrollerElRef,e)}componentDidMount(){this.handleSizing(),this.context.addResizeHandler(this.handleSizing)}componentDidUpdate(){this.handleSizing()}componentWillUnmount(){this.context.removeResizeHandler(this.handleSizing)}computeShrinkWidth(){return function(e){for(let t of e)if("shrink"===t.width)return!0;return!1}(this.props.cols)?ue(this.scrollerElRefs.getAll()):0}computeScrollerDims(){let e=se(),{scrollerRefs:t,scrollerElRefs:r}=this,o=!1,n={},i={};for(let e in t.currentMap){let r=t.currentMap[e];if(r&&r.needsYScrolling()){o=!0;break}}for(let t of this.props.sections){let c=t.key,l=r.currentMap[c];if(l){let t=l.parentNode;n[c]=Math.floor(t.getBoundingClientRect().width-(o?e.y:0)),i[c]=Math.floor(t.getBoundingClientRect().height)}}return{forceYScrollbars:o,scrollerClientWidths:n,scrollerClientHeights:i}}}).addStateEquality({scrollerClientWidths:T,scrollerClientHeights:T}),F({day:"numeric"});export{L as createContext,Z as flushSync};export default null;
