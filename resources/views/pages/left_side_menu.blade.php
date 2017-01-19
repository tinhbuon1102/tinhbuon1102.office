<?php
?>
<link type="text/css" href="{{ URL::asset('css/sidetogglemenu.css') }}" rel="stylesheet" />
<script type="text/javascript" src="{{ URL::asset('js/sidetogglemenu.js') }}"></script>

<script>
    jQuery(function(){
       leftMenu = new sidetogglemenu({
           id: 'togglemenu1',
           downarrowsrc: '{{URL::asset("images/bg-icon-arrow-down.png")}}'
       })
    });
</script>

<div id="togglemenu1" class="sidetogglemenu">
</div>