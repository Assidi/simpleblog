<?php

class MainController extends AbstractController {

    protected $title;
    
    
    public function __construct() {
        parent::__construct(new View(DIR_TMPL));
        // путь к директории с шаблонами
    }
    
    public function action404() {
        parent::action404();
        $this->title = 'Страница не найдена - 404';
        $content = $this->view->render('404', array(), true);
        $this->render($content);
    }
    
    // ошибка доступа, выводится при попытке войти на страницу администратора 
    public function action403() {        
        $this->title = 'Нет доступа';
        $content = $this->view->render('403', array(), true);
        $this->render($content);
    }
    
    // выводится, когда пароль неверен
    
    public function actionErrpass() {        
        $this->title = 'Пароль неверен';
        $content = $this->view->render('errpass', array(), true);
        $this->render($content);
    }
    
    // главная страница
    // вывод всех записей блога
    public function actionIndex() {
        $this->title = 'Мой блог';        
        // количество страниц
        $n = Articles::npage();        
        // какая страница вызывается
        if (isset($_GET['p'])) {
            $page = $_GET['p'];
            if(($page>$n) or ($page<=0)) $page=1;
        }
        else {
            $page = 1;
        }
        // все статьи
        //$articlesAll = Articles::allArticles();
        // одна страница статей
        $articlesPage = Articles::pageArticles($page);
        
        $content = $this->view->render('index', array('articlesAll'=>$articlesPage, 'n'=>$n, 'page'=>$page), true);        
        $this->render($content);
    }
    
    // одна статья блога
    public function actionArticle() {        
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $article = Articles::oneArticle($id);             
            if (!$article) {
                $this->action404();
            }   
            else {
                $this->title = $article['title'];
                $content = $this->view->render('article', array('article'=>$article), true);        
                $this->render($content); 
            }      
            
        }
        else {
            $this->action404();
        }
    }
    
    // редактирование записи 
     public function actionEdit() {
        if((app::isAdmin())) {
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                // проверяем, была ли отправлена форма или надо ее выводить 
                if (isset($_POST['title'])and isset($_POST['text'])) {
                    $title = $_POST['title'];
                    $text = $_POST['text'];
                    Articles::editArticle($id, $title, $text);  
                    $this->redirect('index'); 
                }
                else {                    
                    $article = Articles::oneArticle($id);  
                    if (!$article) {
                        $this->action404();
                    } 
                    else {
                        $this->title = 'Редактирование записи';        
                        $content = $this->view->render('edit', array('article'=>$article), true);
                        $this->render($content);
                    } 
                }
                    
            }
            else {
                $this->action404();
            }
            
        }
        // это конец проверки, админ или не админ 
        else {
            $this->action403();
        }
     }
    
    // удаление записи 
     public function actionDelete() {
        if((app::isAdmin())) {
            // есть, что удалять-то?
            if (isset($_GET['id'])){
                $id = intval($_GET['id']);
                Articles::deleteArticle('id', $id);  
                $this->redirect('index'); 
            }
            else {
                $this->action404();
            }
        }
        else {
            $this->action403();
        }
     }
    
    // добавление записи
    
    public function actionAdd() {
        if((app::isAdmin())) {
            // если данные отправлены - записываем
            if (isset($_POST['title'])and isset($_POST['text'])) {
                $title = $_POST['title'];
                $text = $_POST['text'];
                Articles::addArticle($title, $text);  
                $this->redirect('index'); 
            }
            // если еще нет - выводим форму
            else {
                $this->title = 'Новая запись';        
                $content = $this->view->render('add', array(), true);
                $this->render($content);    
            }
            
        }
        else {
            $this->action403();
        }
        
    }
    
    // вход в панель администратора
    public function actionLogin() {
        // смотрим, была ли отправка формы, если нет, то отправляем в форму, если да - проводит проверку 
        if (isset($_POST['login'])and isset($_POST['password'])) {            
            // форма была отправлена, проверяем данные
            if(app::login($_POST['login'], $_POST['password'])) {
                $this->redirect('index'); 
            }
            else {
                $this->actionErrpass(); 
            }
        }
        else {
            // форма еще не отправлена, посылаем в форму
            //$_SESSION['qq'] = 'Идем в форму';
            $this->title = 'Вход';               
            $content = $this->view->render('login', array(), true);
            $this->render($content);
        }
        
    }
    
    // вход в панель администратора
    public function actionLogout() {
        app::logout();
        $this->redirect('index'); 
    }
    
    protected function render($content) {
        $params = array();
        $params['title'] = $this->title;
        $params['content'] = $content;
        $this->view->render(MAIN_LAYOUT, $params);
    }
}

?>