<!-- $article - массив, содержит данные записи -->

<h1><?=$article['title'];?></h1>

    <div class="article">
        <p class="date">Опубликовано: <?=Helper::dateFormat($article['publicationDate']);?></p>
        <p><?=nl2br($article['content']);?></p>
        <?php if (app::isAdmin()): ?>
        <p><a href="/edit?id=<?=$article['id'];?>">Редактировать запись</a> 
        <a href="/delete?id=<?=$article['id'];?>">Удалить запись</a></p>
        <?php endif; ?>  
    </div>
    

<p><a href="/">Главная страница</a></p>
