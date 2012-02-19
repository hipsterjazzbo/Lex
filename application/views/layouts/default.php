<?php $current_language = $this->session->userdata('current_language'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
	<title><?php echo $template['title']; ?></title>
	<?php echo $template['metadata']; ?>

	<link rel="stylesheet" href="<?= site_url('styles/bootstrap.css') ?>">
	<link rel="stylesheet" href="<?= site_url('styles/styles.css') ?>">

    <style>
    .native {
        font-family: <?= ucfirst($current_language['name']) ?>, <?= strtolower($current_language['name']) ?>, "Helvetica Neue", Helvetica, Arial, sans-serif !important;
    }
    </style>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="<?= site_url('scripts/jquery.cleditor.min.js') ?>"></script>
    <script src="<?= site_url('scripts/main.min.js') ?>"></script>

    <script>
    $(function() {
        $(".wysiwyg").cleditor({
            controls: "bold italic underline | bullets numbering | alignleft center alignright",
            bodyStyle: "margin:4px; cursor:text"
        });
    });
    </script>
</head>
<body>
	<nav class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="#">Lex</a>

				<ul class="nav">
					<li class="dropdown active">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-book icon-white"></i>
							<?php echo $current_language['name']; ?>
							<b class="caret"></b>
						</a>
						
						<ul class="dropdown-menu">
							<?php if (isset($languages) && count($languages) >= 1): ?>
                                <li><a href="javascript:return false;">No other languages found</a></li>
                            <?php endif; ?>

                            <?php foreach ($this->session->userdata('languages') as $language): ?>
                                <?php if ($language['_id'] != $current_language['_id']): ?>
                                    <li><a href="<?= site_url('action/change_language/' . $language['_id']) ?>"><?= $language['name'] ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li class="divider"></li>
                            <li><a href="<?= site_url('page/manage_languages') ?>"><i class="icon-list"></i> Manage languages</a></li>
                            <li><a href="<?= site_url('page/add_language') ?>"><i class="icon-plus"></i> Add a language</a></li>
						</ul>
					</li>
                    <li><a href="#"><?= $this->session->userdata('lala') ?></a></li>
				</ul>

                <!-- <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Settings
                            <b class="caret"></b>
                        </a>
                        
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                        </ul>
                    </li>
                </ul> -->

				<form class="navbar-search pull-right">
					<input type="text" class="search-query" placeholder="Search">
				</form>
			</div>
		</div>
	</nav>

	<div id="wrapper" class="container">
		<div class="row">
			<div id="sidebar" class="span3 well">
				<ul class="nav nav-list">
					<li class="nav-header">Words</li>
					<li><a href="<?= site_url('page/list_words') ?>"><i class="icon-list"></i> List words</a></li>
					<li><a href="<?= site_url('page/add_word') ?>"><i class="icon-plus"></i> Add a word</a></li>

                    <!-- <li class="nav-header">Pages</li>
                    <li><a href="<?= site_url('page/list_words') ?>"><i class="icon-list"></i> List words</a></li>
                    <li><a href="<?= site_url('page/add_word') ?>"><i class="icon-plus"></i> Add a word</a></li> -->
				</ul>
			</div>

			<div id="main" class="offset3 span9">
				<?php echo $template['body']; ?>
			</div>
		</div>
	</div>
</body>
</html>