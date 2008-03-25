{include file="header.tpl" pt="pg"}
<p>
  <form method="post" action="service.php?s=USR&a=LOGIN">
    <table>
      <tr><td>UserName</td><td><input name="user" type="text" id="user" value=""/></td></tr>
      <tr><td>Password</td><td><input name="password" type="password" id="password" value=""/></td></tr>
      <tr><td align="center" colspan="2"><input type="submit" name="Submit" value="Login"/></td></tr>
    </table>
  </form>
</p>
{include file="footer.tpl" pt="pg"}