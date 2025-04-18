<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" href="/assets/favicon.ico" />
    <link rel="stylesheet" href="/assets/global.css" />
    <?php if (isset($title)): ?>
        <title>TestPHP - <?= $title ?></title>
        <meta name="og:title" content="TestPHP - <?= $title ?>" />
    <?php else: ?>
        <title>TestPHP</title>
    <?php endif; ?>
    <?php if (isset($description)): ?>
        <meta name="description" content="<?= $description ?>" />
        <meta name="og:description" content="<?= $description ?>" />
    <?php endif; ?>
</head>