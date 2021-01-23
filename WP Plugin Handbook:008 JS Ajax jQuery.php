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
// wp-admin/admin-ajax.php must get referenced, but never hardcoded!!!
// for admin pages, the correct URL is accessible from global JS variable: ajaxurl
//
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
