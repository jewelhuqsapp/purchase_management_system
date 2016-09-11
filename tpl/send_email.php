<div class="container">
<form method="post">
<input type=email name=email value="<?php print($email);?>">
<input type="hidden" name="po_id" value="<?php print($po_id);?>">

<input type=submit class=submit name=submit value="submit">
<input type="hidden" name="action" value="confirm_send_email">
</form>