Yii2-wishlist
==========
Модуль избранного для Yii2 фреймворка.


Установка
---------------------------------
Выполнить команду

```

```

Далее, мигрируем базу:

```
php yii migrate --migrationPath=vendor/halumein/yii2-wishlist/migrations
```

Подключение и настройка
---------------------------------
В конфигурационный файл приложения добавить модуль wishlist

И модуль (если хотите использовать виджеты)

```php
    'modules' => [
        'cart' => [
            'class' => 'halumein\wishlist\Module',
        ],
        //...
    ]
```

Виджеты
==========
В состав модуля входит несколько виджетов. Все работают аяксом.

```php

<?php
use halumein\wishlist\widgets\BuyButton;
?>

<?php /* Выведет кнопку "добавить в избранное" */ ?>
<?= WishlistButton::widget([
	'model' => $model
]) ?>

<?php /* Выведет кнопку "добавить в избранное" с пользовательскими параметрами */ ?>
<?= WishlistButton::widget([
	'model' => $model, // модель для добавления
	'text' => 'Добавить мой список', // свой текст кнопки
	'htmlTag' => 'a', // тэг
	'cssClass' => 'custom_class' // свой класс
    'cssClassInList' => 'custom_class' // свой класс для добавленного объекта
]) ?>

```

Дэфолтные css-стили
```css

.hal-wishlist-button {
    font-weight: 700;
}

.hal-wishlist-button:before {
    content: "\f08a";
    font: 400 15px/31px "FontAwesome";
    color: white;
    background: #929292; /* цвет сердечка */
    width: 30px;
    text-align: center;
    display: inline-block;
    height: 30px;
    margin: 0 6px 0 0;
    -moz-border-radius: 50px;
    -webkit-border-radius: 50px;
    border-radius: 50px;
}

.hal-wishlist-button:hover {
    cursor: pointer;
}

.in-list:before {
    background: #CC63B0; /* цвет сердечка */
}


```
