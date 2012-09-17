var linktext=new Array()
linktext[0]="Pogrubienie: [b]tekst[/b]"
linktext[1]="Kursywa: [i]tekst[/i]"
linktext[2]="Podkre¶lenie: [u]tekst[/u]"
linktext[5]="Obrazek: [img]http://www.adr.es/obraz.ka[/img]"
linktext[6]="Kod: [code]kod php lub html[/code]"
linktext[7]="Cytat: [quote]cytat[/quote]"
linktext[8]="Kolor czcionki: [color=#000000]tekst[/color]"
linktext[9]="Rozmiar czcionki: [size=5]tekst[/size]"
linktext[10]="¦wiec±cy tekst: [glo=#a1f7a1]tekst[/glo]"

 var ns6=document.getElementById&&!document.all
 var ie=document.all

function show_text(thetext, whichdiv){
 if (ie) eval("document.all."+whichdiv).innerHTML=linktext[thetext]
 else if (ns6) document.getElementById(whichdiv).innerHTML=linktext[thetext]
}

function resetit(whichdiv){
 if (ie) eval("document.all."+whichdiv).innerHTML=' '
 else if (ns6) document.getElementById(whichdiv).innerHTML=' '
}

function AddText(text) {
	if (document.input.message.createTextRange && document.input.message.caretPos) {
		var caretPos = document.input.message.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?
		text + ' ' : text;
	}
	else document.input.message.value += text;
	document.input.message.focus(caretPos)
}

function showcolor(color) {
	AddTxt="[color="+color+"] [/color]";
	AddText(AddTxt);
}



function showsize(size) {
	AddTxt="[size="+size+"] [/size]";
	AddText(AddTxt);
}

function countlimit(maxlength,e,placeholder){
	var theform=eval(placeholder)
	var lengthleft=maxlength-theform.value.length
	var placeholderobj=document.all? document.all[placeholder] : document.getElementById(placeholder)
	if (window.event||e.target&&e.target==eval(placeholder)){
		if (lengthleft<0)
		theform.value=theform.value.substring(0,maxlength)
		placeholderobj.innerHTML=lengthleft
	}
}

function displaylimit(theform,thelimit){
	var limit_text='<b><span id="'+theform.toString()+'">'+thelimit+'</span></b>'
	if (document.all||ns6)
		document.write(limit_text)
	if (document.all){
		eval(theform).onkeypress=function(){ return restrictinput(thelimit,event,theform)}
		eval(theform).onkeyup=function(){ countlimit(thelimit,event,theform)}
	}
	else if (ns6){
		document.body.addEventListener('keypress', function(event) { restrictinput(thelimit,event,theform) }, true);
	document.body.addEventListener('keyup', function(event) { countlimit(thelimit,event,theform) }, true);
	}
}

function storeCaret(text) {
	if (text.createTextRange) {
		text.caretPos = document.selection.createRange().duplicate();
	}
}

function restrictinput(maxlength,e,placeholder){
	if (window.event&&event.srcElement.value.length>=maxlength)
		return false
	else if (e.target&&e.target==eval(placeholder)&&e.target.value.length>=maxlength){
		var pressedkey=/[a-zA-Z0-9\.\,\/]/
		if (pressedkey.test(String.fromCharCode(e.which)))
			e.stopPropagation()
		}
}

function hideLoadingPage() {
if (document.getElementById) { // DOM3 = IE5,NS6
document.getElementById('hidepage').style.visibility = 'hidden';
}
else {
if (document.layers) { // Netscape 4
document.hidepage.visibility = 'hidden';
}
else { // IE 4
document.all.hidepage.style.visibility = 'hidden';
}
}
}
