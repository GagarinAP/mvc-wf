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
            .warning{
                color: red;
            }
        </style>
    </head>
    <body>
        <h3>Registration form</h3>
        <?php if(isset($warning)):?>
        <div class="warning"><?=$warning?></div>
        <?php endif;?>
        <form method="post" action="/login/reg_handler">
            <div><input type="text" name="login" value="<?=$login?>" /> Login</div>
            <div><input type="text" name="email" value="<?=$email?>" /> Email</div>
            <div><input type="password" name="pass" /> Password</div>
            <div><input type="password" name="pass2" /> Confirm password</div>
            <div><input type="submit" value="Register" /></div>
        </form>
    </body>
</html>