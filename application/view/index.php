<h1>Записки у монитора</h1>

<p>Здесь начинающий web-программист в лице меня будет писать о своих успехах в 
изучении web-технологий, а также жаловаться, что ничего не получается. Беседу буду 
вести тихо сам с собою, если кто-нибудь захочет высказать свое мнение - мои профили в 
социальных сетях находятся без труда. 
Сайт написан на php с использованием технологий MVC и ООП. 
</p>


<?php if (app::isAdmin()): ?>
    <p><a href="/add">Новая запись</a></p>
    <p><a href="/logout">Выход</a></p>
<?php endif; ?> 



<!-- выводим статьи -->
<?php foreach ($articlesAll as $article): ?>
    <div class="article">
        <a href="/article?id=<?=$article['id'];?>"><h2><?=$article['title'];?></h2></a>        
        <p class="date">Опубликовано: <?=Helper::dateFormat($article['publicationDate']);?></p>
        <p><?=nl2br(Articles::cutText($article['content'],$article['id']));?></p> 
         <?php if (app::isAdmin()): ?>
        <p><a href="/edit?id=<?=$article['id'];?>">Редактировать запись</a> 
        <a href="#" onclick="if(confirm('Точно хочешь удалить эту запись?'))location.href='/delete?id=<?=$article['id'];?>';" >Удалить запись</a></p>
        <?php endif; ?>       
    </div>
    
<?php endforeach; ?>

<!-- выводим пагинацию, если страниц больше одной -->

<?php if($n>1): ?>
    <div class="wrapper">
        <ul class="pagination">
        <?php for($i=1; $i<=$n; $i++) :?>
            <?php if($i==$page) : ?>
                <li class="active"><a href="/index?p=<?=$i;?>"><?=$i;?></a></li> 
            <?php else : ?>
                <li><a href="/index?p=<?=$i;?>"><?=$i;?></a></li>
            <?php endif; ?> 
        <?php endfor; ?>
        </ul>
    </div>
<?php endif; ?>

