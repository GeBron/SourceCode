<?php
$mapper = new NewsMapper;
$article = new NewsArticle(                                        
        $request->get('headline'),                                 
        $request->get('text'));                                     

if ($request->get('id')) {
    $article->setID($request->get('id'));                          
    $mapper->update($article);                                    
}
else {
    $mapper->insert($article);                                    
}

header("Location: news/list.php");
exit;
