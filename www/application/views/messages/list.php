<table border="1">
<?php foreach($list as $msg): ?>
    <tr>
        <td><?=$msg->user?></td>
        <td><?=$msg->text?></td>
    </tr>
<?php endforeach?>
</table>