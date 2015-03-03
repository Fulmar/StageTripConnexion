$(document).ready(function(){
    $("a.various").fancybox({
        openEffect  : 'none',
        closeEffect : 'none',
        helpers : {
            overlay : {
                locked : false
            }
        }
    });
});

// Facebook
window.fbAsyncInit = function() {
    FB.init({
        appId   : app_id,
        oauth   : true,
        status  : true, // check login status
        cookie  : true, // enable cookies to allow the server to access the session
        xfbml   : true // parse XFBML
    });
    
    // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
    // for any authentication related change, such as login, logout or session refresh. This means that
    // whenever someone who was previously logged out tries to log in again, the correct case below
    // will be handled.
    FB.Event.subscribe('auth.authResponseChange', function(response) {
        // Here we specify what we do with the response anytime this event occurs.
        if (response.status === 'connected') {
            // The response object is returned with a status field that lets the app know the current
            // login status of the person. In this case, we're handling the situation where they
            // have logged in to the app.
            console.log('connected');
            if($('.top-header-login .connect').length == 0) {
                $.ajax({
                    url : baseUrl + 'index.php?option=com_tpcxsocial&task=login.loginFb',
                    dataType: 'html',
                    success: function(response) {
                        $('.top-header-login').html(response);
                    }
                }); 
            }
        }
    }); 
    
  };
  
function fb_login(){
    FB.login(function(response) {
        if (response.authResponse) {
            //console.log(response); // dump complete info
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID
            
            $.fancybox.close();
            
            FB.api('/me', function(response) {
                user_email = response.email; //get user email
                // you can store this data into your database
                
                $.ajax({
                    url : baseUrl + 'index.php?option=com_tpcxsocial&task=login.saveUserFb',
                    dataType: 'json',
                    method: 'post',
                    data: response,
                    success: function() {
                        
                    }
                }); 

            });

        } else {
            //user hit cancel button
            //console.log('User cancelled login or did not fully authorize.');

        }
    });
}
    
function fb_logout() {
    FB.logout(function(response) {
        // Person is now logged out
        // logout joomla
        $.ajax({
            url : baseUrl + 'index.php?option=com_tpcxsocial&task=login.logout',
            method: 'get',
            success: function() {
                $(location).attr('href', baseUrl);
            }
        }); 
    });
}


// Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));
  
// functions generic
function like_topic(topic_id, user_id) {
    data = {
        user_id: user_id,
        topic_id: topic_id
    };
    $.ajax({
        url : baseUrl + 'index.php?option=com_tpcxsocial&task=user.like',
        dataType: 'json',
        method: 'post',
        data: data,
        success: function(data) {
            
            var img = $('.like-topic-' + topic_id + ' a').html();
            $('.like-topic-' + topic_id + ' a').remove();
            $('.like-topic-' + topic_id + '').prepend(img);
            $('.like-topic-' + topic_id + ' .number').html(data.rating);
        }
    }); 
}

function load_posts(data) {
    $.ajax({
        url : baseUrl + 'index.php?option=com_tpcxsocial&view=posts&task=post.load&layout=item',
        dataType: 'html',
        method: 'get',
        data: data,
        beforeSend: function() {
            $('.content-items').html(
                $('<img>')
                    .attr('class', 'loader')
                    .attr('src', baseUrl + 'templates/tpcx/images/ajax-loader.gif')
            );
        },
        success: function(response) {
            $('.content-items img.loader').remove();
            $('.content-items').html(response);
            
            eventFilter(data.id);
        }
    });
}
function eventFilter(topic_id) {
    $('.filter .choices .selected').click(function() {
        $('.filter .children').slideToggle({
            duration: 400
        });
        return false;
    });
    $('.filter .children a').each(function(index, element){
        $(this).click(function(){
            $('input[name=filter_order]').val($(this).attr('data-value'));
            data = {
                filter_order: $('input[name=filter_order]').val(),
                id: topic_id
            };
            // load posts
            load_posts(data);
        });
    });
    
    $(document).click(function(){
        $(".filter .children").slideUp(150);
    });
}
