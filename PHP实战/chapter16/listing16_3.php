<?php
$mapper = new NewsMapper;                                               
if (is_int($request->get('id'))) {                                      
    $article = $mapper->find($request->get('id'));                     

}
else {
    $article = new NewsArticle('','');                                  
}
$template = new Smarty;
$template->assign('content','newsform.tpl');                            
$template->assign('article',$article);
echo $template->fetch('normal.tpl');
