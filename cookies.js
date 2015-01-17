//***************************************************************************
// this function allows you to pass in the name, value and when you want the 
// cookie to expire.
// 
// if you want to delete the cookie set the days to expire to -1
//
function saveCookie (cookieName, cookieValue, daysToExpire) {
	expireDate = new Date
	expireDate.setDate(expireDate.getDate()+daysToExpire)
	
	document.cookie = cookieName + "=" + cookieValue + ";expires=" + expireDate.toGMTString();		
}


//***************************************************************************
// returns the cookies value so that you can use the value. returns null if 
// the cookie expired or does not exist. be careful using null in math formulas
//
function cookieValue(cookieName) {
	if (document.cookie != "") {
		thisCookie = document.cookie.split("; ");
		for (i=0; i<thisCookie.length; i++) {
			if(cookieName == thisCookie[i].split("=")[0]){
				return thisCookie[i].split("=")[1];
			}
		}
	}
	return "";
}