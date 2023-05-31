<?php

include("includes/header.php");

echo getRank("1234A", $conn);
echo getRank("3456C", $conn);
echo getRank("6942N", $conn);

include("includes/footer.php");