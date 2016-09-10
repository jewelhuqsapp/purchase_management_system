<form method=post action='action.php?action=add_notice'>

<center>
<h1>Notice</h1>
<p>Any important message?</p>
<textarea name="description" rows=5 cols=100><?php print($notice);?></textarea> <br>
<input type=submit  class="btn btn-primary" name='actions000' value='Save'><br><br>
</form>