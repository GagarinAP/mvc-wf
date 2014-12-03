<html>
    <head>
        <title>Registration form</title>
        <style>
            form>div {
                margin: 4px;
            }
            form>div>input{
                border: 1px solid #c0c0c0;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <h3>Registration form</h3>
        <?php if(isset($warning)):?>
        <div class="warning"><?=$warning?></div>
        <?php endif?>
        <form method="post" action="/login/handler">
            <div><input type="text" name="login" /> Login</div>
            <div><input type="password" name="pass" /> Password</div>
            <div><input type="submit" value="Login" /></div>
        </form>
    </body>
</html>