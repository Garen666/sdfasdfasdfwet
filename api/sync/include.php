<?php
/**
 * Синхронизация дефолтных значений в базу данных
 */
try {
    SQLObject::TransactionStart();

    // всем текущим settings ставим tabname='', чтобы скрыть их
    $settings = new XShopSettings();
    while ($x = $settings->getNext()) {
        $x->setTabname('');
        $x->update();
    }

    // синхронизируем данные в таблице settings
    $sync = new SQLObjectSync_Data(new XShopSettings());

    // --- контакты ---

    $sync->addData(array(
    'key' => 'header-phone',
    ),
    array(
    'value' => '(067) 842-32-21, (050) 447-95-30, (044) 383-07-78',
    ),
    array(
    'name' => 'Телефоны',
    'type' => 'string',
    'tabname' => 'Контакты',
    'description' => 'Контактные телефоны, которые оборажаются на сайте'
    ));

    $sync->addData(array(
    'key' => 'header-icq',
    ),
    array(
    'value' => '626-191-284',
    ),
    array(
    'name' => 'ICQ',
    'type' => 'string',
    'tabname' => 'Контакты',
    'description' => 'ICQ, которые оборажаются на сайте'
    ));

    $sync->addData(array(
    'key' => 'header-skype',
    ),
    array(
    'value' => 'webproduction_sales',
    ),
    array(
    'name' => 'skype',
    'type' => 'string',
    'tabname' => 'Контакты',
    'description' => 'Skype, которые оборажаются на сайте'
    ));

    $sync->addData(array(
    'key' => 'company-address',
    ),
    array(
    'value' => '14000, Украина, Чернигов, пр. Победы, 129',
    ),
    array(
    'name' => 'Адрес компании',
    'type' => 'string',
    'tabname' => 'Контакты',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'shop-company',
    ),
    array(
    'value' => 'WebProduction',
    ),
    array(
    'name' => 'Название компании',
    'type' => 'string',
    'tabname' => 'Контакты',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'header-email',
    ),
    array(
    'value' => 'sales@webproduction.ua',
    ),
    array(
    'name' => 'Email',
    'type' => 'string',
    'tabname' => 'Контакты',
    'description' => 'Контактный email, который отображается на сайте'
    ));

    $sync->addData(array(
            'key' => 'work-time',
        ),
        array(
            'value' => 'Пн-Пт: 10.00-18.00',
        ),
        array(
            'name' => 'Время работы',
            'type' => 'string',
            'tabname' => 'Контакты',
            'description' => 'Время работы, которое отображается на сайте'
        ));

    // --- уведомления: email ---


    $sync->addData(array(
    'key' => 'feed-back-email',
    ),
    array(
    'value' => 'support@webproduction.ua',
    ),
    array(
    'name' => 'Email для функции Написать письмо',
    'type' => 'string',
    'tabname' => 'Уведомления: email',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'faq-email',
    ),
    array(
    'value' => 'support@webproduction.ua',
    ),
    array(
    'name' => 'Email для функции Вопрос-ответ',
    'type' => 'string',
    'tabname' => 'Уведомления: email',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'call-back-email',
    ),
    array(
    'value' => 'support@webproduction.ua',
    ),
    array(
    'name' => 'Email для функции Обратный звонок',
    'type' => 'string',
    'tabname' => 'Уведомления: email',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'email-guestbook',
    ),
    array(
    'value' => 'support@webproduction.ua',
    ),
    array(
    'name' => 'Email для новых отзывов о магазине',
    'type' => 'string',
    'tabname' => 'Уведомления: email',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'reverse-email',
    ),
    array(
    'value' => 'no-reply@webproduction.ua',
    ),
    array(
    'name' => 'Обратный адрес Email для писем',
    'type' => 'string',
    'tabname' => 'Уведомления: email',
    'description' => 'Адрес с какого будет отправлятся письма пользователям'
    ));

    $sync->addData(array(
    'key' => 'email-orders',
    ),
    array(
    'value' => 'support@webproduction.ua',
    ),
    array(
    'name' => 'Email для уведомления о новых заказах',
    'type' => 'html',
    'tabname' => 'Уведомления: email',
    'description' => 'Укажите на какие email будут приходить информация о новых заказах. Укажите свои email, каждый в новой строке.'
    ));

    $sync->addData(array(
    'key' => 'email-tehnical',
    ),
    array(
    'value' => 'support@webproduction.ua',
    ),
    array(
    'name' => 'Email для технических уведомлений',
    'type' => 'html',
    'tabname' => 'Уведомления: email',
    'description' => 'Укажите на какие email будут приходить технические сообщения (например, обмен данными с XLS). Укажите свои email, каждый в новой строке.'
    ));

    // --- уведомления: шаблоны писем ---

    $sync->addData(array(
    'key' => 'letter-auto-feedback',
    ),
    array(
    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/auto-feedback.html'),
    ),
    array(
    'name' => 'Шаблон письма "Оставьте отзыв"',
    'type' => 'html',
    'tabname' => 'Уведомления: шаблоны',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'letter-signature',
    ),
    array(
    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/signature.html'),
    ),
    array(
    'name' => 'Шаблон подписи письма',
    'type' => 'html',
    'tabname' => 'Уведомления: шаблоны',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'letter-add-feedback',
    ),
    array(
    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/add-feedback.html'),
    ),
    array(
    'name' => 'Шаблон письма "Обратная связь"',
    'type' => 'html',
    'tabname' => 'Уведомления: шаблоны',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'letter-products-notice-of-availability',
    ),
    array(
    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/products-notice-of-availability.html'),
    ),
    array(
    'name' => 'Шаблон письма "Товар уже в наличии"',
    'type' => 'html',
    'tabname' => 'Уведомления: шаблоны',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'letter-registration',
    ),
    array(
    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/registration.html'),
    ),
    array(
    'name' => 'Шаблон письма "Регистрация"',
    'type' => 'html',
    'tabname' => 'Уведомления: шаблоны',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'letter-remindpassword',
    ),
    array(
    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/remindpassword.html'),
    ),
    array(
    'name' => 'Шаблон письма "Восстановление пароля"',
    'type' => 'html',
    'tabname' => 'Уведомления: шаблоны',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'letter-shop-faq-question',
    ),
    array(
    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-faq-question.html'),
    ),
    array(
    'name' => 'Шаблон письма "Новый вопрос в раздел FAQ"',
    'type' => 'html',
    'tabname' => 'Уведомления: шаблоны',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'letter-shop-faq-answer',
    ),
    array(
    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-faq-answer.html'),
    ),
    array(
    'name' => 'Шаблон письма "Ответ на ваш вопрос в раздел FAQ"',
    'type' => 'html',
    'tabname' => 'Уведомления: шаблоны',
    'description' => ''
    ));


    $sync->addData(array(
    'key' => 'letter-shop-guestbook-answer',
    ),
    array(
    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-guestbook-answer.html'),
    ),
    array(
    'name' => 'Шаблон письма "Ваш отзыв был опубликован в разделе Отзывы о магазине"',
    'type' => 'html',
    'tabname' => 'Уведомления: шаблоны',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'letter-shop-guestbook-response',
    ),
    array(
    'value' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-guestbook-response.html'),
    ),
    array(
    'name' => 'Шаблон письма "Новый отзыв в разделе Отзывы о магазине"',
    'type' => 'html',
    'tabname' => 'Уведомления: шаблоны',
    'description' => ''
    ));

    // --- интеграции ---

    $sync->addData(array(
    'key' => 'social-button',
    ),
    array(
    'value' => '1',
    ),
    array(
    'name' => 'Отображать кнопки для социальных сетей',
    'type' => 'boolean',
    'tabname' => 'Интеграции',
    'description' => 'Показывать кнопки социальных сетей (Вконтакте, Однакласники, Facebook, ...) на странице товара'
    ));

    $sync->addData(array(
    'key' => 'interkassa-shopid',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'InterKassa.com: ik_shop_id',
    'type' => 'string',
    'tabname' => 'Интеграции',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'interkassa-secretkey',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'InterKassa.com: secret key',
    'type' => 'string',
    'tabname' => 'Интеграции',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'integration-cloudim',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'CloudIM: код интеграции',
    'type' => 'html',
    'tabname' => 'Интеграции',
    'description' => 'Позволяет добавить on-line чат системы CloudIM'
    ));

    $sync->addData(array(
    'key' => 'integration-googleanalytics',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'Код интеграции с Google Analytics',
    'type' => 'html',
    'tabname' => 'Интеграции',
    'description' => 'Позволяет добавить код сервиса Google Analytics'
    ));

    $sync->addData(array(
    'key' => 'integration-google-wmt',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'Meta-тег для подтверждения прав на Google WebMaster Tools',
    'type' => 'html',
    'tabname' => 'Интеграции',
    'description' => 'Позволяет добавить код для подверждения правообладаниея'
    ));

    $sync->addData(array(
    'key' => 'integration-yandex-wmt',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'Meta-тег для подтверждения прав на Yandex WebMaster Tools',
    'type' => 'html',
    'tabname' => 'Интеграции',
    'description' => 'Позволяет добавить код для подверждения правообладания'
    ));

    $sync->addData(array(
    'key' => 'integration-yandex-metrika-token',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'Яндекс.Метрика auth token',
    'type' => 'string',
    'tabname' => 'Интеграции',
    'description' => 'Для построения отчетов Воронка продаж и т.д.'
    ));

    $sync->addData(array(
    'key' => 'integration-yandex-metrika-counterid',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'Яндекс.Метрика counter ID',
    'type' => 'string',
    'tabname' => 'Интеграции',
    'description' => 'Для построения отчетов Воронка продаж и т.д.'
    ));

    $sync->addData(array(
    'key' => 'integration-liveinternet',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'Код интеграции с LiveInternet',
    'type' => 'html',
    'tabname' => 'Интеграции',
    'description' => 'Позволяет добавить код сервиса LiveInternet'
    ));

    $sync->addData(array(
    'key' => 'integration-yandex-counter',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'Интеграциия с Яндекс.Счетчик',
    'type' => 'html',
    'tabname' => 'Интеграции',
    'description' => 'Счетчик посещаемости веб-сайтов, и анализа поведения пользователей.'
    ));

    $sync->addData(array(
    'key' => 'facebook-widget',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'Facebook Social Widget',
    'type' => 'html',
    'tabname' => 'Интеграции',
    'description' => 'Позволяет добавить виджет facebook.com'
    ));

    $sync->addData(array(
    'key' => 'integration-comments',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'Интеграция с системой комментариев',
    'type' => 'html',
    'tabname' => 'Интеграции',
    'description' => 'Вставьте сюда код виджета комментариев facebook, vk.com, disqus или другой. Форма комментирования появиться в каждом товаре.'
    ));



    // Платежная система (LiqPay)
    $sync->addData(array(
            'key' => 'public-key',
        ),
        array(
            'value' => '',
        ),
        array(
            'name' => 'LiqPay: public key',
            'type' => 'string',
            'tabname' => 'Интеграции',
            'description' => 'Позволяет настроить платежную систему, для оплаты заказа. '
        ));

    $sync->addData(array(
            'key' => 'private-key',
        ),
        array(
            'value' => '',
        ),
        array(
            'name' => 'LiqPay: private key',
            'type' => 'string',
            'tabname' => 'Интеграции',
            'description' => 'Позволяет настроить платежную систему, для оплаты заказа. '
        ));

    // --- встроенные модуля и функции ---
    $sync->addData(array(
    'key' => 'shop-auth-for-order',
    ),
    array(
    'value' => '0',
    ),
    array(
    'name' => 'Требуется ли авторизация для оформления заказа',
    'type' => 'boolean',
    'tabname' => 'Встроенные функции',
    'description' => 'Данная опция позовляет включить/выключить режим продажи товара незарегестрированным пользователям'
    ));

    $sync->addData(array(
    'key' => 'response',
    ),
    array(
    'value' => 1,
    ),
    array(
    'name' => 'Отоброжать блок с последними отзывами из раздела "Отзывы о магазине"',
    'type' => 'boolean',
    'tabname' => 'Встроенные функции',
    'description' => 'Настройка отображения блока "Отзывы о нас" на сайте'
    ));

    $sync->addData(array(
    'key' => 'response-maxcount',
    ),
    array(
    'value' => 3,
    ),
    array(
    'name' => 'Блок отзывов: максимальное количество отоброжаемых отзывов',
    'type' => 'string',
    'tabname' => 'Встроенные функции',
    'description' => 'Позволяет настроить количество выводимых записей в блок "Отзывы о нас"'
    ));

    $sync->addData(array(
    'key' => 'shop-onpage',
    ),
    array(
    'value' => '12',
    ),
    array(
    'name' => 'Количество товаров на странице',
    'type' => 'string',
    'tabname' => 'Встроенные функции',
    'description' => ''
    ));

    // --- SEO ---

    $sync->addData(array(
    'key' => 'seo-meta-description-product',
    ),
    array(
    'value' => '[avail] [price] грн! Бесплатная доставка по Украине. [phones]. [slogan].',
    ),
    array(
    'name' => 'Шаблон meta description для товара',
    'type' => 'html',
    'tabname' => 'SEO',
    ));

    $sync->addData(array(
    'key' => 'seo-meta-description-category',
    ),
    array(
    'value' => '[count] товаров! Бесплатная доставка по Украине. [phones]. [slogan].',
    ),
    array(
    'name' => 'Шаблон meta description для категории',
    'type' => 'html',
    'tabname' => 'SEO',
    ));

    // --

    $sync->addData(array(
    'key' => 'seo-title-product',
    ),
    array(
    'value' => '[name] - купить, цена, отзывы, доставка. [categorypath] [slogan]',
    ),
    array(
    'name' => 'Шаблон title для товара',
    'type' => 'html',
    'tabname' => 'SEO',
    ));

    $sync->addData(array(
    'key' => 'seo-title-category',
    ),
    array(
    'value' => '[categorypath]. Купить, сравнить, цены, отзывы, доставка. [slogan]',
    ),
    array(
    'name' => 'Шаблон title для категории',
    'type' => 'html',
    'tabname' => 'SEO',
    ));

    $sync->addData(array(
    'key' => 'seo-title-tag',
    ),
    array(
    'value' => '[name], купить, сравнить, цены, отзывы, доставка. [slogan]',
    ),
    array(
    'name' => 'Шаблон title для SEO-тега',
    'type' => 'html',
    'tabname' => 'SEO',
    ));

    // --- Текста ---

    $sync->addData(array(
    'key' => 'characteristics-message',
    ),
    array(
    'value' => 'Характеристики и комплектация товара могут изменяться производителем без уведомления.',
    ),
    array(
    'name' => 'Информация об измении комплектации',
    'type' => 'html',
    'tabname' => 'Текста',
    'description' => 'Данный текст будет отображается в нижней части карточки товара.'
    ));

    $sync->addData(array(
    'key' => 'used-user-info',
    ),
    array(
    'value' => 'Хранение и использование компанией «WebProduction» предоставленных пользователями личных данных полностью соответствует действующему законодательству Украины о неприкосновенности личной информации. Личные данные пользователей не предоставляются третьим лицам, но сохраняются для предоставления услуги продажи товаров, представленных на нашем сайте. Компания оставляет за собой право использовать данную информацию в маркетинговых целях.',
    ),
    array(
    'name' => 'Соглашение о предоставлении личных данных',
    'type' => 'html',
    'tabname' => 'Текста',
    'description' => 'Информация, которую клиент видет при регистрации, редактировании своего профиля и офрмлении заказа'
    ));

    $sync->addData(array(
    'key' => 'order-good-message',
    ),
    array(
    'value' => 'Спасибо за ваш заказ! В ближайшее время с вами свяжется наш менеджер.',
    ),
    array(
    'name' => 'Сообщение после удачного оформления заказа',
    'type' => 'html',
    'tabname' => 'Текста',
    'description' => 'После удачного оформления заказа будет выводится это сообщение'
    ));

    $sync->addData(array(
    'key' => 'registration-good-message',
    ),
    array(
    'value' => 'Вы успешно зарегистрированы и вошли.',
    ),
    array(
    'name' => 'Сообщение после удачной регистрации пользователя',
    'type' => 'html',
    'tabname' => 'Текста',
    'description' => 'После удачной регистрации будет выводится это сообщение'
    ));

    $sync->addData(array(
    'key' => 'logout-good-message',
    ),
    array(
    'value' => 'Вы успешно вышли из системы.',
    ),
    array(
    'name' => 'Сообщение после удачного выхода из системы',
    'type' => 'html',
    'tabname' => 'Текста',
    'description' => 'После выхода из системы будет выводиться это сообщение'
    ));

    $sync->addData(array(
    'key' => 'warranty',
    ),
    array(
    'value' => '<ul>
    <li>12 месяцев официальной гарантии от производителя.</li>
    <li>обмен/возврат товара в течение 14 дней</li>
    </ul>',
    ),
    array(
    'name' => 'Гарантии на товар',
    'type' => 'html',
    'tabname' => 'Текста',
    'description' => 'Позволяет добавить сообщение о гарантии по умолчанию'
    ));

    $sync->addData(array(
    'key' => 'payment',
    ),
    array(
    'value' => '<ul>
    <li>товара может производится по факту получения</li>
    </ul>',
    ),
    array(
    'name' => 'Оплата товара',
    'type' => 'html',
    'tabname' => 'Текста',
    'description' => 'Позволяет добавить сообщение об оплате товара по умолчанию'
    ));


    $valueTimeArray = array(0.5,24,168);
    for ($j=1;$j<=5;$j++) {
        $valueBody = '';

        if ($j<=3) { // по умолчанию три шаблона заполнены
            $valueBody = '
Subject: {|$userName|}, у Вас незавершённая покупка

Здравствуйте, {|$userName|}!<br />
<br />

Спасибо, что выбрали наш магазин, но для того чтобы получить товар, Вам нужно завершить покупку.<br />
Ваш товар всё ещё находится в корзине, осталось только <a href="{|$basketUrl|}">оформить заказ</a>
<br />
<br />
<strong>Сумма заказа: </strong>{|$basketSum|} {|$currency|}
<br />
<a href="{|$basketUrl|}" style="background-color: #00FF00; padding: 5px; color: #FFFFFF; font-size:16px; text-decoration:none;">Оформить заказ</a>

<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr class="tab_tr_head">
        <td><strong>Товар</strong></td>
        <td><strong>Фото</strong></td>
        <td width="120" align="center"><strong>Цена</strong></td>
        <td width="80" align="center"><strong>Количество</strong></td>
        <td width="120" align="center"><strong>Сумма</strong></td>
    </tr>
    {|foreach from=$basketsArray item="b"|}
    <tr>
        <td>
            {|$b.name|}
        </td>
        <td>
            <img src="{|$b.image|}" width=100 >
        </td>
        <td align="right">
            {|$b.price|} {|$currency|}
        </td>
        <td align="center">
            {|$b.count|}
        </td>
        <td align="right">
            {|$b.sum|} {|$currency|}
            {|if $b.comment|}
                <br />
                {|$b.comment|}
            {|/if|}
        </td>
    </tr>
    {|/foreach|}
</table>

{|$signature|}
            ';
        }
        $sync->addData(array(
                'key' => 'lost_basket_letter_body_'.$j,
            ),
            array(
                'value' => $valueBody,
            ),
            array(
                'name' => 'Письмо-напоминание о забытой корзине №'.$j,
                'type' => 'html',
                'tabname' => 'Текста',
                'description' => 'Автоматически отправляется письмо-напоминание о том что пользователь не оформил заказ.
                Необходимо установить также время отправления соответствующего письма'
            ));

        $sync->addData(array(
                'key' => 'lost_basket_letter_time_'.$j,
            ),
            array(
                'value' => !empty($valueTimeArray[$j-1]) ? $valueTimeArray[$j-1] : '',
            ),
            array(
                'name' => 'Письмо-напоминание о забытой корзине №'.$j. ' - время отправки письма',
                'type' => 'string',
                'tabname' => 'Текста',
                'description' => 'Укажите через сколько часов (использовать десятичную точку вместо запятой) после ухода
                 с сайта пользователю отправится соответствующее письмо
                 соответствующее письмо'
            ));
    }



    $sync->addData(array(
    'key' => 'seo-text-in-index-page',
    ),
    array(
    'value' => '',
    ),
    array(
    'name' => 'Текст на главную',
    'type' => 'text',
    'tabname' => 'Текста',
    'description' => 'SEO-текст вверху страницы'
    ));

    $sync->addData(array(
    'key' => 'copyright',
    ),
    array(
    'value' => 'Copyright &copy; 2010-'.date('Y').' <a href="http://webproduction.ua/" target="_blank">WebProduction&trade;</a>',
    ),
    array(
    'name' => 'Copyright',
    'type' => 'html',
    'tabname' => 'Текста',
    'description' => ''
    ));

    // --- Настройки магазина ---

    $sync->addData(array(
    'key' => 'image-format',
    ),
    array(
    'value' => 'jpg',
    ),
    array(
    'name' => 'Формат хранения изображений (в том числе thumbnail-файлов)',
    'type' => 'string',
    'tabname' => 'Настройки магазина',
    'description' => 'Доступны: jpg, png. По умолчанию - jpg. Некоторые картинки все равно будут в формате PNG.'
    ));


    $sync->addData(array(
    'key' => 'user-account-activate',
    ),
    array(
    'value' => 1,
    ),
    array(
    'name' => 'Активация аккаунта – подтверждение регистрации на сайте',
    'type' => 'boolean',
    'tabname' => 'Настройки магазина',
    'description' => 'Включение/отключение подтверждения регистрации через e-mail'
    ));



    $sync->addData(array(
    'key' => 'favicon',
    ),
    array(
    'value' => '/_images/favicon.ico',
    ),
    array(
    'name' => 'Favicon',
    'type' => 'image',
    'tabname' => 'Настройки магазина',
    'description' => 'Изображение, которое  отображается браузером в адресной строке перед URL страницы'
    ));

    $sync->addData(array(
        'key' => 'background-image',
    ),
    array(
        'value' => '', // /_images/bg.jpg
    ),
    array(
        'name' => 'Фоновая картинка',
        'type' => 'image',
        'tabname' => 'Настройки магазина',
        'description' => 'Изображение, которое  отображается как фон сайта (Рекомендованные размеры: ширина - 1913px, высота - 1885px)'
    ));

    $sync->addData(array(
            'key' => 'image-404',
        ),
        array(
            'value' => '',
        ),
        array(
            'name' => 'Картинка 404',
            'type' => 'image',
            'tabname' => 'Настройки магазина',
            'description' => 'Изображение, которое отображается, когда не найдена страница на сайте.'
        ));


    $sync->addData(array(
    'key' => 'shop-name',
    ),
    array(
    'value' => 'OneClick',
    ),
    array(
    'name' => 'Название магазина',
    'type' => 'string',
    'tabname' => 'Настройки магазина',
    'description' => ''
    ));

    $sync->addData(array(
    'key' => 'shop-slogan',
    ),
    array(
    'value' => 'OneClick',
    ),
    array(
    'name' => 'Слоган магазина',
    'type' => 'string',
    'tabname' => 'Настройки магазина',
    'description' => ''
    ));


    $sync->sync();

    // бизнес-процесс
    $tmp = new XShopOrderStatus();
    if (!$tmp->select()) {
        $sync = new SQLObjectSync_Data(new XShopOrderCategory());

        $sync->addData(array(
                'name' => 'Новый Заказ'
            ),
            array(
                'default' => 1,
            ));

        $sync->sync();
    }

    // статус заказов
    $tmp = new XShopOrderStatus();
    if (!$tmp->select()) {
        $sync = new SQLObjectSync_Data(new XShopOrderStatus());

        $sync->addData(array(
        'name' => 'Новый'
        ),
        array(
        'categoryid' => 1,
        'default' => 1,
        'message' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-order-new.html'),
        'messageadmin' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-order-new-admin.html'),
        // 'colour' => '#F5D4C9'
        ));

        $sync->sync();
    }




    // синхронизация списка валют
    $tmp = new XShopCurrency();
    if (!$tmp->select()) {
        $sync = new SQLObjectSync_Data(new XShopCurrency());

        $sync->addData(
        array('name' => 'UAH'),
        array('symbol' => 'грн.', 'default' => 1, 'rate' => 1, 'sort' => 0)
        );
        $sync->addData(
        array('name' => 'USD'),
        array('symbol' => '$', 'default' => 0, 'rate' => 8.78, 'sort' => 1)
        );
        $sync->addData(
        array('name' => 'RUB'),
        array('symbol' => 'р.', 'default' => 0, 'rate' => 0.25, 'sort' => 2)
        );
        $sync->addData(
        array('name' => 'EUR'),
        array('symbol' => '€', 'default' => 0, 'rate' => 12, 'sort' => 3)
        );
        $sync->sync();
    }

    //Установление дефолтной валюты
    //@TODO нужно делать полный пересчет магазина при смнене базовой валюты
    $tmp = new XShopCurrency();
    $currencyDefaultName = Engine::Get()->getConfigFieldSecure('currency-default');
    if ($currencyDefaultName) {
        try {
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
            if ($currencyDefaultName != $currencySystem->getName()) {
                $currency = Shop::Get()->getCurrencyService()->getCurrencyByName($currencyDefaultName);
                $currency->setDefault(1);
                $currency->update();

                $currencySystem->setDefault(0); //устанавливаем в 0 предыдущию базовую валюту
                $currencySystem->update();

            }

        } catch (Exeption $e) {
            //Если нету системной валюты установим
            try {
                $currency = Shop::Get()->getCurrencyService()->getCurrencyByName($currencyDefaultName);
                $currency->setDefault(1);
                $currency->update();
            } catch (Exeption $e) {
                if (PackageLoader::Get()->getMode('debug')){
                    print $e;
                }
            }

        }
    }

    SQLObject::TransactionCommit();
} catch (Exception $ge) {
    SQLObject::TransactionRollback();
    throw $ge;
}
