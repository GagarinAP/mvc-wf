<html>
    <head>Edit article</head>
    <body>
        <form action="/article/handler" method="post">
            <div><input type="text" name="title" placeholder="Title" value="<?=$art->title?>" /></div>
            <div><textarea name="content" id="" cols="30" rows="20"><?=$art->content?></textarea></div>
            <input type="hidden" name="art_id" value="<?=$art->id?>" />
            <div><input type="submit" value="Save" /></div>
        </form>
    </body>
</html>