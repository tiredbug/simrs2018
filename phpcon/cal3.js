// +------------------------------------------------------------+
// |                   Popup Calendar(Window)                   |
// +------------------------------------------------------------+
// | Last Modified:                  22-Dec-2005                |
// | Web Site:                       http://www.yxscripts.com   |
// | EMail:                          m_yangxin@hotmail.com      |
// +------------------------------------------------------------+
// |       Copyright 2002  Xin Yang   All Rights Reserved.      |
// |           This version featured on Dynamic Drive           |
// |               (http://www.dynamicdrive.com)                |
// +------------------------------------------------------------+

// default settings
var fontFace1="verdana";
var fontSize1=9;

var titleWidth1=90;
var titleMode1=1;
var dayWidth1=12;
var dayDigits1=1;

var titleColor1="#cccccc";
var daysColor1="#cccccc";
var bodyColor1="#ffffff";
var dayColor1="#ffffff";
var currentdayColor1="#333333";
var footColor1="#cccccc";
var borderColor1="#333333";

var titleFontColor1 = "#333333";
var daysFontColor1 = "#333333";
var dayFontColor1 = "#333333";
var currentdayFontColor1 = "#ffffff";
var footFontColor1 = "#333333";

var calFormat1 = "dd/mm/yyyy";

var weekDay1 = 0;
// ------

// codes
var calWidth1=200, calHeight1=200, calOffsetX1=-200, calOffsetY1=16;
var calWin1=null;
var winX1=0, winY1=0;
var cal1="cal";
var cals1=new Array();
var currentCal1=null;

var yxMonths1=new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
var yxDays1=new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
var yxLinks1=new Array("[close]", "[clear]");

var nav1=navigator.userAgent.toLowerCase();;
var isOpera1=(nav1.indexOf("opera")!=-1)?true:false;
var isOpera51=(nav1.indexOf("opera 5")!=-1 || nav1.indexOf("opera/5")!=-1)?true:false;
var isOpera61=(isOpera1 && parseInt(navigator.appVersion)>=6)?true:false;
var isN61=(nav1.indexOf("gecko")!=-1);
var isN41=(document.layers)?true:false;
var isMac1=(nav1.indexOf("mac")!=-1);
var isIE1=(document.all && !isOpera1 && (!isMac1 || navigator.appVersion.indexOf("MSIE 4")==-1))?true:false;

if (isN41) {
  fontSize1+=2;
}

var span21="</span>";

function span1(tag) {
  return "<span class='"+tag+"'>";
}
function spanx1(tag, color) {
  return "."+tag+" { font-family:"+fontFace1+"; font-size:"+fontSize1+"px; color:"+color+"; }\n";
}

function a11(tag) {
  return "<a class='"+tag+"' href=";
}

function ax1(tag, color) {
  return "."+tag+" { text-decoration:none; color:"+color+"; }\n";
}

function calOBJ1(name, title, field, form) {
  this.name = name;
  this.title = title;
  this.field = field;
  this.formName = form;
  this.form = null
}

function setFont1(font, size) {
  if (font != "") {
    fontFace1=font;
  }
  if (size > 0) {
    fontSize1=size;

    if (isN41) {
      fontSize1+=2;
    }
  }
}

function setWidth1(tWidth, tMode, dWidth, dDigits) {
  if (tWidth > 0) {
    titleWidth1=tWidth;
  }
  if (tMode == 1 || tMode == 2) {
    titleMode1=tMode;
  }
  if (dWidth > 0) {
    dayWidth1=dWidth;
  }
  if (dDigits > 0) {
    dayDigits1=dDigits;
  }
}

function setColor1(tColor, dsColor, bColor, dColor, cdColor, fColor, bdColor) {
  if (tColor != "") {
    titleColor1=tColor;
  }
  if (dsColor != "") {
    daysColor1=dsColor;
  }
  if (bColor != "") {
    bodyColor1=bColor;
  }
  if (dColor != "") {
    dayColor1=dColor;
  }
  if (cdColor != "") {
    currentdayColor1=cdColor;
  }
  if (fColor != "") {
    footColor1=fColor;
  }
  if (bdColor != "") {
    borderColor1=bdColor;
  }
}

function setFontColor1(tColorFont, dsColorFont, dColorFont, cdColorFont, fColorFont) {
  if (tColorFont != "") {
    titleFontColor1=tColorFont;
  }
  if (dsColorFont != "") {
    daysFontColor1=dsColorFont;
  }
  if (dColorFont != "") {
    dayFontColor1=dColorFont;
  }
  if (cdColorFont != "") {
    currentdayFontColor1=cdColorFont;
  }
  if (fColorFont != "") {
    footFontColor1=fColorFont;
  }
}

function setFormat1(format) {
  calFormat1 = format;
}

function setSize1(width, height, ox, oy) {
  if (width > 0) {
    calWidth1=width;
  }
  if (height > 0) {
    calHeight1=height;
  }

  calOffsetX1=ox;
  calOffsetY1=oy;
}

function setweekDay1(wDay) {
  if (wDay == 0 || wDay == 1) {
    weekDay1 = wDay;
  }
}

function setMonthNames1(janName, febName, marName, aprName, mayName, junName, julName, augName, sepName, octName, novName, decName) {
  if (janName != "") {
    yxMonths1[0] = janName;
  }
  if (febName != "") {
    yxMonths1[1] = febName;
  }
  if (marName != "") {
    yxMonths1[2] = marName;
  }
  if (aprName != "") {
    yxMonths1[3] = aprName;
  }
  if (mayName != "") {
    yxMonths1[4] = mayName;
  }
  if (junName != "") {
    yxMonths1[5] = junName;
  }
  if (julName != "") {
    yxMonths1[6] = julName;
  }
  if (augName != "") {
    yxMonths1[7] = augName;
  }
  if (sepName != "") {
    yxMonths1[8] = sepName;
  }
  if (octName != "") {
    yxMonths1[9] = octName;
  }
  if (novName != "") {
    yxMonths1[10] = novName;
  }
  if (decName != "") {
    yxMonths1[11] = decName;
  }
}

function setDayNames1(sunName, monName, tueName, wedName, thuName, friName, satName) {
  if (sunName != "") {
    yxDays1[0] = sunName;
    yxDays1[7] = sunName;
  }
  if (monName != "") {
    yxDays1[1] = monName;
  }
  if (tueName != "") {
    yxDays1[2] = tueName;
  }
  if (wedName != "") {
    yxDays1[3] = wedName;
  }
  if (thuName != "") {
    yxDays1[4] = thuName;
  }
  if (friName != "") {
    yxDays1[5] = friName;
  }
  if (satName != "") {
    yxDays1[6] = satName;
  }
}

function setLinkNames1(closeLink, clearLink) {
  if (closeLink != "") {
    yxLinks1[0] = closeLink;
  }
  if (clearLink != "") {
    yxLinks1[1] = clearLink;
  }
}

function addCalendar1(name, title, field, form) {
  cals1[cals1.length] = new calOBJ1(name, title, field, form);
}

function findCalendar1(name) {
  for (var i = 0; i < cals1.length; i++) {
    if (cals1[i].name == name) {
      if (cals1[i].form == null) {
        if (cals1[i].formName == "") {
          if (document.forms[0]) {
            cals1[i].form = document.forms[0];
          }
        }
        else if (document.forms[cals1[i].formName]) {
          cals1[i].form = document.forms[cals1[i].formName];
        }
      }

      return cals1[i];
    }
  }

  return null;
}

function getDayName1(y,m,d) {
  var wd=new Date(y,m,d);
  return yxDays1[wd.getDay()].substring(0,3);
}

function getMonthFromName1(m3) {
  for (var i = 0; i < yxMonths1.length; i++) {
    if (yxMonths1[i].toLowerCase().substring(0,3) == m3.toLowerCase()) {
      return i;
    }
  }

  return 0;
}

function getFormat1() {
  var calF = calFormat1;

  calF = calF.replace(/\\/g, '\\\\');
  calF = calF.replace(/\//g, '\\\/');
  calF = calF.replace(/\[/g, '\\\[');
  calF = calF.replace(/\]/g, '\\\]');
  calF = calF.replace(/\(/g, '\\\(');
  calF = calF.replace(/\)/g, '\\\)');
  calF = calF.replace(/\{/g, '\\\{');
  calF = calF.replace(/\}/g, '\\\}');
  calF = calF.replace(/\</g, '\\\<');
  calF = calF.replace(/\>/g, '\\\>');
  calF = calF.replace(/\|/g, '\\\|');
  calF = calF.replace(/\*/g, '\\\*');
  calF = calF.replace(/\?/g, '\\\?');
  calF = calF.replace(/\+/g, '\\\+');
  calF = calF.replace(/\^/g, '\\\^');
  calF = calF.replace(/\$/g, '\\\$');

  calF = calF.replace(/dd/i, '\\d\\d');
  calF = calF.replace(/mm/i, '\\d\\d');
  calF = calF.replace(/yyyy/i, '\\d\\d\\d\\d');
  calF = calF.replace(/day/i, '\\w\\w\\w');
  calF = calF.replace(/mon/i, '\\w\\w\\w');

  return new RegExp(calF);
}

function getDateNumbers1(date) {
  var y, m, d;

  var yIdx = calFormat1.search(/yyyy/i);
  var mIdx = calFormat1.search(/mm/i);
  var m3Idx = calFormat1.search(/mon/i);
  var dIdx = calFormat1.search(/dd/i);

  y=date.substring(yIdx,yIdx+4)-0;
  if (mIdx != -1) {
    m=date.substring(mIdx,mIdx+2)-1;
  }
  else {
    var m = getMonthFromName1(date.substring(m3Idx,m3Idx+3));
  }
  d=date.substring(dIdx,dIdx+2)-0;

  return new Array(y,m,d);
}

function hideCal1() {
  calWin1.close();
  calWin1 = null;
  window.status = "";
}

function getLeftIE1(x,m) {
  var dx=0;
  if (x.tagName=="TD"){
    dx=x.offsetLeft;
  }
  else if (x.tagName=="TABLE") {
    dx=x.offsetLeft;
    if (m) { dx+=(x.cellPadding!=""?parseInt(x.cellPadding):2); m=false; }
  }
  return dx+(x.parentElement.tagName=="BODY"?0:getLeftIE1(x.parentElement,m));
}
function getTopIE1(x,m) {
  var dy=0;
  if (x.tagName=="TR"){
    dy=x.offsetTop;
  }
  else if (x.tagName=="TABLE") {
    dy=x.offsetTop;
    if (m) { dy+=(x.cellPadding!=""?parseInt(x.cellPadding):2); m=false; }
  }
  return dy+(x.parentElement.tagName=="BODY"?0:getTopIE1(x.parentElement,m));
}

function getLeftN41(l) { return l.pageX; }
function getTopN41(l) { return l.pageY; }

function getLeftN61(l) { return l.offsetLeft; }
function getTopN61(l) { return l.offsetTop; }

function lastDay1(d) {
  var yy=d.getFullYear(), mm=d.getMonth();
  for (var i=31; i>=28; i--) {
    var nd=new Date(yy,mm,i);
    if (mm == nd.getMonth()) {
      return i;
    }
  }
}

function firstDay1(d) {
  var yy=d.getFullYear(), mm=d.getMonth();
  var fd=new Date(yy,mm,1);
  return fd.getDay();
}

function dayDisplay1(i) {
  if (dayDigits1 == 0) {
    return yxDays1[i];
  }
  else {
    return yxDays1[i].substring(0,dayDigits1);
  }
}

function calTitle1(d) {
  var yy=d.getFullYear(), mm=yxMonths1[d.getMonth()];
  var s;

  if (titleMode1 == 2) {
    s="<tr align='center' bgcolor='"+titleColor1+"'><td colspan='7'>\n<table cellpadding='0' cellspacing='0' border='0'><tr align='center' valign='middle'><td align='right'>"+span1("title")+"<b>"+a11("titlea")+"'javascript:if(window.opener && !window.opener.closed && window.opener.moveYear1) window.opener.moveYear1(-10)'>&nbsp;&#171;</a>&nbsp;"+a11("titlea")+"'javascript:if(window.opener && !window.opener.closed && window.opener.moveYear1) window.opener.moveYear1(-1)'>&#139;&nbsp;</a></b>"+span21+"</td><td width='"+titleWidth1+"'><b>"+span1("title")+yy+span21+"</b></td><td align='left'>"+span1("title")+"<b>"+a11("titlea")+"'javascript:if (window.opener && !window.opener.closed && window.opener.moveYear1) window.opener.moveYear1(1)'>&nbsp;&#155;</a>&nbsp;"+a11("titlea")+"'javascript:if (window.opener && !window.opener.closed && window.opener.moveYear1) window.opener.moveYear1(10)'>&#187;&nbsp;</a></b>"+span21+"</td></tr><tr align='center' valign='middle'><td align='right'>"+span1("title")+"<b>"+a11("titlea")+"'javascript:if (window.opener && !window.opener.closed && window.opener.prepMonth1) window.opener.prepMonth1("+d.getMonth()+")'>&nbsp;&#139;&nbsp;</a></b>"+span21+"</td><td width='"+titleWidth1+"'><b>"+span1("title")+mm+span21+"</b></td><td align='left'>"+span1("title")+"<b>"+a11("titlea")+"'javascript:if (window.opener && !window.opener.closed && window.opener.nextMonth1) window.opener.nextMonth1("+d.getMonth()+")'>&nbsp;&#155;&nbsp;</a></b>"+span21+"</td></tr></table>\n</td></tr><tr align='center' bgcolor='"+daysColor1+"'>";
  }
  else {
    s="<tr align='center' bgcolor='"+titleColor1+"'><td colspan='7'>\n<table cellpadding='0' cellspacing='0' border='0'><tr align='center' valign='middle'><td>"+span1("title")+"<b>"+a11("titlea")+"'javascript:if(window.opener && !window.opener.closed && window.opener.moveYear1) window.opener.moveYear1(-1)'>&nbsp;&#171;</a>&nbsp;"+a11("titlea")+"'javascript:if (window.opener && !window.opener.closed && window.opener.prepMonth1) window.opener.prepMonth1("+d.getMonth()+")'>&#139;&nbsp;</a></b>"+span21+"</td><td width='"+titleWidth1+"'><nobr><b>"+span1("title")+mm+" "+yy+span21+"</b></nobr></td><td>"+span1("title")+"<b>"+a11("titlea")+"'javascript:if (window.opener && !window.opener.closed && window.opener.nextMonth1) window.opener.nextMonth1("+d.getMonth()+")'>&nbsp;&#155;</a>&nbsp;"+a11("titlea")+"'javascript:if(window.opener && !window.opener.closed && window.opener.moveYear1) window.opener.moveYear1(1)'>&#187;&nbsp;</a></b>"+span21+"</td></tr></table>\n</td></tr><tr align='center' bgcolor='"+daysColor1+"'>";
  }

  for (var i=weekDay1; i<weekDay1+7; i++) {
    s+="<td width='"+dayWidth1+"'>"+span1("days")+dayDisplay1(i)+span21+"</td>";
  }

  s+="</tr>";

  return s;
}

function calHeader1() {
  return "<head>\n<title>"+currentCal1.title+"</title>\n<style type='text/css'>\n"+spanx1("title",titleFontColor1)+spanx1("days",daysFontColor1)+spanx1("foot",footColor1)+spanx1("day",dayFontColor1)+spanx1("currentDay",currentdayFontColor1)+ax1("titlea",titleFontColor1)+ax1("daya",dayFontColor1)+ax1("currenta",currentdayFontColor1)+ax1("foota",footFontColor1)+"</style>\n</head>\n<body>\n<table align='center' border='0' bgcolor='"+borderColor1+"' cellspacing='0' cellpadding='1'><tr><td>\n<table cellspacing='1' cellpadding='3' border='0'>";
}

function calFooter1() {
  return "<tr bgcolor='"+footColor1+"'><td colspan='7' align='center'>"+span1("foot")+"<b>"+a11("foota")+"'javascript:if (window.opener && !window.opener.closed && window.opener.hideCal1) window.opener.hideCal1()'>"+yxLinks1[0]+"</a>&nbsp;&nbsp;"+a11("foota")+"'javascript:if (window.opener && !window.opener.closed && window.opener.clearDate1) window.opener.clearDate1()'>"+yxLinks1[1]+"</a></b>"+span21+"</td></tr></table>\n</td></tr></table>\n</body>";
}

function calBody1(d,day) {
  var s="", dayCount=1, fd=firstDay1(d), ld=lastDay1(d);

  if (weekDay1 > 0 && fd == 0) {
    fd = 7;
  }

  for (var i=0; i<6; i++) {
    s+="<tr align='center' bgcolor='"+bodyColor1+"'>";
    for (var j=weekDay1; j<weekDay1+7; j++) {
      if (i*7+j<fd || dayCount>ld) {
        s+="<td>"+span1("day")+"&nbsp;"+span21+"</td>";
      }
      else {
        var bgColor=dayColor1;
        var fgTag="day";
        var fgTagA="daya";
        if (dayCount==day) { 
          bgColor=currentdayColor1; 
          fgTag="currentDay";
          fgTagA="currenta";
        }
        
        s+="<td bgcolor='"+bgColor+"'>"+span1(fgTag)+a11(fgTagA)+"'javascript: if (window.opener && !window.opener.closed && window.opener.pickDate1) window.opener.pickDate1("+dayCount+")'>"+(dayCount++)+"</a>"+span21+"</td>";
      }
    }
    s+="</tr>";
  }

  return s;
}

function moveYear1(dy) {
  cY+=dy;
  var nd=new Date(cY,cM,1);
  changeCal1(nd);
}

function prepMonth1(m) {
  cM=m-1;
  if (cM<0) { cM=11; cY--; }
  var nd=new Date(cY,cM,1);
  changeCal1(nd);
}

function nextMonth1(m) {
  cM=m+1;
  if (cM>11) { cM=0; cY++;}
  var nd=new Date(cY,cM,1);
  changeCal1(nd);
}

function changeCal1(d) {
  var dd = 0;

  if (currentCal1 != null) {
    var calRE = getFormat1();

    if (currentCal1.form[currentCal1.field].value!="" && calRE.test(currentCal1.form[currentCal1.field].value)) {
      var cd = getDateNumbers1(currentCal1.form[currentCal1.field].value);
      if (cd[0] == d.getFullYear() && cd[1] == d.getMonth()) {
        dd=cd[2];
      }
    }
    else {
      var cd = new Date();
      if (cd.getFullYear() == d.getFullYear() && cd.getMonth() == d.getMonth()) {
        dd=cd.getDate();
      }
    }
  }

  var calendar=calHeader1()+calTitle1(d)+calBody1(d,dd)+calFooter1();

  calWin1.document.open();
  calWin1.document.write(calendar);
  calWin1.document.close();
}

function markClick1(e) {
  if (isIE1 || isOpera61) {
    winX1=event.screenX;
    winY1=event.screenY;
  }
  else if (isN41 || isN61) {
    winX1=e.screenX;
    winY1=e.screenY;

    document.routeEvent(e);
  }

  if (isN41 || isN61) { 
    document.routeEvent(e); 
  } 
  else { 
    event.cancelBubble=false; 
  } 

  return true;
}

function showCal1(name) {
  var lastCal=currentCal1;
  var d=new Date(), hasCal=false;

  currentCal1 = findCalendar1(name);

  if (currentCal1 != null && currentCal1.form != null && currentCal1.form[currentCal1.field]) {
    var calRE = getFormat1();

    if (currentCal1.form[currentCal1.field].value!="" && calRE.test(currentCal1.form[currentCal1.field].value)) {
      var cd = getDateNumbers1(currentCal1.form[currentCal1.field].value);
      d=new Date(cd[0],cd[1],cd[2]);

      cY=cd[0];
      cM=cd[1];
      dd=cd[2];
    }
    else {
      cY=d.getFullYear();
      cM=d.getMonth();
      dd=d.getDate();
    }

    var calendar=calHeader1()+calTitle1(d)+calBody1(d,dd)+calFooter1();

    if (calWin1 != null && typeof(calWin1.closed)!="undefined" && !calWin1.closed) {
      hasCal=true;
      calWin1.moveTo(winX1+calOffsetX1,winY1+calOffsetY1);
    }

    if (!hasCal) {
      if (isIE1 || isOpera61) {
        calWin1=window.open("","cal","toolbar=0,width="+calWidth1+",height="+calHeight1+",left="+(winX1+calOffsetX1)+",top="+(winY1+calOffsetY1));
      }
      else {
        calWin1=window.open("","cal","toolbar=0,width="+calWidth1+",height="+calHeight1+",screenx="+(winX1+calOffsetX1)+",screeny="+(winY1+calOffsetY1));
      }
    }

    calWin1.document.open();
    calWin1.document.write(calendar);
    calWin1.document.close();

    calWin1.focus();
  }
  else {
    if (currentCal1 == null) {
      window.status = "Calendar ["+name+"] not found.";
    }
    else if (!currentCal1.form) {
      window.status = "Form ["+currentCal1.formName+"] not found.";
    }
    else if (!currentCal1.form[currentCal1.field]) {
      window.status = "Form Field ["+currentCal1.formName+"."+currentCal1.field+"] not found.";
    }

    if (lastCal != null) {
      currentCal1 = lastCal;
    }
  }
}

function get2Digits1(n) {
  return ((n<10)?"0":"")+n;
}

function clearDate1() {
  currentCal1.form[currentCal1.field].value="";
  hideCal1();
}

function pickDate1(d) {
  hideCal1();
  window.focus();

  var date=calFormat1;
  date = date.replace(/yyyy/i, cY);
  date = date.replace(/mm/i, get2Digits1(cM+1));
  date = date.replace(/MON/, yxMonths1[cM].substring(0,3).toUpperCase());
  date = date.replace(/Mon/i, yxMonths1[cM].substring(0,3));
  date = date.replace(/dd/i, get2Digits1(d));
  date = date.replace(/DAY/, getDayName1(cY,cM,d).toUpperCase());
  date = date.replace(/day/i, getDayName1(cY,cM,d));

  currentCal1.form[currentCal1.field].value=date;
  // IE5/Mac needs focus to show the value, weird.
  currentCal1.form[currentCal1.field].focus();
}
// ------

// user functions
function checkDate1(name) {
  var thisCal = findCalendar1(name);

  if (thisCal != null && thisCal.form != null && thisCal.form[thisCal.field]) {
    var calRE = getFormat1();

    if (calRE.test(thisCal.form[thisCal.field].value)) {
      return 0;
    }
    else {
      return 1;
    }
  }
  else {
    return 2;
  }
}

function getCurrentDate1() {
  var date=calFormat1, d = new Date();
  date = date.replace(/dd/i, get2Digits1(d.getDate()));
  date = date.replace(/mm/i, get2Digits1(d.getMonth()+1));
  date = date.replace(/yyyy/i, d.getFullYear());

  return date;
}

function compareDates1(date1, date2) {
  var calRE = getFormat1();
  var d1, d2;

  if (calRE.test(date1)) {
    d1 = getNumbers1(date1);
  }
  else {
    d1 = getNumbers1(getCurrentDate1());
  }

  if (calRE.test(date2)) {
    d2 = getNumbers1(date2);
  }
  else {
    d2 = getNumbers1(getCurrentDate1());
  }

  var dStr1 = d1[0] + "" + d1[1] + "" + d1[2];
  var dStr2 = d2[0] + "" + d2[1] + "" + d2[2];

  if (dStr1 == dStr2) {
    return 0;
  }
  else if (dStr1 > dStr2) {
    return 1;
  }
  else {
    return -1;
  }
}

function getNumbers1(date) {
  var calRE = getFormat1();
  var y, m, d;

  if (calRE.test(date)) {
    var yIdx = calFormat1.search(/yyyy/i);
    var mIdx = calFormat1.search(/mm/i);
    var m3Idx = calFormat1.search(/mon/i);
    var dIdx = calFormat1.search(/dd/i);

    y=date.substring(yIdx,yIdx+4);
    if (mIdx != -1) {
      m=date.substring(mIdx,mIdx+2);
    }
    else {
      var mm=getMonthFromName1(date.substring(m3Idx,m3Idx+3))+1;
      m=(mm<10)?("0"+mm):(""+mm);
    }
    d=date.substring(dIdx,dIdx+2);

    return new Array(y,m,d);
  }
  else {
    return new Array("", "", "");
  }
}
// ------

if (isN41 || isN61) {
  document.captureEvents(Event.CLICK);
}
document.onclick=markClick1;

function calage1(ctgl, objID)
{
	
var calday = ctgl.substr(0,2);
var calmon = ctgl.substr(3,2);
var calyear = ctgl.substr(6,4);

if(curday == "" || curmon=="" || curyear=="" || calday=="" || calmon=="" || calyear=="")
	{
		//alert("please fill all the values and click go -");
	}	
	else
	{
		var curd = new Date(curyear,curmon-1,curday);
		var cald = new Date(calyear,calmon-1,calday);
		
		var diff =  Date.UTC(curyear,curmon,curday,0,0,0) - Date.UTC(calyear,calmon,calday,0,0,0);

		var dife = datediff(curd,cald);
		vobj = document.getElementById(objID);
		vobj.value = dife[0]+" tahun "+dife[1]+" bulan "+dife[2]+" hari";
		}
}
