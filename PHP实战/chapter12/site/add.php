<?php
require_once('../classes/add_contact_controller.php');

$controller = new AddContactController($_POST);
if ($controller->added()) {
    header('Location: index.php');
}
?><html>
    <head><title>Add Contact</title></head>
    <body>
        <form method="post">
            <h1>Add Contact</h1>
            <label>Name: <input type="text" name="name" /></label>
            <br />
            <label>E-mail: <input type="text" name="email" /></label>
            <br />
            <input type="submit" name="add" value="Add" />
        </form>
    </body>
</html>