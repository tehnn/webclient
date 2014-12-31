
<form  method="POST" action="<?= $this->createUrl('post') ?>">
    <input type="hidden" name="id" value="">
    name:<input type="text" name="name" id="name">
    lname:<input type="text" name="lname" >
    dx:<input type="text" name="dx">
    <button onclick="this.submit()">ตกลง</button>


</form>

<?php
//echo "<pre>";
//print_r($dataProvider);


$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'id',
            'value' => 'CHtml::link($data["id"], Yii::app()->createUrl("client/view",array("id"=>$data["id"])))',
            'type' => 'raw'
        ),
        'name',
        'lname',
        'dx',
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'label' => '',
                    'url' => 'Yii::app()->createUrl("client/delete", array("id"=>$data["id"]))',
                    //'imageUrl' => FALSE,
                    'options' => array('title' => 'ลบ'),
                ))
        )
    )
));

?>
<script>
    $(function(){
        //$("#name").focus();
        $( "input[name='name']").focus();
    });
</script>
