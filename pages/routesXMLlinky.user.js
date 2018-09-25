// ==UserScript==
// @name          ROUTES XML Link
// @namespace     http://ouseful.open.ac.uk
// @description	 Add an XML feed to an OU Library ROUTES search results page.
// @include       http://routes.open.ac.uk/ixbin/*

// ==/UserScript==

(

function() {
  const urlRegex= /Matches for query[\s]*\((.*)\)/ig;

    // tags we will scan looking for un-hyperlinked urls
    var allowedParents = ["td", "font"];
    
    var xpath = "//text()[(parent::" + allowedParents.join(" or parent::") + ")]";

    var candidates = document.evaluate(xpath, document, null, XPathResult.UNORDERED_NODE_SNAPSHOT_TYPE, null);

    for (var cand = null, i = 0; (cand = candidates.snapshotItem(i)); i++) {
        if (urlRegex.test(cand.nodeValue)) {
            var source = cand.nodeValue;

            urlRegex.lastIndex = 0;
            for (var match = null, lastLastIndex = 0; (match = urlRegex.exec(source)); ) {
                //span.appendChild(document.createTextNode(source.substring(lastLastIndex, match.index)));
                
                var a = document.createElement("a");
		    XMLURL='http://routes.open.ac.uk/routes_xml.php?course='+match[1];
                a.setAttribute("href", XMLURL);
			br=document.createElement("br");
			a.appendChild(br);
		    img=document.createElement("img");
			img.setAttribute("src","http://cyber.law.harvard.edu/blogs/system/xml.gif"); img.setAttribute("border", 0); img.setAttribute("alt","XML-RSS feed");
                a.appendChild(img);
                cand.parentNode.appendChild(a);

                lastLastIndex = urlRegex.lastIndex;
            }

            span.appendChild(document.createTextNode(source.substring(lastLastIndex)));
            span.normalize();
        }
    }

 
}
)();