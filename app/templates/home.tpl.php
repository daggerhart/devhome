<?php
/**
 * Homepage (and only page) template
 *
 * $utils       - Very commonly used links.
 * $projects    - Configured projects.
 * $discoveries - Other folders found in the roots array.
 * $settings    - All configured settings.
 */
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Dev Home</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
          integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
          crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet"
          href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"
          integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX"
          crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        /* bug fixes */
        /* https://github.com/twbs/bootstrap/issues/16297 */
        .modal.fade.in {
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
        }

        /* dashboard */
        .project-name {
            margin-bottom: 0;
        }

        .project-source {
            display: block;
            margin-bottom: 10px;
        }

        .project-link a {
            display: block;
            text-decoration: none;
        }

        .project-link a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="wrap">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed"
                        data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1"
                        aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><i
                        class="fa fa-lg fa-fw fa-tachometer"></i></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse"
                 id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    foreach ($utils as $util) {
                        ?>
                        <li>
                            <a href="<?= $util['url'] ?>" target="_blank">
                                <i class="fa fa-<?= $util['icon']; ?>"></i>&nbsp;
                                <?= $util['name'] ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" data-toggle="modal" data-target="#phpinfo">
                            <i class="fa fa-fw fa-pied-piper"></i>PHPInfo
                        </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
        <div class="page-header">
            <h1>Projects</h1>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?php foreach ($projects as $project) { ?>
                    <div class="project"
                         data-folder="<?= $project['folder'] ?>">
                        <h3 class="project-name"><?= $project['name']; ?></h3>
                        <small
                            class="project-source text-muted"><?= $project['source'] ?></small>
                        <p class="project-description text-muted"><?= $project['description'] ?></p>

                        <div class="project-links list-group">
                            <?php foreach ($project['links'] as $link) { ?>
                                <li class="project-link list-group-item">
                                    <a href="<?= $link['url']; ?>">
                                        <i class="fa fa-lg fa-fw fa-<?= $link['icon'] ?>"></i>&nbsp;
                                        <?= $link['name'] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-6">
                <?php if ($discoveries) : ?>
                    <h3>Other</h3>
                    <div class="list-group">
                        <?php foreach ($discoveries as $item) { ?>
                            <a class="list-group-item"
                               href="<?= $item['url']; ?>">
                                <h4 class="list-group-item-heading"><?= $item['folder'] ?></h4>
                                <p class="list-group-item-text text-muted"><?= $item['source']; ?></p>
                            </a>
                        <?php } ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <div id="phpinfo" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title">PHPInfo</h4>
                </div>
                <div class="modal-body">
                    <?php phpinfo(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script
    src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"
        integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ=="
        crossorigin="anonymous"></script>
<script>
    (function ($) {

    })(jQuery);
</script>
</body>
</html>
