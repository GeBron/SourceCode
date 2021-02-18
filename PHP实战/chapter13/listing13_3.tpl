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
    {section name=u loop=$users}
      <tr>
      <td>{$users[u]->getUsername()
      <td>{$users[u]->getFirstname()
      <td>{$users[u]->getLastname()
      <td>{$users[u]->getEmail()
      <td>{$users[u]->getRole()
      <td><a href="userform.php?id={$users[u]->getID()}">Edit</a>
      </tr>
    {/section}
    </table>
    </div>
  </body>
</html>
