<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:aws="http://webservices.amazon.com/AWSECommerceService/2005-10-05" exclude-result-prefixes="aws">

	<xsl:output method="text"/>

<!-- +- -->
<!-- | Base Template Match, General JSON Format -->
<!-- +- -->
	<xsl:template match="/">
		<xsl:value-of select="aws:ListLookupResponse/aws:OperationRequest/aws:Arguments/aws:Argument[@Name = 'CallBack']/@Value" /><xsl:text>( {"ItemSet":{ "Item":[</xsl:text><xsl:apply-templates /><xsl:text> {"endBuffer":"true"} ] } } ) </xsl:text>
	</xsl:template>

	<xsl:template match="aws:RequestId"/>
	<xsl:template match="aws:RequestProcessingTime"/>	

	<xsl:template match="aws:Lists">
		<xsl:apply-templates select="aws:List" />
	</xsl:template>

	<xsl:template match="aws:List">
		<xsl:apply-templates select="aws:ListItem" />
	</xsl:template>	

	<xsl:template match="aws:ListItem">
		<xsl:apply-templates select="aws:Item" />
	</xsl:template>
	
<!-- +- -->
<!-- | Fetch ASIN, URL, Title, Price -->
<!-- +- -->	
	<xsl:template match="aws:Item">
		<xsl:text> {</xsl:text>
		<xsl:text>"asin":"</xsl:text><xsl:value-of select="aws:ASIN"/><xsl:text>",</xsl:text>
		<xsl:text>"url":"</xsl:text><xsl:value-of select="aws:DetailPageURL"/><xsl:text>",</xsl:text>
		<xsl:text>"title":"</xsl:text><xsl:apply-templates select="aws:ItemAttributes/aws:Title"/><xsl:text>",</xsl:text>
		<xsl:text>"imageURL":"</xsl:text><xsl:value-of select="aws:SmallImage/aws:URL"/><xsl:text>"</xsl:text>
		<xsl:text>}, </xsl:text>
	</xsl:template>

<!-- +- -->
<!-- | Title Template, used to strip out quotation marks (which would break the javascript) -->
<!-- +- -->	
	<xsl:template match="aws:Title">

		<xsl:call-template name="find-and-replace">
			<xsl:with-param name="str" select="."/>
			<xsl:with-param name="target">"</xsl:with-param>
			<xsl:with-param name="replacement" select="''"/>
		</xsl:call-template>
	</xsl:template>

<!-- +- -->
<!-- | Search-and-Replace Template, swaps one string (target) with another (replacement) -->
<!-- +- -->	
	<xsl:template name="find-and-replace">

		<xsl:param name="str"/>
		<xsl:param name="target"/>
		<xsl:param name="replacement"/>
		<xsl:choose>
			<xsl:when test="$target and contains($str, $target)">
				<xsl:value-of select="substring-before($str, $target)" disable-output-escaping="yes"/>
				<xsl:value-of select="$replacement" disable-output-escaping="yes"/>
				<xsl:call-template name="find-and-replace">
					<xsl:with-param name="str" select="substring-after($str, $target)"/>

					<xsl:with-param name="target" select="$target"/>
					<xsl:with-param name="replacement" select="$replacement"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$str" disable-output-escaping="yes"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>	
	

</xsl:stylesheet>





