<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Авторизація</title>
    <?= style('login') ?>
</head>
<body>
<section class="container">
    <div class="login">
        <h1>Авторизація</h1>
        <form>
            <p><input type="text" id="login" value="" placeholder="Логін"></p>
            <p><input type="password" id="password" value="" placeholder="Пароль"></p>
            <p class="remember_me">
                <label>
                    <input type="checkbox" checked id="remember_me">
                    Запамятати мене
                </label>
            </p>
            <p class="submit"><input type="submit" id="submit" value="Вхід"></p>
        </form>
    </div>

    <div class="login-help">
        <a href="<?=route('reset')?>">Забули пароль?</a>
    </div>
</section>
<script>var site = '<?= my_site_url() ?>'</script>
<?= script_file('jquery') ?>
<?= script_file('login') ?>
</body>
</html>