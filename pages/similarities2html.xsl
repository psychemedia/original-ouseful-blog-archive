<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:aws="http://webservices.amazon.com/AWSECommerceService/2005-03-23" exclude-result-prefixes="aws">

	<xsl:output method="html"/>

<!-- +- -->
<!-- | Base Template Match, General JSON Format -->
<!-- +- -->
	<xsl:template match="/aws:ItemLookupResponse">

	<html><head><title></title></head><body><h1>Similar Items to ISBN: <xsl:value-of select="aws:OperationRequest/aws:Arguments/aws:Argument[@Name = 'ItemId']/@Value" /></h1>
	<xsl:apply-templates select="aws:Items" /></body></html>
	</xsl:template>

	<xsl:template match="aws:RequestId"/>
	<xsl:template match="aws:RequestProcessingTime"/>		

	<xsl:template match="aws:Items">
		<xsl:apply-templates select="aws:Item" />
	</xsl:template>

	<xsl:template match="aws:Item">
		<xsl:apply-templates select="aws:SimilarProducts" />
	</xsl:template>	

	<xsl:template match="aws:SimilarProducts">
		<xsl:apply-templates select="aws:SimilarProduct" />
	</xsl:template>
	
<!-- +- -->
<!-- | Fetch ASIN, URL, Title, Price -->
<!-- +- -->	
	<xsl:template match="aws:SimilarProduct">
		<hr />
		<div><xsl:attribute name="class">item</xsl:attribute>
		<a><xsl:attribute name="href">http://www.amazon.co.uk/exec/obidos/ASIN/<xsl:value-of select="aws:ASIN"/>/robofestauk-21</xsl:attribute>
			<img><xsl:attribute name="src">http://images.amazon.com/images/P/<xsl:value-of select="aws:ASIN"/>.01.TZZZZZZZ</xsl:attribute></img>
		<xsl:apply-templates select="aws:Title"/></a></div>
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





