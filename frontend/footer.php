<footer>
Made by Got Nerds Inc.
</footer>
</div>
<script type="text/javascript"> 
window.my_config =
{
    currentStatus : 0
};
if ('body:not(.overlaid)') { 
    $('#signbut').click(function(a) {
        $('body').addClass('overlaid');
        if (window.my_config.currentStatus !== 0) {
            window.my_config.currentStatus.css("display","block")
        } else {
        $('#introduction').css("display","block");
        }
    });
    $('#logbut').click(function(a) {
        $('body').addClass('overlaid');
        $('#a').css("display","block");
    });
} 
if ('body.overlaid') {
        $('.double-border').click(function(e) {
            e.stopPropagation();
        });
        $('.xbut').click(function(e){
            $('body').removeClass('overlaid');
           
            $('#introduction, #organization, #organization2, #organization3, #forgot, #forgot2, #a, #confirm, #confirm2, #individual').css('display','none');
		});
}
        </script>
  </body>
</html>