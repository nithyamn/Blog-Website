<!DOCTYPE html>
<html>
<body>

<?php
echo strip_tags("Hello <b><i>world!</i></b>","<b>,<i>");
?>

<p>This function strips a string from HTML, XML, and PHP tags. In this example, we allow &lt;b&gt; tags to be used (all other tags will be removed).</p>

</body>
</html>
