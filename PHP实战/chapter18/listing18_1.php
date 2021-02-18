<?php
require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/Renderer/Default.php';
require_once 'HTML/QuickForm/text.php';
$element = new HTML_QuickForm_text('headline');
$renderer = new HTML_QuickForm_Renderer_Default;
$renderer->setElementTemplate("{element}");
$element->accept($renderer);
print $renderer->toHtml();
