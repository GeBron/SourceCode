<td align="right" valign="top" colspan="2">
<?php
 if ($lang=="no") {
   if ($monitor==="") {
       print "&nbsp;&nbsp;&nbsp;&nbsp;
       <a href=\"$PHP_SELF?show=search\" target=\"_self\"
       class=\"headlink\">Rediger</a>\n";
       print "&nbsp;&nbsp;&nbsp;&nbsp;
       <a href=\"$PHP_SELF?show=search&action=new\"
       target=\"_self\" class=\"headlink\">Ny</a>\n";
   }
 } else {
   if ($monitor=="") {
       print "&nbsp;&nbsp;&nbsp;&nbsp;
       <a href=\"$PHP_SELF?show=search\" target=\"_self\"
       class=\"headlink\">Edit</a>\n";
       print "&nbsp;&nbsp;&nbsp;&nbsp;
       <a href=\"$PHP_SELF?show=search&action=new\"
       target=\"_self\" class=\"headlink\">New</a>\n";
   }
 }
?>
