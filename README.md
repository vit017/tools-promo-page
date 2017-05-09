# tools-promo-page

Инструмент создания акционных страниц.

Для добавления страницы перейдите в административный раздел сайта <a href="http://corp-promo.nichost.ru/manager/">http://corp-promo.nichost.ru/manager/</a>,<br>
Ссылка <a href="http://tools-promo-page/manager/promo/add">Add Promo</a>

Поля:<br>
<b>Page Url</b> - Url страницы. Строка не более 255 символов. Допустимые символы: латиница, цифры, нижнее подчеркивание, дефис<br>
<b>Page Title</b> - Заголовок страницы. Строка не более 255 символов.<br>
<b>Sort</b> - Сортировка страницы. Целое число.<br>
<b>Page show start</b> - Дата начала показа. Формат: dd.mm.YYYY H:i.<br>
<b>Page show end</b> - Дата окончания показа. Формат: dd.mm.YYYY H:i.<br>
<b>Header</b> - Шапка страницы. Текст/html.<br>
<b>Footer</b> - Подвал страницы. Текст/html.<br>

Поля обязательные для заполнения:<br>
<b>Page Url</b><br>
<b>Page Title</b><br>
<b>Page show start</b><br>
<b>Page show end</b><br>
<br>

Активные на текущую дату акции выводятся в публичной части в отсортированном порядке (по полю <b>Sort</b>): 
<a href="http://corp-promo.nichost.ru">http://corp-promo.nichost.ru</a><br>
-Название акции<br>
-Период активности<br>
<br>

По клику на название можно перейти на детальную страницу акции, где будут выведены поля:<br>
<b>Header</b><br>
<b>Footer</b><br>
А также список товаров, привязванных к данной странице.<br>

Чтобы вывести товар на определённой странице, при добавлении товара (<a href="http://corp-promo.nichost.ru/manager/product/add">Add Product</a>) в поле <b>Promo Page</b>
выберете нужную страницу. Товары выводятся в соответствии с собственной сортировкой (<b>Sort</b>).
<br>

Также в административной части можно отредактировать или удалить товар или страницу акции. 
Соответствующие ссылки "Edit record" и "Delete record" находятся на странице со списком элементов:<br>
<a href="http://corp-promo.nichost.ru/manager/">Акции</a><br>
<a href="http://corp-promo.nichost.ru/manager/products">Товары</a>
<br>
<br>
Подробнее о добавлении товаров см. README-import
