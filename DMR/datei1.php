<html>
<body>

<form action="decrypt2.php" method="post">
Name: <textarea cols="60" rows="8" name="encrypt">
<?php
echo readfile("./test.txt");
?>
</textarea>
<input type="submit">
</form>

</body>
</html>
