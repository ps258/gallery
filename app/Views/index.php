<h1 id="gallery_header"><?php echo $title?></h1>

<div id="featured">
<?php
if (isset($featured))
{
    foreach ($featured as $image)
    {
        $path = explode('/', $image);
        $year = $path[1];
        $day = $path[2];
        $image = $path[3];
        $gif = "$image.gif";
        print "<a href=\"/gallery/show_image/$year/$day/$image\"><img class=\"thumb\" src=\"/Photos/$year/$day/$gif\" alt=\"$image\" /></a>\n";
    }
}
?>
</div>

<div id="page_list">
<ul id="date_list">
<?php
    foreach ($years as $year)
    {
        $year = basename($year);
        print "  <li><a href=\"/gallery/show_year/$year\">$year</a></li>\n";
    }
?>
</ul>
</div>
