<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="/global.min.css" />
    <title>TestPHP <?= isset($title) ? sprintf('- %s', $title) : '' ?></title>
    <meta name="og:title" content="TestPHP <?= isset($title)
        ? sprintf('- %s', $title)
        : '' ?>" />
    <?php if (isset($description)): ?>
        <meta name="description" content="<?= $description ?>" />
        <meta name="og:description" content="<?= $description ?>" />
    <?php endif; ?>
</head>