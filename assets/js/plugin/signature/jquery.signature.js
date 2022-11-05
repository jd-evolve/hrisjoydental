/*! http://keith-wood.name/signature.html
	Signature plugin for jQuery UI v1.2.1.
	Requires excanvas.js in IE.
	Written by Keith Wood (wood.keith{at}optusnet.com.au) April 2012.
	Available under the MIT (http://keith-wood.name/licence.html) license. 
	Please attribute the author if you use it. */

/* globals G_vmlCanvasManager */
!function(e){"use strict";var t={options:{distance:0,background:"#fff",color:"#000",thickness:2,guideline:!1,guidelineColor:"#a0a0a0",guidelineOffset:50,guidelineIndent:10,notAvailable:"Your browser doesn't support signing",scale:1,syncField:null,syncFormat:"JSON",svgStyles:!1,change:null},_create:function(){this.element.addClass(this.widgetFullName||this.widgetBaseClass);try{this.canvas=e('<canvas width="'+this.element.width()+'" height="'+this.element.height()+'">'+this.options.notAvailable+"</canvas>")[0],this.element.append(this.canvas)}catch(t){e(this.canvas).remove(),this.resize=!0,this.canvas=document.createElement("canvas"),this.canvas.setAttribute("width",this.element.width()),this.canvas.setAttribute("height",this.element.height()),this.canvas.innerHTML=this.options.notAvailable,this.element.append(this.canvas),G_vmlCanvasManager&&G_vmlCanvasManager.initElement(this.canvas)}this.ctx=this.canvas.getContext("2d"),this._refresh(!0),this._mouseInit()},_refresh:function(t){if(this.resize){var n=e(this.canvas);e("div",this.canvas).css({width:n.width(),height:n.height()})}this.ctx.fillStyle=this.options.background,this.ctx.strokeStyle=this.options.color,this.ctx.lineWidth=this.options.thickness,this.ctx.lineCap="round",this.ctx.lineJoin="round",this.clear(t)},clear:function(e){this.options.disabled||(this.ctx.clearRect(0,0,this.element.width(),this.element.height()),this.ctx.fillRect(0,0,this.element.width(),this.element.height()),this.options.guideline&&(this.ctx.save(),this.ctx.strokeStyle=this.options.guidelineColor,this.ctx.lineWidth=1,this.ctx.beginPath(),this.ctx.moveTo(this.options.guidelineIndent,this.element.height()-this.options.guidelineOffset),this.ctx.lineTo(this.element.width()-this.options.guidelineIndent,this.element.height()-this.options.guidelineOffset),this.ctx.stroke(),this.ctx.restore()),this.lines=[],e||this._changed())},_changed:function(t){if(this.options.syncField){var n="";switch(this.options.syncFormat){case"PNG":n=this.toDataURL();break;case"JPEG":n=this.toDataURL("image/jpeg");break;case"SVG":n=this.toSVG();break;default:n=this.toJSON()}e(this.options.syncField).val(n)}this._trigger("change",t,{})},_setOptions:function(){this._superApply?this._superApply(arguments):e.Widget.prototype._setOptions.apply(this,arguments);var t=0,n=!0;for(var i in arguments[0])arguments[0].hasOwnProperty(i)&&(t++,n=n&&"disabled"===i);(t>1||!n)&&this._refresh()},_mouseCapture:function(){return!this.options.disabled},_mouseStart:function(e){this.offset=this.element.offset(),this.offset.left-=document.documentElement.scrollLeft||document.body.scrollLeft,this.offset.top-=document.documentElement.scrollTop||document.body.scrollTop,this.lastPoint=[this._round(e.clientX-this.offset.left),this._round(e.clientY-this.offset.top)],this.curLine=[this.lastPoint],this.lines.push(this.curLine)},_mouseDrag:function(e){var t=[this._round(e.clientX-this.offset.left),this._round(e.clientY-this.offset.top)];this.curLine.push(t),this.ctx.beginPath(),this.ctx.moveTo(this.lastPoint[0],this.lastPoint[1]),this.ctx.lineTo(t[0],t[1]),this.ctx.stroke(),this.lastPoint=t},_mouseStop:function(e){1===this.curLine.length&&(e.clientY+=this.options.thickness,this._mouseDrag(e)),this.lastPoint=null,this.curLine=null,this._changed(e)},_round:function(e){return Math.round(100*e)/100},toJSON:function(){return'{"lines":['+e.map(this.lines,function(t){return"["+e.map(t,function(e){return"["+e+"]"})+"]"})+"]}"},toSVG:function(){var t=this.options.svgStyles?'style="fill: '+this.options.background+';"':'fill="'+this.options.background+'"',n=this.options.svgStyles?'style="fill: none; stroke: '+this.options.color+"; stroke-width: "+this.options.thickness+';"':'fill="none" stroke="'+this.options.color+'" stroke-width="'+this.options.thickness+'"';return'<?xml version="1.0"?>\n<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">\n<svg xmlns="http://www.w3.org/2000/svg" width="15cm" height="15cm">\n	<g '+t+'>\n		<rect x="0" y="0" width="'+this.canvas.width+'" height="'+this.canvas.height+'"/>\n		<g '+n+">\n"+e.map(this.lines,function(t){return'			<polyline points="'+e.map(t,function(e){return e+""}).join(" ")+'"/>\n'}).join("")+"		</g>\n	</g>\n</svg>\n"},toDataURL:function(e,t){return this.canvas.toDataURL(e,t)},draw:function(e){this.options.disabled||(this.clear(!0),"string"==typeof e&&0===e.indexOf("data:")?this._drawDataURL(e,this.options.scale):"string"==typeof e&&e.indexOf("<svg")>-1?this._drawSVG(e,this.options.scale):this._drawJSON(e,this.options.scale),this._changed())},_drawJSON:function(t,n){"string"==typeof t&&(t=e.parseJSON(t)),this.lines=t.lines||[];var i=this.ctx;e.each(this.lines,function(){i.beginPath(),e.each(this,function(e){i[0===e?"moveTo":"lineTo"](this[0]*n,this[1]*n)}),i.stroke()})},_drawSVG:function(t,n){var i=this.lines=[];e(t).find("polyline").each(function(){var t=[];e.each(e(this).attr("points").split(" "),function(e,n){var i=n.split(",");t.push([parseFloat(i[0]),parseFloat(i[1])])}),i.push(t)});var a=this.ctx;e.each(this.lines,function(){a.beginPath(),e.each(this,function(e){a[0===e?"moveTo":"lineTo"](this[0]*n,this[1]*n)}),a.stroke()})},_drawDataURL:function(e,t){var n=new Image,i=this.ctx;n.onload=function(){i.drawImage(this,0,0,n.width*t,n.height*t)},n.src=e},isEmpty:function(){return 0===this.lines.length},_destroy:function(){this.element.removeClass(this.widgetFullName||this.widgetBaseClass),e(this.canvas).remove(),this.canvas=this.ctx=this.lines=null,this._mouseDestroy()}};e.Widget.prototype._destroy||e.extend(t,{destroy:function(){this._destroy(),e.Widget.prototype.destroy.call(this)}}),e.Widget.prototype._getCreateOptions===e.noop&&e.extend(t,{_getCreateOptions:function(){return e.metadata&&e.metadata.get(this.element[0])[this.widgetName]}}),e.widget("kbw.signature",e.ui.mouse,t),e.kbw.signature.options=e.kbw.signature.prototype.options}(jQuery);