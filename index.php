<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

    <link href='http://fonts.googleapis.com/css?family=EB+Garamond' rel='stylesheet' type='text/css'>


</head>

<body>

    <div class="l-wrapper main">

        <header class="header">
            <h1 class="header__logo"><a href="/">Jim Nielsen</a></h1>
            <h2 class="header__title">Web Designer. <em>Problem Solver.</em></h2>
            <h3 class="header__subtitle">Design Lead at <a href="http://kindlingapp.com">Kindling</a>, New York City</h3>
        </header>

        <section>

            <?php

                // Initiate Mustache
                require dirname(__FILE__).'/resources/mustache.php/src/Mustache/Autoloader.php';
                Mustache_Autoloader::register();
                $mustache = new Mustache_Engine(array(
                    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/resources/templates'),
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

                        // Custom for each
                        if($this->id == 'scriptogram') {
                            $this->data = $this->data['channel'];
                            $this->name = 'Blog';

                            // Trim
                            $length = count($this->data['item']);
                            for($i=0; $i<$length-4; $i++) {
                                array_pop($this->data['item']);
                            }

                        } elseif($this->id == 'dribbble') {
                            // Trim
                            $length = count($this->data['shots']);
                            for($i=0; $i<$length-2; $i++) {
                                array_pop($this->data['shots']);
                            }
                        } elseif($this->id == 'published-articles') {
                            // nothing?
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

                        <article class="section" id="<?php echo $Section->id ?>">
                            <h1 class="l-left section__header icon icon-<?php echo $Section->iconClass ?>">
                                <?php echo $Section->id ?>
                            </h1>
                            <ul class="l-right section__content">
                                <?php echo $mustache->render($Section->id, $Section->data); ?>
                            </ul>
                        </article>

                    <?php
                }
            ?>

            <div class="clearfix"></div>
        </section>
    </div>

    <footer class="l-wrapper footer">
        <p class="left"><a href="mailto:jimniels@gmail.com">jimniels@gmail.com</a></p>
        <p class="right"><a href="http://twitter.com/jimniels">@jimniels</a></p>
    </footer>

</body>
</html>