// ==UserScript==
// @name           delicious rewrite
// @namespace      http://feeds.feedburner.com/ouseful
// @description    Redirects delicous links page to the first usr:rewrite tagged link it finds
// @include        http://del.icio.us/*
// ==/UserScript==

(function(){

function deliReWrite(){
	d=document.body;
	el=d.getElementsByTagName('div');
	for(i=0;i<el.length;i++){
		if(el[i].getAttribute('class')){
			if(el[i].getAttribute('class').indexOf('meta')!=-1){
				tl=el[i].getElementsByTagName('a');
					for(j=0;j<tl.length;j++){
						if(tl[j].firstChild.nodeValue=='usr:redirect'){
							t1=el[i].parentNode.childNodes[1].childNodes[0];
							window.location=t1.getAttribute('href')
						}
					}
				}
			}
		}
	}

deliReWrite();
})();
