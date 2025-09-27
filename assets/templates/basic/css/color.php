<?php
header("Content-Type:text/css");
function checkhexcolor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color or !checkhexcolor($color)) {
    $color = "#27AE61";
}

?>

:root{
--main : <?php echo $color; ?>;
}