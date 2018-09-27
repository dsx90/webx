<li>
    <a href="<?= \yii\helpers\Url::to([$this->controller, 'slug' => $category['slug']]) ?>">
        <?= $category['title']?>
        <?php if(isset($category['childs']) ): ?>
            <sup><?= count($category['childs'])?></sup><span class="badge pull-right"><i class="fa fa-plus"></i></span>
        <?php endif;?>
    </a>
    <?php if( isset($category['childs']) ): ?>
        <ul>
            <?= $this->getMenuHtml($category['childs'])?>
        </ul>
    <?php endif;?>
</li>