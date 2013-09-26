
//
//
//  Section Class
//
function Section(config) {

    this.$target = config.$target;
    this.$template = config.$template;
    this.data = config.data;

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
//  Page Load
//
$(document).ready(function () {

    //
    //
    // Dribbble 
    //
    $.getJSON("http://dribbble.com/jimniels/shots.json?callback=?", function(data){

        Dribbble = new Section({
            $target: $('#dribbble'),
            $template: $('#template-dribbble'),
            data: data.shots
        });

        // Trim API results down to two items
        Dribbble.data.splice(2, Dribbble.data.length-2);

        // Render the module
        Dribbble.render();
    });

    //
    //
    //  Side Projects & Published Articles
    //
    $.getJSON('resources/json/data.json', function(data){
        
        PublishedArticles = new Section({
            $target: $('#published-articles'),
            $template: $('#template-published-articles'),
            data: data['published-articles']
        });

        SideProjects = new Section({
            $target: $('#side-projects'),
            $template: $('#template-side-projects'),
            data: data['side-projects']
        });

        // Render the modules
        SideProjects.render();
        PublishedArticles.render();
    });

    //
    //
    //  Scriptogram
    //
    $.getJSON('resources/get-scriptogram.php', function(data){
        
        Scriptogram = new Section({
            $target: $('#scriptogram'),
            $template: $('#template-scriptogram'),
            data: data.channel.item
        });

        // Trim results down to four
        Scriptogram.data.splice(5, Scriptogram.data.length - 5 );

        // Render the modules
        Scriptogram.render();
    });
        
});




//
//
//  Handlebar Helpers
//

// Convert to filename
Handlebars.registerHelper('filenameify', function(title) {
    return title.replace(/ +/g, '-').toLowerCase();
});

// Make dates pretty - 4 January, 2013
Handlebars.registerHelper('prettyDate', function(date) {
    var d = new Date(date);
    var months = [ 
        "January", 
        "February", 
        "March", 
        "April", 
        "May", 
        "June",
        "July", 
        "August", 
        "September", 
        "October", 
        "November",
        "December"
    ];
    return months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
});


//
//
//  Scriptogram Stuff
//
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
