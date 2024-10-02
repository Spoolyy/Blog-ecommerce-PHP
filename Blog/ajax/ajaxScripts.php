<?php
$result = ['response'=> $_POST['firstnumber'] + $_POST['secondnumber']];
echo json_encode($result);