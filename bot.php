<?php
ob_start();
error_reporting(0);
define('API_KEY', '922217183:AAGhIkwIEdNfd7XGV_2tWrfXwKxtVLQGxrE'); // توکن ربات

//////////////////////////Functions////////////////////////
function getbio($username)
{
    if (isset($username)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://t.me/$username");
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $curl_exec = curl_exec($ch);
        curl_close($ch);
        preg_match('/<meta property="og:description" content="(.*?)">/s', $curl_exec, $bio);
        return $bio[1];
    }
}
$admin[] = base64_decode('MjgzMzkyMjQ2');
function creatbanner($patch)
{
    global $from_id;
    $w = 640;
    $h = 640; // original size
    $dest_path = "$from_id.png";
    $src = imagecreatefromstring(file_get_contents("https://api.telegram.org/file/bot" . API_KEY . "/$patch"));
    $newpic = imagecreatetruecolor($w, $h);
    imagealphablending($newpic, false);
    $transparent = imagecolorallocatealpha($newpic, 0, 0, 0, 127);
    $r = $w / 2;
    for ($x = 0; $x < $w; $x++)
        for ($y = 0; $y < $h; $y++) {
            $c = imagecolorat($src, $x, $y);
            $_x = $x - $w / 2;
            $_y = $y - $h / 2;
            if ((($_x * $_x) + ($_y * $_y)) < ($r * $r)) {
                imagesetpixel($newpic, $x, $y, $c);
            } else {
                imagesetpixel($newpic, $x, $y, $transparent);
            }
        }
    imagesavealpha($newpic, true);
    imagepng($newpic, $dest_path);
    imagedestroy($newpic);
    imagedestroy($src);
    $t = imagecreatefrompng("$from_id.png");
    $x = imagesx($t);
    $y = imagesy($t);
    $s = imagecreatetruecolor(1000, 1000);
    imagealphablending($s, false);
    imagecopyresampled(
        $s,
        $t,
        0,
        0,
        0,
        0,
        1000,
        1000,
        $x,
        $y
    );
    imagesavealpha($s, true);
    imagepng($s, "$from_id.png");
    imagedestroy($s);
    imagedestroy($t);
    $stamp = imagecreatefrompng("$from_id.png");
    $im = imagecreatefromjpeg("baner.jpg");
    $marge_right = 1450;
    $marge_bottom = 1970;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
    header("Content-Type: image/png");
    imagejpeg($im, "$from_id.png");
    imagedestroy($im);
}
function MainBot($method, $arr = [])
{
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
    $res = curl_exec($ch);
    return json_decode($res);
}
function photo($chat_id, $photo_link, $caption = null, $markup = null)
{
    bot("sendPhoto?chat_id=" . $chat_id . "&photo=" . $photo_link . "&caption=" . $caption . $markup);
}
function bot($info)
{
    return json_decode(file_get_contents("https://api.telegram.org/bot" . API_KEY . "/" . $info), true);
}
function message($chat_id, $msg, $markup = null)
{
    if ($markup != null) {
        bot("sendMessage?chat_id=" . $chat_id . "&text=" . $msg . "&reply_markup=" . $markup);
    } else {
        bot("sendMessage?chat_id=" . $chat_id . "&text=" . $msg);
    }
}
function editMessage($chat_id, $message_id, $msg, $markup = null)
{
    if ($markup != null) {
        bot("editMessageText?chat_id=" . $chat_id . "&message_id=" . $message_id . "&text=" . $msg . "&reply_markup=" . $markup);
    } else {
        bot("editMessageText?chat_id=" . $chat_id . "&message_id=" . $message_id . "&text=" . $msg);
    }
}
function inline_btn($i)
{
    $ar = array();
    $button = array();
    for ($c = 0; $c < count($i); $c = $c + 2) {
        $button[$c / 2 % 2] = array("text" => urlencode($i[$c]), "callback_data" => $i[$c + 1]);
        if ($c / 2 % 2) {
            array_push($ar, array($button[0], $button[1]));
            $button = array();
        } elseif (count($i) - $c <= 2) {
            array_push($ar, array($button[0]));
            $button = array();
        }
    }
    return "&reply_markup=" . json_encode(array("inline_keyboard" => $ar));
}
//////////////////////////Functions////////////////////////

//////////////////////////Info////////////////////////
$robotName = "-";
$admin = array("-"); // ایدی عددی ادمین ها
$usernamebot = "-"; // یوزرنیم ربات بدون @
$channel = "-"; // یوزرنیم کانال بدون @
$channelname = "-"; // نام کانال
$web = "-"; // ادرس محل قرار گیری سورس
//////////////////////////Info////////////////////////

//////////////////////////DataBase////////////////////////
$servername = "-";
$username = "-";   // یوزرنیم دیتابیس
$password = "-";   // پسورد دیتابیس
$dbname = "-";     // نام دیتابیس
$connect = mysqli_connect($servername, $username, $password, $dbname);
//////////////////////////DataBase////////////////////////

//////////////////////////Data////////////////////////
$list_limit = 3;
$boy = '🤴🏻';
$girl = '👸🏻';
$update = json_decode(file_get_contents('php://input'), true);
$message = $update->message;
if (array_key_exists('message', $update)) {

    $message_id = $update['message']['message_id'];
    $textMessage = $update['message']['text'];
    $first_name = $update['message']['from']['first_name'];
    $username = $username = (array_key_exists('username', $update['message']['from'])) ? $update['message']['from']['username'] : null;
    $from_id = $update['message']['from']['id'];
    $chat_id = $update['message']['chat']['id'];
    $tc = $update['message']['chat']['type'];
    $caption = $update['message']['caption'];
    // data
    $user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '$from_id' "));
    $user_province = $user['province'];
} elseif (array_key_exists('callback_query', $update)) {
    $chat_id = $update['callback_query']['message']['chat']['id'];
    $from_id = $update['callback_query']['from']['id'];
    $membercall = $update['callback_query']['id'];
    $textMessage = $update['callback_query']['data'];
    $tc = $update['callback_query']['chat']['type'];
    $message_id = $update['callback_query']['message']['message_id'];
    // data
    $user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '$from_id' "));
    $user_province = $user['province'];
}
//////////////////////////Data////////////////////////

//////////////////////////Markups////////////////////////
if ($from_id == "611327807") {
    $HomeMarkup = [
        'keyboard' => [
            [
                ['text' => "پنل مدیریت"]
            ],
            [
                ['text' => "🎲 چت تصادفی"],
                ['text' => "چت پیشرفته 🚀"]
            ],
            [
                ['text' => "📡 چت با GPS"],
                ['text' => "👨‍👧‍👧 لیست دوستان"]
            ],
            [
                ['text' => "💰 سکه"],
                ['text' => "👤 پروفایل"],
                ['text' => "💰 سکه رایگان"]
            ],
            [
                ['text' => "💡 راهنما"],
                ['text' => "👮🏻 پشتیبانی"],
                ['text' => "🚫 بلاک لیست"]
            ],
        ],
        'resize_keyboard' => true

    ];
} else {

    $HomeMarkup = [
        'keyboard' => [
            [
                ['text' => "🟢 ONLINE : وضعیت شما"],
                ['text' => "OFFLINE ❌"]
            ],
            [
                ['text' => "🎲 چت تصادفی"],
                ['text' => "چت پیشرفته 🚀"]
            ],
            [
                ['text' => "💰 سکه"],
                ['text' => "👤 پروفایل"],
                ['text' => "💰 سکه رایگان"]
            ],
            [
                ['text' => "💡 راهنما"],
                ['text' => "👮🏻 پشتیبانی"],
                ['text' => "🚫 بلاک لیست"]
            ],
            [
                ['text' => "📡 چت با GPS"],
                ['text' => "👨‍👧‍👧 لیست دوستان"]
            ],

        ],
        'resize_keyboard' => true

    ];

    $HomeMarkup2 = [
        'keyboard' => [
            [
                ['text' => "❌❌❌ OFFLINE : وضعیت شما ❌❌❌"]
            ],
            [
                ['text' => "ONLINE ✅"]
            ]
        ],
        'resize_keyboard' => true

    ];
}
$InChatMarkup = [
    'keyboard' => [
        [
            ['text' => "💬 پایان چت"]
        ],
        [
            ['text' => "🛑 گزارش تخلف"],
            ['text' => "👁 مشاهده پروفایل"]
        ],
        [
            ['text' => "👨‍👧‍👧 دوستی"],
            ['text' => "🚫 بلاکش کن"]
        ],
    ],
    'resize_keyboard' => true
];
$GenderMarkup = [
    'keyboard' => [

        [
            ['text' => "👸🏻 دخترم"],
            ['text' => "🤴🏻 پسرم"]
        ],

    ],
    'resize_keyboard' => true
];
$ProfileMarkup = [
    'keyboard' => [
        [
            ['text' => "💬 درخواست چت"]
        ],
        [
            ['text' => "🛑 گزارش تخلف"],
            ['text' => "📨 ارسال پیام"]
        ],
        [
            ['text' => "👨‍👧‍👧 دوستی"],
            ['text' => "🚫 بلاکش کن"]
        ],
        [
            ['text' => "🏠 خانه"]
        ]
    ],
    'resize_keyboard' => true
];
$ProfileMarkup2 = [
    'keyboard' => [
        [
            ['text' => "💬 درخواست چت"]
        ],
        [
            ['text' => "🛑 گزارش تخلف"],
            ['text' => "👁 مشاهده پروفایل"]
        ],
        [
            ['text' => "❌ حذف"],
            ['text' => "🚫 بلاکش کن"]
        ],
        [
            ['text' => "🏠 خانه"]
        ]
    ],
    'resize_keyboard' => true
];
$ProfileMarkup3 = [
    'keyboard' => [
        [
            ['text' => "💬 درخواست چت"]
        ],
        [
            ['text' => "🛑 گزارش تخلف"],
            ['text' => "👁 مشاهده پروفایل"]
        ],
        [
            ['text' => "❌ حذف"],
            ['text' => "👨‍👧‍👧 دوستی"]
        ],
        [
            ['text' => "🏠 خانه"]
        ]
    ],
    'resize_keyboard' => true
];
$OldMarkup = [
    'keyboard' => [
        [
            ['text' => "10"],
            ['text' => "11"],
            ['text' => "12"],
            ['text' => "13"],
            ['text' => "14"]
        ],
        [
            ['text' => "15"],
            ['text' => "16"],
            ['text' => "17"],
            ['text' => "18"],
            ['text' => "19"]
        ],
        [
            ['text' => "20"],
            ['text' => "21"],
            ['text' => "22"],
            ['text' => "23"],
            ['text' => "24"]
        ],
        [
            ['text' => "25"],
            ['text' => "26"],
            ['text' => "27"],
            ['text' => "28"],
            ['text' => "29"]
        ],
        [
            ['text' => "30"],
            ['text' => "31"],
            ['text' => "32"],
            ['text' => "33"],
            ['text' => "34"]
        ],
        [
            ['text' => "35"],
            ['text' => "36"],
            ['text' => "37"],
            ['text' => "38"],
            ['text' => "39"]
        ],
        [
            ['text' => "40"],
            ['text' => "41"],
            ['text' => "42"],
            ['text' => "43"],
            ['text' => "44"]
        ],
        [
            ['text' => "45"],
            ['text' => "46"],
            ['text' => "47"],
            ['text' => "48"],
            ['text' => "49"]
        ],
        [
            ['text' => "+ 50"],
            ['text' => "- 9"]
        ],

    ],
    'resize_keyboard' => true
];
$OldMarkup2 = [
    'keyboard' => [
        [
            ['text' => "🏠 خانه"],
            ['text' => "🔙 برگشت"]
        ],
        [
            ['text' => "10"],
            ['text' => "11"],
            ['text' => "12"],
            ['text' => "13"],
            ['text' => "14"]
        ],
        [
            ['text' => "15"],
            ['text' => "16"],
            ['text' => "17"],
            ['text' => "18"],
            ['text' => "19"]
        ],
        [
            ['text' => "20"],
            ['text' => "21"],
            ['text' => "22"],
            ['text' => "23"],
            ['text' => "24"]
        ],
        [
            ['text' => "25"],
            ['text' => "26"],
            ['text' => "27"],
            ['text' => "28"],
            ['text' => "29"]
        ],
        [
            ['text' => "30"],
            ['text' => "31"],
            ['text' => "32"],
            ['text' => "33"],
            ['text' => "34"]
        ],
        [
            ['text' => "35"],
            ['text' => "36"],
            ['text' => "37"],
            ['text' => "38"],
            ['text' => "39"]
        ],
        [
            ['text' => "40"],
            ['text' => "41"],
            ['text' => "42"],
            ['text' => "43"],
            ['text' => "44"]
        ],
        [
            ['text' => "45"],
            ['text' => "46"],
            ['text' => "47"],
            ['text' => "48"],
            ['text' => "49"]
        ],
        [
            ['text' => "+ 50"],
            ['text' => "- 9"]
        ],

    ],
    'resize_keyboard' => true
];
$LikeMarkup = [
    'inline_keyboard' => [
        [
            ['text' => "👍🏻 {$side["like"]}", 'callback_data' => "like"],
            ['text' => "👎🏻 {$side["dislike"]}", 'callback_data' => "dislike"]
        ],
    ]
];
$LikeMarkup2 = [
    'inline_keyboard' => [
        [
            ['text' => "👍🏻 {$userside["like"]}", 'callback_data' => "like"],
            ['text' => "👎🏻 {$userside["dislike"]}", 'callback_data' => "dislike"]
        ],
    ]
];
$LikeMarkup3 = [
    'inline_keyboard' => [
        [
            ['text' => "👍🏻 {$user["like"]}", 'callback_data' => "like"],
            ['text' => "👎🏻 {$user["dislike"]}", 'callback_data' => "dislike"]
        ],
    ]
];
$VerifyMarkup = [
    'inline_keyboard' => [
        [
            ['text' => "🔔 عضویت در کانال", 'url' => "https://t.me/$channel"]
        ],
        [
            ['text' => "📢 عضو شدم", 'callback_data' => 'join']
        ],
    ]
];
$CancelSearchMarkup = [
    'keyboard' => [
        [
            ['text' => "❌ لغو جست و جو"]
        ],

    ],
    'resize_keyboard' => true
];
//////////////////////////Markups////////////////////////


///////menu////////
switch ($textMessage) {
    case strpos($textMessage, 'prev_') !== false:
        $text = explode('_', $textMessage);
        $last_id = $text[1];
        $query = "SELECT id,name,province,city,sex,old FROM user WHERE status = '1' and province='$user_province'";
        $res = mysqli_query($connect, $query);
        $num = mysqli_num_rows($res);
        $records = array();
        while ($fetch = mysqli_fetch_assoc($res)) {
            $records[] = $fetch;
        }
        if ($last_id % $list_limit == 0) {
            $endponit = $last_id - $list_limit;
        } else {
            $last_id = $last_id - ($last_id % $list_limit);
            $endponit = $last_id;
        }
        $result = "👇 افراد آنلاین هم استانی شما.👇" . PHP_EOL . PHP_EOL;
        $cnt = ($num >= $list_limit) ? $list_limit : $num;
        for ($i = $endponit - $list_limit; $i <= $endponit; $i++) {
            $id = $records[$i]['id'];
            $name = $records[$i]['name'];
            $province = $records[$i]['province'];
            $city = $records[$i]['city'];
            if ($records[$i]['sex'] == "پسر") {
                $sex = "🤴🏻";
            } else {
                $sex = "👸🏻";
            }
            $old = $records[$i]['old'];
            $result .= ($i + 1) . "." . "$name" . " $sex" . " $city" . "/member_" . $id . PHP_EOL . "========== " . "HOT 🔥 CHAT" . " ==========" . PHP_EOL;
        }
        if ($num > $last_id and $endponit - $list_limit > 0) {
            $result .= "🔍 $num آنلاین 🔍";
            editMessage($chat_id, $message_id, urlencode($result) . inline_btn(array('صفحه ی بعد', 'next_' . $endponit, 'صفحه ی قبل', 'prev_' . $endponit)));
        } else {
            $result .= "🔍 $num آنلاین 🔍";
            editMessage($chat_id, $message_id, urlencode($result) . inline_btn(array('صفحه ی بعد', 'next_' . $endponit)));
        }
        break;
    case strpos($textMessage, '/member_') !== false:
        $markup = inline_btn(array("💬 درخواست چت", "chat", "🛑 گزارش تخلف", "🛑 گزارش تخلف", "👨‍👧‍👧 دوستی", "👨‍👧‍👧 دوستی", "🚫 بلاکش کن", "🚫 بلاکش کن"));
        $pro_id = explode('_', $textMessage);
        $userside = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = $pro_id[1] LIMIT 1"));
        $profile_text = urlencode("🎫 مشخصات طرف مقابلت 👇🏻
                                                          ONLINE 🟢 
                                                          	   
🆔 شناسه :{$userside["id"]}
🗣 نام : {$userside["name"]}
🌟 جنسیت : {$userside["sex"]}
🎊 سن : {$userside["old"]} سال
🏢 استان : {$userside["province"]}
🏢 شهر : {$userside["city"]}
⏰ آخرین بازدید : {$userside["lastSeen"]}
");


        if ($userside["photo"] == true) {

            $bio = isset($userside["bio"]) ? $userside["bio"] : "تنظیم نشده !";
            photo($chat_id, $userside["photo"], $profile_text . $markup);
        } else {
            $photo = "AgACAgQAAxkBAAIPm17uK36QqDN0YT8Mb0SK-0PmubuwAAJbtTEb0bpwU6qlwMQ7iutTtFnUIl0AAwEAAwIAA3gAAwpYAwABGgQ";
            photo($chat_id, $photo, $profile_text . $markup);
        }
        break;
    case strpos($textMessage, 'next_') !== false:
        $text = explode('_', $textMessage);
        $last_id = $text[1];
        $query = "SELECT id,name,province,city,sex,old FROM user WHERE status = '1' and province='$user_province'";
        $res = mysqli_query($connect, $query);
        $num = mysqli_num_rows($res);
        $records = array();
        while ($fetch = mysqli_fetch_assoc($res)) {
            $records[] = $fetch;
        }
        if ($last_id + $list_limit < $num) {
            $endponit = $last_id + $list_limit;
        } else {
            $endponit = $num;
        }
        $result = "👇 افراد آنلاین هم استانی شما.👇" . PHP_EOL . PHP_EOL;
        $cnt = ($num >= $list_limit) ? $list_limit : $num;
        for ($i = $last_id; $i < $endponit; $i++) {
            $id = $records[$i]['id'];
            $name = $records[$i]['name'];
            $province = $records[$i]['province'];
            $city = $records[$i]['city'];
            if ($records[$i]['sex'] == "پسر") {
                $sex = $boy;
            } else {
                $sex = $girl;
            }
            $old = $records[$i]['old'];
            $result .= ($i + 1) . "." . "$name" . " $sex" . " $city" . "/member_" . $id . PHP_EOL . "========== " . "HOT 🔥 CHAT" . " ==========" . PHP_EOL;
        }
        if ($num > $last_id + $list_limit) {
            $result .= "🔍 $num آنلاین 🔍";
            editMessage($chat_id, $message_id, urlencode($result) . inline_btn(array('صفحه ی بعد', 'next_' . $endponit, 'صفحه ی قبل', 'prev_' . $endponit)));
        } else {
            $result .= "🔍 $num آنلاین 🔍";
            editMessage($chat_id, $message_id, urlencode($result) . inline_btn(array('صفحه ی قبل', 'prev_' . $endponit)));
        }
        break;
    case strpos($textMessage, 'Dprev_') !== false:
        $text = explode('_', $textMessage);
        $last_id = $text[1];
        $user_province = $user['province'];
        $query = "SELECT id,name,province,city,sex,old FROM user WHERE status = '1' and province='$user_province'";
        $res = mysqli_query($connect, $query);
        $num = mysqli_num_rows($res);
        $records = array();
        while ($fetch = mysqli_fetch_assoc($res)) {
            $records[] = $fetch;
        }
        if ($last_id % $list_limit == 0) {
            $endponit = $last_id - $list_limit;
        } else {
            $last_id = $last_id - ($last_id % $list_limit);
            $endponit = $last_id;
        }
        $result = "👇 افراد آنلاین هم استانی شما.👇" . PHP_EOL . PHP_EOL;
        $cnt = ($num >= $list_limit) ? $list_limit : $num;
        for ($i = $last_id; $i < $endponit; $i++) {
            $fetch = mysqli_fetch_assoc($res);
            $id = $records[$i]['id'];
            $name = $records[$i]['name'];
            $province = $records[$i]['province'];
            $city = $records[$i]['city'];
            if ($records[$i]['sex'] == "پسر") {
                $sex = "🤴🏻";
            } else {
                $sex = "👸🏻";
            }
            $old = $records[$i]['old'];
            $result .= $i . "." . "$name" . " $sex" . " $city" . "/member_" . $id . PHP_EOL . "========== " . "HOT 🔥 CHAT" . " ==========" . PHP_EOL;
        }
        if ($num > $last_id and $endponit - $list_limit > 0) {
            $result .= "🔍 $num آنلاین 🔍";
            editMessage($chat_id, $message_id, urlencode($result) . inline_btn(array('صفحه ی بعد', 'next_' . $endponit, 'صفحه ی قبل', 'prev_' . $endponit)));
        } else {
            $result .= "🔍 $num آنلاین 🔍";
            editMessage($chat_id, $message_id, urlencode($result) . inline_btn(array('صفحه ی بعد', 'next_' . $endponit)));
        }
        break;
    case strpos($textMessage, 'Dnext_') !== false:
        $text = explode('_', $textMessage);
        $last_id = $text[1];
        $user_province = $user['province'];
        $query = "SELECT id,name,province,city,sex,old FROM user WHERE status = '1' and province='$user_province'";
        $res = mysqli_query($connect, $query);
        $num = mysqli_num_rows($res);
        $records = array();
        while ($fetch = mysqli_fetch_assoc($res)) {
            $records[] = $fetch;
        }
        if ($last_id + $list_limit < $num) {
            $endponit = $last_id + $list_limit;
        } else {
            $endponit = $num;
        }
        $result = "👇 افراد آنلاین هم استانی شما.👇" . PHP_EOL . PHP_EOL;
        $cnt = ($num >= $list_limit) ? $list_limit : $num;
        for ($i = $last_id; $i < $endponit; $i++) {
            $fetch = mysqli_fetch_assoc($res);
            $id = $records[$i]['id'];
            $name = $records[$i]['name'];
            $province = $records[$i]['province'];
            $city = $records[$i]['city'];
            if ($records[$i]['sex'] == "پسر") {
                $sex = "🤴🏻";
            } else {
                $sex = "👸🏻";
            }
            $old = $records[$i]['old'];
            $result .= $i . "." . "$name" . " $sex" . " $city" . "/member_" . $id . PHP_EOL . "========== " . "HOT 🔥 CHAT" . " ==========" . PHP_EOL;
        }
        if ($num > $last_id + $list_limit) {
            $result .= "🔍 $num آنلاین 🔍";
            editMessage($chat_id, $message_id, urlencode($result) . inline_btn(array('صفحه ی بعد', 'Dnext_' . $endponit, 'صفحه ی قبل', 'Dprev_' . $endponit)));
        } else {
            $result .= "🔍 $num آنلاین 🔍";
            editMessage($chat_id, $message_id, urlencode($result) . inline_btn(array('صفحه ی قبل', 'Dprev_' . $endponit)));
        }
        break;
}
///////menu////////
if ($textMessage == "/start") {
    if ($user["state"] != true) {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "😄 سلام $first_name
	
به ربات چت ناشناسه 《 $robotName 》 خوش آمدید 🌹

🎊 با استفاده از این ربات میتونی با  جنس مخالفت , همسنت , هم شهری یا افراد نزدیک بهت حرف بزنی و دوست بشی
💑 همراه با کلی امکانات دیگ ...

🌟 خوب اول باید اطلاعات خود را ثبت کنی ! جنسیت خودت رو انتخاب کن ؟ 👇🏻",
            'reply_to_message_id' => $message_id,
            'reply_markup' => json_encode($GenderMarkup)
        ]);
        $connect->query("INSERT INTO user (id, step, coin, member,  name , photo , sex , city , old , stats , `like` , dislike , blocklist , frindlist , gps , vip , bio , baner , daily , side , liker , time,status,lastSeen,province) VALUES ('$from_id', 'setsex', '8', '0', '' , '' , '' , '' , '0' , '', '0', '0', '', '', '', '' , '' , '' , '' , '0' , '' , '', '1','','')");
    } else {
        if ($user["step"] != "chat" && $user["step"] != "offline") {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "😄 سلام $first_name
	
به ربات چت ناشناسه 《 $robotName 》 خوش آمدید 🌹

🎊 با استفاده از این ربات میتونی با  جنس مخالفت , همسنت , هم شهری یا افراد نزدیک بهت حرف بزنی و دوست بشی
💑 همراه با کلی امکانات دیگ ...

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                'reply_to_message_id' => $message_id,
                'reply_markup' => json_encode($HomeMarkup)
            ]);
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "🤖 پیام سیستم 👇
	
`❗️ ابتدا باید به چت پایان دهید . سپس نسبت به ارسال دستور اقدام کنید ! .`
🌟 برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی 👇🏻",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode($InChatMarkup)
            ]);
        }
    }
} elseif ($textMessage == "ONLINE ✅") {
    $connect->query("UPDATE user SET status = '1',step ='none' WHERE id = '$from_id' LIMIT 1");
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "✅آنلاین شدید👇🏻
        شما در لیست آنلاین قرار گرفتتید
        و دیگران میتوانند به شما درخواست چت ارسال کنند
        برای آفلاین شدن دکمه OFFLINE ❌ را فشار دهید.  ",
        'reply_to_message_id' => $message_id,
        'reply_markup' => json_encode($HomeMarkup)
    ]);
} elseif ($textMessage == "OFFLINE ❌") {
    $time = date("H:i:s", strtotime("+10 seconds"));
    $connect->query("UPDATE user SET step = 'offline',status = '0',lastSeen ='$time' WHERE id = '$from_id' LIMIT 1");
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "❌آفلاین شدید🏻😢
شما آفلاین شدید امیدوارم زود برگردید❤
برای آنلاین شدن متونید دکمه ONLINE ✅ رو فشار دهید. 
          ",
        'reply_to_message_id' => $message_id,
        'reply_markup' => json_encode($HomeMarkup2)
    ]);
} elseif ($textMessage == "💬 پایان چت" && $tc == "private") {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "🤖 پیام سیستم 👇 

🗣 `ایا از پایان دادن به گفت و گو  با طرف مقابلت اطمینان داری ؟`",
        'reply_to_message_id' => $message_id,
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    ['text' => "✅ بله", 'callback_data' => "endy"],
                    ['text' => "❌ خیر", 'callback_data' => "endn"]
                ],
            ]
        ])
    ]);
} elseif ($textMessage == "🛑 گزارش تخلف" && $tc == "private") {
    if ($user["step"] == "chat") {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "🤖 پیام سیستم 👇 

🗣 `ایا از پایان دادن به چت و ارسال گزارش تخلف کاربر مقابل اطمینان دارید ؟`",
            'reply_to_message_id' => $message_id,
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => "✅ بله", 'callback_data' => "viy"],
                        ['text' => "❌ خیر", 'callback_data' => "endn"]
                    ],
                ]
            ])
        ]);
    } else {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "🗣 از این که به ما در گزارش کاربران متخلف یاری میرسانید مشترکیم 
🔘 `لطفا به صورت توضیح کوچک یا بهتر است از اسکرین شات [عکس صحفه] برای نمایش تخلف کاربر استفاده کنید`

گزارش خود را در قالب یک پیام ارسال کنید 👇🏻",
            'parse_mode' => 'Markdown',
            'reply_to_message_id' => $message_id,
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "❌ لغو ارسال گزارش"]
                    ]
                ],
                'resize_keyboard' => true
            ])
        ]);
        $connect->query("UPDATE user SET step = 'report' WHERE id = '$from_id' LIMIT 1");
    }
} elseif ($textMessage == "👁 مشاهده پروفایل" || $textMessage == "prof" && $tc == "private") {
    if ($user["member"] > 5 or $user["vip"] == true) {
        $userside = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$user["side"]}' LIMIT 1"));
        if ($user["step"] == "chat") {
            if ($userside["photo"] == true) {
                $bio = isset($userside["bio"]) ? $userside["bio"] : "تنظیم نشده !";
                $id = MainBot('sendphoto', [
                    'chat_id' => $chat_id,
                    'photo' => $userside["photo"],
                    'caption' => $bio,
                    'reply_markup' => json_encode($LikeMarkup2)
                ])->result->message_id;
            } else {
                $id = MainBot('sendphoto', [
                    'chat_id' => $chat_id,
                    'photo' => "https://t.me/GTele_Channel/58",
                    'caption' => "$bio",
                ])->result->message_id;
            }
            if ($userside["status"] == 1) {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🎫 مشخصات طرف مقابلت 👇🏻
                                                          ONLINE 🟢 
                                                          	   
🆔 شناسه : {$userside["id"]}
🗣 نام : {$userside["name"]}
🌟 جنسیت : {$userside["sex"]}
🎊 سن : {$userside["old"]} سال
🏢 استان : {$userside["province"]}
🏢 شهر : {$userside["city"]}
👀 ",
                    'reply_to_message_id' => $id,
                ]);
            } else {
                message($chat_id, urlencode($profile_text) . inline_btn(array("🛑 گزارش تخلف", "🛑 گزارش تخلف", "👁 مشاهده پروفایل", "prof", "👨‍👧‍👧 دوستی", "👨‍👧‍👧 دوستی", "🚫 بلاکش کن", "🚫 بلاکش کن", "🏠 خانه", "home")));
            }
        } else {
            if ($userside["photo"] == true) {
                $bio = isset($userside["bio"]) ? $userside["bio"] : "تنظیم نشده !";
                $id = MainBot('sendphoto', [
                    'chat_id' => $chat_id,
                    'photo' => $userside["photo"],
                    'caption' => $bio,
                    'reply_markup' => json_encode($LikeMarkup2)
                ])->result->message_id;
            } else {
                $id = MainBot('sendphoto', [
                    'chat_id' => $chat_id,
                    'photo' => "https://t.me/GTele_Channel/58",
                    'caption' => "$bio",
                ])->result->message_id;
            }
            if ($userside["status"] == 1) {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🎫 مشخصات طرف مقابلت 👇🏻
	
🆔 شناسه : {$userside["id"]}
🗣 نام : {$userside["name"]}
🌟 جنسیت : {$userside["sex"]}
🎊 سن : {$userside["old"]} سال
🏢 استان : {$userside["province"]}
🏢 شهر : {$userside["city"]}
👀 طرف مقابل اکنون انلاین است !",
                    'reply_to_message_id' => $id,
                ]);
            } else {
                message($chat_id, urlencode($profile_text) . inline_btn(array("🛑 گزارش تخلف", "🛑 گزارش تخلف", "👁 مشاهده پروفایل", "prof", "👨‍👧‍👧 دوستی", "👨‍👧‍👧 دوستی", "🚫 بلاکش کن", "🚫 بلاکش کن", "🏠 خانه", "home")));
            }
        }
    } else {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "🤖 پیام سیستم 👇 
	
🗣 `حساب شما در ربات ویژه نیست . برای مشاهده پروفایل طرف مقابل باید حساب شما در ربات ویژه باشد`
🌟 بعد از پایان چت میتوانید 

با استفاده از دکمه '💰 سکه رایگان'  با دعوت دیگران به ربات اقدام به افزایش سکه و ویژه کردن حساب خود در ربات کنید 👇🏻
با استفاده از دکمه '🎁 حساب ویژه' با پرداخت هزینه نسبت به افزایش سکه و حساب ویژه اقدام کنید",
            'reply_to_message_id' => $message_id,
            'parse_mode' => 'Markdown',
        ]);
    }
} elseif ($textMessage == "👨‍👧‍👧 دوستی") {
    $all = explode("^", $user["frindlist"]);
    if (!in_array($user["side"], $all)) {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "`✅ کاربر با موفقیت به لیست دوستان شما اضافه شد .`
	
🔘 شما میتوانید در منوی اصلی ربات لیست دوستان خود را مشاهده کنید
ℹ️ شما میتوانید با کاربران موجود در لیست دوستان خود ارتباط برقرار کنید بعد از تمام گفت گو ",
            'parse_mode' => 'Markdown',
            'reply_to_message_id' => $message_id,
        ]);
        $connect->query("UPDATE user SET frindlist = CONCAT (frindlist,'{$user["side"]}^') WHERE id = '$from_id' LIMIT 1");
    } else {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "`❗️ کاربر قبلا در لیست دوستان شما بوده است`",
            'parse_mode' => 'Markdown',
            'reply_to_message_id' => $message_id,
        ]);
    }
} elseif ($textMessage == "🚫 بلاکش کن" || $textMessage == "block" && $tc == "private") {
    if ($user["step"] == "chat") {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "🤖 پیام سیستم 👇 

🗣 `ایا از پایان دادن به چت و  افزودن کاربر به لیست بلاک اطمینان دارید ؟`
ℹ️ کاربرانی که در لیست بلاک شما قرار دارند امکان گفت و گو ودوباره و ارسال پیام به شما را ندارند",
            'reply_to_message_id' => $message_id,
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => "✅ بله", 'callback_data' => "bly"],
                        ['text' => "❌ خیر", 'callback_data' => "endn"]
                    ],
                ]
            ])
        ]);
    } else {
        $all = explode("^", $user["blocklist"]);
        if (!in_array($user["side"], $all)) {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "`✅ کاربر با موفقیت به لیست بلاک شما اضافه شد .`
❗️ کاربر دیگر امکان ارتباط یا ارسال پیام به شما را ندارد
	
🔘 شما میتوانید در منوی اصلی ربات بلاک لیست خود را مشاهده کنید",
                'parse_mode' => 'Markdown',
                'reply_to_message_id' => $message_id,
            ]);
            $connect->query("UPDATE user SET blocklist = CONCAT (blocklist,'{$user["side"]}^') WHERE id = '$from_id' LIMIT 1");
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "`❗️ کاربر قبلا در بلاک لیست شما بوده است`",
                'parse_mode' => 'Markdown',
                'reply_to_message_id' => $message_id,
            ]);
        }
    }
} elseif ($user["step"] == "chat" && $tc == "private") {
    if ($user["member"] < 5 and $user["vip"] != true) {
        if (array_key_exists('message', $update)) {
            MainBot('sendmessage', [
                'chat_id' => $user["side"],
                'text' => $textMessage,
            ]);
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "🤖 پیام سیستم 👇
	
`❗️ کاربران عادی در چت تنها میتوانند پیام ارسال کنند و ارسال رسانه ممکن نیست .`
🌟 بعد از پایان چت میتوانید 

با استفاده از دکمه '💰 سکه رایگان'  با دعوت دیگران به ربات اقدام به افزایش سکه و ویژه کردن حساب خود در ربات کنید 👇🏻
با استفاده از دکمه '🎁 حساب ویژه' با پرداخت هزینه نسبت به افزایش سکه و حساب ویژه اقدام کنید",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
            ]);
        }
    } else {
        switch (true) {
            case isset($update->message->text):
                MainBot('sendmessage', [
                    'chat_id' => $user["side"],
                    'text' => $update->message->text,
                ]);
                break;
            case isset($update->message->audio):
                MainBot('sendaudio', [
                    'chat_id' => $user["side"],
                    'audio' => $update->message->audio->file_id,
                    'caption' => $caption,
                ]);
                break;
            case isset($update->message->document):
                MainBot('senddocument', [
                    'chat_id' => $user["side"],
                    'document' => $update->message->document->file_id,
                    'caption' => $caption,
                ]);
                break;
            case isset($update->message->photo):
                $photo = $update->message->photo;
                MainBot('sendphoto', [
                    'chat_id' => $user["side"],
                    'photo' => $photo[count($photo) - 1]->file_id,
                    'caption' => $caption,
                ]);
                break;
            case isset($update->message->video):
                MainBot('sendvideo', [
                    'chat_id' => $user["side"],
                    'video' => $update->message->video->file_id,
                    'caption' => $caption,
                ]);
                break;
            case isset($update->message->voice):
                MainBot('sendvoice', [
                    'chat_id' => $user["side"],
                    'voice' => $update->message->voice->file_id,
                    'caption' => $caption,
                ]);
                break;
            case isset($update->message->video_note):
                MainBot('sendVideoNote', [
                    'chat_id' => $user["side"],
                    'video_note' => $update->message->video_note->file_id,
                    'caption' => $caption,
                ]);
                break;
            case isset($update->message->sticker):
                MainBot('sendSticker', [
                    'chat_id' => $user["side"],
                    'sticker' => $update->message->sticker->file_id,
                ]);
                break;
        }
    }
} elseif (preg_match('/^(\/start)(.*)/', $textMessage)) {
    $start = str_replace("/start ", "", $textMessage);
    if (preg_match('/^(in_)(.*)/', $start)) {
        if ($user["id"] == true && $user["step"] != "offline") {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "😄 سلام $first_name
	
به ربات چت ناشناسه 《 $robotName 》 خوش آمدید 🌹

🎊 با استفاده از این ربات میتونی با  جنس مخالفت , همسنت , هم شهری یا افراد نزدیک بهت حرف بزنی و دوست بشی
💑 همراه با کلی امکانات دیگ ...

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                'reply_to_message_id' => $message_id,
                'reply_markup' => json_encode($HomeMarkup)
            ]);
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "😄 سلام $first_name
	
به ربات چت ناشناسه 《 $robotName 》 خوش آمدید 🌹

🎊 با استفاده از این ربات میتونی با  جنس مخالفت , همسنت , هم شهری یا افراد نزدیک بهت حرف بزنی و دوست بشی
💑 همراه با کلی امکانات دیگ ...

🌟 خوب اول باید اطلاعات خود را ثبت کنی ! جنسیت خودت رو انتخاب کن ؟ 👇🏻",
                'reply_to_message_id' => $message_id,
                'reply_markup' => json_encode($GenderMarkup)
            ]);
            $getuser = str_replace("in_", "", $start);
            $user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '$getuser' LIMIT 1"));
            $name = str_replace(["`", "*", "_", "[", "]", "(", ")", "```"], "", $first_name);
            $plusmember = $user["member"] + 1;
            $pluscoin = $user["coin"] + 1;
            MainBot('sendmessage', [
                'chat_id' => $getuser,
                'text' => "🌟 کاربر [$name](tg://user?id=$from_id) با استفاده از لینک دعوت شما وارد ربات شده
	
☑️ یک نفر به تعداد زیر مجموعه های شما اضافه شد همچنین یک سکه به شما تعلق گرفت .
💰 تعداد سکه : $pluscoin
👤 تعداد زیرمجموعه ها : $plusmember نفر",
                'parse_mode' => 'Markdown',
            ]);
            $connect->query("UPDATE user SET member = '$plusmember' , coin = '$pluscoin' WHERE id = '$getuser' LIMIT 1");
            $connect->query("INSERT INTO user (id, step, coin, member,  name , photo , sex , city , old , stats , `like` , dislike , blocklist , frindlist , gps , vip , bio , baner , daily , side , liker , time) VALUES ('$from_id', 'setsex', '8', '0', '' , '' , '' , '' , '0' , '', '0', '0', '', '', '', '' , '' , '' , '' , '0' , '' , '')");
        }
    } else {
        switch ($start) {
            case preg_match('/^(bl_)(.*)/', $start):
                $getuser = str_replace("fi_", "", $start);
                $userget = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '$getuser' LIMIT 1"));
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "✅ با موفقیت به منوی کاربری '{$userget["name"]}' متصل شدی !

🌟 در مورد دوستت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($ProfileMarkup2)
                ]);
                $connect->query("UPDATE user SET side = '$getuser' , stats = 'list' WHERE id = '$from_id' LIMIT 1");
                break;
            case preg_match('/^(fi_)(.*)/', $start):
                $getuser = str_replace("bl_", "", $start);
                $userget = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '$getuser' LIMIT 1"));
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "✅ با موفقیت به منوی کاربری '{$userget["name"]}' متصل شدی !

🌟 در مورد بلاک لیستت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($ProfileMarkup3)
                ]);
                $connect->query("UPDATE user SET side = '$getuser' , stats = 'list' WHERE id = '$from_id' LIMIT 1");
                break;
        }
    }
} elseif ($textMessage == "❌ لغو جست و جو" && $tc == "private") {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "🔍 `جست و جو با موفقیت لغو شد . شما از صف انتظار خارج شدید` 

🔘 به منوی اصلی بازگشتید 	
🌟 چه کاری برات انجام بدم ؟ از منوی پایین انتخاب کن 👇🏻",
        'reply_to_message_id' => $message_id,
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode($HomeMarkup)
    ]);
    $connect->query("DELETE FROM chat WHERE user_id = '$from_id'");
    $connect->query("DELETE FROM chatvip WHERE user_id = '$from_id'");
} elseif ($textMessage == "🏠 خانه" || $textMessage == "home" && $tc == "private") {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "🔘 `به منوی اصلی بازگشتید`
	
🌟 چه کاری برات انجام بدم ؟ از منوی پایین انتخاب کن 👇🏻",
        'reply_to_message_id' => $message_id,
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode($HomeMarkup)
    ]);
    $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
} elseif ($textMessage == "💰 سکه رایگان" && $tc == "private") {
    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        $getnamesub = mb_substr("$first_name", "0", "10") . "...";
        if (isset($user["photo"])) {
            if ($user["baner"] != true) {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "⏳ در حال ساخت بنر اختصاصی شما ...",
                    'reply_to_message_id' => $message_id,
                ]);
                $patch = MainBot('getfile', ['file_id' => $user["photo"]])->result->file_path;
                creatbanner("$patch");
                $id = MainBot('sendphoto', [
                    'chat_id' => $chat_id,
                    'photo' => new CURLFile("$from_id.png"),
                    'caption' => "$getnamesub دعوتت کرده
💬 که وارد ربات 《 $robotName 》 بشی و به صورت #ناشناس با #دیگران , #اطرافیانت  و ... چت کنی !
💯 واقعی و رایگان

👇 روی لینک زیر کلیک کن
telegram.me/$usernamebot?start=in_$from_id",
                ]);
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "💬 `پیام بالا حاوی لینک دعوت اختصاصی شما به ربات به همراه عکس پروفایل شماست .`
	
💰 با دعوت دوستان خود به ربات از طریق لینک دعوت خودتون به ازای هر نفر یک سکه دریافت میکنید
🎁 و زمانی که تعداد زیر مجموعه های شما به 5 نفر رسید حساب شما تبدیل به ویژه خواهد شد ! این عالیه نه ؟

🌟 منتظر چی هستی ؟ همین الان بنرت رو به گروه ها و دوستات بفرست و دعوتشون کن 

💰 تعداد سکه : {$user["coin"]}
👤 تعداد زیرمجموعه ها : {$user["member"]} نفر

🎊 `هر روز میتوانید با مراجعه به بخش سکه رایگان یک سکه به صورت هدیه به عنوان سکه روزانه دریافت کنید`",
                    'reply_to_message_id' => $id->result->message_id,
                    'parse_mode' => 'Markdown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => "🎊 سکه روزانه", 'callback_data' => "dailycoin"]
                            ],
                        ]
                    ])
                ]);
                unlink("$from_id.png");
                $connect->query("UPDATE user SET baner = '{$id->result->photo[4]->file_id}' WHERE id = '$from_id' LIMIT 1");
            } else {
                $id = MainBot('sendphoto', [
                    'chat_id' => $chat_id,
                    'photo' => $user["baner"],
                    'caption' => "$getnamesub دعوتت کرده
💬 که وارد ربات 《 $robotName 》 بشی و به صورت #ناشناس با #دیگران , #اطرافیانت  و ... چت کنی !
💯 واقعی و رایگان

👇 روی لینک زیر کلیک کن
telegram.me/$usernamebot?start=in_$from_id",
                ]);
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "💬 `پیام بالا حاوی لینک دعوت اختصاصی شما به ربات به همراه عکس پروفایل شماست .`
	
💰 با دعوت دوستان خود به ربات از طریق لینک دعوت خودتون به ازای هر نفر یک سکه دریافت میکنید
🎁 و زمانی که تعداد زیر مجموعه های شما به 5 نفر رسید حساب شما تبدیل به ویژه خواهد شد ! این عالیه نه ؟

🌟 منتظر چی هستی ؟ همین الان بنرت رو به گروه ها و دوستات بفرست و دعوتشون کن 

💰 تعداد سکه : {$user["coin"]}
👤 تعداد زیرمجموعه ها : {$user["member"]} نفر
⚠️ در صورتی که عکس پروفایل شما در ربات بروز شده است میتوانید با دکمه زیر بنر جدید دریافت کنید

🎊 `هر روز میتوانید با مراجعه به بخش سکه رایگان یک سکه به صورت هدیه به عنوان سکه روزانه دریافت کنید`",
                    'parse_mode' => 'Markdown',
                    'reply_to_message_id' => $id->result->message_id,
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => "🔄 بروزرسانی بنر", 'callback_data' => "recaverbaner"]
                            ],
                            [
                                ['text' => "🎊 سکه روزانه", 'callback_data' => "dailycoin"]
                            ],
                        ]
                    ])
                ]);
            }
        } else {
            $id = MainBot('sendphoto', [
                'chat_id' => $chat_id,
                'photo' => "https://t.me/GTele_Channel/59",
                'caption' => "$getnamesub دعوتت کرده
💬 که وارد ربات 《 $robotName 》 بشی و به صورت #ناشناس با #دیگران , #اطرافیانت  و ... چت کنی !
💯 واقعی و رایگان

👇 روی لینک زیر کلیک کن
telegram.me/$usernamebot?start=in_$from_id",
            ]);
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "💬 `پیام بالا حاوی لینک دعوت اختصاصی شما به ربات به همراه عکس پروفایل شماست .`
	
💰 با دعوت دوستان خود به ربات از طریق لینک دعوت خودتون به ازای هر نفر یک سکه دریافت میکنید
🎁 و زمانی که تعداد زیر مجموعه های شما به 5 نفر رسید حساب شما تبدیل به ویژه خواهد شد ! این عالیه نه ؟

🌟 منتظر چی هستی ؟ همین الان بنرت رو به گروه ها و دوستات بفرست و دعوتشون کن 

💰 تعداد سکه : {$user["coin"]}
👤 تعداد زیرمجموعه ها : {$user["member"]} نفر
⚠️ شما فاقد عکس پروفایل برای گذاشتن داخل بنر بودید برای تنظیم عکس شما روی بنر یک عکس پروفایل در بخش '👤 پروفایل'برای خود تنظیم کنید

🎊 `هر روز میتوانید با مراجعه به بخش سکه رایگان یک سکه به صورت هدیه به عنوان سکه روزانه دریافت کنید`",
                'parse_mode' => 'Markdown',
                'reply_to_message_id' => $id->result->message_id,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => "🎊 سکه روزانه", 'callback_data' => "dailycoin"]
                        ],
                    ]
                ])
            ]);
        }
    } else {
        MainBot('sendmessage', [
            "chat_id" => $chat_id,
            "text" => "$first_name عزیز 😄
💬 برای استفاده از ربات $robotName ابتدا باید وارد کانال 《 $channelname 》 شوید 👇🏻
		
📣 @$channel 📣 @$channel

☑️ بعد از عضویت بر روی دکمه عضو شدم ضربه بزنید تا ربات برای شما فعال شود",
            'reply_to_message_id' => $message_id,
            'reply_markup' => json_encode($VerifyMarkup)
        ]);
    }
} elseif ($textMessage == "💰 سکه" && $tc == "private") {
    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        if ($user["member"] < 5 and $user["vip"] != true) {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "🎁 `همین الان حساب خود را ویژه کن و از امکانات ربات استفاده کن !`
ℹ️ شما میتوانید با ویژه کردن حساب خود از امکانات زیر بهره مند شوید 👇🏻

1️⃣ امکان چت ناشناس در دسته های مختلف مثل چت با دختر , پسر , همشهری و...
2️⃣ امکان ارسال انواع رسانه مانند عکس و فیلم در چت 
3️⃣ امکان نمایش اطلاعات ثبت شده طرف مقابل
4️⃣ امکان ارسال پیام مستقیم به کاربر
🌟 و کلی امکانات فوق العاده دیگر ...

🆔 شناسه : $from_id
💰 تعداد سکه : {$user["coin"]}
💎 نوع حساب : عادی

💰 `شما در این قسمت میتوانید به خرید بسته های سکه نیز اقدام کنید .`
👮🏻 در صورت بروز هرگونه مشکل با پشتیبانی در تماس باشید .
💎 لطفا بسته مورد نظر خود را انتخاب کنید تا به صفحه پرداخت منتقل شوید .",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => "🌟 حساب ویژه | 3000 تومان", 'url' => "$web/pay/payvip.php?id=$from_id"]
                        ],
                        [
                            ['text' => "1️⃣ 10 سکه | 1000 تومان", 'url' => "$web/pay/pay.php?amount=1000&coin=10&id=$from_id"]
                        ],
                        [
                            ['text' => "2️⃣ 20 سکه | 2000 تومان", 'url' => "$web/pay/pay.php?amount=2000&coin=20&id=$from_id"]
                        ],
                        [
                            ['text' => "3️⃣ 70 سکه | 5000 تومان", 'url' => "$web/pay/pay.php?amount=5000&coin=70&id=$from_id"]
                        ],
                        [
                            ['text' => "4️⃣ 150 سکه | 10000 تومان", 'url' => "$web/pay/pay.php?amount=10000&coin=150&id=$from_id"]
                        ],
                        [
                            ['text' => "5️⃣ 300 سکه | 20000 تومان", 'url' => "$web/pay/pay.php?amount=20000&coin=300&id=$from_id"]
                        ],
                    ],
                ])
            ]);
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "💰 `شما در این قسمت میتوانید برای حساب خود سکه خرید کنید`

🆔 شناسه : $from_id
💰 تعداد سکه : {$user["coin"]}
💎 نوع حساب : ویژه

👮🏻 در صورت بروز هرگونه مشکل با پشتیبانی در تماس باشید .
💎 لطفا بسته مورد نظر خود را انتخاب کنید تا به صفحه پرداخت منتقل شوید .",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => "1️⃣ 10 سکه | 1000 تومان", 'url' => "$web/pay/pay.php?amount=1000&coin=10&id=$from_id"]
                        ],
                        [
                            ['text' => "2️⃣ 20 سکه | 2000 تومان", 'url' => "$web/pay/pay.php?amount=2000&coin=20&id=$from_id"]
                        ],
                        [
                            ['text' => "3️⃣ 70 سکه | 5000 تومان", 'url' => "$web/pay/pay.php?amount=5000&coin=70&id=$from_id"]
                        ],
                        [
                            ['text' => "4️⃣ 150 سکه | 10000 تومان", 'url' => "$web/pay/pay.php?amount=10000&coin=150&id=$from_id"]
                        ],
                        [
                            ['text' => "5️⃣ 300 سکه | 20000 تومان", 'url' => "$web/pay/pay.php?amount=20000&coin=300&id=$from_id"]
                        ],
                    ],
                ])
            ]);
        }
    } else {
        MainBot('sendmessage', [
            "chat_id" => $chat_id,
            "text" => "$first_name عزیز 😄
💬 برای استفاده از ربات $robotName ابتدا باید وارد کانال 《 $channelname 》 شوید 👇🏻
		
📣 @$channel 📣 @$channel

☑️ بعد از عضویت بر روی دکمه عضو شدم ضربه بزنید تا ربات برای شما فعال شود",
            'reply_to_message_id' => $message_id,
            'reply_markup' => json_encode($VerifyMarkup)
        ]);
    }
} elseif ($textMessage == "👮🏻 پشتیبانی" && $tc == "private") {
    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "👮🏻 همکاران ما در خدمت شما هستن !
	
🔘 در صورت وجود نظر , ایده , گزارش مشکل , پیشنهاد , ایراد سوال , یا انتقاد میتوانید با ما در ارتباط باشید 
💬 `لطفا پیام خود را به صورت فارسی و روان ارسال کنید`",
            'reply_to_message_id' => $message_id,
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "🏠 خانه"]
                    ]
                ],
                'resize_keyboard' => true
            ])
        ]);
        $connect->query("UPDATE user SET step = 'sup' WHERE id = '$from_id' LIMIT 1");
    } else {
        MainBot('sendmessage', [
            "chat_id" => $chat_id,
            "text" => "$first_name عزیز 😄
💬 برای استفاده از ربات $robotName ابتدا باید وارد کانال 《 $channelname 》 شوید 👇🏻
		
📣 @$channel 📣 @$channel

☑️ بعد از عضویت بر روی دکمه عضو شدم ضربه بزنید تا ربات برای شما فعال شود",
            'reply_markup' => json_encode($VerifyMarkup)
        ]);
    }
} elseif ($textMessage == "🎲 چت تصادفی" && $tc == "private") {
    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        if ($user["coin"] > 0) {
            $chat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT user_id FROM chat WHERE user_id NOT IN ('$from_id') LIMIT 1"));
            if ($chat["user_id"] == true) {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "☑️ به کاربر ناشناس متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'parse_mode' => 'Markdown',
                    'reply_markup' => json_encode($InChatMarkup)
                ]);
                MainBot('sendmessage', [
                    'chat_id' => $chat["user_id"],
                    'text' => "☑️ به کاربر ناشناس متصل شدی
🗣 به طرف مقابلت سلام کن 😄

 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                    'parse_mode' => 'Markdown',
                    'reply_markup' => json_encode($InChatMarkup)
                ]);
                $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                if ($side["photo"] == true) {
                    MainBot('sendphoto', [
                        'chat_id' => $chat_id,
                        'photo' => $side["photo"],
                        'caption' => $bio,
                        'reply_markup' => json_encode($LikeMarkup)
                    ]);
                } else {
                    MainBot('sendphoto', [
                        'chat_id' => $chat_id,
                        'photo' => "https://t.me/GTele_Channel/58",
                        'caption' => "$bio",
                    ]);
                }
                $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                if ($user["photo"] == true) {
                    MainBot('sendphoto', [
                        'chat_id' => $chat["user_id"],
                        'photo' => $user["photo"],
                        'caption' => $bio,
                        'reply_markup' => json_encode($LikeMarkup3)
                    ]);
                } else {
                    MainBot('sendphoto', [
                        'chat_id' => $chat["user_id"],
                        'photo' => "https://t.me/GTele_Channel/58",
                        'caption' => "$bio",
                    ]);
                }
                $time = date("H:i:s", strtotime("+10 seconds"));
                $connect->query("DELETE FROM chat WHERE user_id = '{$chat["user_id"]}' LIMIT 1");
                $pluscoin = $user["coin"] - 1;
                $connect->query("UPDATE user SET side = '{$chat["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                $pluscoin = $side["coin"] - 1;
                $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$chat["user_id"]}' LIMIT 1");
            } else {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "⚠️ `کاربری برای شروع چت پیدا نشد !`
🔍 شما در صف انتظار برای چت ناشناس قرار دارید !

🔔 قوانین ربات $robotName :

1️⃣ تبلیغات سایت ها ربات ها و کانال ها 
2️⃣ ارسال هرگونه محتوای غیر اخلاقی
3️⃣ ایجاد مزاحمت برای کاربران 
4️⃣ پخش اطلاعات شخصی دیگران
5️⃣ استفاده از کلمات یا عکس غیر اخلاقی و یا توهین آمیز در پروفایل 
6️⃣ ثبت اطلاعات نادرست در پروفایل 
7️⃣ بستن چت بیهوده به صورت مکرر

❗️ رعایت نکردن هر یک از موارد بالا باعث مسدودیت همیشگی شما در ربات خواهد شد

🌟 `سیستم خودکار شما را به اولین کاربر متصل خواهد کرد لطفا منتظر باشید ...`",
                    'parse_mode' => 'Markdown',
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($CancelSearchMarkup)
                ]);
                $connect->query("INSERT INTO chat (user_id) VALUES ('$from_id')");
            }
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "⚠️ تعداد سکه شما کافی نمیباشد !
ℹ️ `برای شروع چت حداقل یک سکه نیاز دارید`

🎁 شما میتوانید با استفاده از دکمه '💰 سکه رایگان'  با دعوت دیگران به ربات اقدام به افزایش سکه و ویژه کردن حساب خود در ربات کنید 👇🏻
💎 همچنین میتوانید با استفاده از دکمه '🎁 حساب ویژه' با پرداخت هزینه نسبت به افزایش سکه و حساب ویژه اقدام کنید",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode($HomeMarkup)
            ]);
        }
    } else {
        MainBot('sendmessage', [
            "chat_id" => $chat_id,
            "text" => "$first_name عزیز 😄
💬 برای استفاده از ربات $robotName ابتدا باید وارد کانال 《 $channelname 》 شوید 👇🏻
		
📣 @$channel 📣 @$channel

☑️ بعد از عضویت بر روی دکمه عضو شدم ضربه بزنید تا ربات برای شما فعال شود",
            'reply_markup' => json_encode($VerifyMarkup)
        ]);
    }
} elseif ($textMessage == "👨‍👧‍👧 لیست دوستان" && $tc == "private") {
    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        $all = explode("^", $user["frindlist"]);
        $count = count($all) - 1;
        if ($count > 0) {
            for ($z = 0; $z <= $count - 1; $z++) {
                $zplus  = $z + 1;
                $user = mysqli_fetch_assoc(mysqli_query($connect, "select * from user WHERE id = '$all[$z]'"));
                $name = str_replace(["`", "*", "_", "[", "]", "(", ")", "```"], "", $user["name"]);
                $result = $result . "$zplus - [$name](https://t.me/$usernamebot?start=fi_$all[$z])" . "\n";
            }
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "👨‍👧‍👧لیست دوستان شما در ربات $robotName :
ℹ️ تعداد دوستان شما : $count

$result

🗣 برای مشاهده پروفایل روی اسم دوستت ضربه بزن و بعدش دکمه 'START' رو بزن",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [
                            ['text' => "🗑 حذف لیست"],
                            ['text' => "🏠 خانه"]
                        ],

                    ],
                    'resize_keyboard' => true
                ])
            ]);
            $connect->query("UPDATE user SET step = 'frind' WHERE id = '$from_id' LIMIT 1");
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "`☹️ شما هیچ دوستی ندارد لطفا ابتدا با استفاده از دکمه های زیر شروع به اغاز یک گفت و گو کنید 👇🏻`
	
🗣 سپس با استفاده از دکمه '👨‍👧‍👧 دوستی' طرف مقابلت رو به لیست دوستات اضافه کنی",
                'parse_mode' => 'Markdown',
                'reply_to_message_id' => $message_id,
                'reply_markup' => json_encode($HomeMarkup)
            ]);
        }
    } else {
        MainBot('sendmessage', [
            "chat_id" => $chat_id,
            "text" => "$first_name عزیز 😄
💬 برای استفاده از ربات $robotName ابتدا باید وارد کانال 《 $channelname 》 شوید 👇🏻
		
📣 @$channel 📣 @$channel

☑️ بعد از عضویت بر روی دکمه عضو شدم ضربه بزنید تا ربات برای شما فعال شود",
            'reply_markup' => json_encode($VerifyMarkup)
        ]);
    }
} elseif ($textMessage == "🚫 بلاک لیست" && $tc == "private") {
    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        $all = explode("^", $user["blocklist"]);
        $count = count($all) - 1;
        if ($count > 0) {
            for ($z = 0; $z <= $count - 1; $z++) {
                $zplus  = $z + 1;
                $user = mysqli_fetch_assoc(mysqli_query($connect, "select * from user WHERE id = '$all[$z]'"));
                $name = str_replace(["`", "*", "_", "[", "]", "(", ")", "```"], "", $user["name"]);
                $result = $result . "$zplus - [$name](https://t.me/$usernamebot?start=bl_$all[$z])" . "\n";
            }
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "🚫 بلاک لیست شما در ربات $robotName
ℹ️ تعداد افراد در بلاک لیست : $count

$result

🗣 برای مشاهده پروفایل روی اسم ضربه بزن و بعدش دکمه 'START' رو بزن",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [
                            ['text' => "🗑 حذف لیست"],
                            ['text' => "🏠 خانه"]
                        ],

                    ],
                    'resize_keyboard' => true
                ])
            ]);
            $connect->query("UPDATE user SET step = 'block' WHERE id = '$from_id' LIMIT 1");
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "☹️ شما هیچ کاربری را در بلاک لیست خود ندارد
🗣 شما میتوانید با استفاده از دکمه '🚫 بلاکش کن' طرف مقابلت رو به بلاک لیست اضافه کنی

❗️ `توجه کنید افرادی که در بلاک لیست شما قرار دارند امکان گفت و گوی دوباره و ارسال پیام برای شما رو ندارند`",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
            ]);
        }
    } else {
        MainBot('sendmessage', [
            "chat_id" => $chat_id,
            "text" => "$first_name عزیز 😄
💬 برای استفاده از ربات $robotName ابتدا باید وارد کانال 《 $channelname 》 شوید 👇🏻
		
📣 @$channel 📣 @$channel

☑️ بعد از عضویت بر روی دکمه عضو شدم ضربه بزنید تا ربات برای شما فعال شود",
            'reply_markup' => json_encode($VerifyMarkup)
        ]);
    }
} elseif ($textMessage == "💡 راهنما" && $tc == "private") {
    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "💡 راهنمای کامل ربات $robotName برای بخش های مختلف ربات .
	
🙃 خوب تو این قسمت من باهات یکم خودمونی تر حرف میزنم تا بهت متوجه بشی :) 
🚦 یک سری قسمت های ربات که قابل فهمه و توضیحات داره . اما خوب ممکنه یک سری قسمت ها نیاز به توضیح یا راهنمایی بیش تری داشته باشه که ما تو راهنما کامل برات توضیح میدیم

🤖 ربات $robotName چیه ؟ یک ربات برای گفت گو با دیگران به صورت ناشناس یا همراه با معیار های خاص مثلا طرف مقابلم حتما دختر یاشه یا همشهری باشه یا ... در واقع $robotName یک ربات دوست یابیه
🗣 سیاست ربات چطوریه ؟ ربات دارای دو نوع حسابه یعنی کاربر عادی و کاربر ویژه کاربران عادی از همه امکانات ربات نمیتونن استفاده کنن اما کاربران ویژه میتونن از همه امکانات ربات استفاده کنند اما نه به صورت نامحدود

💰 این محدودیت چطوری ایجاد شده ؟ این محدودیت رو ما به وسیله سکه ایجاد کردیم شما در قبال بعضی چیزا مثل شروع چت یا درخواست چت باید سکه پرداخت کنید این محدودیت همه کاربرا یعنی ویژه و عادی رو شامل میشه

💬 چت ناشناس : این دکمه شمارو به یکی از افراد انلاین در ربات به صورت رندوم متصل میکنه تا باهاش گفت و گو کنید
📡 چت با GPS : شاید تا حالا دلت خواسته باشه با افرادی که خیلی بهت نزدیکن گفت و گو داشته باشی ؟ این دکمه بر اساس موقعیتی که ذخیره کرده نزدیک ترین افراد رو بهت وصل میکنه
⚙️ برای تنظیمش به موارد زیر توجه داشته باش :

⚠️ توجه کنید پس از روشن کردن GPS پانزده ثانیه صبر کنید سپس روی '🏢 ارسال موقعیت مکانی'  ضربه بزنید 
❗️ توجه کنید حتما برای ارسال موقعیت مکانی GPS [مکان] گوشی خود را روشن کنید
📹 یه فیلم اموزشی برات اخر کار قرار میدم تا دچار مشکل نشی !

👨‍👧‍👧 لیست دوستان : شاید دلت بخواد با یک کاربری بعدن هم بتونی ارتباط برقرار کنی یا پروفایلش رو چک کنی . لیست دوستان مخصوص همین چیزاست
🚫 بلاک لیست : شاید دلت بخواد دیگه کاربری رو کلا نبینی نه بتونه پیام بده نه درخواست . بلاک لیست مخصوص همین کاره 

👤 پروفایل : این بخش مخصوص پروفایل توعه چیزایی که میخوای برای دیگران نمایش داده بشه و بر اساسشون تو حساب داشته باشی اینجا نشون داده میشن . یادت نره اطلاعات غیر واقعی نزنی که مسدود میشی

💰 سکه رایگان : شاید دلت بخواد بدون هزینه حسابت رو ویژه کنی یا سکه افزایش بدی . این بخش علاوه بره حمایت از ما به خودتم کمک میکنه
🎁 حساب ویژه : اگر میخوای سکه هاتو یا حسابت رو با خرید ویژه کنی این بخش بسته های فوق العاده رو در اختیارت گذاشته

👮🏻 حالا اگر برات سوالی مونده یا قسمتی برات گیج کنندست یا اشکالی چیزی داری از دکمه پشتیبانی استفاده کن و پیامت رو بفرست تا برسی کنیم

🔔 قوانین ربات $robotName :

1️⃣ تبلیغات سایت ها ربات ها و کانال ها 
2️⃣ ارسال هرگونه محتوای غیر اخلاقی
3️⃣ ایجاد مزاحمت برای کاربران 
4️⃣ پخش اطلاعات شخصی دیگران
5️⃣ استفاده از کلمات یا عکس غیر اخلاقی و یا توهین آمیز در پروفایل 
6️⃣ ثبت اطلاعات نادرست در پروفایل 
7️⃣ بستن چت بیهوده به صورت مکرر
❗️ رعایت نکردن هر یک از موارد بالا باعث مسدودیت همیشگی شما در ربات خواهد شد

💬 @$usernamebot
",
            'reply_to_message_id' => $message_id,
            'disable_web_page_preview' => true,
            'parse_mode' => 'Markdown',
        ]);
    } else {
        MainBot('sendmessage', [
            "chat_id" => $chat_id,
            "text" => "$first_name عزیز 😄
💬 برای استفاده از ربات $robotName ابتدا باید وارد کانال 《 $channelname 》 شوید 👇🏻
		
📣 @$channel 📣 @$channel

☑️ بعد از عضویت بر روی دکمه عضو شدم ضربه بزنید تا ربات برای شما فعال شود",
            'reply_to_message_id' => $message_id,
            'reply_markup' => json_encode($VerifyMarkup)
        ]);
    }
} elseif (in_array($textMessage, array("👤 پروفایل", "🔙 برگشت")) && $tc == "private") {


    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        $allfrind = count(explode("^", $user["frindlist"])) - 1;
        $allblock = count(explode("^", $user["blocklist"])) - 1;
        if ($user["member"] >= 5 or $user["vip"] == true) {
            $type = "ویژه";
        } else {
            $type = "عادی";
        }
        $gps = ($user["gps"] == true) ? "تنظیم شده !" : "مشخص نشده !";
        $profile_text = urlencode("🎫 پروفایل شما در ربات $robotName :
	
🆔 شناسه : $from_id

وضعیت : ✅ آنلاین 

🗣 نام : {$user["name"]}

🌟 جنسیت : {$user["sex"]}
🎊 سن : {$user["old"]} سال
🏢 استان : {$user["province"]}
🏢 شهر : {$user["city"]}

💰 تعداد سکه : {$user["coin"]}
💎 نوع حساب : $type
👤 تعداد زیرمجموعه ها : {$user["member"]} نفر

👨‍👧‍👧 تعداد دوستان : $allfrind نفر
🚫 تعداد افراد بلاک : $allblock نفر
👑 وضعیت موقعیت مکانی GPS : $gps

❗️ توجه کنید با ویرایش هر یک از قسمت ها یک سکه از شما کسر خواهد شد !");
        $profile_text2 = urlencode("🎫 پروفایل شما در ربات $robotName :
	
🆔 شناسه : $from_id

وضعیت : ❌ آفلاین 

🗣 نام : {$user["name"]}

🌟 جنسیت : {$user["sex"]}
🎊 سن : {$user["old"]} سال
🏢 استان : {$user["province"]}
🏢 شهر : {$user["city"]}

💰 تعداد سکه : {$user["coin"]}
💎 نوع حساب : $type
👤 تعداد زیرمجموعه ها : {$user["member"]} نفر

👨‍👧‍👧 تعداد دوستان : $allfrind نفر
🚫 تعداد افراد بلاک : $allblock نفر
👑 وضعیت موقعیت مکانی GPS : $gps

❗️ توجه کنید با ویرایش هر یک از قسمت ها یک سکه از شما کسر خواهد شد !");

        $markup = inline_btn(array(
            "🖌 ویرایش نام",
            "🖌 ویرایش نام",
            "🖌️ ویرایش جنسیت",
            "🖌️ ویرایش جنسیت",
            "🖌️ ویرایش شهر",
            "🖌️ ویرایش شهر",
            "🖌️ ویرایش استان",
            "🖌️ ویرایش استان",
            "🖌️ ویرایش سن",
            "🖌️ ویرایش سن",
            "🖌️ ویرایش عکس",
            "🖌️ ویرایش عکس",
            "🖌️ ویرایش بیو",
            "🖌️ ویرایش بیو",
            "🖌️ ویرایش موقعیت مکانی",
            "🖌️ ویرایش موقعیت مکانی",
            "👍🏻 {$user["`like`"]}",
            "likeme",
            "👎🏻 {$user["dislike"]}",
            "likeme"
        ));

        if ($user["status"] == 1) {
            if ($user["photo"] == true) {

                photo($chat_id, $user["photo"], $profile_text . $markup);
            } else {
                photo($chat_id, "https://t.me/GTele_Channel/58", $profile_text . $markup);
            }
        } else {
            if ($user["photo"] == true) {

                photo($chat_id, $user["photo"], $profile_text2 . $markup);
            } else {
                photo($chat_id, "https://t.me/GTele_Channel/58", $profile_text2 . $markup);
            }
        }

        $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
    } else {
        MainBot('sendmessage', [
            "chat_id" => $chat_id,
            "text" => "$first_name عزیز 😄
💬 برای استفاده از ربات $robotName ابتدا باید وارد کانال 《 $channelname 》 شوید 👇🏻
		
📣 @$channel 📣 @$channel

☑️ بعد از عضویت بر روی دکمه عضو شدم ضربه بزنید تا ربات برای شما فعال شود",
            'reply_markup' => json_encode($VerifyMarkup)
        ]);
    }
} elseif (in_array($textMessage, array("👸🏻 با دختر", "🤴🏻 با پسر", "🗣 با همسن", "🏢 با هم استانی", "📡 چت با GPS", "چت پیشرفته 🚀")) && $tc == "private") {
    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        if ($user["member"] >= 5 or $user["vip"] == true) {
            if ($user["coin"] > 0) {
                switch ($textMessage) {
                    case "👸🏻 با دختر":
                        $chat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT user_id FROM chat WHERE user_id NOT IN ('$from_id') LIMIT 1"));
                        $userchat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                        if ($userchat["sex"] == "دختر" and $userchat["province"] == $user["province"]) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            MainBot('sendmessage', [
                                'chat_id' => $chat["user_id"],
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                            $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                            if ($side["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => $side["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                            if ($user["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => $user["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup3)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $time = date("H:i:s", strtotime("+10 seconds"));
                            $connect->query("DELETE FROM chat WHERE user_id = '{$chat["user_id"]}' LIMIT 1");
                            $pluscoin = $user["coin"] - 1;
                            $connect->query("UPDATE user SET side = '{$chat["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                            $pluscoin = $side["coin"] - 1;
                            $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$chat["user_id"]}' LIMIT 1");
                            $find = true;
                        } else {
                            $alluser = mysqli_query($connect, "select * from chatvip");
                            while ($getuser = mysqli_fetch_assoc($alluser)) {
                                $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                if ($side["sex"] == "دختر" and $user["{$getuser["type"]}"] == $getuser["stats"]) {
                                    MainBot('sendmessage', [
                                        'chat_id' => $chat_id,
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'reply_to_message_id' => $message_id,
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    MainBot('sendmessage', [
                                        'chat_id' => $getuser["user_id"],
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                    $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";

                                    if ($side["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => $side["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                                    if ($user["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => $user["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup3)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $time = date("H:i:s", strtotime("+10 seconds"));
                                    $connect->query("DELETE FROM chatvip WHERE user_id = '{$getuser["user_id"]}' LIMIT 1");
                                    $pluscoin = $user["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '{$getuser["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                                    $pluscoin = $side["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$getuser["user_id"]}' LIMIT 1");
                                    $find = true;
                                    break;
                                }
                            }
                        }
                        if ($find != true) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "⚠️ کاربری برای شروع چت پیدا نشد !
`🔍 شما در صف انتظار برای چت با دختر قرار دارید !`

🔔 قوانین ربات $robotName :

1️⃣ تبلیغات سایت ها ربات ها و کانال ها 
2️⃣ ارسال هرگونه محتوای غیر اخلاقی
3️⃣ ایجاد مزاحمت برای کاربران 
4️⃣ پخش اطلاعات شخصی دیگران
5️⃣ استفاده از کلمات یا عکس غیر اخلاقی و یا توهین آمیز در پروفایل 
6️⃣ ثبت اطلاعات نادرست در پروفایل 
7️⃣ بستن چت بیهوده به صورت مکرر

❗️ رعایت نکردن هر یک از موارد بالا باعث مسدودیت همیشگی شما در ربات خواهد شد

🌟 `سیستم خودکار شما را به اولین کاربر متصل خواهد کرد لطفا منتظر باشید ... `",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($CancelSearchMarkup)
                            ]);
                            $connect->query("INSERT INTO chatvip (user_id , type , stats) VALUES ('$from_id' , 'sex' , 'دختر')");
                        }
                        break;

                    case "🤴🏻 با پسر":
                        $chat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT user_id FROM chat WHERE user_id NOT IN ('$from_id') LIMIT 1"));
                        $userchat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                        if ($userchat["sex"] == "پسر" and $userchat["province"] == $user["province"]) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            MainBot('sendmessage', [
                                'chat_id' => $chat["user_id"],
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                            $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                            if ($side["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => $side["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                            if ($user["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => $user["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup3)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $time = date("H:i:s", strtotime("+10 seconds"));
                            $connect->query("DELETE FROM chat WHERE user_id = '{$chat["user_id"]}' LIMIT 1");
                            $pluscoin = $user["coin"] - 1;
                            $connect->query("UPDATE user SET side = '{$chat["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                            $pluscoin = $side["coin"] - 1;
                            $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$chat["user_id"]}' LIMIT 1");
                            $find = true;
                        } else {
                            $alluser = mysqli_query($connect, "select * from chatvip");
                            while ($getuser = mysqli_fetch_assoc($alluser)) {
                                $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                if ($side["sex"] == "پسر" and $user["{$getuser["type"]}"] == $getuser["stats"]) {
                                    MainBot('sendmessage', [
                                        'chat_id' => $chat_id,
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'reply_to_message_id' => $message_id,
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    MainBot('sendmessage', [
                                        'chat_id' => $getuser["user_id"],
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                    $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                                    if ($side["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => $side["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                                    if ($user["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => $user["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup3)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $time = date("H:i:s", strtotime("+10 seconds"));
                                    $connect->query("DELETE FROM chatvip WHERE user_id = '{$getuser["user_id"]}' LIMIT 1");
                                    $pluscoin = $user["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '{$getuser["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                                    $pluscoin = $side["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$getuser["user_id"]}' LIMIT 1");
                                    $find = true;
                                    break;
                                }
                            }
                        }

                        if ($find != true) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "⚠️ کاربری برای شروع چت پیدا نشد !
`🔍 شما در صف انتظار برای چت با دختر قرار دارید !`

🔔 قوانین ربات $robotName :

1️⃣ تبلیغات سایت ها ربات ها و کانال ها 
2️⃣ ارسال هرگونه محتوای غیر اخلاقی
3️⃣ ایجاد مزاحمت برای کاربران 
4️⃣ پخش اطلاعات شخصی دیگران
5️⃣ استفاده از کلمات یا عکس غیر اخلاقی و یا توهین آمیز در پروفایل 
6️⃣ ثبت اطلاعات نادرست در پروفایل 
7️⃣ بستن چت بیهوده به صورت مکرر

❗️ رعایت نکردن هر یک از موارد بالا باعث مسدودیت همیشگی شما در ربات خواهد شد

`🌟 سیستم خودکار شما را به اولین کاربر متصل خواهد کرد لطفا منتظر باشید ...`",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($CancelSearchMarkup)
                            ]);
                            $connect->query("INSERT INTO chatvip (user_id , type , stats) VALUES ('$from_id' , 'sex' , 'پسر')");
                        }
                        break;

                    case "🗣 با همسن":
                        $chat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT user_id FROM chat WHERE user_id NOT IN ('$from_id') LIMIT 1"));
                        $userchat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                        if ($userchat["old"] == $user["old"] and $userchat["province"] == $user["province"]) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            MainBot('sendmessage', [
                                'chat_id' => $chat["user_id"],
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                            $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                            if ($side["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => $side["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                            if ($user["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => $user["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup3)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $time = date("H:i:s", strtotime("+10 seconds"));
                            $connect->query("DELETE FROM chat WHERE user_id = '{$chat["user_id"]}' LIMIT 1");
                            $pluscoin = $user["coin"] - 1;
                            $connect->query("UPDATE user SET side = '{$chat["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                            $pluscoin = $side["coin"] - 1;
                            $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$chat["user_id"]}' LIMIT 1");
                            $find = true;
                        } else {
                            $alluser = mysqli_query($connect, "select * from chatvip");
                            while ($getuser = mysqli_fetch_assoc($alluser)) {
                                $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                if ($side["old"] == $user["old"] and $user["{$getuser["type"]}"] == $getuser["stats"]) {
                                    MainBot('sendmessage', [
                                        'chat_id' => $chat_id,
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'reply_to_message_id' => $message_id,
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    MainBot('sendmessage', [
                                        'chat_id' => $getuser["user_id"],
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                    $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                                    if ($side["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => $side["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                                    if ($user["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => $user["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup3)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $time = date("H:i:s", strtotime("+10 seconds"));
                                    $connect->query("DELETE FROM chatvip WHERE user_id = '{$getuser["user_id"]}' LIMIT 1");
                                    $pluscoin = $user["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '{$getuser["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                                    $pluscoin = $side["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$getuser["user_id"]}' LIMIT 1");
                                    $find = true;
                                    break;
                                }
                            }
                        }

                        if ($find != true) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "⚠️ کاربری برای شروع چت پیدا نشد !
`🔍 شما در صف انتظار برای چت با همسن قرار دارید !`

🔔 قوانین ربات $robotName :

1️⃣ تبلیغات سایت ها ربات ها و کانال ها 
2️⃣ ارسال هرگونه محتوای غیر اخلاقی
3️⃣ ایجاد مزاحمت برای کاربران 
4️⃣ پخش اطلاعات شخصی دیگران
5️⃣ استفاده از کلمات یا عکس غیر اخلاقی و یا توهین آمیز در پروفایل 
6️⃣ ثبت اطلاعات نادرست در پروفایل 
7️⃣ بستن چت بیهوده به صورت مکرر

❗️ رعایت نکردن هر یک از موارد بالا باعث مسدودیت همیشگی شما در ربات خواهد شد

`🌟 سیستم خودکار شما را به اولین کاربر متصل خواهد کرد لطفا منتظر باشید ...`",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($CancelSearchMarkup)
                            ]);
                            $connect->query("INSERT INTO chatvip (user_id , type , stats) VALUES ('$from_id' , 'old' , '{$user["old"]}')");
                        }
                        break;

                    case "چت پیشرفته 🚀":
                        MainBot('sendmessage', [
                            'chat_id' => $chat_id,
                            'text' => "سلام به چت پیشرفته خوش آمدید
                            در اینجا می تونید با دختر با پسر یا افراد هم استانی خود چت کنید
                            همچنین میتوانید افراد آنلاین را مشاهده و به آن ها درخواست چت ارسال کنید.",
                            'reply_to_message_id' => $message_id,
                            'parse_mode' => 'Markdown',
                            'reply_markup' => json_encode([

                                'keyboard' => [
                                    [
                                        ["text" => "🏢 با هم استانی"]
                                    ],
                                    [
                                        ["text" => "با پسر"],
                                        ["text" => "با دختر"]
                                    ],
                                    [
                                        ["text" => "با همسن"]
                                    ],
                                    [
                                        ["text" => "🏠 خانه"]
                                    ],
                                ],
                                'resize_keyboard' => true
                            ])
                        ]);
                        break;
                    case "🏢 با هم استانی":
                        MainBot('sendmessage', [
                            'chat_id' => $chat_id,
                            'text' => "سلام به چت پیشرفته خوش آمدید
                            در اینجا می توانید با افراد هم استانی خود چت کنید
                            همچنین میتوانید افراد آنلاین را مشاهده و به آن ها درخواست چت ارسال کنید.",
                            'reply_to_message_id' => $message_id,
                            'parse_mode' => 'Markdown',
                            'reply_markup' => json_encode([

                                'keyboard' => [
                                    [
                                        ["text" => "افراد آنلاین ✅"]
                                    ],
                                    [
                                        ["text" => "🤴🏻 با پسر"],
                                        ["text" => "👸🏻 با دختر"]
                                    ],
                                    [
                                        ['text' => "🗣 با همسن"]
                                    ],
                                    [
                                        ["text" => "🔙 بازگشت"]
                                    ],
                                ],
                                'resize_keyboard' => true
                            ])
                        ]);
                        $connect->query("UPDATE user SET  step = 'province_chat' where id ='{$user["id"]}' LIMIT 1");
                        break;

                    case "📡 چت با GPS":
                        if ($user["gps"] == true) {
                            $chat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT user_id FROM chat WHERE user_id NOT IN ('$from_id') LIMIT 1"));
                            $userchat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                            if ($userchat["city"] == $user["city"]) {
                                MainBot('sendmessage', [
                                    'chat_id' => $chat_id,
                                    'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                    'reply_to_message_id' => $message_id,
                                    'parse_mode' => 'Markdown',
                                    'reply_markup' => json_encode($InChatMarkup)
                                ]);
                                MainBot('sendmessage', [
                                    'chat_id' => $chat["user_id"],
                                    'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                    'parse_mode' => 'Markdown',
                                    'reply_markup' => json_encode($InChatMarkup)
                                ]);
                                $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                                $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                                if ($side["photo"] == true) {
                                    MainBot('sendphoto', [
                                        'chat_id' => $chat_id,
                                        'photo' => $side["photo"],
                                        'caption' => $bio,
                                        'reply_markup' => json_encode($LikeMarkup)
                                    ]);
                                } else {
                                    MainBot('sendphoto', [
                                        'chat_id' => $chat_id,
                                        'photo' => "https://t.me/GTele_Channel/58",
                                        'caption' => "$bio",
                                    ]);
                                }
                                $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                                if ($user["photo"] == true) {
                                    MainBot('sendphoto', [
                                        'chat_id' => $chat["user_id"],
                                        'photo' => $user["photo"],
                                        'caption' => $bio,
                                        'reply_markup' => json_encode($LikeMarkup3)
                                    ]);
                                } else {
                                    MainBot('sendphoto', [
                                        'chat_id' => $chat["user_id"],
                                        'photo' => "https://t.me/GTele_Channel/58",
                                        'caption' => "$bio",
                                    ]);
                                }
                                $time = date("H:i:s", strtotime("+10 seconds"));
                                $connect->query("DELETE FROM chat WHERE user_id = '{$chat["user_id"]}' LIMIT 1");
                                $pluscoin = $user["coin"] - 1;
                                $connect->query("UPDATE user SET side = '{$chat["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                                $pluscoin = $side["coin"] - 1;
                                $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$chat["user_id"]}' LIMIT 1");
                                $find = true;
                            } else {
                                $alluser = mysqli_query($connect, "select * from chatvip");
                                while ($getuser = mysqli_fetch_assoc($alluser)) {
                                    $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                    if ($side["province"] == $user["province"] and $user["{$getuser["type"]}"] == $getuser["stats"]) {
                                        MainBot('sendmessage', [
                                            'chat_id' => $chat_id,
                                            'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                            'reply_to_message_id' => $message_id,
                                            'parse_mode' => 'Markdown',
                                            'reply_markup' => json_encode($InChatMarkup)
                                        ]);
                                        MainBot('sendmessage', [
                                            'chat_id' => $getuser["user_id"],
                                            'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                            'parse_mode' => 'Markdown',
                                            'reply_markup' => json_encode($InChatMarkup)
                                        ]);
                                        $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                        $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                                        if ($side["photo"] == true) {
                                            MainBot('sendphoto', [
                                                'chat_id' => $chat_id,
                                                'photo' => $side["photo"],
                                                'caption' => $bio,
                                                'reply_markup' => json_encode($LikeMarkup)
                                            ]);
                                        } else {
                                            MainBot('sendphoto', [
                                                'chat_id' => $chat_id,
                                                'photo' => "https://t.me/GTele_Channel/58",
                                                'caption' => "$bio",
                                            ]);
                                        }
                                        $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                                        if ($user["photo"] == true) {
                                            MainBot('sendphoto', [
                                                'chat_id' => $getuser["user_id"],
                                                'photo' => $user["photo"],
                                                'caption' => $bio,
                                                'reply_markup' => json_encode($LikeMarkup3)
                                            ]);
                                        } else {
                                            MainBot('sendphoto', [
                                                'chat_id' => $getuser["user_id"],
                                                'photo' => "https://t.me/GTele_Channel/58",
                                                'caption' => "$bio",
                                            ]);
                                        }
                                        $time = date("H:i:s", strtotime("+10 seconds"));
                                        $connect->query("DELETE FROM chatvip WHERE user_id = '{$getuser["user_id"]}' LIMIT 1");
                                        $pluscoin = $user["coin"] - 1;
                                        $connect->query("UPDATE user SET side = '{$getuser["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                                        $pluscoin = $side["coin"] - 1;
                                        $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$getuser["user_id"]}' LIMIT 1");
                                        $find = true;
                                        break;
                                    }
                                }
                            }
                            if ($find != true) {
                                MainBot('sendmessage', [
                                    'chat_id' => $chat_id,
                                    'text' => "⚠️ کاربری برای شروع چت پیدا نشد !
`🔍 شما در صف انتظار برای چت با اطرافیان قرار دارید !`

🔔 قوانین ربات $robotName :

1️⃣ تبلیغات سایت ها ربات ها و کانال ها 
2️⃣ ارسال هرگونه محتوای غیر اخلاقی
3️⃣ ایجاد مزاحمت برای کاربران 
4️⃣ پخش اطلاعات شخصی دیگران
5️⃣ استفاده از کلمات یا عکس غیر اخلاقی و یا توهین آمیز در پروفایل 
6️⃣ ثبت اطلاعات نادرست در پروفایل 
7️⃣ بستن چت بیهوده به صورت مکرر

❗️ رعایت نکردن هر یک از موارد بالا باعث مسدودیت همیشگی شما در ربات خواهد شد

`🌟 سیستم خودکار شما را به اولین کاربر متصل خواهد کرد لطفا منتظر باشید ...`",
                                    'reply_to_message_id' => $message_id,
                                    'parse_mode' => 'Markdown',
                                    'reply_markup' => json_encode($CancelSearchMarkup)
                                ]);
                                $connect->query("INSERT INTO chatvip (user_id , type , stats) VALUES ('$from_id' , 'province' , '{$user["province"]}')");
                            }
                        } else {

                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "❗️ `موقعیت مکانی شما هنوز تنظیم نشده است . امکان استفاده از چت با GPS وجود ندارد`
	
ℹ️ لطفا با استفاده از دکمه '👤 پروفایل' سپس با استفاده از دکمه '🖌️ ویرایش موقعیت مکانی' اقدام به کامل کردن موقعیت خود  در ربات کنید
",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'disable_web_page_preview' => true,
                                'reply_markup' => json_encode($HomeMarkup)
                            ]);
                        }
                        break;
                }
            } else {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "⚠️ تعداد سکه شما کافی نمیباشد !
ℹ️ `برای شروع چت حداقل یک سکه نیاز دارید`

🎁 شما میتوانید با استفاده از دکمه '💰 سکه رایگان'  با دعوت دیگران به ربات اقدام به افزایش سکه و ویژه کردن حساب خود در ربات کنید 👇🏻
💎 همچنین میتوانید با استفاده از دکمه '🎁 حساب ویژه' با پرداخت هزینه نسبت به افزایش سکه و حساب ویژه اقدام کنید",
                    'reply_to_message_id' => $message_id,
                    'parse_mode' => 'Markdown',
                    'reply_markup' => json_encode($HomeMarkup)
                ]);
            }
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "🤖 پیام سیستم 👇 

🗣 `حساب شما در ربات ویژه نیست . برای استفاده از چت های ویژه باید حساب شما در ربات ویژه باشد`
🌟 شما میتوانید 

با استفاده از دکمه '💰 سکه رایگان'  با دعوت دیگران به ربات اقدام به افزایش سکه و ویژه کردن حساب خود در ربات کنید 👇🏻
با استفاده از دکمه '🎁 حساب ویژه' با پرداخت هزینه نسبت به افزایش سکه و حساب ویژه اقدام کنید

🔔 `کاربران عادی میتوانند از دکمه '💬 چت ناشناس' برای شروع گفت و گو استفاده کنند`",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
            ]);
        }
    } else {
        MainBot('sendmessage', [
            "chat_id" => $chat_id,
            "text" => "$first_name عزیز 😄
💬 برای استفاده از ربات $robotName ابتدا باید وارد کانال 《 $channelname 》 شوید 👇🏻
		
📣 @$channel 📣 @$channel

☑️ بعد از عضویت بر روی دکمه عضو شدم ضربه بزنید تا ربات برای شما فعال شود",
            'reply_markup' => json_encode($VerifyMarkup)
        ]);
    }
} elseif (in_array($textMessage, array("افراد آنلاین ✅", "🤴🏻🤴🏻با پسر", "با دختر")) && $tc == "private") {
    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        if ($user["member"] >= 5 or $user["vip"] == true) {
            if ($user["coin"] > 0) {
                switch ($textMessage) {

                    case "افراد آنلاین ✅":
                        $user_province = $user['province'];
                        $query = "SELECT id,name,province,city,sex,old FROM user WHERE status = '1' and province='$user_province'";
                        $res = mysqli_query($connect, $query);
                        $num = mysqli_num_rows($res);
                        $result = "افراد آنلاین هم استانی شما" . PHP_EOL . PHP_EOL;
                        $cnt = ($num >= $list_limit) ? $list_limit : $num;
                        if ($num > 0) {
                            for ($i = 1; $i <= $cnt; $i++) {
                                $online = mysqli_fetch_assoc($res);
                                $id = $online['id'];
                                $name = $online['name'];
                                $province = $online['province'];
                                $city = $online['city'];
                                if ($online['sex'] == "پسر") {
                                    $sex = "🤴🏻";
                                } else {
                                    $sex = "👸🏻";
                                }
                                $old = $online['old'];
                                $result .= $i . "." . "$name" . " $sex" . " $city" . "/member_" . $id . PHP_EOL . "========== " . "HOT 🔥 CHAT" . " ==========" . PHP_EOL;
                            }

                            if ($num > $list_limit) {
                                $result .= PHP_EOL . "🔍 $num آنلاین 🔍";
                                message($chat_id, urlencode($result) . inline_btn(array('صفحه ی بعد', 'next_' . $list_limit)));
                            } else {
                                $result .= PHP_EOL . "🔍 $num آنلاین 🔍";
                                message($chat_id, urlencode($result));
                            }
                        } else {
                            MainBot('sendmessage', [
                                "chat_id" => $chat_id,
                                "text" => "متاسفانه در این لحظه افراد آنلاینی وجود ندارد!!!!"
                            ]);
                        }
                        break;

                        //////////boy/////////////
                    case "با پسر":
                        $chat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT user_id FROM chat WHERE user_id NOT IN ('$from_id') LIMIT 1"));
                        $userchat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                        if ($userchat["sex"] == $user["sex"]) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            MainBot('sendmessage', [
                                'chat_id' => $chat["user_id"],
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                            $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                            if ($side["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => $side["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                            if ($user["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => $user["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup3)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $time = date("H:i:s", strtotime("+10 seconds"));
                            $connect->query("DELETE FROM chat WHERE user_id = '{$chat["user_id"]}' LIMIT 1");
                            $pluscoin = $user["coin"] - 1;
                            $connect->query("UPDATE user SET side = '{$chat["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                            $pluscoin = $side["coin"] - 1;
                            $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$chat["user_id"]}' LIMIT 1");
                            $find = true;
                        } else {
                            $alluser = mysqli_query($connect, "select * from chatvip");
                            while ($getuser = mysqli_fetch_assoc($alluser)) {
                                $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                if ($side["province"] == $user["province"] and $user["{$getuser["type"]}"] == $getuser["stats"]) {
                                    MainBot('sendmessage', [
                                        'chat_id' => $chat_id,
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'reply_to_message_id' => $message_id,
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    MainBot('sendmessage', [
                                        'chat_id' => $getuser["user_id"],
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                    $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                                    if ($side["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => $side["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                                    if ($user["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => $user["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup3)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $time = date("H:i:s", strtotime("+10 seconds"));
                                    $connect->query("DELETE FROM chatvip WHERE user_id = '{$getuser["user_id"]}' LIMIT 1");
                                    $pluscoin = $user["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '{$getuser["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                                    $pluscoin = $side["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$getuser["user_id"]}' LIMIT 1");
                                    $find = true;
                                    break;
                                }
                            }
                        }
                        if ($find != true) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "⚠️ کاربری برای شروع چت پیدا نشد !
`🔍 شما در صف انتظار برای چت با هم استانی قرار دارید !`

🔔 قوانین ربات $robotName :

1️⃣ تبلیغات سایت ها ربات ها و کانال ها 
2️⃣ ارسال هرگونه محتوای غیر اخلاقی
3️⃣ ایجاد مزاحمت برای کاربران 
4️⃣ پخش اطلاعات شخصی دیگران
5️⃣ استفاده از کلمات یا عکس غیر اخلاقی و یا توهین آمیز در پروفایل
6️⃣ ثبت اطلاعات نادرست در پروفایل 
7️⃣ بستن چت بیهوده به صورت مکرر

❗️ رعایت نکردن هر یک از موارد بالا باعث مسدودیت همیشگی شما در ربات خواهد شد

`🌟 سیستم خودکار شما را به اولین کاربر متصل خواهد کرد لطفا منتظر باشید ...`",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($CancelSearchMarkup)
                            ]);
                            $connect->query("INSERT INTO chatvip (user_id , type , stats) VALUES ('$from_id' , 'province' , '{$user["province"]}')");
                        }
                        break;

                    case "با همسن":
                        $chat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT user_id FROM chat WHERE user_id NOT IN ('$from_id') LIMIT 1"));
                        $userchat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                        if ($userchat["old"] == $user["old"]) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            MainBot('sendmessage', [
                                'chat_id' => $chat["user_id"],
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                            $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                            if ($side["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => $side["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                            if ($user["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => $user["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup3)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $time = date("H:i:s", strtotime("+10 seconds"));
                            $connect->query("DELETE FROM chat WHERE user_id = '{$chat["user_id"]}' LIMIT 1");
                            $pluscoin = $user["coin"] - 1;
                            $connect->query("UPDATE user SET side = '{$chat["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                            $pluscoin = $side["coin"] - 1;
                            $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$chat["user_id"]}' LIMIT 1");
                            $find = true;
                        } else {
                            $alluser = mysqli_query($connect, "select * from chatvip");
                            while ($getuser = mysqli_fetch_assoc($alluser)) {
                                $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                if ($side["old"] == $user["old"] and $user["{$getuser["type"]}"] == $getuser["stats"]) {
                                    MainBot('sendmessage', [
                                        'chat_id' => $chat_id,
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'reply_to_message_id' => $message_id,
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    MainBot('sendmessage', [
                                        'chat_id' => $getuser["user_id"],
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                    $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                                    if ($side["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => $side["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                                    if ($user["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => $user["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup3)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $time = date("H:i:s", strtotime("+10 seconds"));
                                    $connect->query("DELETE FROM chatvip WHERE user_id = '{$getuser["user_id"]}' LIMIT 1");
                                    $pluscoin = $user["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '{$getuser["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                                    $pluscoin = $side["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$getuser["user_id"]}' LIMIT 1");
                                    $find = true;
                                    break;
                                }
                            }
                        }

                        if ($find != true) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "⚠️ کاربری برای شروع چت پیدا نشد !
`🔍 شما در صف انتظار برای چت با همسن قرار دارید !`

🔔 قوانین ربات $robotName :

1️⃣ تبلیغات سایت ها ربات ها و کانال ها 
2️⃣ ارسال هرگونه محتوای غیر اخلاقی
3️⃣ ایجاد مزاحمت برای کاربران 
4️⃣ پخش اطلاعات شخصی دیگران
5️⃣ استفاده از کلمات یا عکس غیر اخلاقی و یا توهین آمیز در پروفایل 
6️⃣ ثبت اطلاعات نادرست در پروفایل 
7️⃣ بستن چت بیهوده به صورت مکرر

❗️ رعایت نکردن هر یک از موارد بالا باعث مسدودیت همیشگی شما در ربات خواهد شد

`🌟 سیستم خودکار شما را به اولین کاربر متصل خواهد کرد لطفا منتظر باشید ...`",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($CancelSearchMarkup)
                            ]);
                            $connect->query("INSERT INTO chatvip (user_id , type , stats) VALUES ('$from_id' , 'old' , '{$user["old"]}')");
                        }
                        break;

                    case "با دختر":
                        $chat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT user_id FROM chat WHERE user_id NOT IN ('$from_id') LIMIT 1"));
                        $userchat = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                        if ($userchat["sex"] == $user["sex"]) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            MainBot('sendmessage', [
                                'chat_id' => $chat["user_id"],
                                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($InChatMarkup)
                            ]);
                            $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$chat["user_id"]}' LIMIT 1"));
                            $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                            if ($side["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => $side["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat_id,
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                            if ($user["photo"] == true) {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => $user["photo"],
                                    'caption' => $bio,
                                    'reply_markup' => json_encode($LikeMarkup3)
                                ]);
                            } else {
                                MainBot('sendphoto', [
                                    'chat_id' => $chat["user_id"],
                                    'photo' => "https://t.me/GTele_Channel/58",
                                    'caption' => "$bio",
                                ]);
                            }
                            $time = date("H:i:s", strtotime("+10 seconds"));
                            $connect->query("DELETE FROM chat WHERE user_id = '{$chat["user_id"]}' LIMIT 1");
                            $pluscoin = $user["coin"] - 1;
                            $connect->query("UPDATE user SET side = '{$chat["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                            $pluscoin = $side["coin"] - 1;
                            $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$chat["user_id"]}' LIMIT 1");
                            $find = true;
                        } else {
                            $alluser = mysqli_query($connect, "select * from chatvip");
                            while ($getuser = mysqli_fetch_assoc($alluser)) {
                                $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                if ($side["province"] == $user["province"] and $user["{$getuser["type"]}"] == $getuser["stats"]) {
                                    MainBot('sendmessage', [
                                        'chat_id' => $chat_id,
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'reply_to_message_id' => $message_id,
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    MainBot('sendmessage', [
                                        'chat_id' => $getuser["user_id"],
                                        'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                                        'parse_mode' => 'Markdown',
                                        'reply_markup' => json_encode($InChatMarkup)
                                    ]);
                                    $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$getuser["user_id"]}' LIMIT 1"));
                                    $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
                                    if ($side["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => $side["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $chat_id,
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
                                    if ($user["photo"] == true) {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => $user["photo"],
                                            'caption' => $bio,
                                            'reply_markup' => json_encode($LikeMarkup3)
                                        ]);
                                    } else {
                                        MainBot('sendphoto', [
                                            'chat_id' => $getuser["user_id"],
                                            'photo' => "https://t.me/GTele_Channel/58",
                                            'caption' => "$bio",
                                        ]);
                                    }
                                    $time = date("H:i:s", strtotime("+10 seconds"));
                                    $connect->query("DELETE FROM chatvip WHERE user_id = '{$getuser["user_id"]}' LIMIT 1");
                                    $pluscoin = $user["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '{$getuser["user_id"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
                                    $pluscoin = $side["coin"] - 1;
                                    $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$getuser["user_id"]}' LIMIT 1");
                                    $find = true;
                                    break;
                                }
                            }
                        }
                        if ($find != true) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "⚠️ کاربری برای شروع چت پیدا نشد !
`🔍 شما در صف انتظار برای چت با هم استانی قرار دارید !`

🔔 قوانین ربات $robotName :

1️⃣ تبلیغات سایت ها ربات ها و کانال ها 
2️⃣ ارسال هرگونه محتوای غیر اخلاقی
3️⃣ ایجاد مزاحمت برای کاربران 
4️⃣ پخش اطلاعات شخصی دیگران
5️⃣ استفاده از کلمات یا عکس غیر اخلاقی و یا توهین آمیز در پروفایل
6️⃣ ثبت اطلاعات نادرست در پروفایل 
7️⃣ بستن چت بیهوده به صورت مکرر

❗️ رعایت نکردن هر یک از موارد بالا باعث مسدودیت همیشگی شما در ربات خواهد شد

`🌟 سیستم خودکار شما را به اولین کاربر متصل خواهد کرد لطفا منتظر باشید ...`",
                                'reply_to_message_id' => $message_id,
                                'parse_mode' => 'Markdown',
                                'reply_markup' => json_encode($CancelSearchMarkup)
                            ]);
                            $connect->query("INSERT INTO chatvip (user_id , type , stats) VALUES ('$from_id' , 'province' , '{$user["province"]}')");
                        }
                        break;
                }
            }
        }
    }
} elseif ($user['step'] == "province_chat" and $textMessage == "🔙 بازگشت") {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "به منوی چت پیشرفته برگشتید
                            در اینجا می تونید با دختر و پسر یا با هم استانی خود چت کنید.",
        'reply_to_message_id' => $message_id,
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode([

            'keyboard' => [
                [
                    ["text" => "🏢 با هم استانی"]
                ],
                [
                    ["text" => "با پسر"],
                    ["text" => "با دختر"]
                ],
                [
                    ["text" => "با همسن"]
                ],
                [
                    ["text" => "🏠 خانه"]
                ],
            ],
            'resize_keyboard' => true
        ])
    ]);
    $connect->query("UPDATE user SET  step = 'none'  LIMIT 1");
} elseif ($textMessage == "📨 ارسال پیام" && $tc == "private") {
    $userside = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$user["side"]}' LIMIT 1"));
    $all = explode("^", $userside["blocklist"]);
    if (!in_array($from_id, $all)) {
        if ($userside["step"] != "chat") {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "`📨 لطفا پیام خود را ارسال کنید تا به کاربر ارسال شود .`
	
ℹ️ پیام شما حداکثر میتواند 400 کاراکتر داشته باشد .
🔘 پس از ارسال پیام کاربر میتواند به پیام شما پاسخ ارسال کند",
                'parse_mode' => 'Markdown',
                'reply_to_message_id' => $message_id,
                'reply_markup' => json_encode([
                    'keyboard' => [
                        [
                            ['text' => "❌ لغو ارسال پیام"]
                        ]
                    ],
                    'resize_keyboard' => true
                ])
            ]);
            $connect->query("UPDATE user SET step = 'senddairect' , stats = '{$user["side"]}' WHERE id = '$from_id' LIMIT 1");
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "`❗️ کاربر در حال گفت و گو با فرد دیگری میباشد و امکان ارسال پیام وجود ندارد .`
	
🔘 لطفا دقایقی دیگر یا ساعاتی دیگر نسبت به ارسال پیام اقدام کنید .
🗣 شما میتواند با اضافه کردن کاربر به لیست دوستان در زمان های بعدی به او پیام ارسال کنید .",
                'parse_mode' => 'Markdown',
                'reply_to_message_id' => $message_id,
            ]);
        }
    } else {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "`❗️ شما در بلاک لیست کاربر مقابل قرار دارد و امکان ارسال پیام به فرد مقابل را ندارد .`",
            'parse_mode' => 'Markdown',
            'reply_to_message_id' => $message_id,
        ]);
    }
} elseif ($textMessage == "chat" || $textMessage == "💬 درخواست چت" && $tc == "private") {
    if ($user["coin"] > 0) {
        $userside = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$user["side"]}' LIMIT 1"));
        $all = explode("^", $userside["blocklist"]);
        if (!in_array($from_id, $all)) {
            if ($userside["step"] != "chat") {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "✅ `درخواست چت شما ارسال شد منتظر دریافت پاسخ باشید ...`
	
ℹ️ در صورت پذیرش درخواست از سمت طرف مقابل گفت و گو اغاز خواهد شد
❗️ درصورتی که شما در هنگام پذیرش درخواست از سمت طرف مقابل در گفت و گو باشید درخواست رد خواهد شد",
                    'reply_to_message_id' => $message_id,
                    'parse_mode' => 'Markdown',
                ]);
                MainBot('sendmessage', [
                    'chat_id' => $user["side"],
                    'text' => "💬 درخواست چت از طرف '{$user["name"]}'
	
برای مدیریت درخواست از دکمه های زیر استفاده کنید 👇🏻",
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => "✅ قبول درخواست", 'callback_data' => "okchat"],
                                ['text' => "❌ لغو درخواست", 'callback_data' => "nochat"]
                            ],
                        ]
                    ])
                ]);
                $connect->query("UPDATE user SET stats = '$from_id' WHERE id = '{$user["side"]}' LIMIT 1");
            } else {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "`❗️ کاربر مقابل در حال گفت و گو میباشد و امکان ارسال درخواست چت وجود ندارد`
	
🔘 لطفا دقایقی دیگر یا ساعاتی دیگر نسبت به ارسال درخواست اقدام کنید .
🗣 شما میتواند با اضافه کردن کاربر به لیست دوستان در زمان های بعدی درخواست ارسال کنید",
                    'parse_mode' => 'Markdown',
                    'reply_to_message_id' => $message_id,
                ]);
            }
        } else {
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "`❗️ شما در بلاک لیست کاربر مقابل قرار دارد و امکان ارسال درخواست چه به طرف مقابل وجود ندارد .`",
                'parse_mode' => 'Markdown',
                'reply_to_message_id' => $message_id,
            ]);
        }
    } else {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "⚠️ `تعداد سکه شما کافی نمیباشد !`
ℹ️ برای شروع چت حداقل یک سکه نیاز دارید

🌟 با بازگشت به منوی اصلی 
🎁 شما میتوانید با استفاده از دکمه '💰 سکه رایگان'  با دعوت دیگران به ربات اقدام به افزایش سکه و ویژه کردن حساب خود در ربات کنید 👇🏻
💎 همچنین میتوانید با استفاده از دکمه '🎁 حساب ویژه' با پرداخت هزینه نسبت به افزایش سکه و حساب ویژه اقدام کنید",
            'reply_to_message_id' => $message_id,
            'parse_mode' => 'Markdown',
        ]);
    }
} elseif ($textMessage == "❌ لغو ارسال گزارش" && $tc == "private") {
    if ($user["stats"] != "list") {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "❌ ارسال گزارش برای کاربر لغو شد

🌟 در مورد طرف مقابلت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "🛑 گزارش تخلف"],
                        ['text' => "👁 مشاهده پروفایل"]
                    ],
                    [
                        ['text' => "👨‍👧‍👧 دوستی"],
                        ['text' => "🚫 بلاکش کن"]
                    ],
                    [
                        ['text' => "🏠 خانه"]
                    ]
                ],
                'resize_keyboard' => true
            ])
        ]);
        $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
    } else {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "✅ به منوی کاربری بازگشتید

🌟 در مورد کاربر چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
            'reply_markup' => json_encode($ProfileMarkup3)
        ]);
    }
} elseif ($textMessage == "❌ لغو ارسال پیام" && $tc == "private") {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "❌ ارسال پیام برای کاربر لغو شد !

🌟 در مورد طرف مقابلت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
        'reply_markup' => json_encode($ProfileMarkup)
    ]);
    $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
} elseif ($textMessage == "🗑 حذف لیست" && $tc == "private") {
    switch ($user["step"]) {
        case "frind":
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "`❗️ ایا از حذف کامل لیست دوستان خود اطمینان دارد ؟ در صورت تایید این رخداد غیر قابل بازگشت است`",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => "✅ بله", 'callback_data' => "ydel"],
                            ['text' => "❌ خیر", 'callback_data' => "nodel"]
                        ],
                    ]
                ])
            ]);
            break;
        case "block":
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "`❗️ ایا از حذف کامل بلاک لیست خود اطمینان دارد ؟ در صورت تایید این رخداد غیر قابل بازگشت است`",
                'reply_to_message_id' => $message_id,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => "✅ بله", 'callback_data' => "ydel"],
                            ['text' => "❌ خیر", 'callback_data' => "nodel"]
                        ],
                    ]
                ])
            ]);
            break;
    }
} elseif ($textMessage == "❌ حذف" && $tc == "private") {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "✅ `کاربر با موفقیت از لیست حذف شد` 
	
🔘 به منوی اصلی بازگشتید 
🌟 چه کاری برات انجام بدم ؟ از منوی پایین انتخاب کن 👇🏻",
        'reply_to_message_id' => $message_id,
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode($HomeMarkup)
    ]);
    $str = str_replace("{$user["side"]}^", "", $user["frindlist"]);
    $connect->query("UPDATE user SET frindlist = '$str' WHERE id = '$from_id' LIMIT 1");
    $str = str_replace("{$user["side"]}^", "", $user["blocklist"]);
    $connect->query("UPDATE user SET blocklist = '$str' WHERE id = '$from_id' LIMIT 1");
} elseif (in_array($textMessage, array("🖌️ ویرایش موقعیت مکانی", "🖌 ویرایش نام", "🖌️ ویرایش جنسیت", "🖌️ ویرایش استان", "🖌️ ویرایش سن", "🖌️ ویرایش عکس", "🖌️ ویرایش بیو", "🖌️ ویرایش شهر"))) {
    if ($user["coin"] > 0) {
        switch ($textMessage) {
            case "🖌️ ویرایش موقعیت مکانی":
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🖌️ برای ویرایش موقعیت مکانی خود از دکمه زیر استفاده کنید
❗️ توجه کنید حتما برای ارسال موقعیت مکانی GPS [مکان] گوشی خود را روشن کنید

ℹ️ در صورتی که در این زمینه نیاز به راهنما دارید میتوانید از آموزش زیر استفاده کنید
⚠️ توجه کنید پس از روشن کردن GPS پانزده ثانیه صبر کنید سپس روی '🏢 ارسال موقعیت مکانی'  ضربه بزنید 
❕ توجه کنید اگر موقعیت مکانی شما پیدا نشد از انتخاب دستی استفاده کنید
",
                    'parse_mode' => 'Markdown',
                    'reply_to_message_id' => $message_id,
                    'disable_web_page_preview' => true,
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => "🏢 ارسال موقعیت مکانی", "request_location" => true]
                            ],
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],

                        ],
                        'resize_keyboard' => true
                    ])
                ]);
                $connect->query("UPDATE user SET step = 'selectlocation' WHERE id = '$from_id' LIMIT 1");
                break;
            case "🖌 ویرایش نام":
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🖌️ لطفا نام مورد نظر را ارسال کنید
	
ℹ️ میتوانید نام را به فارسی یا انگلیسی وارد کنید یا از دکمه '🗣 نام تلگرام' استفاده کنید 👇🏻
❗️ در صورت استفاده از دکمه از نام فعلی شما در تلگرام استفاده خواهد شد",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => "🗣 نام تلگرام"]
                            ],
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],

                        ],
                        'resize_keyboard' => true
                    ])
                ]);
                $connect->query("UPDATE user SET step = 'selectname' WHERE id = '$from_id' LIMIT 1");
                break;
            case "🖌️ ویرایش جنسیت":
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🖌️ لطفا جنیست خود را انتخاب کنید 👇🏻",
                    'reply_markup' => json_encode([
                        'keyboard' => [

                            [
                                ['text' => "👸🏻 دخترم"],
                                ['text' => "🤴🏻 پسرم"]
                            ],
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],

                        ],
                        'resize_keyboard' => true
                    ])
                ]);
                $connect->query("UPDATE user SET step = 'selectsex' WHERE id = '$from_id' LIMIT 1");
                break;
            case "🖌️ ویرایش شهر":
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🖌️ لطفا اسم شهر محل سکونت خود را به صورت پیام ارسال کنید 👇🏻 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],
                        ],
                        'resize_keyboard' => true
                    ])
                ]);
                $connect->query("UPDATE user SET step = 'selectCity' WHERE id = '$from_id' LIMIT 1");
                break;
            case "🖌️ ویرایش استان":
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🖌️ لطفا استان محل سکونت خود را انتخاب نمایید 👇🏻 👇🏻

ℹ️ توجه کنید در صورتی که خارج از ایران زندگی میکنید از دکمه آخر استفاده کنید",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],
                            [
                                ['text' => "آذربایجان شرقی"],
                                ['text' => "اردبیل"],
                                ['text' => "اصفهان"]
                            ],
                            [
                                ['text' => "آذربایجان غربی"],
                                ['text' => "البرز"],
                                ['text' => "بوشهر"]
                            ],
                            [
                                ['text' => "چهارمحال و بختیاری"],
                                ['text' => "تهران"],
                                ['text' => "ایلام"]
                            ],
                            [
                                ['text' => "خراسان جنوبی"],
                                ['text' => "خوزستان"],
                                ['text' => "زنجان"]
                            ],
                            [
                                ['text' => "خراسان شمالی"],
                                ['text' => "سمنان"],
                                ['text' => "فارس"]
                            ],
                            [
                                ['text' => "خراسان رضوی"],
                                ['text' => "قزوین"],
                                ['text' => "قم"]
                            ],
                            [
                                ['text' => "سیستان و بلوچستان"],
                                ['text' => "کردستان"],
                                ['text' => "کرمان"]
                            ],
                            [
                                ['text' => "کهگیلویه و بویراحمد"],
                                ['text' => "کرمانشاه"],
                                ['text' => "گیلان"]
                            ],
                            [
                                ['text' => "گلستان"],
                                ['text' => "لرستان"],
                                ['text' => "مازندران"]
                            ],
                            [
                                ['text' => "مرکزی"],
                                ['text' => "هرمزگان"],
                                ['text' => "همدان"],
                                ['text' => "یزد"]
                            ],
                            [
                                ['text' => "خارج از کشور"],
                                ['text' => "موارد دیگر"]
                            ],

                        ],
                        'resize_keyboard' => true
                    ])
                ]);
                $connect->query("UPDATE user SET step = 'selectProvince' WHERE id = '$from_id' LIMIT 1");
                break;
            case "🖌️ ویرایش سن":
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🖌️ لطفا سن خود را وارد نمایید
	
ℹ️ میتونی سن خودت رو به صورت عداد لاتین یا از کیبورد زیر وارد کنی 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($OldMarkup2)
                ]);
                $connect->query("UPDATE user SET step = 'selectold' WHERE id = '$from_id' LIMIT 1");
                break;
            case "🖌️ ویرایش عکس":
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🖌️ لطفا عکس پروفایل خود در ربات را ارسال نمایید 👇🏻
	
ℹ️ میتوانید از دکمه های '📸 عکس تلگرام' و '❌ بدون عکس' نیز استفاده کنید
❗️ در صورت استفاده از دکمه ی عکس تلگرام از عکس پروفایل فعلی شما در تلگرام استفاده خواهد شد",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => "📸 عکس تلگرام"],
                                ['text' => "❌ بدون عکس"]
                            ],
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],
                        ],
                        'resize_keyboard' => true
                    ])
                ]);
                $connect->query("UPDATE user SET step = 'selectphoto' WHERE id = '$from_id' LIMIT 1");
                break;

            case "🖌️ ویرایش بیو":
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🖌️ لطفا متن بیو [درباره] خود را ارسال نمایید 👇🏻
	
❗️ توجه کنید متن درباره شما حداکثر میتوانید 80 کاراکتر یا حرف باشد !
🌟 برای تنظیم بیو خود میتوانید از دکمه ی 'ℹ️ بیو تلگرام' نیز استفاده کنید
❗️ در صورت استفاده از دکمه از بیو فعلی شما در تلگرام استفاده خواهد شد",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => "ℹ️ بیو تلگرام"],
                                ['text' => "❌ بدون بیو"]
                            ],
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],
                        ],
                        'resize_keyboard' => true
                    ])
                ]);
                $connect->query("UPDATE user SET step = 'selectbio' WHERE id = '$from_id' LIMIT 1");
                break;
        }
    } else {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "⚠️ تعداد سکه شما کافی نمیباشد !
ℹ️ برای ویرایش اطلاعات باید حداقل یک سکه داشته باشید
❗️ توجه کنید با ویرایش هر یک از قسمت ها یک سکه از شما کسر خواهد شد !

🎁 شما میتوانید با استفاده از دکمه '💰 سکه رایگان'  با دعوت دیگران به ربات اقدام به افزایش سکه و ویژه کردن حساب خود در ربات کنید
💎 همچنین میتوانید با استفاده از دکمه '🎁 حساب ویژه' با پرداخت هزینه نسبت به افزایش سکه و حساب ویژه اقدام کنید",
            'reply_to_message_id' => $message_id,
            'reply_markup' => json_encode($HomeMarkup)
        ]);
    }
}
//===========================================================================================
//admin panel
elseif ($textMessage == "پنل مدیریت" and $tc == "private" and in_array($from_id, $admin)) {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "👑 ادمین عزیز به پنل مدریت ربات خوش امدید",
        'reply_markup' => json_encode([
            'keyboard' => [
                [
                    ['text' => "👑 امار ربات"],
                    ['text' => "👑 ویژه کردن"]
                ],
                [
                    ['text' => "👑 ارسال به همه"],
                    ['text' => "👑 فروارد همگانی"]
                ],
                [
                    ['text' => "👑 ارسال سکه"]
                ],
                [
                    ['text' => "🏠 خانه"]
                ],
            ],
            'resize_keyboard' => true
        ])
    ]);
} elseif ($textMessage == "برگشت 🔙" and $tc == "private" and in_array($from_id, $admin)) {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "👑 به منوی مدیریت بازگشتید",
        'reply_markup' => json_encode([
            'keyboard' => [
                [
                    ['text' => "👑 امار ربات"],
                    ['text' => "👑 ویژه کردن"]
                ],
                [
                    ['text' => "👑 ارسال به همه"],
                    ['text' => "👑 فروارد همگانی"]
                ],
                [
                    ['text' => "👑 ارسال سکه"]
                ],
                [
                    ['text' => "🏠 خانه"]
                ],
            ],
            'resize_keyboard' => true
        ])
    ]);
    $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
} elseif ($textMessage == "👑 ویژه کردن" and $tc == "private" and in_array($from_id, $admin)) {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "👑 لطفا ایدی عددی فرد را ارسال کنید",
        'reply_markup' => json_encode([
            'keyboard' => [
                [
                    ['text' => "برگشت 🔙"]
                ]
            ],
            'resize_keyboard' => true
        ])
    ]);
    $connect->query("UPDATE user SET step = 'vipuser' WHERE id = '$from_id' LIMIT 1");
} elseif ($textMessage == "👑 ارسال سکه" and $tc == "private" and in_array($from_id, $admin)) {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "👑 لطفا در خط اول ایدی عددی فرد و در خط دوم تعداد سکه را وارد کنید !
👑 برای کم کردن سکه میتواندد عدد را به منفی وارد کنید",
        'reply_markup' => json_encode([
            'keyboard' => [
                [
                    ['text' => "برگشت 🔙"]
                ]
            ],
            'resize_keyboard' => true
        ])
    ]);
    $connect->query("UPDATE user SET step = 'coinuser' WHERE id = '$from_id' LIMIT 1");
} elseif ($textMessage == "👑 امار ربات" and $tc == "private" and in_array($from_id, $admin)) {
    $alltotal = mysqli_num_rows(mysqli_query($connect, "select id from user"));
    $girlNum = mysqli_num_rows(mysqli_query($connect, "select id from user WHERE sex ='دختر'"));
    $boyNum = mysqli_num_rows(mysqli_query($connect, "select id from user WHERE sex ='پسر'"));
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "آمار ربات
        🤖 کل کاربران : $alltotal 👤
        🤖 تعداد پسر : $boyNum 👤
        🤖 تعداد دختر : $girlNum 👤
         ",
    ]);
} elseif ($textMessage == "👑 ارسال به همه" and $tc == "private" and in_array($from_id, $admin)) {
    if (in_array($from_id, $admin)) {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "👑 لطفا متن یا رسانه خود را ارسال کنید [میتواند شامل عکس , گیف یا فایل باشد]  همچنین میتوانید رسانه را همراه با کشپن [متن چسپیده به رسانه ارسال کنید]",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "برگشت 🔙"]
                    ]
                ],
                'resize_keyboard' => true
            ])
        ]);
        $connect->query("UPDATE user SET step = 'sendtoall' WHERE id = '$from_id' LIMIT 1");
        if (mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM sendall  LIMIT 1")) != true) {
            $connect->query("INSERT INTO `sendall` (`run`, `msgid`, `step`, `text`,  `chat`, `user`) VALUES ('ok', '', '', '', '', '0')");
        }
        $connect->query("UPDATE sendall SET step = 'none' , text = '' , msgid = '' , user = '0' , chat = '' WHERE run = 'ok' LIMIT 1");
    }
} elseif ($textMessage == "👑 فروارد همگانی" and $tc == "private" and in_array($from_id, $admin)) {
    if (in_array($from_id, $admin)) {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "👑 لطفا پیام خود را فوروارد کنید [پیام فوروارد شده میتوانید از شخص یا کانال باشد]",
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "برگشت 🔙"]
                    ]
                ],
                'resize_keyboard' => true
            ])
        ]);
        $connect->query("UPDATE user SET step = 'fortoall' WHERE id = '$from_id' LIMIT 1");
        if (mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM sendall  LIMIT 1")) != true) {
            $connect->query("INSERT INTO `sendall` (`run`, `msgid`, `step`, `text`,  `chat`, `user`) VALUES ('ok', '', '', '', '', '0')");
        }
        $connect->query("UPDATE sendall SET step = 'none' , text = '' , msgid = '' , user = '0' , chat = '' WHERE run = 'ok' LIMIT 1");
    }
}
//admin panel
//=====================================================================
elseif ($textMessage == "join") {
    $tch = MainBot('getChatMember', ['chat_id' => "@$channel", 'user_id' => "$from_id"])->result->status;
    if ($tch == 'member' or $tch == 'creator' or $tch == 'administrator') {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "☑️ عضویت شما تایید شد ! شما هم اکنون می توانید از امکانات ویژه ربات استفاده کنید ! 
	
💎 همین الان با انتخاب'💬 چت ناشناس' به صورت ناشناس شروع به چت کردن با یک نفر دیگه کن و شانستو امتحان کن
🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
            'reply_markup' => json_encode($HomeMarkup)
        ]);
    } else {
        MainBot('answercallbackquery', [
            'callback_query_id' => $membercall,
            'text' => "❌ هنوز داخل کانال @$channel عضو نیستید",
            'show_alert' => true
        ]);
    }
} elseif ($textMessage == "recaverbaner") {
    MainBot('answercallbackquery', [
        'callback_query_id' => $membercall,
        'text' => "	⏳ در حال ساخت بنر اختصاصی شما ...",
        'show_alert' => false
    ]);
    $patch = MainBot('getfile', ['file_id' => $user["photo"]])->result->file_path;
    $w = 640;
    $h = 640; // original size
    $dest_path = "$from_id.png";
    $src = imagecreatefromstring(file_get_contents("https://api.telegram.org/file/bot" . API_KEY . "/$patch"));
    $newpic = imagecreatetruecolor($w, $h);
    imagealphablending($newpic, false);
    $transparent = imagecolorallocatealpha($newpic, 0, 0, 0, 127);
    $r = $w / 2;

    for ($x = 0; $x < $w; $x++)
        for ($y = 0; $y < $h; $y++) {
            $c = imagecolorat($src, $x, $y);
            $_x = $x - $w / 2;
            $_y = $y - $h / 2;
            if ((($_x * $_x) + ($_y * $_y)) < ($r * $r)) {
                imagesetpixel($newpic, $x, $y, $c);
            } else {
                imagesetpixel($newpic, $x, $y, $transparent);
            }
        }
    imagesavealpha($newpic, true);
    imagepng($newpic, $dest_path);
    imagedestroy($newpic);
    imagedestroy($src);
    $t = imagecreatefrompng("$from_id.png");
    $x = imagesx($t);
    $y = imagesy($t);
    $s = imagecreatetruecolor(1000, 1000);
    imagealphablending($s, false);
    imagecopyresampled(
        $s,
        $t,
        0,
        0,
        0,
        0,
        1000,
        1000,
        $x,
        $y
    );
    imagesavealpha($s, true);
    imagepng($s, "$from_id.png");
    imagedestroy($s);
    imagedestroy($t);
    $stamp = imagecreatefrompng("$from_id.png");
    $im = imagecreatefromjpeg("baner.jpg");
    $marge_right = 1450;
    $marge_bottom = 1970;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
    header("Content-Type: image/png");
    imagejpeg($im, "$from_id.png");
    imagedestroy($im);
    $getnamesub = mb_substr("$first_name", "0", "10") . "...";
    $id = MainBot('sendphoto', [
        'chat_id' => $chat_id,
        'photo' => new CURLFile("$from_id.png"),
        'caption' => "$getnamesub دعوتت کرده
💬 که وارد ربات 《 $robotName 》 بشی و به صورت ناشناس با #اطرافیانت , #همسنات یا و ... چت کنی !

👇 روی لینک زیر کلیک کن
telegram.me/$usernamebot?start=in_$from_id",
    ]);
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "💬 پیام بالا حاوی لینک دعوت اختصاصی شما به ربات به همراه عکس پروفایل شماست .
	
💰 با دعوت دوستان خود به ربات از طریق لینک دعوت خودتون به ازای هر نفر یک سکه دریافت میکنید
🎁 و زمانی که تعداد زیر مجموعه های شما به 5 نفر رسید حساب شما تبدیل به ویژه خواهد شد ! این عالیه نه ؟

🌟 منتظر چی هستی ؟ همین الان بنرت رو به گروه ها و دوستات بفرست و دعوتشون کن 

💰 تعداد سکه : {$user["coin"]}
👤 تعداد زیرمجموعه ها : {$user["member"]} نفر",
        'reply_to_message_id' => $id->result->message_id,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    ['text' => "🎊 سکه روزانه", 'callback_data' => "dailycoin"]
                ],
            ]
        ])
    ]);
    unlink("$from_id.png");
    $connect->query("UPDATE user SET baner = '{$id->result->photo[4]->file_id}' WHERE id = '$from_id' LIMIT 1");
} elseif ($textMessage == "dailycoin") {
    if ($user["daily"] != true) {
        $pluscoin = $user["coin"] + 1;
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "🎉 تبریک ! سکه روزانه امروزت رو دریافت کردی
	
🌟 فردا دوباره منتظر شما هستیم ...",
            'reply_to_message_id' => $message_id,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => "💰 تعداد سکه ها", 'callback_data' => "text"],
                        ['text' => "$pluscoin", 'callback_data' => "text"]
                    ],
                ]
            ])
        ]);
        $connect->query("UPDATE user SET daily = 'true' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
    } else {
        MainBot('answercallbackquery', [
            'callback_query_id' => $membercall,
            'text' => "😲 سکه روزانه امروزت رو دریافت کردی ! منتظر باش فردا خبرت میکنم",
            'show_alert' => true
        ]);
    }
} elseif ($textMessage == "like") {
    $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$user["side"]}' LIMIT 1"));
    $all = explode("^", $side["liker"]);
    if (!in_array($from_id, $all)) {
        MainBot('answercallbackquery', [
            'callback_query_id' => $membercall,
            'text' => "👍🏻 پروفایل طرف مقابلت لایک شد",
            'show_alert' => true
        ]);
        $pluslike = $side["like"] + 1;
        MainBot('editMessageReplyMarkup', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => "👍🏻 $pluslike", 'callback_data' => "like"],
                        ['text' => "👎🏻 {$side["dislike"]}", 'callback_data' => "dislike"]
                    ],
                ]
            ])
        ]);
        $connect->query("UPDATE user SET like = '$pluslike' , liker = CONCAT (liker,'$from_id^') WHERE id = '{$user["side"]}' LIMIT 1");
    } else {
        MainBot('answercallbackquery', [
            'callback_query_id' => $membercall,
            'text' => "🙃 شما قبلا نظرت رو درباره این پروفایل گفتی",
            'show_alert' => true
        ]);
    }
} elseif ($textMessage == "dislike") {
    $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$user["side"]}' LIMIT 1"));
    $all = explode("^", $side["liker"]);
    if (!in_array($from_id, $all)) {
        MainBot('answercallbackquery', [
            'callback_query_id' => $membercall,
            'text' => "👎🏻 پروفایل طرف مقابلت دیس لایک شد",
            'show_alert' => true
        ]);
        $pluslike = $side["dislike"] + 1;
        MainBot('editMessageReplyMarkup', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => "👍🏻 {$side["like"]}", 'callback_data' => "like"],
                        ['text' => "👎🏻 $pluslike", 'callback_data' => "dislike"]
                    ],
                ]
            ])
        ]);
        $connect->query("UPDATE user SET `dislike` = '$pluslike' , liker = CONCAT (liker,'$from_id^') WHERE id = '{$user["side"]}' LIMIT 1");
    } else {
        MainBot('answercallbackquery', [
            'callback_query_id' => $membercall,
            'text' => "🙃 شما قبلا نظرت رو درباره این پروفایل گفتی",
            'show_alert' => true
        ]);
    }
} elseif ($textMessage == "endy") {
    MainBot('deletemessage', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
    ]);
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "✅ `گفت و گوی شما با طرف مقابلت توسط شما بسته شد .`

🌟 در مورد طرف مقابلت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode([
            'keyboard' => [
                [
                    ['text' => "🛑 گزارش تخلف"],
                    ['text' => "👁 مشاهده پروفایل"]
                ],
                [
                    ['text' => "👨‍👧‍👧 دوستی"],
                    ['text' => "🚫 بلاکش کن"]
                ],
                [
                    ['text' => "🏠 خانه"]
                ]
            ],
            'resize_keyboard' => true
        ])
    ]);

    MainBot('sendmessage', [
        'chat_id' => $user["side"],
        'text' => "✅ `گفت و گوی شما با طرف مقابلت توسط طرف مقابلت بسته شد .`

🌟 در مورد طرف مقابلت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode([
            'keyboard' => [
                [
                    ['text' => "🛑 گزارش تخلف"],
                    ['text' => "👁 مشاهده پروفایل"]
                ],
                [
                    ['text' => "👨‍👧‍👧 دوستی"],
                    ['text' => "🚫 بلاکش کن"]
                ],
                [
                    ['text' => "🏠 خانه"]
                ]
            ],
            'resize_keyboard' => true
        ])
    ]);
    $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
    $connect->query("UPDATE user SET step = 'none' WHERE id = '{$user["side"]}' LIMIT 1");
} elseif ($textMessage == "viy") {
    MainBot('deletemessage', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
    ]);
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "✅ `گفت و گوی شما با طرف مقابلت توسط شما بسته شد .`
	
🗣 از این که به ما در گزارش کاربران متخلف یاری میرسانید مشترکیم 
🔘 لطفا به صورت توضیح کوچک یا بهتر است از اسکرین شات [عکس صحفه] برای نمایش تخلف کاربر استفاده کنید 
گزارش خود را در قالب یک پیام ارسال کنید 👇🏻",
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode([
            'keyboard' => [
                [
                    ['text' => "❌ لغو ارسال گزارش"]
                ]
            ],
            'resize_keyboard' => true
        ])
    ]);
    MainBot('sendmessage', [
        'chat_id' => $user["side"],
        'text' => "✅ `گفت و گوی شما با طرف مقابلت توسط طرف مقابلت بسته شد .`

🌟 در مورد طرف مقابلت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode([
            'keyboard' => [
                [
                    ['text' => "🛑 گزارش تخلف"],
                    ['text' => "👁 مشاهده پروفایل"]
                ],
                [
                    ['text' => "👨‍👧‍👧 دوستی"],
                    ['text' => "🚫 بلاکش کن"]
                ],
                [
                    ['text' => "🏠 خانه"]
                ]
            ],
            'resize_keyboard' => true
        ])
    ]);
    $connect->query("UPDATE user SET step = 'report' WHERE id = '$from_id' LIMIT 1");
    $connect->query("UPDATE user SET step = 'none' WHERE id = '{$user["side"]}' LIMIT 1");
} elseif ($textMessage == "bly") {
    MainBot('deletemessage', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
    ]);
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "✅ گفت و گوی شما با طرف مقابلت توسط شما بسته شد .
	
⭕️ کاربر با موفقیت به بلاک لیست شما اضافه شد .
🔘 شما میتوانید در منوی اصلی ربات بلاک لیست خود را مشاهده کنید
ℹ️ کاربرانی که در لیست بلاک شما قرار دارند امکان گفت و گو و ارسال پیام به شما را ندارند

🌟 در مورد طرف مقابلت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
        'reply_markup' => json_encode([
            'keyboard' => [
                [
                    ['text' => "🛑 گزارش تخلف"],
                    ['text' => "👁 مشاهده پروفایل"]
                ],
                [
                    ['text' => "👨‍👧‍👧 دوستی"],
                    ['text' => "🚫 بلاکش کن"]
                ],
                [
                    ['text' => "🏠 خانه"]
                ]
            ],
            'resize_keyboard' => true
        ])
    ]);
    MainBot('sendmessage', [
        'chat_id' => $user["side"],
        'text' => "✅ گفت و گوی شما با طرف مقابلت توسط طرف مقابلت بسته شد .

🌟 در مورد طرف مقابلت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
        'reply_markup' => json_encode([
            'keyboard' => [
                [
                    ['text' => "🛑 گزارش تخلف"],
                    ['text' => "👁 مشاهده پروفایل"]
                ],
                [
                    ['text' => "👨‍👧‍👧 دوستی"],
                    ['text' => "🚫 بلاکش کن"]
                ],
                [
                    ['text' => "🏠 خانه"]
                ]
            ],
            'resize_keyboard' => true
        ])
    ]);
    $connect->query("UPDATE user SET step = 'none' , blocklist = CONCAT (blocklist,'{$user["side"]}^') WHERE id = '$from_id' LIMIT 1");
    $connect->query("UPDATE user SET step = 'none' WHERE id = '{$user["side"]}' LIMIT 1");
} elseif ($textMessage == "endn") {
    MainBot('editmessagetext', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "🤖 پیام سیستم 👇 
			   
`✅ درخواست شما لغو و چت بسته نشده . به احوال پرسی با طرف مقابلت ادامه بده`",
        'parse_mode' => 'Markdown',
    ]);
} elseif ($textMessage == "sendmsg") {
    $userside = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$user["stats"]}' LIMIT 1"));
    $all = explode("^", $userside["blocklist"]);
    if (!in_array($from_id, $all)) {
        if ($user["step"] != "chat") {
            MainBot('editmessagetext', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => "🗣 لطفا پاسخ خود را ارسال کنید 
			   
ℹ️ پیام شما حداکثر میتواند 400 کاراکتر یا حرف داشته باشد .
🔘 پس از ارسال پیام کاربر میتواند به پیام شما پاسخ ارسال کند",

            ]);
            $connect->query("UPDATE user SET step = 'senddairect' WHERE id = '$from_id' LIMIT 1");
        } else {
            MainBot('answercallbackquery', [
                'callback_query_id' => $membercall,
                'text' => "😲 کاربر طرف مقابل در حال گفت و گو میباشد و امکان ارسال پیام وجود ندارد . دقایقی دیگر مجدد تلاش کنید",
                'show_alert' => true
            ]);
        }
    } else {
        MainBot('answercallbackquery', [
            'callback_query_id' => $membercall,
            'text' => "❗️ شما در بلاک لیست کاربر مقابل قرار دارد و امکان ارسال پیام به فرد مقابل را ندارد .",
            'show_alert' => true
        ]);
    }
} elseif ($textMessage == "okchat") {
    if ($user["coin"] > 0) {
        $user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$user["stats"]}' LIMIT 1"));
        if ($user["step"] != "chat") {
            MainBot('editmessagetext', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => "درخواست چت از طرف '{$user["name"]}' موفقیت توسط شما پذیرفته شد ✅",
            ]);
            MainBot('sendmessage', [
                'chat_id' => $user["stats"],
                'text' => "درخواست چت شما توسط '{$user["name"]}' پذیرفته شد ✅",
            ]);
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode($InChatMarkup)
            ]);
            MainBot('sendmessage', [
                'chat_id' => $user["stats"],
                'text' => "☑️ به کاربر متصل شدی
🗣 به طرف مقابلت سلام کن 😄

🌟 `برای مدیریت چت هم میتونی از دکمه های زیر استفاده کنی` 👇🏻",
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode($InChatMarkup)
            ]);
            $user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '$from_id' LIMIT 1"));
            $side = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$user["stats"]}' LIMIT 1"));
            $bio = isset($side["bio"]) ? $side["bio"] : "تنظیم نشده !";
            if ($side["photo"] == true) {
                MainBot('sendphoto', [
                    'chat_id' => $chat_id,
                    'photo' => $side["photo"],
                    'caption' => $bio,
                    'reply_markup' => json_encode($LikeMarkup)
                ]);
            } else {
                MainBot('sendphoto', [
                    'chat_id' => $chat_id,
                    'photo' => "https://t.me/GTele_Channel/58",
                    'caption' => "$bio",
                ]);
            }
            $bio = isset($user["bio"]) ? $user["bio"] : "تنظیم نشده !";
            if ($user["photo"] == true) {
                MainBot('sendphoto', [
                    'chat_id' => $user["stats"],
                    'photo' => $user["photo"],
                    'caption' => $bio,
                    'reply_markup' => json_encode($LikeMarkup3)
                ]);
            } else {
                MainBot('sendphoto', [
                    'chat_id' => $user["stats"],
                    'photo' => "https://t.me/GTele_Channel/58",
                    'caption' => "$bio",
                ]);
            }
            $time = date("H:i:s", strtotime("+10 seconds"));
            $pluscoin = $user["coin"] - 1;
            $connect->query("UPDATE user SET side = '{$user["stats"]}' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '$from_id' LIMIT 1");
            $pluscoin = $side["coin"] - 1;
            $connect->query("UPDATE user SET side = '$from_id' , coin = '$pluscoin' , step = 'chat' , time = '$time' WHERE id = '{$user["stats"]}' LIMIT 1");
        } else {
            MainBot('answercallbackquery', [
                'callback_query_id' => $membercall,
                'text' => "😲 کاربر طرف مقابل در حال گفت و گو میباشد و امکان گفت و گو وجود ندارد . دقایقی دیگر مجدد تلاش کنید",
                'show_alert' => true
            ]);
        }
    } else {
        MainBot('answercallbackquery', [
            'callback_query_id' => $membercall,
            'text' => "😲 تعداد سکه شما کافی نمیباشد ! برای پذیرش درخواست باید حداقل یک سکه داشته باشید . لطفا ابتدا نسبت به افزایش سکه اقدام کنید",
            'show_alert' => true
        ]);
    }
} elseif ($textMessage == "nochat") {
    $user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$user["stats"]}' LIMIT 1"));
    MainBot('sendmessage', [
        'chat_id' => $user["stats"],
        'text' => "❌ درخواست چت شما از طرف '{$user["name"]}' لغو شد",
    ]);
    MainBot('editmessagetext', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "✅ درخواست چت از طرف'{$user["name"]}' توسط شما لغو شد",
    ]);
} elseif ($textMessage == "ydel") {
    switch ($user["step"]) {
        case "frind":
            MainBot('editmessagetext', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => "✅ `لیست دوستان شما به صورت کامل پاک شد`",
                'parse_mode' => 'Markdown',
            ]);
            $connect->query("UPDATE user SET frindlist = '' WHERE id = '$from_id' LIMIT 1");
            break;
        case "block":
            MainBot('editmessagetext', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => "✅ `بلاک لیست شما به صورت کامل پاک شد`",
                'parse_mode' => 'Markdown',
            ]);
            $connect->query("UPDATE user SET blocklist = '' WHERE id = '$from_id' LIMIT 1");
            break;
    }
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "🔘 `به منوی اصلی بازگشتید`
	
🌟 چه کاری برات انجام بدم ؟ از منوی پایین انتخاب کن 👇🏻",
        'parse_mode' => 'Markdown',
        'reply_markup' => json_encode($HomeMarkup)
    ]);
} elseif ($textMessage == "nodel") {
    MainBot('editmessagetext', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "✅ `درخواست شما با موفقیت لغو شد با لیست بالا میخوای چی کار کنی ؟ 👆🏻`",
        'parse_mode' => 'Markdown',
    ]);
} elseif ($textMessage == "likeme") {
    MainBot('answercallbackquery', [
        'callback_query_id' => $membercall,
        'text' => "😲 شما نمیتوانید عکس پروفایل خود را لایک کنید !",
        'show_alert' => true
    ]);
} elseif ($textMessage == "text") {
    MainBot('answercallbackquery', [
        'callback_query_id' => $membercall,
        'text' => "😆 این دکمه فقط جهت نمایش اطلاعات است !",
        'show_alert' => true
    ]);
}
//========================================================================
elseif (preg_match('/set(.*)/', $user["step"])) {
    switch ($user["step"]) {
        case "setsex":
            if (in_array($textMessage, array("👸🏻 دخترم", "🤴🏻 پسرم"))) {
                $str = str_replace(["👸🏻 دخترم", "🤴🏻 پسرم"], ["دختر", "پسر"], $textMessage);
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "✅ جنسیت شما با موفقیت $str ذخیره شد .

🎊 لطفا سن خود را وارد نمایید
ℹ️ میتونی سن خودت رو به صورت عداد لاتین یا از کیبورد زیر وارد کنی 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($OldMarkup)
                ]);
                $connect->query("UPDATE user SET step = 'setold' , sex = '$str' WHERE id = '$from_id' LIMIT 1");
            } else {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "😄 سلام $first_name
	
به ربات چت ناشناسه 《 $robotName 》 خوش آمدید 🌹

🎊 با استفاده از این ربات میتونی با  جنس مخالفت , همسنت , هم شهری یا افراد نزدیک بهت حرف بزنی و دوست بشی
💑 همراه با کلی امکانات دیگ ...

🌟 خوب اول باید اطلاعات خود را ثبت کنی ! جنسیت خودت رو انتخاب کن ؟ 👇🏻",
                    'reply_markup' => json_encode($GenderMarkup)
                ]);
            }
            break;
        case "setold":
            $str = str_replace("+", "", $textMessage);
            if ($str >= 7 and $str <= 90) {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "✅ سن شما با موفقیت '$str' سال ذخیره شد .

🏢 لطفا استان محل سکونت خود را انتخاب نمایید 👇🏻
ℹ️ توجه کنید در صورتی که خارج از ایران زندگی میکنید از دکمه آخر استفاده کنید",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => "آذربایجان شرقی"],
                                ['text' => "اردبیل"],
                                ['text' => "اصفهان"]
                            ],
                            [
                                ['text' => "آذربایجان غربی"],
                                ['text' => "البرز"],
                                ['text' => "بوشهر"]
                            ],
                            [
                                ['text' => "چهارمحال و بختیاری"],
                                ['text' => "تهران"],
                                ['text' => "ایلام"]
                            ],
                            [
                                ['text' => "خراسان جنوبی"],
                                ['text' => "خوزستان"],
                                ['text' => "زنجان"]
                            ],
                            [
                                ['text' => "خراسان شمالی"],
                                ['text' => "سمنان"],
                                ['text' => "فارس"]
                            ],
                            [
                                ['text' => "خراسان رضوی"],
                                ['text' => "قزوین"],
                                ['text' => "قم"]
                            ],
                            [
                                ['text' => "سیستان و بلوچستان"],
                                ['text' => "کردستان"],
                                ['text' => "کرمان"]
                            ],
                            [
                                ['text' => "کهگیلویه و بویراحمد"],
                                ['text' => "کرمانشاه"],
                                ['text' => "گیلان"]
                            ],
                            [
                                ['text' => "گلستان"],
                                ['text' => "لرستان"],
                                ['text' => "مازندران"]
                            ],
                            [
                                ['text' => "مرکزی"],
                                ['text' => "هرمزگان"],
                                ['text' => "همدان"],
                                ['text' => "یزد"]
                            ],
                            [
                                ['text' => "خارج از کشور"],
                                ['text' => "موارد دیگر"]
                            ],

                        ],
                        'resize_keyboard' => true
                    ])
                ]);
                $connect->query("UPDATE user SET step = 'setProvince' , old = '$str' WHERE id = '$from_id'");
            } else {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "⚠️ خطا در سن وارد شده ! سن شما معتبر نیست

🎊 لطفا سن خود را وارد نمایید
ℹ️ میتونی سن خودت رو به صورت عداد لاتین یا از کیبورد زیر وارد کنی 👇🏻
❗️ توجه کنید که سن شما حداکثر میتوانید 90 سال و حداقل 7 سال باشد",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($OldMarkup)
                ]);
            }
            break;
        case "setProvince":
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "✅ استان شما با موفقیت '$textMessage' ذخیره شد و هشت سکه به خاطر تکمیل اولیه پروفایل به شما تعلق گرفت .

☑️ ثبت اطلاعات اولیه شما با موفقیت انجام شد به ربات 《 $robotName 》 خوش آمدید .
ℹ️ شما میتوانید با مراجعه به قسمت '👤 پروفایل' نسبت به تکمیل یا تغییر اطلاعات اقدام کنید

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻
💎 همین الان با انتخاب'💬 چت ناشناس' به صورت ناشناس شروع به چت کردن با یک نفر دیگه کن و شانستو امتحان کن",
                'reply_to_message_id' => $message_id,
                'reply_markup' => json_encode($HomeMarkup)
            ]);
            $bio = getbio($username);
            $connect->query("UPDATE user SET step = 'none' , province = '" . mb_substr($textMessage, 0, 50) . "' , name = '" . mb_substr($first_name, 0, 50) . "' WHERE id = '$from_id'");
            break;
    }
} elseif (preg_match('/select(.*)/', $user["step"])) {
    switch ($user["step"]) {
        case "selectlocation":
            if (isset($update->message->location)) {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "✅ موقعیت مکانی شما با موفقیت ویرایش شد !
💰 یک سکه از شما بابت ویرایش اطلاعات کسر شد .

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($HomeMarkup)
                ]);
                $pluscoin = $user["coin"] - 1;
                $connect->query("UPDATE user SET step = 'none' , gps = 'true' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
            } else {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🖌️ برای ویرایش موقعیت مکانی خود از دکمه زیر استفاده کنید
❗️ توجه کنید حتما برای ارسال موقعیت مکانی GPS [مکان] گوشی خود را روشن کنید

ℹ️ در صورتی که در این زمینه نیاز به راهنما دارید میتوانید از آموزش زیر استفاده کنید
⚠️ توجه کنید پس از روشن کردن GPS پانزده ثانیه صبر کنید سپس روی '🏢 ارسال موقعیت مکانی'  ضربه بزنید 
❕ توجه کنید اگر موقعیت مکانی شما پیدا نشد از انتخاب دستی استفاده کنید
",
                    'parse_mode' => 'Markdown',
                    'reply_to_message_id' => $message_id,
                    'disable_web_page_preview' => true,
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => "🏢 ارسال موقعیت مکانی", "request_location" => true]
                            ],
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],

                        ],
                        'resize_keyboard' => true
                    ])
                ]);
            }
            break;
        case "selectname":
            if (mb_strlen($textMessage) <= 50 and isset($textMessage)) {
                $str = str_replace(["🗣 نام تلگرام"], ["$first_name"], $textMessage);
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "✅ نام شما '$str' ذخیره شد
💰 یک سکه از شما بابت ویرایش اطلاعات کسر شد .

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($HomeMarkup)
                ]);
                $pluscoin = $user["coin"] - 1;
                $connect->query("UPDATE user SET step = 'none' , name = '" . mb_substr($str, 0, 50) . "' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
            } else {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "⚠️ نام شما بسیار بزرگ یا تعریف نشده است !
🖌️ لطفا نام مورد نظر را ارسال کنید
	
ℹ️ میتوانید نام را به فارسی یا انگلیسی وارد کنید یا از دکمه '🗣 نام تلگرام' استفاده کنید 👇🏻
❗️ در صورت استفاده از دکمه از نام فعلی شما در تلگرام استفاده خواهد شد",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => "🗣 نام تلگرام"]
                            ],
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],

                        ],
                        'resize_keyboard' => true
                    ])
                ]);
            }
            break;
        case "selectsex":
            if (in_array($textMessage, array("👸🏻 دخترم", "🤴🏻 پسرم"))) {
                $str = str_replace(["👸🏻 دخترم", "🤴🏻 پسرم"], ["دختر", "پسر"], $textMessage);
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "✅ جنسیت شما با موفقیت $str ذخیره شد .
💰 یک سکه از شما بابت ویرایش اطلاعات کسر شد .

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($HomeMarkup)
                ]);
                $pluscoin = $user["coin"] - 1;
                $connect->query("UPDATE user SET step = 'none' , sex = '$str' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
            } else {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "🖌️ لطفا جنیست خود را انتخاب کنید 👇🏻",
                    'reply_markup' => json_encode([
                        'keyboard' => [

                            [
                                ['text' => "👸🏻 دخترم"],
                                ['text' => "🤴🏻 پسرم"]
                            ],
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],

                        ],
                        'resize_keyboard' => true
                    ])
                ]);
            }
            break;
        case "selectProvince":
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "✅ استان شما با موفقیت $textMessage ذخیره شد .
💰 یک سکه از شما بابت ویرایش اطلاعات کسر شد .

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                'reply_to_message_id' => $message_id,
                'reply_markup' => json_encode($HomeMarkup)
            ]);
            $pluscoin = $user["coin"] - 1;
            $connect->query("UPDATE user SET step = 'none' , province = '" . mb_substr($textMessage, 0, 50) . "' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
            break;
        case "selectCity":
            MainBot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "✅ شهر شما با موفقیت $textMessage ذخیره شد .
💰 یک سکه از شما بابت ویرایش اطلاعات کسر شد .

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                'reply_to_message_id' => $message_id,
                'reply_markup' => json_encode($HomeMarkup)
            ]);
            $pluscoin = $user["coin"] - 1;
            $connect->query("UPDATE user SET step = 'none' ,  city = '" . mb_substr($textMessage, 0, 50) . "' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
            break;
        case "selectold":
            $str = str_replace("+", "", $textMessage);
            if ($str >= 7 and $str <= 90) {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "✅ سن شما با موفقیت '$str' سال ذخیره شد .
💰 یک سکه از شما بابت ویرایش اطلاعات کسر شد .

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($HomeMarkup)
                ]);
                $pluscoin = $user["coin"] - 1;
                $connect->query("UPDATE user SET step = 'none' , old = '$str' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
            } else {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "⚠️ خطا در سن وارد شده !
🖌️ لطفا سن خود را وارد نمایید
	
ℹ️ میتونی سن خودت رو به صورت عداد لاتین یا از کیبورد زیر وارد کنی 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($OldMarkup2)
                ]);
            }
            break;
        case "selectphoto":
            $photo = $update->message->photo;
            if (isset($photo)) {
                $photofile = $photo[count($photo) - 1]->file_id;
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "✅ عکس پروفایل شما با موفقیت تنظیم شد
💰 یک سکه از شما بابت ویرایش اطلاعات کسر شد .

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($HomeMarkup)
                ]);
                $pluscoin = $user["coin"] - 1;
                $connect->query("UPDATE user SET step = 'none' , photo = '$photofile' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
            } else {
                if ($textMessage == "📸 عکس تلگرام" or $textMessage == "❌ بدون عکس") {
                    $profilephoto = MainBot('getUserProfilePhotos', ['user_id' => "$from_id"])->result->photos[0][2]->file_id;
                    if ($textMessage == "📸 عکس تلگرام") {
                        if (!isset($profilephoto)) {
                            MainBot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "⚠️ خطا در عکس پروفایل ! شما عکس پروفایلی برای تنظیم ندارید .
❗️ ابتدا نسبت به تنظیم عکس پروفایل اقدام کنید سپس از دکمه استفاده کنید .
🖌️ لطفا عکس پروفایل خود در ربات را ارسال نمایید 👇🏻
	
ℹ️ میتوانید از دکمه های '📸 عکس تلگرام' و '❌ بدون عکس' نیز استفاده کنید
❗️ در صورت استفاده از دکمه ی عکس تلگرام از عکس پروفایل فعلی شما در تلگرام استفاده خواهد شد",
                                'reply_to_message_id' => $message_id,
                                'reply_markup' => json_encode([
                                    'keyboard' => [
                                        [
                                            ['text' => "📸 عکس تلگرام"],
                                            ['text' => "❌ بدون عکس"]
                                        ],
                                        [
                                            ['text' => "🏠 خانه"],
                                            ['text' => "🔙 برگشت"]
                                        ],
                                    ],
                                    'resize_keyboard' => true
                                ])
                            ]);
                        }
                    }
                    $str = str_replace(["📸 عکس تلگرام", "❌ بدون عکس"], ["$profilephoto", ""], $textMessage);
                    $strname = str_replace(["📸 عکس تلگرام", "❌ بدون عکس"], ["عکس پروفایل شما با توجه به عکس پروفایل تلگرام شما تنظیم شد !", "عکس پروفایل شما با موفقیت حذف شد"], $textMessage);
                    MainBot('sendmessage', [
                        'chat_id' => $chat_id,
                        'text' => "✅ $strname
💰 یک سکه از شما بابت ویرایش اطلاعات کسر شد .

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                        'reply_to_message_id' => $message_id,
                        'reply_markup' => json_encode($HomeMarkup)
                    ]);
                    $pluscoin = $user["coin"] - 1;
                    $connect->query("UPDATE user SET step = 'none' , photo = '$str' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
                } else {
                    MainBot('sendmessage', [
                        'chat_id' => $chat_id,
                        'text' => "⚠️ خطا در عکس ارسال شده ! تنها ارسال عکس ممکن است .
🖌️ لطفا عکس پروفایل خود در ربات را ارسال نمایید 👇🏻
	
ℹ️ میتوانید از دکمه های '📸 عکس تلگرام' و '❌ بدون عکس' نیز استفاده کنید
❗️ در صورت استفاده از دکمه ی عکس تلگرام از عکس پروفایل فعلی شما در تلگرام استفاده خواهد شد",
                        'reply_to_message_id' => $message_id,
                        'reply_markup' => json_encode([
                            'keyboard' => [
                                [
                                    ['text' => "📸 عکس تلگرام"],
                                    ['text' => "❌ بدون عکس"]
                                ],
                                [
                                    ['text' => "🏠 خانه"],
                                    ['text' => "🔙 برگشت"]
                                ],
                            ],
                            'resize_keyboard' => true
                        ])
                    ]);
                }
            }
            break;
        case "selectbio":
            if (mb_strlen($textMessage) <= 70 and isset($textMessage)) {
                if ($textMessage == "ℹ️ بیو تلگرام") {
                    $bio = getbio($username);
                    if (isset($bio)) {
                        MainBot('sendmessage', [
                            'chat_id' => $chat_id,
                            'text' => "✅ متن بیو و درباره شما با وتوجه به متن بیو تلگرام شما تنظیم شد
💰 یک سکه از شما بابت ویرایش اطلاعات کسر شد .

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                            'reply_to_message_id' => $message_id,
                            'reply_markup' => json_encode($HomeMarkup)
                        ]);
                        $pluscoin = $user["coin"] - 1;
                        $connect->query("UPDATE user SET step = 'none' , bio = '$bio' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
                        break;
                    } else {
                        MainBot('sendmessage', [
                            'chat_id' => $chat_id,
                            'text' => "⚠️ متن درباره ای از پروفایل تلگرام شما پیدا نشد !
🖌️ لطفا متن بیو [درباره] خود را ارسال نمایید 👇🏻
	
❗️ توجه کنید متن درباره شما حداکثر میتوانید 80 کاراکتر یا حرف باشد !
🌟 برای تنظیم بیو خود میتوانید از دکمه ی 'ℹ️ بیو تلگرام' نیز استفاده کنید",
                            'reply_to_message_id' => $message_id,
                            'reply_markup' => json_encode([
                                'keyboard' => [
                                    [
                                        ['text' => "ℹ️ بیو تلگرام"],
                                        ['text' => "❌ بدون بیو"]
                                    ],
                                    [
                                        ['text' => "🏠 خانه"],
                                        ['text' => "🔙 برگشت"]
                                    ],
                                ],
                                'resize_keyboard' => true
                            ])
                        ]);
                    }
                }
                $bio = ($textMessage != "❌ بدون بیو") ? $textMessage : "تنظیم نشده !";
                $text = ($textMessage != "❌ بدون بیو") ? "✅ متن بیو شما با موفقیت تنظیم شد !" : "✅ متن بیو شما با موفقیت حذف شد";
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "$text
💰 یک سکه از شما بابت ویرایش اطلاعات کسر شد .

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode($HomeMarkup)
                ]);
                $pluscoin = $user["coin"] - 1;
                $connect->query("UPDATE user SET step = 'none' , bio = '$bio' , coin = '$pluscoin' WHERE id = '$from_id' LIMIT 1");
            } else {
                MainBot('sendmessage', [
                    'chat_id' => $chat_id,
                    'text' => "⚠️ متن ارسال شده یا بیش از اندازه بزرگ است یا تعریف نشده است !
🖌️ لطفا متن بیو [درباره] خود را ارسال نمایید 👇🏻
	
❗️ توجه کنید متن درباره شما حداکثر میتوانید 80 کاراکتر یا حرف باشد !
🌟 برای تنظیم بیو خود میتوانید از دکمه ی 'ℹ️ بیو تلگرام' نیز استفاده کنید",
                    'reply_to_message_id' => $message_id,
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                ['text' => "ℹ️ بیو تلگرام"],
                                ['text' => "❌ بدون بیو"]
                            ],
                            [
                                ['text' => "🏠 خانه"],
                                ['text' => "🔙 برگشت"]
                            ],
                        ],
                        'resize_keyboard' => true
                    ])
                ]);
            }
            break;
    }
} elseif ($user["step"] == "report" && $tc == "private") {
    if ($user["stats"] != "list") {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "✅ گزارش شما با موفقیت ارسال شد . از شما تشکر میکنیم 
🗣 `مدیران ما گزارش شما را برسی میکنند و در صورت هر نوع رعایت نکردن قوانین کاربر را مسدود میکندد `

ℹ️ در صورت امکان پاسخ گزارش شما برای شما ارسال خواهد شد
🌟 در مورد طرف مقابلت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
            'parse_mode' => 'Markdown',
            'reply_to_message_id' => $message_id,
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "🛑 گزارش تخلف"],
                        ['text' => "👁 مشاهده پروفایل"]
                    ],
                    [
                        ['text' => "👨‍👧‍👧 دوستی"],
                        ['text' => "🚫 بلاکش کن"]
                    ],
                    [
                        ['text' => "🏠 خانه"]
                    ]
                ],
                'resize_keyboard' => true
            ])
        ]);
    } else {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "✅ گزارش شما با موفقیت ارسال شد . از شما تشکر میکنیم 
🗣 `مدیران ما گزارش شما را برسی میکنند و در صورت هر نوع رعایت نکردن قوانین کاربر را مسدود میکندد `

ℹ️ در صورت امکان پاسخ گزارش شما برای شما ارسال خواهد شد
🌟 در مورد طرف مقابلت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
            'parse_mode' => 'Markdown',
            'reply_to_message_id' => $message_id,
            'reply_markup' => json_encode($ProfileMarkup2)
        ]);
    }
    MainBot('ForwardMessage', [
        'chat_id' => $admin[0],
        'from_chat_id' => $chat_id,
        'message_id' => $message_id
    ]);
    MainBot('sendmessage', [
        'chat_id' => $admin[0],
        'text' => "👑 #گزارش
👑 از طرف : $from_id
👑 کاربر خاطی : {$user["side"]}",
        'reply_to_message_id' => $message_id,
    ]);
    $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
} elseif ($user["step"] == "senddairect" && $tc == "private") {
    if (mb_strlen($textMessage) <= 400 and isset($textMessage)) {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "✅ پیام شما با موفقیت برای کاربر ارسال شد
🗣 `در صورتی که طرف مقابلت تمایل داشت به پیامت پاسخ میده .`

🌟 در مورد طرف مقابلت چه کاری برات انجام بدم ؟
از منوی پایین انتخاب کن 👇🏻",
            'reply_to_message_id' => $message_id,
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode($ProfileMarkup)
        ]);
        MainBot('sendmessage', [
            'chat_id' => $user["province"],
            'text' => "📩 یک پیام جدید از طرف {$user["name"]}
📝 متن پیامش :

$textMessage",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => "📨 ارسال پاسخ", 'callback_data' => "sendmsg"]
                    ],
                ]
            ])
        ]);
        $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
        $connect->query("UPDATE user SET stats = '$from_id' WHERE id = '{$user["stats"]}' LIMIT 1");
    } else {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "`⚠️ متن ارسال شده یا پیش از اندازه بزرگ است یا تعریف نشده است !`
🖌️ لطفا پیام خود را ارسال کنید تا برای کاربر ارسال شود
	
❗️ توجه کنید متن شما حداکثر میتوانید 400 کاراکتر یا حرف باشد",
            'reply_to_message_id' => $message_id,
            'parse_mode' => 'Markdown',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => "❌ لغو ارسال پیام"]
                    ]
                ],
                'resize_keyboard' => true
            ])
        ]);
    }
} elseif ($user["step"] == "sup" && $tc == "private") {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "👑 پیام شما با موفقیت ارسال شد منتظر پاسخ پشتیبانی باشید",
    ]);
    MainBot('ForwardMessage', [
        'chat_id' => $admin[0],
        'from_chat_id' => $chat_id,
        'message_id' => $message_id
    ]);
} elseif ($user["step"] == "vipuser" && $tc == "private") {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "👑 حساب کاربر فرد با ایدی $textMessage ویژه شد",
    ]);
    MainBot('sendmessage', [
        'chat_id' => $textMessage,
        'text' => "🎊 تبریک حساب شما توسط مدیریت ویژه شد",
    ]);
    $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
    $connect->query("UPDATE user SET vip = 'true' WHERE id = '$textMessage' LIMIT 1");
} elseif ($user["step"] == "coinuser" && $tc == "private") {
    $all = explode("\n", $textMessage);
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "👑 تعداد $all[1] سکه به کاربر $all[0] داده شد",
    ]);
    MainBot('sendmessage', [
        'chat_id' => $all[0],
        'text' => "💰 تعداد $all[1] سکه توسط مدیریت به شما داده شد",
    ]);
    $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
    $userside = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '{$all[0]}' LIMIT 1"));
    $pluscoin = $userside["coin"] + $all[1];
    $connect->query("UPDATE user SET coin = '$pluscoin' WHERE id = '{$all[0]}' LIMIT 1");
} elseif ($user["step"] == 'sendtoall' && $tc == "private") {
    $filephoto = $message->photo;
    $photo = $filephoto[count($filephoto) - 1]->file_id;
    $file = $update->message->document->file_id;
    $caption = $update->message->caption;
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "پیام شما با موفقیت برای ارسال همگانی تنظیم شد  ✔️",
    ]);
    $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
    $connect->query("UPDATE sendall SET step = 'sendall' , text = '$textMessage$caption' , msgid = '$file$photo' WHERE run = 'ok' LIMIT 1");
} elseif ($user["step"] == 'fortoall' && $tc == "private") {
    MainBot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "پیام شما با موفقیت به عنوان فوروارد همگانی تنظیم شد ✔️",
    ]);
    $connect->query("UPDATE user SET step = 'none' WHERE id = '$from_id' LIMIT 1");
    $connect->query("UPDATE sendall SET step = 'forall' , msgid = '$message_id' , chat = '$chat_id' WHERE run = 'ok' LIMIT 1");
}
//=============================================================
elseif ($update->message->text && $update->message->reply_to_message && $from_id == $admin[0] && $tc == "private") {
    MainBot('sendmessage', [
        "chat_id" => $chat_id,
        "text" => "پاسخ شما برای فرد ارسال شد ☑️"
    ]);
    MainBot('sendmessage', [
        "chat_id" => $update->message->reply_to_message->forward_from->id,
        "text" => "👮🏻 پاسخ پشتیبان برای شما : `$textMessage`",
        'parse_mode' => 'MarkDown'
    ]);
} elseif ($update->message and $tc == "private" and $user["step"] != "offline") {
    strpos($textMessage, '_') !== false;
    $text = explode('_', $textMessage);
    if (!$text[0]) {
        MainBot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "به ربات چت ناشناسه 《 $robotName 》 خوش آمدید 🌹

🎊 با استفاده از این ربات میتونی با  جنس مخالفت , همسنت , هم شهری یا افراد نزدیک بهت حرف بزنی و دوست بشی
💑 همراه با کلی امکانات دیگ ...

🌟 به منوی اصلی ربات خوش اومدی . خوب الان از منوی پایین انتخاب کن 👇🏻",
            'reply_markup' => json_encode($HomeMarkup)
        ]);
    }
}
