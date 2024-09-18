<?php
$isaccepted = filter_input(INPUT_GET, "is_accepted", FILTER_VALIDATE_INT);
setcookie("cookie", $isaccepted, time()+ 86400, "/");
header("Location:index.php");
