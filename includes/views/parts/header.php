<!DOCTYPE html>
<html lang="de">
<head>
	<title><?php echo $this->title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" rel="stylesheet">
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/main.css" rel="stylesheet">
	<script src="assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	
    <?php if($this->current == "index"): ?>
        <link href="assets/css/bootstrap-treeview.min.css" rel="stylesheet">
        <script src="assets/js/bootstrap.treeview.min.js" type="text/javascript"></script>
		<script src="assets/js/classes/core.js" type="text/javascript"></script>
		<script src="assets/js/test.js" type="text/javascript"></script>
        <script src="assets/js/classes/Overview.js" type="text/javascript"></script>
    <?php endif; ?>

</head>
<body>