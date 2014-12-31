<button onclick="history.back()">ย้อนกลับ</button>
<hr>
<form method="POST" action="<?=$this->createUrl('put')?>">
    
    <?php foreach ($rawData as $key => $value): ?>
        <?= $key ?> : <input type="text" id="<?=$key?>" name="<?= $key ?>" value="<?= $value ?>" > <br>

    <?php endforeach; ?>
        <input type="submit" value="Save">
</form>
