<?php 
    session_start();
    
    include_once "connectBD.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sliderStyle.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Computer Shop</title>
</head>

<body <? if($_SESSION['set_scroll'] == 1) {
    ?> 
        onload="document.getElementsByName('scroll-point')[0].scrollIntoView(1)";
    <?php }
       unset($_SESSION['set_scroll']); 
    ?>>
    <div class="wrapper">
        <header>
            <div class="top__info">
                <div class="content">
                    <div class="info_content">
                        <div class="city">рязань</div>
                        <div class="info_nav">
                            <a href="#"><span class="info_nav_label">магазин</span></a>
                            <a href="#"><span class="info_nav_label">акции</span></a>
                            <a href="#"><span class="info_nav_label">помощь</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="main_header">
                <div class="content">
                    <div class="header_content">
                        <div class="header_logo">
                            <a href="../php/index.php"><img src="../img/logo.jpg" alt="" class="img"></a>
                        </div>
                        <div class="header_search">
                            <form action="#" method="post">
                                <input type="text" name="search" placeholder="Поиск по сайту">
                            </form>
                        </div>
                        <div class="header-basket-container">
                            <a href="#" class="header_basket" onclick="toggleBasket()" id="basket-ref">
                                <img src="../img/basket.svg" alt="basket_logo">
                                <span class="header_label">корзина</span>
                            </a>
                            <div class="header-basket-form profile-form-inactive" id="basket-div">
                                <div class="basket-form-header active">
                                    <span>Корзина</span>
                                </div>
                                <div class="basket-container">
                                    <?php
                                        include_once "basket.php";
                                        $basket = $_SESSION['basket'];
                                        if(isset($_SESSION['current_user'])) {
                                            if(count($basket) > 0) {
                                                ?>
                                                <form action="../php/deleteBasket.php" method="post">
                                                    <?php
                                                        while($item = mysqli_fetch_assoc($basket)) {
                                                                $id = $item['id_prod'];
                                                                $id_prod = mysqli_query($db, "SELECT `name` FROM `Products` WHERE `id` = $id");
                                                                $item_name = mysqli_fetch_assoc($id_prod);
                                                            ?>
                                                            <div class="basket-item">
                                                                <input type="checkbox" name="item[]" value="<?php echo $item['id'];?>">
                                                                <div class="item-name">
                                                                    <?php 
                                                                        echo $item_name['name'];
                                                                        echo " ".$item['i_count']."шт.";
                                                                    ?>
                                                                </div>

                                                            </div>
                                                            <?
                                                                unset($id_prod);
                                                                unset($item_name);
                                                        }                                                
                                                    ?>
                                                    <div class="basket-buttons">
                                                        <input type="submit" name="delete" value="Очистить">
                                                        <input type="submit" name="out" value="Купить">
                                                    </div>
                                                </form>
                                                <?php
                                            }
                                        } else {
                                            echo "<center>Авторизуйтесь</center>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="header-profile-container">
                            <?php
                                if (isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 0) {
                                    ?>
                                        <a href="#" class="header_profile" onclick="toggleUserMenu()" id="user-ref">
                                            <img src="../img/user.svg" alt="profile_logo">
                                            <span class="header_label"><?php echo $_SESSION['current_user']; ?></span>
                                        </a>
                                        <div class="header-profile-user profile-form-inactive" id="user-div">
                                            <?php 
                                                if($_SESSION['user_type'] == 1) {
                                                    ?>
                                                    <div class="header-profile-admin">
                                                        <a href="#" class="header-profile-nav" onclick="callAddForm()"><span>Добавить товар</span></a>    
                                                        <hr>
                                                        <form action="../php/unlogin.php" method="post">
                                                            <div class="header-profile-nav"><input type="submit" value="Выйти из профиля"></div>
                                                        </form> 
                                                        </div>
                                                    <?php
                                                } else if($_SESSION['user_type'] == 0) {
                                                    ?>
                                                    <div class="header-profile-common">   
                                                        <hr>
                                                        <form action="../php/unlogin.php" method="post">
                                                            <div class="header-profile-nav"><input type="submit" value="Выйти из профиля"></div>
                                                        </form> 
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    <?php
                                } 
                                else {
                                ?>
                                <a href="#" class="header_profile
                                <?php
                                    if($_SESSION['registration'] == 1 || $_SESSION['authorisation'] == 1) {
                                        echo " profile-form-active-ref";
                                    }
                                    ?>" onclick="toggleLoginForm()" id="login-ref">
                                    <img src="../img/user.svg" alt="profile_logo">
                                    <span class="header_label">личный кабинет</span>
                                </a>
                                <div class="header-profile-form 
                                <?php
                                if($_SESSION['registration'] == 0 && $_SESSION['authorisation'] == 0) {
                                    echo " profile-form-inactive";
                                }
                                ?>" id="login-div">
                                <div class="header-profile-login
                                    <?php
                                    if($_SESSION['registration'] == 1) {
                                        echo " profile-form-inactive";
                                    } 
                                    ?>" id="login-form">
                                    <div class="profile-form-header">
                                        <span>Авторизация</span>
                                        /
                                        <span id="active-span" onclick="toggleRegistration()">Регистрация</span>
                                    </div>
                                    <form action="../php/login.php" method="post" id="profile-form">
                                        <div class="
                                        <?php
                                            if($_SESSION['authorisation'] == 1) {
                                                if($_SESSION['login_wrong'] == 1) {
                                                    echo " error-input-tag";
                                                }
                                            }
                                        ?>"><input type="text" name="login" placeholder="login"/></div>
                                        <div class="
                                        <?php
                                            if($_SESSION['authorisation'] == 1) {
                                                if($_SESSION['pass_wrong'] == 1) {
                                                    echo " error-input-tag";
                                                }
                                            }
                                        ?>"><input type="password" name="password" id="pass" placeholder="password"/></div>
                                        <div class="profile-buttons">
                                            <input type="submit" value="Войти"/>
                                        </div>
                                    </form>
                                    </div>
                                    <div class="header-profile-registration
                                    <?php
                                    if($_SESSION['registration'] == 0) {
                                        echo " profile-form-inactive";
                                    }
                                    ?>" id="registration-form">
                                    <div class="profile-form-header">
                                        <span id="active-span" onclick="toggleRegistration()">Авторизация</span>
                                        /
                                        <span>Регистрация</span>
                                    </div>
                                    <form action="../php/registration.php" method="post" id="profile-form">
                                        <div class="
                                        <?php 
                                            if($_SESSION['registration'] == 1) {
                                                $errors = $_SESSION["errors"];
                                                if($errors["login_lenght"] == 1 || $errors['login_compare']) 
                                                    echo "error-input-tag-login";
                                            }
                                        ?>">
                                        <input type="text" name="login" placeholder="login"/></div>
                                        <div class=""><input type="email" name="email" placeholder="e-mail"/></div>
                                        <input type="password" name="password" id="pass" placeholder="password"/>
                                        <div class="profile-buttons">
                                            <input type="submit" value="Зарегестрироваться"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header_catalog">
                <div class="catalog_nav content">
                    <a href="#" class="catalog_item_reference">
                        <div class="catalog_item">
                            <img src="" alt="" class="catalog_item_logo">
                            <div class="span catalog_label">видеокарта</div>
                        </div>
                    </a>
                    <a href="#" class="catalog_item_reference">
                        <div class="catalog_item">
                            <img src="" alt="" class="catalog_item_logo">
                            <div class="span catalog_label">процессор</div>
                        </div>
                    </a>
                    <a href="#" class="catalog_item_reference">
                        <div class="catalog_item">
                            <img src="" alt="" class="catalog_item_logo">
                            <div class="span catalog_label">память</div>
                        </div>
                    </a>
                    <a href="#" class="catalog_item_reference">
                        <div class="catalog_item">
                            <img src="" alt="" class="catalog_item_logo">
                            <div class="span catalog_label">питание и охлаждение</div>
                        </div>
                    </a>
                    <a href="#" class="catalog_item_reference">
                        <div class="catalog_item">
                            <img src="" alt="" class="catalog_item_logo">
                            <div class="span catalog_label">прочая переферия</div>
                        </div>
                    </a>
                    <a href="#" class="catalog_item_reference">
                        <div class="catalog_item">
                            <img src="" alt="" class="catalog_item_logo">
                            <div class="span catalog_label">сборка</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="add-edit-content  profile-form-inactive" id="add-edit">
                <div class="add-edit-container">
                    <div class="add-form-content profile-form-inactive" id="add-div">
                        <div class="add-form-container">
                            <div class="add-edit-header">
                                <span>Добавить новый товар</span>
                            </div>
                            <div class="add-form">
                                <form action="../php/addProduct.php" method="post" enctype="multipart/form-data">
                                    <div class="add-edit-input"><input type="text" name="name" placeholder="Имя товара"/></div>
                                    <div class="add-edit-input"><input type="text" name="cost" placeholder="Стоимость"/></div>
                                    <div class="add-edit-input">
                                        <select name="type" id="">
                                            <option value="0">Видеокарта</option>
                                            <option value="1">Процессор</option>
                                            <option value="2">Память</option>
                                        </select>
                                    </div>
                                    <span>Выберите фото для товара</span>
                                    <div class="add-edit-input"><input type="file" accept=".jpg, .jpeg, .png" name="photo" id="photo"></div>
                                    <div class="add-edit-buttons">
                                        <div class="add-edit-input"><input type="reset" value="Сбросить"></div>
                                        <div class="add-edit-input"><input type="submit" value="Создать"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="close-form"><a href="#" onclick="closeAddForm()">X</a></div>
                        </div>
                    </div>
                    <div class="edit-form-content profile-form-inactive" id="edit-div">
                        <div class="edit-form-container">
                            <div class="add-edit-header">
                                <span>Отредактировать товар</span>
                            </div>
                            <div class="edit-form">
                                <form action="../php/changeProduct.php" method="post" enctype="multipart/form-data">
                                    <?php
                                        $item_id = $_SESSION['edit_id'];
                                        $result = mysqli_query($db, "SELECT * FROM `Products` WHERE `id` = '$item_id'");
                                        while($item = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <div class="add-edit-input"><input type="text" name="name" value="<?php echo $item['name'];?>"/></div>
                                    <div class="add-edit-input"><input type="text" name="cost" value="<?php echo $item['cost'];?>"/></div>
                                    <div class="add-edit-input">
                                        <select name="type" id="">
                                            <option value="0" <?php if($item['type'] == 0) {?> selected="selected" <?php;}?>>Видеокарта</option>
                                            <option value="1" <?php if($item['type'] == 1) {?> selected="selected"<?php;}?>>Процессор</option>
                                            <option value="2" <?php if($item['type'] == 2) {?> selected="selected"<?php;}?>>Память</option>
                                        </select>
                                    </div>
                                    <span>Выберите фото для товара</span>
                                    <div class="add-edit-input"><input type="file" accept=".jpg, .jpeg, .png" name="photo" id="photo"></div>
                                    <div class="add-edit-buttons">
                                        <input type="hidden" name="edit-id" value="<?php echo $item_id;?>">
                                        <div class="add-edit-input"><input type="reset" value="Очистить"></div>
                                        <div class="add-edit-input"><input type="submit" value="Принять"></div>
                                    </div>
                                    <img src="<?php echo $item['images']?>" alt="" class="edit-img">
                                    <?php }
                                    ?>
                                </form>
                            </div>
                            <div class="close-form"><a href="#" onclick="closeEditForm()">X</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="main__body">
            <div class="container content">
                <div id="content-slider">
                    <div id="slider">
                        <!-- Контейнер для слайдера -->
                        <div id="mask">
                            <!-- Маска -->
                            <ul>
                                <li id="first" class="firstanimation">
                                    <!-- ID для всплывающей подсказки и класс для анимации -->
                                    <a href="#"> <img src="../img/1.jpg" alt="Cougar" /> </a>
                                    <div class="info">
                                        <div>Акция №0</div>
                                        <div>Бесплатная доставка</div>
                                    </div>
                                </li>

                                <li id="second" class="secondanimation">
                                    <a href="#"> <img src="../img/2.jpg" alt="Lions" /> </a>
                                    <div class="info">
                                        <div>Акция №1</div>
                                        <div>Платная доставка</div>
                                    </div>
                                </li>

                                <li id="third" class="thirdanimation">
                                    <a href="#"> <img src="../img/3.jpg" alt="Snowalker" /> </a>
                                    <div class="info">
                                        <div>Акция №5</div>
                                        <div>Быстрая доставка</div>
                                    </div>
                                </li>

                                <li id="fourth" class="fourthanimation">
                                    <a href="#"> <img src="../img/4.jpg" alt="Howling" /> </a>
                                    <div class="info">
                                        <div>Акция №2</div>
                                        <div>Медленная доставка</div>
                                    </div>
                                </li>

                                <li id="fifth" class="fifthanimation">
                                    <a href="#"> <img src="../img/2.jpg" alt="Sunbathing" /> </a>
                                    <div class="info">
                                        <div>Акция №3</div>
                                        <div>Доставка?</div>
                                    </div>
                                </li>
                            </ul>

                        </div> <!-- Конец маски -->
                        <div class="progress-bar"></div> <!-- Строка выполнения-->
                    </div> <!-- Конец контейнера для слайдера -->
                </div>
            </div>
            <div class="pn__product">
                <div class="content">
                    <div class="slider__product__switch" id="slider-switch">
                        <div class="slider__product__pop">
                            <div class="slider__product">
                                <img src="../img/1.jpg" alt="">
                                <div class="slider__product__text">
                                    <div class="slider__product__label">
                                        <span>Процессор</span>
                                    </div>
                                    <div class="slider__product__price">
                                        <span>50 000</span>
                                    </div>
                                </div>
                                <a href="#" class="buy-button">
                                    <span>Купить</span>
                                </a>
                            </div>
                            <div class="slider__product">
                                <img src="../img/2.jpg" alt="">
                                <div class="slider__product__text">
                                    <div class="slider__product__label">
                                        <span>Накопитель</span>
                                    </div>
                                    <div class="slider__product__price">
                                        <span>5 000</span>
                                    </div>
                                </div>
                                <a href="#" class="buy-button">
                                    <span>Купить</span>
                                </a>
                            </div>
                            <div class="slider__product">
                                <img src="../img/3.jpg" alt="">
                                <div class="slider__product__text">
                                    <div class="slider__product__label">
                                        <span>Оперативная память</span>
                                    </div>
                                    <div class="slider__product__price">
                                        <span>6 000</span>
                                    </div>
                                </div>
                                <a href="#" class="buy-button">
                                    <span>Купить</span>
                                </a>
                            </div>
                            <div class="slider__product">
                                <a href="../html/item.html"><img src="../img/4.jpg" alt=""></a>
                                <div class="slider__product__text">
                                    <div class="slider__product__label">
                                        <span>Видеокарта</span>
                                    </div>
                                    <div class="slider__product__price">
                                        <span>75 000</span>
                                    </div>
                                </div>
                                <a href="#" class="buy-button">
                                    <span>Купить</span>
                                </a>
                            </div>
                        </div>
                        <div class="slider__product__new">
                            <div class="slider__product">
                                <img src="../img/1.jpg" alt="">
                                <div class="slider__product__text">
                                    <div class="slider__product__label">
                                        <span>Процессор</span>
                                    </div>
                                    <div class="slider__product__price">
                                        <span>50 000</span>
                                    </div>
                                </div>
                                <a href="#" class="buy-button">
                                    <span>Купить</span>
                                </a>
                            </div>
                            <div class="slider__product">
                                <img src="../img/2.jpg" alt="">
                                <div class="slider__product__text">
                                    <div class="slider__product__label">
                                        <span>Накопитель</span>
                                    </div>
                                    <div class="slider__product__price">
                                        <span>5 000</span>
                                    </div>
                                </div>
                                <a href="#" class="buy-button">
                                    <span>Купить</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a name="scroll-point"></a>
            <div class="main-catalog">
                <div class="content">
                    <div class="main-catalog-content">
                        <div class="something">
                            <span>Каталог</span>
                            <div class="main-catalog-nav">
                                <div class="catalog-nav-container">
                                    <form action="../php/sorting.php" method="post">
                                        <div class="catalog-nav-ref"><input type="submit" value="Видеокарты" name="0"></div>
                                        <div class="catalog-nav-ref"><input type="submit" value="Процессоры" name="1"></div>
                                        <div class="catalog-nav-ref"><input type="submit" value="Память" name="2"></div>
                                    </form>
                                    <a href="#" class="catalog-nav-ref">
                                        <div class="catalog-nav-item">Питание и охлаждение</div>
                                    </a>
                                    <a href="#" class="catalog-nav-ref">
                                        <div class="catalog-nav-item">Прочая переферия</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="main-catalog-container">
                            <?php
                                if(isset($_SESSION['sort']) && $_SESSION['sort'] == 1) {
                                    $sort_type = $_SESSION['sort_type'];
                                    $result = mysqli_query($db, "SELECT * FROM `Products` WHERE `type` = '$sort_type'");
                                    unset($_SESSION['sort']);
                                } else {
                                    $result = mysqli_query($db, "SELECT * FROM `Products`");
                                }
                                
                                if(isset($result)) {
                                    $rowCount = 3;
                                    echo "<div class=\"main-catalog-row\">";
                                    while($item = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <div class="main-catalog-item">
                                            <img src="<?php echo $item['images'] ?>" alt="">
                                            <div class="catalog-item-text">
                                                <div class="catalog-item-label">
                                                <span><?php echo $item['name'] ?></span>
                                                </div>
                                                <div class="catalog-item-price">
                                                    <span><?php echo $item['cost'] ?> руб</span>
                                                </div>
                                            </div>
                                                <?php
                                                    if($_SESSION['user_type'] == 1) {
                                                        ?>
                                                            <div class="edit-delete-buttons">
                                                                <form action="../php/startEdit.php" method="post" class="inside-form">
                                                                    <input type="submit" value="Редакт." name="<?php echo $item['id']?>" />
                                                                </form>
                                                                <form action="../php/deleteProduct.php" method="post" class="inside-form">
                                                                    <input type="submit" value="Удалить" name="<?php echo $item['id']?>" >
                                                                </form>
                                                            </div>
                                                            <!-- <a href="#" onclick="callEditForm()">Edit</a> -->
                                                        <?php
                                                        // $_SESSION['edit_id'] = $item['id'];
                                                    }
                                                ?>
                                                <form action="../php/addBasket.php" method="post">
                                                    <input type="hidden" name="idProduct" value="<?php echo $item['id'];?>">
                                                    <input type="submit" value="Купить" class="buy-button">
                                                </form>
                                            </div>
                                        <?php
                                        $rowCount--;
                                        if($rowCount == 0) {
                                            ?></div>
                                            <div class="main-catalog-row">
                                            <?php
                                            $rowCount = 3;
                                        }
                                    }
                                    ?></div><?php
                                }
                                unset($result);
                                unset($item);
                            ?>
                            <!-- <div class="main-catalog-row">
                                <div class="main-catalog-item">
                                    <img src="../img/4.jpg" alt="">
                                    <div class="catalog-item-text">
                                        <div class="catalog-item-label">
                                            <span>Видеокарта</span>
                                        </div>
                                        <div class="catalog-item-price">
                                            <span>75 000</span>
                                        </div>
                                    </div>
                                    <a href="../html/item.html" class="buy-button">
                                        <span>Купить</span>
                                    </a>
                                </div>
                                <div class="main-catalog-item">
                                    <img src="../img/1.jpg" alt="">
                                    <div class="catalog-item-text">
                                        <div class="catalog-item-label">
                                            <span>Процессор</span>
                                        </div>
                                        <div class="catalog-item-price">
                                            <span>50 000</span>
                                        </div>
                                    </div>
                                    <a href="#" class="buy-button">
                                        <span>Купить</span>
                                    </a>
                                </div>
                                <div class="main-catalog-item">
                                    <img src="../img/1.jpg" alt="">
                                    <div class="catalog-item-text">
                                        <div class="catalog-item-label">
                                            <span>Процессор</span>
                                        </div>
                                        <div class="catalog-item-price">
                                            <span>50 000</span>
                                        </div>
                                    </div>
                                    <a href="#" class="buy-button">
                                        <span>Купить</span>
                                    </a>
                                </div>
                            </div>
                            <div class="main-catalog-row">
                                <div class="main-catalog-item">
                                    <img src="../img/1.jpg" alt="">
                                    <div class="catalog-item-text">
                                        <div class="catalog-item-label">
                                            <span>Процессор</span>
                                        </div>
                                        <div class="catalog-item-price">
                                            <span>50 000</span>
                                        </div>
                                    </div>
                                    <a href="#" class="buy-button">
                                        <span>Купить</span>
                                    </a>
                                </div>
                                <div class="main-catalog-item">
                                    <img src="../img/1.jpg" alt="">
                                    <div class="catalog-item-text">
                                        <div class="catalog-item-label">
                                            <span>Процессор</span>
                                        </div>
                                        <div class="catalog-item-price">
                                            <span>50 000</span>
                                        </div>
                                    </div>
                                    <a href="#" class="buy-button">
                                        <span>Купить</span>
                                    </a>
                                </div>
                                <div class="main-catalog-item">
                                    <img src="../img/1.jpg" alt="">
                                    <div class="catalog-item-text">
                                        <div class="catalog-item-label">
                                            <span>Процессор</span>
                                        </div>
                                        <div class="catalog-item-price">
                                            <span>50 000</span>
                                        </div>
                                    </div>
                                    <a href="#" class="buy-button">
                                        <span>Купить</span>
                                    </a>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="logo">
                <img src="../img/logo.jpg" alt="">
            </div>
            <div class="footer-info">
                <a href="#" class="footer-reference">о компании</a>
                <a href="#" class="footer-reference">партнеры</a>
                <a href="#" class="footer-reference">оплата</a>
                <a href="#" class="footer-reference">акции</a>
                <a href="#" class="footer-reference">контакты</a>
                <a href="#" class="footer-reference">доставка</a>
            </div>
            <div class="footer-contact">
                <span>8 (800) 888 88 88</span>
                <span> EMAIL@EMAIL</span>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../js/slick.min.js"></script>
    <script src="../js/toggleScript.js"></script>
    <script src="../js/script.js"></script>
    <?php
        if(isset($_SESSION['edit']) && $_SESSION['edit'] == 1) {
            ?>
            <script>callEditForm();</script>
            <?
            unset($_SESSION['edit']);
        }    
    ?>
</body>

</html>