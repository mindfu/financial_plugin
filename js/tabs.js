JQuery (document).ready( function($){
    $("div.tpp_posts").mouseover( function()){
        var div = $(this);
        
       $.post('wp-admin/admin-ajax.php', {
           action: "tpp_comments",
           post_id: $(this).find("a").attr("id")
        }, function (data) {
            div.append($(data));
        }
        );
        return false;
        });
        
        $("div.top_post").mouseout( function() {
            
            $("post").remove();
            
        });
    });
    
    
    <!-- comment -->