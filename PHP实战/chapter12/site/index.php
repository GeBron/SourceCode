<?php
require_once(dirname(__FILE__) . '/../classes/configuration.php');
require_once(dirname(__FILE__) . '/../classes/transaction.php');
require_once(dirname(__FILE__) . '/../classes/contact.php');

$configuration = new Configuration();
$transaction = new MysqlTransaction(
        $configuration->getDbHost(),
        $configuration->getDbUsername(),
        $configuration->getDbPassword(),
        $configuration->getDb());
$finder = new ContactFinder();
$contacts = $finder->findAll($transaction);
?><html>
    <head>
        <title>Show Contacts</title>
        <style>
            td, th {border: 1px inset gray}
            table {border: 1px outset black}
        </style>
    </head>
    <body>
        <h1>Show Contacts</h1>
        <table>
            <tr><th>Name</th><th>E-mail</th></tr>
            <?php
                while ($contact = $contacts->next()) {
                    print "<tr>\n";
                    print "<td>{$contact->getName()}</td>\n";
                    print "<td>{$contact->getEmail()}</td>\n";
                    print "</tr>\n";
                }
            ?>
        </table>
        <a href="add.php">Add contact</a>
    </body>
</html>