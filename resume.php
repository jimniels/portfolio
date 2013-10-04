<?php
$recentProjects = json_decode( file_get_contents(dirname(__FILE__).'/resources/json/recent-projects.json'), true );
$recentProjects = $recentProjects['recent-projects'];
$publishedArticles = json_decode( file_get_contents(dirname(__FILE__).'/resources/json/published-articles.json'), true );
$publishedArticles = $publishedArticles['published-articles'];
?><!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Jim Nielsen, Designer</title>
    <meta name="description" content="Jim Nielsen, a web and graphic designer currently living and working in NYC">
    <meta name="author" content="Jim Nielsen">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {white-space: pre; font-family: monospace}
        a {color: inherit;}
        a:hover {color: #c02702;}
    </style>

</head>

<body>{
    "<strong style="color: #c02702;">person-you-should-hire</strong>" : {
        "name":             "<strong>Jim Nielsen</strong>",
        "title":            "Web Designer",
        "twitter-url":      "<a href="http://twitter.com/jimniels">http://twitter.com/jimniels</a>",
        "dribbble-url":     "<a href="http://dribbble.com/jimniels">http://dribbble.com/jimniels</a>",
        "blog-url":         "<a href="http://scriptogr.am/jimniels">http://scriptogr.am/jimniels</a>",
    
        "recent-projects": [ <?php foreach ($recentProjects as $index => $project) {
            echo '
            {
                "title":            "'.$project['title'].'",
                "link":             "<a href="'.$project['link'].'">'.$project['link'].'</a>",
                "description":      "'.$project['description'].'"'; if($project['cta']) { echo ',
                "case-study":       "<a href="'.$project['cta'].'">'.$project['cta'].'</a>"';
            } echo '
            }'; if($index != count($recentProjects)-1) {echo ',';}; }?>

        ],

        "published-articles": [ <?php foreach ($publishedArticles as $index => $article) {
            echo '
            {
                "title":            "'.$article['title'].'",
                "publisher":        "'.$article['publisher'].'",
                "publish-date":     "'.$article['publish-date'].'",
                "link":             "<a href="'.$article['link'].'">'.$article['link'].'</a>",
                "excerpt":          "'.$article['excerpt'].'"';
            echo '
            }'; if($index != count($publishedArticles)-1) {echo ',';}; }?>
        
        ]
    }
}</body>
</html>