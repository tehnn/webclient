<button onclick="history.back()">ย้อนกลับ</button>
<hr>
<form method="POST" action="<?=$this->createUrl('put')?>">
    
    <?php foreach ($rawData as $key => $value): ?>
        <?= $key ?> : <input type="text" cid="<?=$key?>" name="<?= $key ?>" value="<?= $value ?>" > <br>

    <?php endforeach; ?>
        <input type="submit" value="Save">
       
        <a href="<?=$this->createUrl('delete',array('cid'=>$cid))?>">ลบ</a>
      
</form>
