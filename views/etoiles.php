
<script language="javascript">
    var obj = document.getElementById('evaluation');
    var old = document.getElementById('note');       
    obj.removeChild(old);
</script>

<script language="javascript">
    var target = document.getElementById('evaluation');
    var elem = document.createElement('note');
    var txt = document.createTextNode(<?php $note ?>);
        
    elem.appendChild(txt);
    elem.id = 'note';
        
    target.appendChild(elem);
</script>