// ==UserScript==
// @name           searchfeedr Traveller script
// @namespace      http://ouseful.open.ac.uk/blog
// @description    Lets you search tag based technorati links
// @include        http://del.icio.us/*
// @include        http://technorati.com/tag/*
// @include        http://wink.com/*
// @include        http://h2obeta.law.harvard.edu/*
// @include        http://www.blinklist.com/*
// @include        http://www.simpy.com/*
// @exclude        http://del.icio.us/tag/*
// ==/UserScript==

(function() {

// searchfeedr (Trveller) - A OUseful Widget
// Tony Hirst, http://ouseful.open.ac.uk/blog

var DeliStuff;

var deliSearch = {

formatSearchTerms: function(){
 var searchTerms= document.getElementById('usrSearchTerms').value;
 searchTerms= searchTerms.replace ( / /g, '+' );
 return searchTerms;
},

deliSearchURL: function(searchtype) {
 var sfRoot='http://blogs.open.ac.uk/Maths/ajh59/searchfeedrlabs.php?';
 var query=deliSearch.formatSearchTerms();
 var myURL=location.href;
 if (location.host=='del.icio.us') {
  myURL=myURL.replace('http://del.icio.us/','http://del.icio.us/rss/');
  myURL=sfRoot+'f='+myURL+'&q='+query+'&s='+searchtype+'&t=f';
 } else if (location.host=='technorati.com') {
  myURL=myURL.replace('http://technorati.com/','http://feeds.technorati.com/feed/posts/');
  myURL=sfRoot+'f='+myURL+'&q='+query+'&s='+searchtype+'&t=f';
 } else if (location.host=='wink.com'){
  var winkbits=location.pathname.split('--');
  if (winkbits[3]=='collections') {
  	myURL='http://wink.com/services/feed/collection?fmt=rss2&amp;i='+winkbits[2]+'&amp;u='+winkbits[1]+'&amp;n='+winkbits[0].replace('/','');
  	myURL=sfRoot+'f='+escape(myURL)+'&q='+query+'&s='+searchtype+'&t=f';
  	}
 } else if (location.host=='h2obeta.law.harvard.edu') {
  myURL=myURL.replace('http://h2obeta.law.harvard.edu/','http://h2obeta.law.harvard.edu/rss/');
  myURL=sfRoot+'f='+myURL+'&q='+query+'&s='+searchtype+'&t=f';
 } else if (location.host=='www.blinklist.com'){
  myURL+='rss.xml';
  myURL=sfRoot+'f='+myURL+'&q='+query+'&s='+searchtype+'&t=f';
 } else if (location.host=='www.simpy.com') {
  myURL=myURL.replace('http://www.simpy.com/user/','http://www.simpy.com/rss/user/');
  myURL=myURL.replace('/tag/','/links/');
  myURL=sfRoot+'f='+myURL+'&q='+query+'&s='+searchtype+'&t=f';
 }
 if (myURL!='') window.open(myURL);
},

deliSearchURLd:function(){
 deliSearch.deliSearchURL('domains');
},

deliSearchURLp:function(){
 deliSearch.deliSearchURL('pages');
},


addListener: function(element, type, expression, bubbling){
 bubbling = bubbling || false;
 if(window.addEventListener) { // Standard
  element.addEventListener(type, expression, bubbling);
  return true;
 } else if(window.attachEvent) { // IE
  element.attachEvent('on' + type, expression);
  return true;
 } else return false;
},

test: function(){alert('asjahdjahsfjhgdsfhgds');}
}

//deliSearch.test();

if( typeof( deliSearchOpenWin ) == 'undefined' ) var deliSearchOpenWin='_top';
if ((deliSearchOpenWin != '_top') && (deliSearchOpenWin != '_new')) deliSearchOpenWin='_top';

if( typeof( deliSearchType ) == 'undefined' ) var deliSearchType='pages';
if ((deliSearchType  != 'pages') && (deliSearchType  != 'domain')) deliSearchType ='pages';

ds_d=document;
ds_b=ds_d.getElementsByTagName('body')[0];

ds_i=ds_d.createElement('form');
ds_i.setAttribute('name', 'dataForm');

//ds_i.setAttribute('onsubmit','deliSearch.doDeliSearch();return false;');
//ds_i.onsubmit = function(){deliSearch.doDeliSearch();}

//ds_i.addEventListener('submit', deliSearch.doDeliSearch, true );

ds_f=ds_d.createElement('label');
ds_ft=ds_d.createTextNode('Search these links:');
ds_f.appendChild(ds_ft);
ds_i.appendChild(ds_f);

ds_f=ds_d.createElement('input');
ds_f.setAttribute('id', 'usrSearchTerms');
ds_f.setAttribute('type', 'text');
ds_f.setAttribute('size', 12);
ds_i.appendChild(ds_f);

ds_f=ds_d.createElement('input');
ds_f.setAttribute('value', 'searchfeedr (Pages)');
ds_f.setAttribute('type', 'button');
ds_f.setAttribute('class', 'but');
deliSearch.addListener(ds_f,'click', deliSearch.deliSearchURLp, true );
ds_i.appendChild(ds_f);

ds_f=ds_d.createElement('input');
ds_f.setAttribute('value', 'searchfeedr (Domains)');
ds_f.setAttribute('type', 'button');
ds_f.setAttribute('class', 'but');
deliSearch.addListener(ds_f,'click', deliSearch.deliSearchURLd, true );
ds_i.appendChild(ds_f);


ds_b.insertBefore(ds_i,ds_b.firstChild);


})();