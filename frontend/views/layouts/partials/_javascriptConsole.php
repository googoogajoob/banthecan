<div id="jsDebugDiv"></div>
<script type="text/javascript">
$(document).ready(function () {
    if (typeof console != "undefined") {
        if (typeof console.log != 'undefined') {
            console.olog = console.log;
        } else {
            console.olog = function () {};
        }
    }
    console.log = function(message) {
        console.olog(message);
        $('#jsDebugDiv').append('<p>' + message + '</p>');
    };

    console.error = console.debug = console.info = console.log;
    }
);
</script>