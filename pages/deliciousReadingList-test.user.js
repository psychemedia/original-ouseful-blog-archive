// ==UserScript==
// @name          del.icio.us Reading Lists OPML Link - test script
// @namespace     http://ouseful.open.ac.uk
// @description	  Add a link to a service that will generate an OPML file of items on a delicious page
// @include       http://del.icio.us/*

// ==/UserScript==
(
function () {
	var el2=document.getElementsByTagName('link');

	for(i=0;i<el2.length;i++){
		if(el2[i].getAttribute('rel')=='alternate'){
			feed=encodeURIComponent(el2[i].getAttribute('href'));
			i=el2[i].length;	
		}
	}

	var l='http://www.w3.org/2000/06/webdata/xslt?xslfile='+encodeURIComponent('http://pragmatron.org/xslt/delicious-to-opml.xsl')+'&xmlfile=';
	var XMLURL=l+feed+'&transform=Submit';

 	var el=document.getElementById('footer-inner');
	var p = document.createElement("p");
	var a = document.createElement("a");
	a.setAttribute("href", XMLURL);
	img=document.createElement("img");
	img.setAttribute("src","http://images.scripting.com/archiveScriptingCom/2005/03/14/opml.gif");
	img.setAttribute("border", 0);
	img.setAttribute("alt","XML-RSS feed");
	a.appendChild(img);
	p.appendChild(a);
	el.appendChild(p);

}

)();