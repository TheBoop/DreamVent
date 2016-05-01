<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</head>
<body>

<h1 class="well well-lg">List of Pictures</h1>
<?php foreach( $pictures as $picture ): ?>
    <div class="table table-bordered bg-success"><a href="<?php echo $picture->picture_link; ?>"><?php echo e($picture->picture_link); ?></a></div>
<?php endforeach; ?>

</body>
</html>