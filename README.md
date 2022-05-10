### ОАО «Коммерцбанк Таджикистана»
# Протокол взаимодействия партнера с интернет-эквайрингом

**Версия:** 3.0

**Дата:** 2022/03/18

## Содержание
1. [Общие сведения](#1-общие-сведения-использования-сервиса)
2. [Термины и определения](#2-термины-и-определения)
3. [Описание API](#3-описание-api)<br />
    3.1. [Инициализация ордера](#31-инициализация-ордера)<br />
    3.2. [Проверка статуса (deprecated)](#32-проверка-статуса-платежа-deprecated)<br />
    3.3. [Получение информации об ордере](#33-получение-информации-об-ордере)<br />
4. [Составляющие объекты](#4-составляющие-объекты)
5. [Примеры](#5-примеры)

## 1. Общие сведения использования сервиса
Данный репозиторий представляет собой описание протокола взаимодействия партнёра с интернет-эквайрингом банковских карт «Корти Милли» от ОАО «Коммерцбанк Таджикистана» (далее, Банк).

### 1.1. Платежная форма
Платежная форма сервиса реализована на WEB-принципах, работает с реальными объектами и обладает предсказуемым поведением. Платежная форма позволяет создавать транзакции зачисляя денежные средства на банковский счёт партнёра.

### 1.2. API
API сервиса построена на REST-принципах, работает с реальными объектами и обладает предсказуемым поведением. API позволяет отправлять заявки на проведение транзакций, получать информацию о совершенных транзакциях.

API сервиса в качестве основного протокола использует протокол HTTP.

API сервиса принимает GET-запросы. API всегда возвращает ответ в формате JSON.

Примечание: Количество JSON-атрибутов в ответах сервиса могут быть изменены или расширены динамично, сохраняя обратную совместимость без уведомления пользователей протокола.

### 1.3. Правила формирования подписи
С передаваемых и получаемых данных (массива байт) в определенном порядке снимается HMAC-SHA1 подпись. Подпись передается в качестве параметра в теле запроса.
Ключ формирования подписи выдаётся Банком и Банк в праве в одностороннем порядке изменять ключи для подписи.

## 2. Термины и определения
<table style="width: 100%;">
    <thead>
        <tr>
            <th style="width: 20%;">Термин</th>
            <th style="width: 100%;">Определение</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>API</td><td>Application Programming Interface</td></tr>
        <tr><td>HTTP</td><td>Hypertext Transfer Protocol <a href="https://datatracker.ietf.org/doc/html/rfc2616">(RFC 2616)</a></td></tr>
        <tr><td>JSON</td><td>JavaScript Object Notation <a href="https://datatracker.ietf.org/doc/html/rfc7159">(RFC 7159)</a></td></tr>
        <tr><td>HMAC</td><td>Hash-based message authentication code <a href="https://datatracker.ietf.org/doc/html/rfc2104">(RFC 2104)</a></td></tr>
        <tr><td>SHA-1</td><td>US Secure Hash Algorithm 1 <a href="https://datatracker.ietf.org/doc/html/rfc3174">(RFC 3174)</a></td></tr>
    </tbody>
</table>

## 3. Описание API
### 3.1. Инициализация ордера
<strong>Описание:</strong> Инициализация ордера. Клиент должен быть перенаправлен на данную страницу методом POST и инициализационными данными.<br />
<strong>Адрес:</strong> `/payment`<br />
<strong>Метод:</strong> POST<br />
<strong>Тип:</strong> перенаправление<br />
<strong>Порядок данных для подписи:</strong> `id + orderDescription + amount + login + currency + password + privateSecurityKey`<br />
<strong>Входящие параметры:</strong>
<table style="width: 100%;">
    <thead>
        <tr>
            <th>Имя</th>
            <th>Тип</th>
            <th>Обязательность</th>
            <th>По умолчанию</th>
            <th>Описание</th>
            <th>Версия</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>aqId</td><td>Integer</td><td>Да</td><td></td><td>ID эквайринга. Выдаётся Банком</td><td>2.0</td></tr>
        <tr><td>orderDescription</td><td>String (2048)</td><td>Нет</td><td></td><td>Описание ордера</td><td>2.0</td></tr>
        <tr><td>amount</td><td>Float</td><td>Да</td><td></td><td>Сумма ордера</td><td>2.0</td></tr>
        <tr><td>currency</td><td>String (3)</td><td>Да</td><td>TJS</td><td>Валюта ордера</td><td>2.0</td></tr>
        <tr><td>id</td><td>String (255)</td><td>Да</td><td>null</td><td>Идентификатор ордера</td><td>2.0</td></tr>
        <tr><td>login</td><td>String (255)</td><td>Да</td><td>null</td><td>Идентификатор партнёра. Выдаётся Банком</td><td>2.0</td></tr>
        <tr><td>orderType</td><td>OrderType (enum)</td><td>Нет</td><td>KortiMilli</td><td>Вид оплаты</td><td>3.0</td></tr>
        <tr><td>amountType</td><td>AmountType (enum)</td><td>Нет</td><td>Fixed</td><td>Тип суммы</td><td>3.0</td></tr>
        <tr><td>returnUrl</td><td>String (2048)</td><td>Нет</td><td></td><td>Ссылка для перенаправления при успешной оплате</td><td>2.1</td></tr>
        <tr><td>failUrl</td><td>String (2048)</td><td>Нет</td><td></td><td>Ссылка для перенаправления при неуспешной оплате</td><td>2.1</td></tr>
        <tr><td>callbackUrl</td><td>String (2048)</td><td>Нет</td><td></td><td>Ссылка для уведомлений стороннего сервиса</td><td>2.2</td></tr>
        <tr><td>token</td><td>String (32)</td><td>Да</td><td></td><td>Подпись данных</td><td>2.0</td></tr>
    </tbody>
</table>

### 3.2. Проверка статуса платежа (deprecated)
<strong>Описание:</strong> Устаревший метод. Проверка статуса платежа по идентификатору платежа.<br />
<strong>Адрес:</strong> `/status/{aqId}/{paymendId}/{token}/`<br />
<strong>Метод:</strong> GET<br />
<strong>Тип:</strong> Запрос<br />
<strong>Порядок данных для подписи входящего запроса:</strong> `paymentId + login + password + privateSecurityKey`<br />
<strong>Порядок данных для подписи исходящего запроса:</strong> `paymentId + status_code`<br />
<strong>Входящие параметры:</strong><br />
<table style="width: 100%;">
    <thead>
        <tr>
            <th>Имя</th>
            <th>Тип</th>
            <th>Обязательность</th>
            <th>По умолчанию</th>
            <th>Описание</th>
            <th>Версия</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>aqId</td><td>Integer</td><td>Да</td><td>null</td><td>ID эквайринга. Выдаётся Банком</td><td>2.2</td></tr>
        <tr><td>paymentId</td><td>String (2048)</td><td>Да</td><td>null</td><td>Идентификатор платежа при инициализации ордера</td><td>2.2</td></tr>
        <tr><td>token</td><td>String (2048)</td><td>Да</td><td>null</td><td>Подпись данных</td><td>2.2</td></tr>
    </tbody>
</table>
<strong>Исходящие параметры:</strong><br />
<table style="width: 100%;">
    <thead>
        <tr>
            <th>Имя</th>
            <th>Тип</th>
            <th>Описание</th>
            <th>Версия</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>paymentId</td><td>String (2048)</td><td>Идентификатор платежа при инициализации ордера</td><td>2.2</td></tr>
        <tr><td>status_code</td><td>Status_code (enum)</td><td>Код статуса</td><td>2.2</td></tr>
        <tr><td>token</td><td>String (32)</td><td>Подпись данных</td><td>2.2</td></tr>
    </tbody>
</table>

### 3.3. Получение информации об ордере
<strong>Описание:</strong> Получение информации об ордере по идентификатору платежа<br />
<strong>Адрес:</strong> `/payment/status/{login}/{id}/{token}/`<br />
<strong>Метод:</strong> GET<br />
<strong>Тип:</strong> Запрос<br />
<strong>Порядок данных для подписи входящего запроса:</strong> `externalId + currency + orderType + amountType + orderDescription + login`<br />
<strong>Порядок данных для подписи исходящего запроса:</strong> `externalId + currency + orderType + amountType + login + password`<br />
<strong>Входящие параметры:</strong><br />
<table style="width: 100%;">
    <thead>
        <tr>
            <th>Имя</th>
            <th>Тип</th>
            <th>Обязательность</th>
            <th>По умолчанию</th>
            <th>Описание</th>
            <th>Версия</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>login</td><td>String (2048)</td><td>Да</td><td>null</td><td>Логин партнёра. Выдаётся Банком</td><td>3.0</td></tr>
        <tr><td>id</td><td>String (2048)</td><td>Да</td><td>null</td><td>Идентификатор платежа при инициализации ордера</td><td>3.0</td></tr>
        <tr><td>token</td><td>String (2048)</td><td>Да</td><td>null</td><td>Подпись данных</td><td>3.0</td></tr>
    </tbody>
</table>

<strong>Исходящие параметры:</strong><br />
<table style="width: 100%;">
    <thead>
        <tr>
            <th>Имя</th>
            <th>Тип</th>
            <th>Описание</th>
            <th>Версия</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>order</td><td>Integer</td><td>Уникальный идентификатор ордера</td><td>3.0</td></tr>
        <tr><td>externalId</td><td>String (255)</td><td>Идентификатор платежа при инициализации ордера</td><td>3.0</td></tr>
        <tr><td>orderType</td><td>OrderType (enum)</td><td>Тип ордера</td><td>3.0</td></tr>
        <tr><td>amountType</td><td>AmountType (enum)</td><td>Тип суммы</td><td>3.0</td></tr>
        <tr><td>amount</td><td>Float | null</td><td>Сумма (null если сумма не была указана)</td><td>3.0</td></tr>
        <tr><td>commission</td><td>Float | null</td><td>Комиссия (null если сумма не была указана) </td><td>3.0</td></tr>
        <tr><td>currency</td><td>String (3)</td><td>Валюта</td><td>3.0</td></tr>
        <tr><td>orderDescription</td><td>String (2048)</td><td>Описании ордера при инициализации ордера</td><td>3.0</td></tr>
        <tr><td>status</td><td>Status (enum)</td><td>Статус транзакции</td><td>3.0</td></tr>
        <tr><td>token</td><td>String (40)</td><td>Подпись данных</td><td>3.0</td></tr>
    </tbody>
</table>

## 4. Составляющие объекты
### OrderType
<strong>Тип:</strong> String<br />
<strong>Значения:</strong>
- `KortiMilli` - Оплата при помощи карт "Корти Милли"

### AmountType
<strong>Тип:</strong> String<br />
<strong>Значения:</strong>
- `fixed` - ордер с фиксированной суммой
- `userInput` - ордер с неопределенной суммой (задаётся клиентом)

### Status
<strong>Тип:</strong> String<br />
<strong>Значения:</strong>
- `pending` - ордер обрабатывается. Статус не финализирован.
- `success` - ордер успешен. Статус финализирован.
- `failed` - ордер неуспешен. Статус финализирован.

### Status_code (deprecated)
<strong>Тип:</strong> Integer<br />
<strong>Значения:</strong>
- `100` - В ожидании
- `102` - В обработке
- `200` - Успешно оплачено
- `400` - Неверный ID мерчанта
- `401` - Некорректный ключ безопасности
- `404` - Платеж не найден
- `405` - Неподдерживаемый метод
- `500` - Платеж не был реализован
- `501` - Платеж отменён
- `502` - Платеж отклонён

## 5. Примеры
- [Пример реализации на языке php](https://github.com/CommerceBankTajikistan/CBTPay/tree/master/php)
