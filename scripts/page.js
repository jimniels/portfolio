$(document).ready(function () {     
    

    //
    //
    //  Sections
    //
    function Section(config) {

        this.$target = config.$target;
        this.$template = config.$template;
        this.data = {};

        this.renderError = function() {
            this.$target.html('Data could not be loaded');
        },

        this.render = function() {
            var template = Handlebars.compile( this.$template.html() );
            this.$target.html( template( this.data ) );
        }
    };

    //
    //
    //  Define Objects
    //
    Dribbble = new Section({
        $target: $('#dribbble'),
        $template: $('#template-dribbble')
    });
    PublishedArticles = new Section({
        $target: $('#published-articles'),
        $template: $('#template-published-articles')
    });


    //
    //
    //  Execute Ajax Calls
    //

    //
    //
    // Dribbble 
    //
    $.getJSON("http://dribbble.com/jimniels/shots.json?callback=?", function(data){

        // Temp variable for trimming results down to two
        var dataTmp = { shots: [] };
        for($i=0;$i<2;$i++) {
            dataTmp.shots.push( data.shots[$i] );
        } 

        Dribbble.data = dataTmp;
        Dribbble.render();

    });

    //
    //
    //  Published Articles
    //
    $.getJSON('json/published-articles.json', function(data){
        PublishedArticles.data = data;
        PublishedArticles.render();
    });

    
        
});

/* creates a feed instance and loads the feed */
function OnLoad() {
    var feed = new google.feeds.Feed("http://scriptogr.am/jimniels/feed/");
    feed.load(feedLoaded);
}

/* when the feed is loaded */
function feedLoaded(result) {
    
    if (!result.error) {

        var html = '';

        /* loops through the feed elements (omit the newest post because it's shown on homepage), and append posts to the div */
        for (var i = 0; i < 4; i++) {
            var entry = result.feed.entries[i];

            /* gets the date of the post */
            var entryDate = new Date(entry.publishedDate);
            var curr_date = entryDate.getDate();
            var curr_month = entryDate.getMonth();
            var curr_year = entryDate.getFullYear();
            /* displays names of months instedad of numbers */
            var month_names = new Array ( );
            month_names[month_names.length] = "January";
            month_names[month_names.length] = "February";
            month_names[month_names.length] = "March";
            month_names[month_names.length] = "April";
            month_names[month_names.length] = "May";
            month_names[month_names.length] = "June";
            month_names[month_names.length] = "July";
            month_names[month_names.length] = "August";
            month_names[month_names.length] = "September";
            month_names[month_names.length] = "October";
            month_names[month_names.length] = "November";
            month_names[month_names.length] = "December";

            html += '<li><h2><a href="'+entry.link+'">'+entry.title+'</a></h2><p><time class="meta">'+ month_names[curr_month] + ' ' + curr_date + ', ' + curr_year + '</time></p></li>';
                        
            $('#blog').html( html );
        }
    }
}
