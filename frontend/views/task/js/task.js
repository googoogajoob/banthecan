/**
 * Created by and on 4-May-15.
 */

function taskUser(id) {
    $('#task-user_id').find('img').each(function(key, value) {
        alert( value.attr('class') );
    });
}
