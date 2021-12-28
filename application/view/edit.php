<h1>Редактирование записи</h1>


<form method="POST">
    <div class="form-group">
        <label for="title">Заголовок</label>
        <input type="text" class="form-control" name="title" id="title" value="<?=$article['title'];?>">
    </div>
     <div class="form-group">
        <label for="text">Текст</label>
        <textarea class="form-control" rows="5" id="text" name="text"><?=$article['content'];?></textarea>
     </div>
    <input type="submit" class="btn btn-default" name="submit" value="Сохранить">

</form>
    

<p><a href="/">Главная страница</a></p>
