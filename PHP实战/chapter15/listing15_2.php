<?php
switch($_REQUEST['cmd']) {
    case 'updateNews': updateNews(); break;
    case 'insertNews': insertNews(); break;
    case 'editArticle': editArticle(); break;
    case 'newArticle': newArticle(); break;
    default: die("No such command: ".$_REQUEST['cmd']);
}

function insertNews() {
    $sql = mysql_real_escape_string(
        "INSERT INTO News ".
        "(headline,text) ".
        "VALUES ('".$_POST['headline']."','"
        .$_POST['text']."') "
    );
    mysql_query($sql);
    header("Location: http://localhost/newslist.php");
    exit;
}

function updateNews() {
    $sql = mysql_real_escape_string(
        "UPDATE News SET ".
        "headline = '".$_POST['headline']."',".
        "text = '".$_POST['text']."' ".
        "WHERE id = ".$_POST['id']
    );
    mysql_query($sql);
    header("Location: http://localhost/newslist.php");
    exit;
}

function editArticle() {
    $sql = mysql_real_escape_string(
        'SELECT id,text,headline '.
        'FROM News WHERE id = '.$_REQUEST['id']
    );
    $r = mysql_query($sql);
    $article = mysql_fetch_assoc($r);
    showForm('updateNews',$article);
}

function newArticle() {
    showForm('insertNews',array());
}

function showForm($command,$article) {
    ?>
<html>
<body>
<h1>Submit news</h1>
<form method="POST">
  <input type="hidden" name="cmd"
    value="<?php echo $command ?>">
  <input type="hidden" name="id"
    value="<?php echo $article['id'] ?>">
  Headline:
  <input type="text" name="headline"
  value="<?php echo $article['headline'] ?>"><br>
  Text:
  <textarea name="text"ols="50" rows="20">
    <?php echo $article['text'] ?></textarea><br>
  <input type="submit" value="Submit news">
</form>
</body>
</html>
<?php
}
