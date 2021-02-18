<html>
  <head>
    <div tal:replace="structure form/getValidationScript" />           
  </head>
  <body>
    <span tal:define="draft elements/status/options/draft"/>          
    <span tal:define="published                                       
      elements/status/options/published"/>                            
    <form method="post" onsubmit="return validate_(this);">            
      <table>
        <tr>
          <td tal:content="elements/headline/getLabel">               
              Headline (this is sample text that PHPTAL removes)      
          </td>                                                       
          <td>                                                        
            <input type="text"                                        
              name="${elements/headline/getName}"                     
              value="${elements/headline/getValue}" />                
          </td>
        </tr>
        <tr>
          <td tal:content="elements/category/getLabel">
              Category (this is sample text that PHPTAL removes)
          </td>
          <td tal:content="structure elements/category/asHtml">       
            <select>                                                  
            </select>                                                 
          </td>                                                       
        </tr>
        <tr>
          <td>
            <span tal:content="published/getLabel"/>:                 
            <input type="radio" name="${elements/status/getName}"     
              value="${published/getValue}"                           
              tal:attributes="checked published/getChecked" />        
              <span tal:content="draft/getLabel"/>:                   
            <input type="radio" name="${elements/status/getName}"     
              value="${draft/getValue}"                               
              tal:attributes="checked draft/getChecked" />            
          </td>
        </tr>
        <tr>
          <td tal:content="elements/body/getLabel">
              Body (this is sample text that PHPTAL removes)
          </td>
          <td>
            <textarea tal:content="elements/body/getValue"
              name="${elements/body/getName}">
            </textarea>
          </td>
        </tr>
      </table>
      <input type="submit" />
    </form>
  </body>
</html>
