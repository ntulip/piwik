{literal}
<style>
input, textarea, p {
	font-family: Georgia,"Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
	font-size:0.9em;
	padding:0.2em;
}
input {
	margin-top:0.8em;
}
</style>
{/literal}

<form method="post" action="index.php?module=Feedback&action=sendFeedback">

<p><strong>your email	:</strong>
<br /><input type="text" name="email" size="40" /></p>

<p><strong>your feedback:</strong><br/>
<i>please be precise if you request for a feature or report a bug</i></p>
<textarea name="body" cols="37" rows="10"></textarea>
<br/>
<input type="submit" value="Send feedback" />
</form>
