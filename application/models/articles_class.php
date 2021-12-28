<?php

/**
 * @author Assidi
 * @copyright 2017
 */

// класс для статей в блоге

class Articles extends AbstractDb{
    protected $tableName='articles';
    public $articleId;
    public $articleTitle;
    public $articleContent;
    public $articleDate;
    
    // соединение с базой данных
    public function __construct() {
        parent::__construct(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }
    
    // закрытие соединения с БД
    public function __destruct() {
        parent::__destruct();
    }
    
    // выбор всех статей
    public function selectAllArticles() {        
        return $this->selectAll($this->tableName);
    }
    
    // выбор всех статей, отсортированных по убыванию даты
    public function selectAllArticlesSort() {        
        return $this->selectAllSort($this->tableName,'publicationDate', 'DESC');
    }
    
    // выбор статей, отсортированных по убыванию даты, начиная с записи start и количепством n
    public function selectArticlesSortLimit($start, $n) {
        return $this->selectSortLimit($this->tableName,'publicationDate', 'DESC', $start, $n);
    }  
    
    // выбор всех статей
    public static function allArticles() {
        $blog = new Articles;        
        $articlesAll = $blog->selectAllArticlesSort();
        return $articlesAll;
    }
    
    // выбор одной статьи по иденфикатору
    public static function oneArticle($id) {        
        $blog = new Articles;
        $name = "id";
        $table = $blog->tableName;
        $article = $blog->selectOne($table, $name, $id);
        return $article;
    }
    
    
    // выбор одной статьи по идентификатору
    public function selectArticle($id) {
        $name = "id";
        return $this->selectOne($this->tableName, $name, $id);
    }
    
    // добавление записи
    // возвращает true, усли удалось добавить и false, если нет
        
    public static function addArticle($title, $text) {
        $title = trim($title);
        $text = trim($text);
        $date = time();
        $blog = new Articles;
        $newArticle = array();
        $newArticle['title'] = $title;
        $newArticle['content'] = $text;
        $newArticle['publicationDate'] = $date;
        $table = $blog->tableName;
        $result = $blog->newRecord($table, $newArticle);
        return $result;
        
    }
    
    // редактирование записи 
    // возвращает true, усли удалось добавить и false, если нет
    
    public static function editArticle($id, $title, $text) {
        $title = trim($title);
        $text = trim($text);
        $blog = new Articles;
        $newArticle = array();
        $newArticle['title'] = $title;
        $newArticle['content'] = $text;
        $table = $blog->tableName;
        $result = $blog->editRecord($table, 'id', $id, $newArticle);
        return $result;
    }
    
    
    
    /**
     * удаление записи
     * @param $name - название поля
     * @param $value - значение поля, по которым ищется удаляемый элемент 
     */
    public static function deleteArticle($name, $value) {
        $blog = new Articles();
        $table = $blog->tableName;
        $result = $blog->deleteRecord($table, $name, $value);
        return $result;
    }
    
    // отрезает кусок записи для вывода в списке
    // если запись короткая - то не отрезает 
    public static function cutText($content, $id) {
        // удаляем тэги
        $post = strip_tags($content);
        $l = iconv_strlen($post,'UTF-8');
        // короткие посты не обкусываем 
        $lmax = 300;
        if ($l<$lmax) {
            return $post;
        }
        else {
            // будет скрывать часть строки с точки, запятой или скобки, за которыми идет пробел
            $reg = "/[\.,)]\s/";
            $arrstr = preg_split($reg, $post,-1, PREG_SPLIT_OFFSET_CAPTURE);
            $n = count($arrstr);
    
            for ($i=0; $i<$n; $i++) {
                $pos = $arrstr[$i][1];                
                if ($pos>$lmax) break;        
            }
            $str = substr($post, 0, $pos);
            $str = $str.'<a href="article?id='.$id.'">Читать дальше</a>';
            return $str;    
        }
    }
    /**
     * определяет количество страниц, а которых выодятся записи
     * используется глобальная константа NPERPAGE -количепство записей на странице
     * @return integer
     */
    public static function npage() {
        $blog = new Articles();
        $table = $blog->tableName;
        // получаем колтчество статей
        $nart = $blog->countRecords($table);
        // теперь надо поделить на число записей на странице
        // и округлить в большую сторону
        $n = ceil($nart/NPERPAGE);
        return $n;
    }
    
    /**
     * выбирает статьи со страницы с заданным номером
     * @param $page integer
     * @return array
     */
    
    public static function pageArticles($page) {
        // количество страниц
        $n = self::npage();
        $blog = new Articles();
        $table = $blog->tableName;
        // если страница всего одна, то не заморачиваемся 
        if($n==1) {
            $articlesAll = $blog->selectAllArticlesSort();
            return $articlesAll;
        }    
        // страниц несколько и начинается самое интересное
        // это количество записей, которые надо выбрать  
        $nart = NPERPAGE;
        $nfirst = NPERPAGE*($page-1);
        // теперь можно вызывать функцию
        $result = $blog->selectArticlesSortLimit($nfirst, $nart);
        return $result;
    }
    
}

?>