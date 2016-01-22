<?php
$page_title = 'Contact Us';
include ('includes/header.html');
?>
 <!-- hello -->
<form name="contactform" method="post" action="sendFormEmail.php">
 
<table>
 
<tr>
 
 <td>
 
  <label for="first_name">First Name *</label>
 
 </td>
 
 <td >
 
  <input  type="text" name="first_name" maxlength="50" size="30">
 
 </td>
 
</tr>
 
<tr>
 
 <td >
 
  <label for="last_name">Last Name *</label>
 
 </td>
 
 <td >
 
  <input  type="text" name="last_name" maxlength="50" size="30">
 
 </td>
 
</tr>
 
<tr>
 
 <td >
 
  <label for="email">Email Address *</label>
 
 </td>
 
 <td >
 
  <input  type="text" name="email" maxlength="80" size="30">
 
 </td>
 
</tr>
 
<tr>
 
 <td >
 
  <label for="telephone">Telephone Number</label>
 
 </td>
 
 <td >
 
  <input  type="text" name="telephone" maxlength="30" size="30">
 
 </td>
 
</tr>
 
<tr>
 
 <td >
 
  <label for="comments">Comments *</label>
 
 </td>
 
 <td >
 
  <textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
 
 </td>
 
</tr>
 
<tr>
 
 <td colspan="2" style="text-align:center">
 
  <input type="submit" value="Submit"> 
 
 </td>
 
</tr>
 
</table>
 
</form>
 
<?php
include ('includes/footer.html');
?>
