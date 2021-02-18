<xsl:stylesheet version="1.0"                                         
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">                   
  <xsl:output method="html">                                          
  <xsl:template match="/">                                            
    <html xmlns="http://www.w3.org/1999/xhtml">                       
      <head>
        <title>
          User administration
        </title>
      </head>
      <body>
        <div id="content">
          <h1>
            User administration
          </h1>
          <table id="AdminList" cellspacing="0">
            <tr>
              <th>Login name</th>
              <th>First Name</th>
              <th>Last name</th>
              <th>Email address</th>
              <th>Role</th>
              <th>
              </th>
            </tr>
            <xsl:for-each select="/userlist/user">                    
              <tr>
                <td><xsl:value-of select="username"/></td>            
                <td><xsl:value-of select="firstname"/></td>           
                <td><xsl:value-of select="lastname"/></td>            
                <td><xsl:value-of select="email"/></td>               
                <td><xsl:value-of select="role"/></td>                
                <td>
                  <a class="CommandLink"
                    href="{concat('userform.php?id=',id)}">            
                    Edit
                  </a>
                </td>
              </tr>
            </xsl:for-each>
          </table>
        </div>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
