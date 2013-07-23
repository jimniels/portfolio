$(document).ready(function () {     
    
    //
    // Dribbble Posts
    //
    var html = '';
    $.getJSON("http://dribbble.com/jimniels/shots.json?callback=?", function(data){
        $.each(data.shots, function(i,shot){
            if (i < 4)
                html += '<li><a href="'+shot.url+'"><img src="'+shot.image_teaser_url+'" /></a></li>';
        });
        $('#dribbble').html(html);
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

            html += '<li><a href="'+entry.link+'">'+entry.title+'</a></li>';
                        
            $('#blog').html( html );
        }
    }
}