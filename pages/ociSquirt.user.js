// ==UserScript==
// @name	Squirt into moodle
// @namespace	http://feeds.feedburner.com/ouseful
// @description	Add a widgetbox panel to a moodle sidebar
// @include	
// ==/UserScript==

(function() {
 var squirtPoint='left-column';
 var iHeight=400;
 var iWidth=200;
 var wbURL='http://widgetserver.com/syndication/subscriber/InsertPanel.js?panelId=2fb67836-a410-4f4e-aa4d-b156ef81a3f6';

 d=document;
 b=d.getElementById(squirtPoint);

 function ss(src){
  s=d.createElement('script');
  s.setAttribute('type','text/javascript');
  s.setAttribute('src',src);
  return(s)
 };

 sp=ss(wbURL);
 i=document.createElement('iframe');
 i.setAttribute('src',"http://ouseful.open.ac.uk/widgetBoxDemo.html");
 i.setAttribute('id','ajh_wb');
 i.setAttribute('style','height:'+iHeight+'px;width:'+iWidth+'px;')
 b.insertBefore(i,b.firstChild);

})()