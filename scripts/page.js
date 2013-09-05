$(document).ready(function () {     
    
    //
    // Dribbble Posts
    //
    var html = '';
    $.getJSON("http://dribbble.com/jimniels/shots.json?callback=?", function(data){
        $.each(data.shots, function(i,shot){
            if (i < 2)
                html += '<li><a href="'+shot.url+'"><img src="'+shot.image_url+'" /></a></li>';
        });
        $('#dribbble').html(html);
    });


    $.getJSON('json/published-articles.json', function(data){
        console.log(data);
        var html = '';
        for (var i = 0; i< data.length; i++) {
            html += '<li><a href="'+data[i].link+'">'+data[i].title+'</a><time class="meta">date</time></li>';
        };
        $('#published-articles').html(html);
    }).done(function(){

    }).fail(function(){

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

            html += '<li><a href="'+entry.link+'">'+entry.title+'</a><time class="meta">'+ month_names[curr_month] + ' ' + curr_date + ', ' + curr_year + '</time></li>';
                        
            $('#blog').html( html );
        }
    }
}
