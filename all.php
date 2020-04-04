<?php
    include_once(__DIR__ . '/QueryBuilder/MysqlQueryBuilder.php');
    include_once(__DIR__ . '/DB.php');

    $db = new DB('', '', '', '');

    $moviesWithPicturesQuery = (new MysqlQueryBuilder())
        ->select('movie', ['title'])
        ->leftJoin('pictures', [
            ['movie.movie_id', '=' ,'pictures.movie_id']
        ])->where('pictures.movie_id', 'NULL', 'IS NOT');

    $moviesWithoutPicturesQuery = (new MysqlQueryBuilder())
        ->select('movie', ['title'])
        ->leftJoin('pictures', [
            ['movie.movie_id', '=' ,'pictures.movie_id']
        ])->where('pictures.movie_id', 'NULL', 'IS');

    $moviesWithPictures = $db->query($moviesWithPicturesQuery)->fetchAll();
    $moviesWithoutPictures = $db->query($moviesWithoutPicturesQuery)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tree</title>

        <style>
            .tree > li:hover{
                cursor: pointer;
            }
        </style>
    </head>
    <body>
    <ul id="tree" class="tree">
        <li>Фильмы
            <ul>
                <li>Фильмы с кадрами
                    <?php if (!empty($moviesWithPictures)): ?>
                    <ul>
                        <?php foreach($moviesWithPictures as $movieWithPic): ?>
                            <li><?php echo $movieWithPic['title'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <li>Фильмы без кадров
                    <?php if (!empty($moviesWithoutPictures)): ?>
                        <ul>
                            <?php foreach($moviesWithoutPictures as $movieWithoutPic): ?>
                                <li><?php echo $movieWithoutPic['title'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            </ul>
        </li>
    </ul>

    <script>
        document.querySelector("#tree").onclick = function(e) {
            var ul = e.target.querySelector('ul');

            if (ul !== null) {
                ul.hidden = !ul.hidden;
            }
        }
    </script>
    </body>
</html>
