<?php
require_once("../../../wp-blog-header.php");
header("Content-Type: text/css");
print mytheme_liquid_content_filter(file_get_contents(get_stylesheet_uri()));
?>