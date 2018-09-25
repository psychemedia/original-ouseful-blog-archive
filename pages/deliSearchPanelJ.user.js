// ==UserScript==
// @name           deliSearch in del.icio.us script
// @namespace      http://ouseful.open.ac.uk/blog
// @description    Lets you search delicious links
// @include        http://del.icio.us/*
// ==/UserScript==

(function() {

// deliSearch - A OUseful Widget
// Tony Hirst, http://ouseful.open.ac.uk/blog

var DeliStuff;

var deliSearch = {

formatSearchTerms: function(){
 var searchTerms= document.getElementById('usrSearchTerms').value;
 searchTerms= searchTerms.replace ( / /g, '+' );
 return searchTerms;
},

deliSearchURL: function(searchtype) {
 var URL= window.location.href;
 var query=deliSearch.formatSearchTerms();
 URL=URL.split('/');
 var usrTag='u='+URL[3];
 if (URL.length>4) usrTag=usrTag+'&t='+URL[4];
 var myURL='http://blogs.open.ac.uk/Maths/ajh59/deliSearch.php?'+usrTag+'&q='+query+'&s='+searchtype;
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
ds_f.setAttribute('value', 'deliSearch (Pages)');
ds_f.setAttribute('type', 'button');
ds_f.setAttribute('class', 'but');
deliSearch.addListener(ds_f,'click', deliSearch.deliSearchURLp, true );
ds_i.appendChild(ds_f);

ds_f=ds_d.createElement('input');
ds_f.setAttribute('value', 'deliSearch (Domains)');
ds_f.setAttribute('type', 'button');
ds_f.setAttribute('class', 'but');
deliSearch.addListener(ds_f,'click', deliSearch.deliSearchURLd, true );
ds_i.appendChild(ds_f);


ds_b.insertBefore(ds_i,ds_b.firstChild);


})();