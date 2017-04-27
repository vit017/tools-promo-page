<? require_once __DIR__ . '/../functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/assets/ckeditor_4.6.2_standard/contents.css">

    <script src="/assets/ckeditor_4.6.2_standard/ckeditor.js"></script>




    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Hello, world!</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Дата начала показа страницы</label>
                    <div class='input-group date datetimepicker'>
                        <input type='text' name="date_show_start"
                               placeholder="Дата начала показа страницы"
                               class="form-control"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Дата окончания показа страницы</label>
                    <div class='input-group date datetimepicker'>
                        <input type='text' name="date_show_end" placeholder="Дата окончания показа страницы"
                               class="form-control"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>

                <div class="form-group">
                    <label>URL страницы</label>
                    <div class='input-group'>
                        <span class="input-group-addon">
                            <span><?= $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . '/' ?></span>
                        </span>
                        <input type='text' name="date_show_end" placeholder="Дата окончания показа страницы"
                               class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label>Название акции</label>
                    <input type='text' name="name" placeholder="Название акции" class="form-control"/>
                </div>

                <div class="form-group">
                    <label>Шапка</label>
                    <textarea name="header" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>

                <div class="form-group">
                    <label>Подвал</label>
                    <textarea name="footer" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>

                <? /*
    <div class="form__field">
        <input type="text" placeholder="Название акции" name="url">
    </div>
    <div class="form__field">
        <textarea name="header" id="" cols="30" rows="10">шапка</textarea>
    </div>
    <div class="form__field">
        <textarea name="footer" id="" cols="30" rows="10">подвал</textarea>
    </div>

*/ ?>
            </form>
        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script-->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/assets/js/jquery-1.11.1.min.js"></script>
<script src="/assets/js/moment-with-locales.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/bootstrap-datetimepicker.min.js"></script>


<script>
    CKEDITOR.replace('footer');
</script>


<script src="/assets/js/main.js"></script>
</body>
</html>

















