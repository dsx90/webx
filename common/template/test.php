<?php
$this->title = $model->title;
?>

<p class="hint">
    <span class="fa fa-eye"></span> <?=$views ?>
    <?= \yii\helpers\Html::button('<span class="fa fa-star"></span> '. $likes, ['class' => 'btn btn-default like', 'id' => $model->id])?>
</p>
<?=$this->registerJs('
$(".like").click(function(){
    var id = $(this).attr("id");
    $.post("like/"+id, {
        }, function(data){
            $("#"+id).html("<span class=\'glyphicon glyphicon-thumbs-up\'></span> "+data);
        });
})
');
?>