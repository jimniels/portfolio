<?php header('Content-type: text/html; charset=UTF-8'); ?><!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Jim Nielsen, Designer</title>
    <meta name="description" content="Jim Nielsen, a web and graphic designer currently living and working in NYC">
    <meta name="author" content="Jim Nielsen">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="resources/stylesheets/style.css">

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link href="http://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet" type="text/css">


</head>

<body>

    <div class="l-wrapper main">

        <header class="header">
            <h1 class="header__logo"><a href="/">Jim Nielsen</a></h1>
            <h2 class="header__title">Web Designer. <em>Problem Solver.</em></h2>
            <h3 class="header__subtitle">Design Lead at <a href="http://kindlingapp.com">Kindling</a>, New York City</h3>
            <a href="resume" class="header__developer">dev-friendly &raquo;</a>
        </header>

        <section>

            <?php
                // http://stackoverflow.com/questions/2087103/innerhtml-in-phps-domdocument
                function DOMinnerHTML(DOMNode $element) { 
                    $innerHTML = ""; 
                    $children  = $element->childNodes;

                    foreach ($children as $child) 
                    { 
                        $innerHTML .= $element->ownerDocument->saveHTML($child);
                    }

                    return $innerHTML; 
                }
                
                // Initiate Mustache
                require dirname(__FILE__).'/resources/mustache.php/src/Mustache/Autoloader.php';
                Mustache_Autoloader::register();

                
                $mustache = new Mustache_Engine(array(
                    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/resources/templates'),
                    'helpers' => array(
                        'getTweet' => function($data, Mustache_LambdaHelper $helper) {
                            $html = $helper->render($data);

                            $DOM = new DOMDocument;
                            $DOM->loadHTML($html);
                            $items = $DOM->getElementsByTagName('p');
                            $item = $items->item(0);

                            return DOMinnerHTML($item);
                        },
                        'getScreenName' => function($data, Mustache_LambdaHelper $helper) {
                            $url = $helper->render($data);
                            $url = explode('twitter.com/', $url);
                            return $url[1];
                        }
                    ),
                ));


                // Setup Class for each section
                class Section {
                    public  $id,
                            $name,
                            $iconClass,
                            $data;

                    public function __construct($id) {
                        
                        // Initiate values
                        $this->id = $id;
                        $this->name = $id;
                        $this->iconClass = $id;
                        $this->data = json_decode(file_get_contents(dirname(__FILE__).'/resources/json/'. $this->id .'.json'), true);

                        // Massage the data we need for output
                        if($this->id == 'scriptogram') {
                            $this->data = $this->data['channel'];
                            $this->name = 'Blog';

                            // Trim down results
                            $this->data['item'] = array_slice($this->data['item'], 0, 5);

                            // Format dates
                            for($i=0; $i<count($this->data['item']); $i++) {
                                $this->data['item'][$i]['pubDate'] = date("M j, Y", strtotime($this->data['item'][$i]['pubDate']) );
                            }

                        } elseif($this->id == 'dribbble') {
                            // Trim
                            $this->data['shots'] = array_slice($this->data['shots'], 0, 2);
                        } elseif($this->id == 'published-articles') {
                            // Trim down tweets to one for templating
                            for($i=0; $i<count($this->data['published-articles']); $i++) {
                                // Get random number to pick random tweet
                                $rand = rand(0, count($this->data['published-articles'][$i]['tweets']));
                                // Trim down the tweets array
                                $this->data['published-articles'][$i]['tweets'] = array_slice($this->data['published-articles'][$i]['tweets'], $rand-1, 1);
                            }  
                        } elseif($this->id == 'recent-projects') {
                            $this->iconClass = 'hammer';
                        } 

                        
                    }
                }

                // Define sections
                $sections = array(
                    'scriptogram',
                    'dribbble',
                    'published-articles',
                    'recent-projects'
                );   

                foreach ($sections as $id) {
                    $Section = new Section($id);
                    ?>

                        <article class="section clearfix" id="<?php echo $Section->id ?>">
                            <h1 class="l-left section__header icon icon-<?php echo $Section->iconClass ?>">
                                <?php echo  ucwords(str_replace('-', ' ', $Section->id) ) ?>
                            </h1>
                            <ul class="l-right section__content <?php if($Section->id == 'dribbble'){echo 'clearfix';} ?>">
                                <?php echo $mustache->render($Section->id, $Section->data); ?>
                            </ul>
                        </article>

                    <?php
                }
            ?>

            <div class="clearfix">&nbsp;</div>
        </section>
    </div>

    <footer class="l-wrapper footer">
        <p>If you want to contact me, you can email me <a href="mailto:jimniels@gmail.com">jimniels@gmail.com</a> or find me on twitter <a href="http://twitter.com/jimniels">@jimniels</a></p>
    </footer>

    <!-- Tracking Code -->
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-19579223-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>

</body>
</html>