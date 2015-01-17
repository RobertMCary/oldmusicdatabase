window.onload = styleCheck;
	
function styleCheck(){
	if(cookieValue("cStyle") != ""){
		document.getElementsByName('optStyle')[cookieValue("cStyle")].checked=true;
	}
	changeStyle(document.getElementsByName('optStyle')[cookieValue("cStyle")].value)
}

function changeStyle(title){
	var lnks = document.getElementsByTagName('link');
	for (var i= lnks.length - 1; i>=0; i--){
		if(lnks[i].getAttribute('rel').indexOf('style') > -1 && lnks[i].getAttribute('title')){
			lnks[i].disabled = true;
			if(lnks[i].getAttribute('title') == title){
				lnks[i].disabled = false;
			}
		}
	}
}
	
function setStyle(){
	var optIndex = 0;
	for (var i=0; i<document.getElementsByName('optStyle').length; i++){
		if(document.getElementsByName('optStyle')[i].checked){
			optIndex=i;
		}
	}
	saveCookie("cStyle", optIndex, 1);
	alert("Your style choice has been saved.");
	document.getElementById('optStyleCheck').checked=false;
}