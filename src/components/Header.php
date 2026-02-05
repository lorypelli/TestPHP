<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="/global.min.css" />
    <?php if (isset($title)): ?>
        <title>TestPHP <?= sprintf('- %s', $title) ?></title>
        <meta name="og:title" content="TestPHP <?= sprintf(
            '- %s',
            $title,
        ) ?>" />
    <?php else: ?>
        <title>TestPHP</title>
        <meta name="og:title" content="TestPHP" />
    <?php endif; ?>
    <?php if (isset($description)): ?>
        <meta name="description" content="<?= $description ?>" />
        <meta name="og:description" content="<?= $description ?>" />
    <?php endif; ?>
</head>