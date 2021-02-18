<?php
require_once 'UserFinder.php';

$finder = new UserFinder;                                             
$users = $finder->findAll();                                          

?>
<html>
  <head>
    <title>User administration</title>
  </head>
  <body>
    <div id="content">
      <h1>User administration</h1>
    <table id="AdminList" cellspacing="0">
    <tr>
      <th>Login name</th>
      <th>First Name</th>
      <th>Last name</th>
      <th>Email address</th>
      <th>Role</th>
      <th></th>
    </tr>
    <?php foreach ($users as $u) : ?>                                  
      <tr>
        <td><?php echo htmlentities($u->getUserName()) ?></td>        
        <td><?php echo htmlentities($u->getFirstName()) ?></td>       
        <td><?php echo htmlentities($u->getLastName()) ?></td>        
        <td><?php echo htmlentities($u->getEmail()) ?></td>           
        <td><?php echo htmlentities($u->getRole()) ?></td  >          
        <td><a href="userform.php?id=<?php
             echo htmlentities($u->getID()) ?>"
              class="CommandLink">Edit</a>
      </tr>
    <?php endforeach; ?>
    </table>
    </div>
  </body>
</html>
