<?php
# jQuery - super super basic overview (don't even know why I'm copying this over ... durp)
?>
<script>
	jQuery.(selector).event(function);

/* SELECTORS & EVENTS */
/* Selectors are the same as CSS. ie: ".class" / "#id"   */
    $.(".pref").change(function(){
        /*do stuff*/
    });
</script>

<form id="radioform">
	<table>
		<tbody>
		<tr>
			<td><input class="pref" checked="checked" name="book" type="radio" value="Sycamore Row" />Sycamore Row</td>
			<td>John Grisham</td>
		</tr>
		<tr>
			<td><input class="pref" name="book" type="radio" value="Dark Witch" />Dark Witch</td>
			<td>Nora Roberts</td>
		</tr>
		</tbody>
	</table>
</form>

<?php
# USING AJAX
// wp-admin/admin-ajax.php must get referenced. This will come from PHP and sent to jQuery - but never hardcoded!!!
// jQuery's: var this2 = this; is used later for callback function

# GET PROPER URL
// For admin pages: the correct URL is accessible from global JS variable: ajaxurl
// For other pages: the correct URL is accesible from PHP's wp_localize_script();
//    then referenced from jQuery's: my_ajax_obj.ajax_url;

// Send request with jQuery's: $.post(URL, POST_data, callback_function);

# DATA
// post data is the second parameter of jQuery's: $.post(URL, POST_data, callback_function);
// Data must be accompanied by an action parameter
// Any secure data transfer (ie: anything going into database) must be accompanied by a nonce
/** example DATA array
{   _ajax_nonce: my_ajax_obj.nonce,     //  NONCE
	action: "my_tag_count",             //  ACTION
	title: this.value                   //  DATA
}
*/
// Any other necessary data to complete task, send in DATA array, ie:
//    title: this.value,
// using either XML or JSON for single-string transmission is usually preferred
// NOTE: you can do CSV, or any custom string encoding as well if you wish

# NONCE
// referenced, in this case, as: my_ajax_obj.nonce;
// key the nonce value as _ajax_nonce, as shown: _ajax_nonce = my_ajax_obj.nonce;

# ACTION
// in part, constructs a tag to use to hook Ajax handler code.
// Example uses "my_tag_count" as action value. ie:
//    action: "my_tag_count",

# CALLBACK
// function that is called when the data is returned from server
// function is usually anonymous
// the passed parameter is the server's response
// response is anything from a single bit to an entire XML file
// NOTE: if no response is required, then a callback function is not necessary
// Example's anon callback:
/**
]function(data) {
	this2.nextSibling.remove();
	$(this2).after(data);
}
*/
// NOTE: the line: var this2 = this;
//    allows the value from this to pass into the anonymous function's scope as this2


// Output the block on the page or in own file.
// usually stored in:
//    plugin_main_folder/js/my_jquery.js
?>
<script>
    ]jQuery(document).ready(function($) {          //   wrapper
        $(".pref").change(function() {             //   event
            var this2 = this;                      //   use in callback
            $.post(my_ajax_obj.ajax_url, {         //   POST request
                _ajax_nonce: my_ajax_obj.nonce,    //   nonce
                action: "my_tag_count",            //   action
                title: this.value                  //   data
            }, function(data) {                    //   callback
                this2.nextSibling.remove();        //   remove current title
                $(this2).after(data);              //   insert server response
            });
        });
    });
</script>
