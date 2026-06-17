<div class="top-bar">

    <div class="wrap">

        <div class="top-links">

            <?php foreach ($top_links as $link): ?>

                <a href="<?php echo e($link['url']); ?>">
                    <?php echo e($link['text']); ?>
                </a>

            <?php endforeach; ?>

        </div>

    <div class="top-extra">
        <a href="#">书记信箱</a> ｜ <a href="#">校长信箱</a> ｜ 
            <?php if (isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en'): ?>
                <a href="?lang=zh-CN&csrf_token=<?php echo csrf_token(); ?>">简体中文</a>
            <?php else: ?>
                <a href="?lang=en&csrf_token=<?php echo csrf_token(); ?>">English</a>
            <?php endif; ?>
    </div>

    </div>

</div>

<!-- Header -->

<header class="header">

    <div class="wrap">

        <a href="/" class="logo">

            <img src="<?php echo e($logo_2); ?>" alt="<?php echo e($title); ?>">

        </a>

        <ul class="nav">

            <?php foreach ($nav_links as $nav): ?>

                <li>

                    <a href="<?php echo e($nav['url']); ?>">
                        <?php echo e($nav['text']); ?>
                    </a>

                    <?php if (!empty($nav['children'])): ?>

                        <ul class="subnav">

                            <?php foreach ($nav['children'] as $child): ?>

                                <li>

                                    <a href="<?php echo e($child['url']); ?>">
                                        <?php echo e($child['text']); ?>
                                    </a>

                                </li>

                            <?php endforeach; ?>

                        </ul>

                    <?php endif; ?>

                </li>

            <?php endforeach; ?>

        </ul>

    </div>

</header>
