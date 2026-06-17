<?php
//index.php - 首页
//Copyright (c) 2025-2026 Shaanxi Jima Cloud Education Innovation Studio
//website:extreme-code.cn
//数据库配置修改位于:根目录/config/database.php
//坏菜了！！！！这个代码我自己都看不懂！！！！不要瞎改！！！！！
//加载信息
//没设计容错，别tm乱删文件
//天知道那些文件啥地方引用了！！！！！！！！！
//A1变量部分 //数据库config
require __DIR__ . '/../app/models/title.php';
require __DIR__ . '/../app/models/keywords.php';
require __DIR__ . '/../app/models/logo_1.php';
require __DIR__ . '/../app/models/logo_2.php';
require __DIR__ . '/../app/models/ico.php';
require __DIR__ . '/../app/models/icp.php';
require __DIR__ . '/../app/models/address.php';
require __DIR__ . '/../app/models/postal_code.php';
//防护加载
require __DIR__ . '/../app/models/csrf.php';//CSRF防护
// //b1语言包加载
// require_once __DIR__ . '/public/lib/language/zh-CN.php';//zh-CN语言包
// require_once __DIR__ . '/public/lib/language/en.php';//en语言包

function e($str)
{
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

//c1页面数据加载 //单表数据库
/*顶部链接*/
require_once __DIR__ . '/../app/models/top_links.php';
/*导航*/
require_once __DIR__ . '/../app/models/nav_links.php';
/*Banner*/
require_once __DIR__ . '/../app/models/banner_imgs.php';
/*校园要闻*/
require_once __DIR__ . '/../app/models/yaowen_list_q4.php';//q4
/*综合新闻*/
require_once __DIR__ . '/../app/models/index_news_q6.php';//q6
/*学术交流*/
require_once __DIR__ . '/../app/models/xueshu_list_q4.php';//q4
/*媒体关注*/
require_once __DIR__ . '/../app/models/meiti_list_q4.php';//q4
/*门户*/
require_once __DIR__ . '/../app/models/portal_cards.php';




//lang
$allowed_languages = ['zh-CN', 'en'];
$cookie_options = [
    'expires'  => time() + 30 * 86400,          // 30 天
    'path'     => '/',
    'secure'   => isset($_SERVER['HTTPS']),     // 仅 HTTPS 下发送（生产环境建议强制开启）
    'httponly' => true,                         // 禁止 JS 读取，防 XSS
    'samesite' => 'Lax'                         // 防 CSRF
];

if (isset($_GET['lang']) && in_array($_GET['lang'], $allowed_languages, true)) {
    // CSRF 验证
    if (!csrf_verify()) {
        die('CSRF token 验证失败，请刷新页面后重试。');
    }

    setcookie('lang', $_GET['lang'], $cookie_options);

    $redirect_url = strtok($_SERVER['REQUEST_URI'], '?');
    if ($redirect_url === false || $redirect_url === '') {
        $redirect_url = '/';
    }
    header('Location: ' . $redirect_url);
    exit;
}

// --- 4. 读取当前语言 ---
if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $allowed_languages, true)) {
    $lang = $_COOKIE['lang'];
} else {
    $lang = 'zh-CN';
    setcookie('lang', $lang, $cookie_options);
}




if (isset($_COOKIE['lang'])) {
    $lang = $_COOKIE['lang'];
    
    if ($lang === 'en') {
        require_once __DIR__ . '/public/lib/language/en.php';
    } elseif ($lang === 'zh-CN') {
        require_once __DIR__ . '/public/lib/language/zh-CN.php';
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo e($lang); ?>">

<head>

<meta charset="UTF-8">

<title><?php echo e($title); ?> - <?php echo e($index_title); ?></title>

<meta name="keywords" content="<?php echo e($keywords); ?>">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<link rel="icon" href="<?php echo e($ico); ?>" type="image/x-icon">

<link rel="stylesheet" href="public/css/index.css">

</head>

<body>

<!-- 顶部栏 -->

<?php require_once __DIR__ . '/public/lib/head.php'; ?>

<!-- 轮番图Banner -->

<div class="banner">

    <div class="slides-container">

        <?php foreach ($banner_imgs as $key => $b): ?>

            <a href="<?php echo e($b['link']); ?>"
               class="slide <?php echo $key === 0 ? 'active' : ''; ?>">

                <img src="<?php echo e($b['img']); ?>" alt="">

                <div class="banner-text">

                    <?php echo e($b['title']); ?>

                </div>

            </a>

        <?php endforeach; ?>

    </div>

    <button class="banner-arrow banner-arrow--left">&#10094;</button>

    <button class="banner-arrow banner-arrow--right">&#10095;</button>

    <div class="banner-dots">

        <?php foreach ($banner_imgs as $key => $b): ?>

            <span class="dot <?php echo $key === 0 ? 'active' : ''; ?>"
                  data-index="<?php echo $key; ?>"></span>

        <?php endforeach; ?>

    </div>

</div>

<!-- 主体 -->

<div class="main wrap">

    <!-- 校园要闻 -->

    <div class="news-section">

        <div class="news-left">

            <h2 class="section-title">

                <?php echo e($school_new); ?>

                <a href="#" class="more"><?php echo e($more); ?>&gt;</a>

            </h2>

            <div class="yaowen-grid">

                <?php foreach ($yaowen_list as $yw): ?>

                    <a href="<?php echo e($yw['link']); ?>" class="yw-card">

                        <div class="yw-image">

                            <img src="<?php echo e($yw['img']); ?>" alt="">

                        </div>

                        <div class="yw-content">

                            <h3>
                                <?php echo e($yw['title']); ?>
                            </h3>

                            <p>
                                <?php echo e($yw['desc']); ?>
                            </p>

                        </div>

                    </a>

                <?php endforeach; ?>

            </div>

        </div>

        <!-- 综合新闻 -->

        <div class="news-right">

            <h2 class="section-title">

                <?php echo e($zh_new); ?>

                <a href="#" class="more"><?php echo e($more); ?>&gt;</a>

            </h2>

            <ul class="news-list">

                <?php foreach ($xinwen_list as $xw): ?>

                    <li>

                        <a href="<?php echo e($xw['link']); ?>">

                            <?php echo e($xw['title']); ?>

                        </a>

                        <span>

                            <?php echo e($xw['date']); ?>

                        </span>

                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    </div>

    <!-- 学术交流 / 媒体关注 -->

    <div class="info-cols">

        <div class="info-col">

            <h2 class="section-title">

                <?php echo e($academic_exchange); ?>

                <a href="#" class="more"><?php echo e($more); ?>&gt;</a>

            </h2>

            <ul class="info-list">

                <?php foreach ($xueshu_list as $xs): ?>

                    <li>

                        <a href="<?php echo e($xs['link']); ?>">

                            <?php echo e($xs['title']); ?>

                        </a>

                        <span>

                            <?php echo e($xs['date']); ?>

                        </span>

                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

        <div class="info-col">

            <h2 class="section-title">
                    <!-- 媒体关注 -->
                <?php echo e($media_attention); ?>

                <a href="#" class="more"><?php echo e($more); ?>&gt;</a>

            </h2>

            <ul class="info-list">

                <?php foreach ($meiti_list as $mt): ?>

                    <li>

                        <a href="<?php echo e($mt['link']); ?>">

                            <?php echo e($mt['title']); ?>

                        </a>

                        <span>

                            <?php echo e($mt['date']); ?>

                        </span>

                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    </div>

    <!-- 门户 -->

    <div class="portal-grid">

        <?php foreach ($portal_cards as $card): ?>

            <a href="#"
               class="portal-card <?php echo e($card['class']); ?>">

                <div class="portal-inner">

                    <h3>

                        <?php echo e($card['title']); ?>

                    </h3>

                    <div class="portal-desc">

                        <?php foreach ($card['desc'] as $desc): ?>

                            <span>

                                <?php echo e($desc); ?>

                            </span>

                        <?php endforeach; ?>

                    </div>

                </div>

            </a>

        <?php endforeach; ?>

    </div>

</div>

<!-- Footer -->
<?php require_once __DIR__ . '/public/lib/footer.php'; ?>

<script>

(function(){

    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    const prevBtn = document.querySelector('.banner-arrow--left');
    const nextBtn = document.querySelector('.banner-arrow--right');

    let current = 0;

    const total = slides.length;

    function showSlide(index){

        slides[current].classList.remove('active');
        dots[current].classList.remove('active');

        current = (index + total) % total;

        slides[current].classList.add('active');
        dots[current].classList.add('active');

    }

    prevBtn.addEventListener('click', function(){

        showSlide(current - 1);

    });

    nextBtn.addEventListener('click', function(){

        showSlide(current + 1);

    });

    dots.forEach(function(dot){

        dot.addEventListener('click', function(){

            showSlide(parseInt(this.dataset.index));

        });

    });

    setInterval(function(){

        showSlide(current + 1);

    }, 4000);

})();

</script>

</body>
</html>