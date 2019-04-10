{$model->getSnippet('test',[
    'test' => 'работает'
])}

<!--<p class="hint">
    <span class="fa fa-eye"></span> {$model->visit}
    <span id="{$model->id}" class="like">
        <i class="fa fa-star-o"></i> {$model->like}
    </span>
</p>-->

{$this->registerJs('
    $(".like").click(function(){
        var id = $(this).attr("id");
            $.post("like?id="+id, {
                }, function(data){
            $("#"+id).html("<span class=\'fa fa-star-o\'></span> "+data);
        });
    })
')}