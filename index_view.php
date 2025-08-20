<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Last2Lines is a medium to express and register a peaceful campaign using two lines of poetry.">
    <meta name="keywords" content="Last2Lines, L2L, Poem, Spoken poetry, Last Two Lines, Kashmir, Protest, Poetry, Campaign, Ghazal, Charity">
    <meta name="author" content="Abdul Wajid">

    </head>
<body>
<div id="loading">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <div class="object" id="object_one"></div>
            <div class="object" id="object_two"></div>
            <div class="object" id="object_three"></div>
            <div class="object" id="object_four"></div>
            <div class="object" id="object_five"></div>
        </div>
    </div>
</div>
<section id="home">
    <div class="home-overlay">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="home-text">
                        <h1>Last Two Lines</h1>
                        <p>Total Authors: <span><?php echo $pageData->totalAuthors; ?></span></p>
                        <p>Total Couplets: <span><?php echo $pageData->totalCouplets; ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="features">
    <div class="container">
        <?php if (!empty($pageData->activeChapter)) : ?>
            <div class="row text-center couplets-container">
                <h3><?php echo htmlspecialchars($pageData->activeChapter['chapter_name']); ?></h3>
                <?php foreach ($pageData->firstTwoCouplets as $couplet) : ?>
                    <p class="couplet"><?php echo htmlspecialchars($couplet['couplet_text']); ?></p>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No active chapter found.</p>
        <?php endif; ?>
    </div>
</section>
</body>
</html>