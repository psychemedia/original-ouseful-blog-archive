<html>
<head><title>Demo Book Details Form</title>
<style type="text/css">
div { margin-left:50px; margin-top:5px;}
</style>
</head>
<body>

<h1>Get Book Details demo</h1>

<p>This page provides a simple testbed for a Greasemonkey script that looks
up the book detail information from an Amazon web service for a book given it's ISBN.
You can find the associateds Greasemonkey script here: <a href="http://blogs.open.ac.uk/Maths/ajh59/demoBookDetailsForm.user.js">sample Greasemonkey script</a>.</p>
<p>To use the script, you will need to use the <a href="http://www.mozilla.com/firefox/">Firefox web browser</a> 
with the <a href="http://greasemonkey.mozdev.org/">Greasemonkey extension</a> installed.</p>
<p>The actual form only contains the text input boxes and their labels. The Greasemonkey script
adds a 'Get book Info' link that calls a function that grabs an ISBN number typed into
the ISBN text entry box and attempts to look up the details of that book from the 
Amazon webservice. (Alternative web services could also have been used.) 
If it finds the book details, it adds them to the form.</p>

<form >

<div>

      <div>
        Book Author/Editor: <input type="text" id="author" name="author" value="" size="40" />
      </div>
      <div>
        Title: <input type="text" id="title" name="itemtitle" value="" size="40" />
      </div>

      <div>
        Publisher: <input type="text" id="publisher" name="publisher" value="" size="40" />
      </div>
      <div>
        Edition: <input type="text" id="edition" name="edition" value="" size="40" />
      </div>
      <div>
        ISBN: <input type="text" id="isbn" name="isbn" value="" size="40" /> (e.g. 0849304563)
      </div>
      <div>
        Date of Publication: <input type="text" id="publicationDate" name="dateofpub" value="" size="25" />
      </div>
      <div>
        Price: (&pound;) <input type="text" id="price" name="price" value="" size="25" />
      </div>
</div>
</form>

</body>
</html>