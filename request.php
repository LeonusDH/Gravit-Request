<?php
if (config::$settings['tech_work'] == true) {
    die(messages::$msg['tech_work']);
}
$login = str_replace(' ', '', $_GET['login']);
$pass = $_GET['password'];
$key = str_replace(' ', '', $_GET['key']);
$ipA = str_replace(' ', '', $_GET['ip']);
$ip = '';
$type = str_replace(' ', '', $_GET['type']);
$size = str_replace(' ', '', $_GET['size']);
class config
{
    static $settings = array(
        "db_host" => '', // 127.0.0.1 или localhost или IP
        "db_port" => '3306', // порт к БД
        "db_user" => '', // Имя пользователя БД
        "db_pass" => '', // Пароль БД
        "db_db" => '', // Имя базы данных сайта
        "cms_type" => 0, // Тип CMS [0 - DLE, 1 - WebMCR, 2 - XenForo]
        "key_request" => '', // Секрет-Ключ скрипта для взаимодействия с авторизацией, обязательно для заполнения.
        //Создайте к примеру через сайт http://www.onlinepasswordgenerator.ru/ используя Спец. Символы
        "un_tpl" => '([a-zA-Z0-9\_\-]+)', // Проверка на Regexp
        "un_key" => '([a-zA-Z0-9\_\-\%\*\(\)\{\}\?\@\#\$\~]+)', // Проверка на Regexp для ключа, дополнительно %*(){}?@#$
        "skin_path" => "../minecraft/skins/", // Сюда вписать путь до skins/
        "cloak_path" => "../minecraft/cloaks/", // Сюда вписать путь до cloaks/
        "avatar_path" => "faces/", // Не менять
        "auth_limiter_path" => "al/", // Не менять
        "auth_cooldown" => 5, // Куллдаун на авторизацию. Смотреть README
        // Далее идут base64 скина, плаща и аватара Стива
        "b64s" => "iVBORw0KGgoAAAANSUhEUgAAAEAAAAAgCAMAAACVQ462AAAAWlBMVEVHcEwsHg51Ri9qQC+HVTgjIyNOLyK7inGrfWaWb1udZkj///9SPYmAUjaWX0FWScwoKCgAzMwAXl4AqKgAaGgwKHImIVtGOqU6MYkAf38AmpoAr68/Pz9ra2t3xPtNAAAAAXRSTlMAQObYZgAAAZJJREFUeNrUzLUBwDAUA9EPMsmw/7jhNljl9Xdy0J3t5CndmcOBT4Mw8/8P4pfB6sNg9yA892wQvwzSIr8f5JRzSeS7AaiptpxazUq8GPQB5uSe2DH644GTsDFsNrqB9CcDgOCAmffegWWwAExnBrljqowsFBuGYShY5oakgOXs/39zF6voDG9r+wLvTCVUcL+uV4m6uXG/L3Ut691697tgnZgJavinQHOB7DD8awmaLWEmaNuu7YGf6XcIITRm19P1ahbARCRGEc8x/UZ4CroXAQTVIGL0YySrREBADFGicS8XtG8CTS+IGU2F6EgSE34VNKoNz8348mzoXGDxpxkQBpg2bWobjgZSm+uiKDYH2BAO8C4YBmbgAjpq5jUl4yGJC46HQ7HJBfkeTAImIEmgmtpINi44JsHx+CKA/BTuArISXeBTR4AI5gK4C2JqRfPs0HNBkQnG8S4Yxw8IGoIZfXEBOW1D4YJDAdNSXgRevP+ylK6fGBCwsWywmA19EtBkJr8K2t4N5pnAVwH0jptsBp+2gUFj4tL5ywAAAABJRU5ErkJggg==",
        "b64c" => "iVBORw0KGgoAAAANSUhEUgAAAEAAAAAgAQMAAACYU+zHAAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAAAxJREFUeAFjGAV4AQABIAABL3HDQQAAAABJRU5ErkJggg==",
        "b64a" => "iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAIAAAABc2X6AAAACXBIWXMAAA7EAAAOxAGVKw4bAAABP0lEQVR42u3ZPUtCYRjGcU8ecAglD2JKcEDBrc8gGg3RFk5ODoIurY4Frg622eTgJmQ4BI0NfQkXLdAhMDm+hAVNfoNrOGA+4f9aLx64f9wON0fr1I0E9ikHgT0LYMCAAQMGDHh3sc0cKx2NifZtPmPDgAEDBgwYMOB/f2ndXZcNHHrxtRZtvdNlw4ABAwYMGDBgE2I93FREfRQ+9H3x6Hyu1NvMSVy04+GADQMGDBgwYMCAzY+tb6nzWlO0hWxDtMXcyPctdf+UEO3jq5qqd1tlw4ABAwYMGDBgE2K1Kxeijhy7otVXWv/5xfdYV5dnotXftCYzjw0DBgwYMGDAgI24tFqlvO/H7x/eToZOJR3RTuV/mvykAQMGDBgwYMB/FltfS+tf9TjuhLY0ViioNrH8/mHDgAEDBgwYMGDzswFXWTZaG7TM4wAAAABJRU5ErkJggg==",
        "avatar_cooldown" => 60, // Кэш аватаров в файловой системе в секундах, если не было затребовано другое разрешение
        "debug_mysql" => false, // Проверка на ошибки MySQL. Сохранение в файл debug.log !!! Не устанавливайте true навсегда и не забудьте после настройки удалить файл debug.log из папки
        "tech_work" => false
    );
    //Настройка названия таблицы, колонок и permission
    static $table = array(
        // DLE - При типе CMS 0
        "dle_tn" => "dle_users", // Название таблици
        "dle_user" => "name", // Название колонки пользователя name или username ?
        "dle_permission_column" => 'permissions', // Удалите целиком, оставив '' или исправьте название колонки для прав лаунчера. Будте внимательны с названием колонки, s на конце есть или нет в БД.
        // WebMCR - При типе CMS 1
        "wmcr_tn" => "mcr_users", // Название таблици
        "wmcr_user" => "login", // Название колонки пользователя
        "wmcr_permission_column" => '', // Удалите целиком, оставив '' или исправьте название колонки для прав лаунчера. Будте внимательны с названием колонки, s на конце есть или нет в БД.
        // XenForo - При типе CMS 2
        "xf_permission_column" => '', // Удалите целиком, оставив '' или исправьте название колонки для прав лаунчера. Будте внимательны с названием колонки, s на конце есть или нет в БД.
    );
    public static $mainDB = null;
    public static function initMainDB()
    {
        if (config::$mainDB == null)
            config::$mainDB = new db('', 0, true);
    }
}

class messages
{
    static $msg = array(
        "need_key" => "Проверьте секрет-ключ скрипта.\nДля обработки запроса",
        "err" => "Ошибка ",
        "player_not_found" => "Пользователь не найден",
        "pass_not_found" => "Пароль не найден",
        "incorrect_pass" => "Пароль неверный",
        "invalid" => "Введите правильные параметры",
        "tech_work" => "Проводятся тех. работы",
        "rgx_err" => "Проверка на Regexp выявила несоответствие",
        "not_impl" => "Не реализовано",
        "player_null" => "Пользователь не может быть пустым",
        "pass_null" => "Пароль не может быть пустым",
        "auth_limiter" => "Превышен лимит авторизаций.\nПопробуйте позднее",
        "php_old" => "Используйте версию PHP 5.6 и выше. "
    );
}
if (strnatcmp(phpversion(), '5.6') >= 0) {
    if (exists($login)) {
        if (exists($key) && !exists($type)) {
            if (rgxp_valid($login, 0) && rgxp_valid($key, 1)) {
                exists_ip();
                auth_limiter($ip);
                if (exists($pass)) {
                    auth($login);
                } else {
                    die(messages::$msg['pass_null']);
                }
            }
        }
        if (rgxp_valid($login, 2) && exists($type) && !exists($key)) {
            texture($login, $type, $size);
        }
    } else {
        die(messages::$msg['player_null']);
    }
} else {
    echo messages::$msg['php_old'];
    die("Ваша версия → " . phpversion());
}
function texture($login, $type, $size)
{
    $path = '';
    $ext = '.png';
    $type_num = 0;
    switch ($type) {
        case 'skin':
            $default = config::$settings['b64s'];
            $path = config::$settings['skin_path'];
            $type_num = 1;
            break;
        case 'cloak':
            $default = config::$settings['b64c'];
            $path = config::$settings['cloak_path'];
            $type_num = 2;
            break;
        case 'avatar':
            $default = config::$settings['b64a'];
            $path = config::$settings['avatar_path'];
            $type_num = 3;
            break;
        default:
            die(messages::$msg['invalid']);
            break;
    }
    if ($type_num == 3) {
        $thumb = $path . strtolower($login) . $ext;
        if (is_numeric($size) == FALSE || $size <= 0) {
            $size = 80;
        }
        list($w, $h) = getimagesize($thumb);
        if ((file_exists($thumb) && (filemtime($thumb) >= time() - 1 * config::$settings['avatar_cooldown'])) && $size == $w) {
            header("Content-type: image/png");
            echo file_get_contents($thumb);
        } else {
            $loadskin = ci_find_file(config::$settings['skin_path'] . $login . $ext);  // чтение файла скина
            if ($loadskin) {
                $newFile = $thumb;
                list($width, $height) = getimagesize($loadskin); // взятие оригинальных размеров картинки в пикселях
                $width = $width / 8; // 1/8 матрицы
                ini_set('gd.png_ignore_warning', 0); //отключение отладочной информации
                $canvas = imagecreatetruecolor($size, $size); // новое canvas поле
                $image = imagecreatefrompng($loadskin); // создание png из файла для дальнейшего взаимодействия с ним
                imagecopyresized($canvas, $image, 0, 0, $width, $width, $size, $size, $width, $width); // голова
                imagecopyresized($canvas, $image, 0, 0, $width * 5, $width, $size, $size, $width, $width); // второй слой
                imagecolortransparent($image, imagecolorat($image, 63, 0)); // получение индекса цвета пикселя и определение цвета как прозрачный
                imagepng($canvas, $newFile, 9); // сохранение по пути изображения, степень сжатия пакета zlib 9 - максимальный
            } else {
                default_texture($default);
            }
            header("Content-type: image/png");
            echo file_get_contents($thumb);
            remove_old_files(config::$settings['avatar_path'], config::$settings['avatar_cooldown']);
        }
    } else {
        $thumb = $path . $login . $ext;
        if (file_exists($thumb)) {
            header("Content-type: image/png");
            readfile($thumb);
        } else {
            default_texture($default);
        }
    }
}
function default_texture($default)
{
    header("Content-type: image/png");
    echo base64_decode($default);
}
function ci_find_file($filename)
{
    if (file_exists($filename))
        return $filename;
    $directoryName = dirname($filename);
    $fileArray = glob($directoryName . '/*', GLOB_NOSORT);
    $fileNameLowerCase = strtolower($filename);
    foreach ($fileArray as $file) {
        if (strtolower($file) == $fileNameLowerCase) {
            return $file;
        }
    }
    return false;
}
function auth_limiter($ip)
{
    global $ipA;
    if (!exists($ipA)) {
        return true;
    }
    rgxp_valid($ip, 3);
    $newName = config::$settings['auth_limiter_path'] . strtolower($ip) . '.txt';
    remove_old_files(config::$settings['auth_limiter_path'], config::$settings['auth_cooldown']);
    if (time() - filectime($newName) < 1 * config::$settings['auth_cooldown']) {
        file_put_contents($newName, '');
        die(messages::$msg['auth_limiter']);
    }
    file_put_contents($newName, '');
    return true;
}
function remove_old_files($path, $cooldown)
{
    foreach (glob($path . "*") as $file) {
        if (time() - filectime($file) > $cooldown) {
            unlink($file);
        }
    }
}
function rgxp_valid($var, $type)
{
    switch ($type) {
        case '0':
            if (preg_match("/^" . config::$settings['un_tpl'] . "/", $var, $varR) == 1 || filter_var($var, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                die(messages::$msg['rgx_err']);
            }
            break;
        case '1':
            if (preg_match("/^" . config::$settings['un_key'] . "/", $var, $varR) == 1) {
                if ($var == config::$settings['key_request']) {
                    return true;
                } else {
                    die(messages::$msg['need_key']);
                }
            } else {
                die(messages::$msg['rgx_err']);
            }
            break;
        case '2':
            if (preg_match("/^" . config::$settings['un_tpl'] . "/", $var, $varR) == 1) {
                return true;
            } else {
                die(messages::$msg['rgx_err']);
            }
            break;
        case '3':
            if (filter_var($var, FILTER_VALIDATE_IP)) {
                return true;
            } else {
                die(messages::$msg['rgx_err']);
            }
            break;
        default:
            die(messages::$msg['err']);
            break;
    }
}
function auth($login)
{
    switch (config::$settings['cms_type']) {
        case '0':
            config::initMainDB();
            if (exists(config::$table['dle_permission_column'])) {
                $perm = ",`" . config::$table['dle_permission_column'] . "`";
            }
            $tn = config::$table['dle_tn'];
            $cl_user = config::$table['dle_user'];
            $qr = config::$mainDB->query("SELECT `" . $cl_user . "`,`password`" . $perm . " FROM " . $tn . " WHERE (`email`=? OR `" . $cl_user . "`=?) LIMIT 1", "ss", $login, $login)->fetch_assoc();
            if (!isset($qr['password']) && !isset($qr[$cl_user])) {
                die(messages::$msg['player_not_found']);
            }
            $user = $qr[$cl_user];
            if (isset($qr[config::$table['dle_permission_column']])) {
                $permissions = $qr[config::$table['dle_permission_column']];
            } else {
                $permissions = 0;
            }
            pass_valid($user, $qr['password'], $permissions);
            break;
        case '1':
            config::initMainDB();
            if (exists(config::$table['wmcr_permission_column'])) {
                $perm = ",`" . config::$table['wmcr_permission_column'] . "`";
            }
            $tn = config::$table['wmcr_tn'];
            $cl_user = config::$table['wmcr_user'];
            $qr = config::$mainDB->query("SELECT `" . $cl_user . "`,`password`" . $perm . " FROM " . $tn . " WHERE (`email`=? OR `" . $cl_user . "`=?) LIMIT 1", "ss", $login, $login)->fetch_assoc();
            if (!isset($qr['password']) && !isset($qr[$cl_user])) {
                die(messages::$msg['player_not_found']);
            }
            $user = $qr[$cl_user];
            if (isset($qr[config::$table['wmcr_permission_column']])) {
                $permissions = $qr[config::$table['wmcr_permission_column']];
            } else {
                $permissions = 0;
            }
            pass_valid($user, $qr['password'], $permissions);
            break;
        case '2':
            config::initMainDB();
            if (exists(config::$table['xf_permission_column'])) {
                $perm = ",`" . config::$table['xf_permission_column'] . "`";
            }
            $qr = config::$mainDB->query("SELECT `user_id`,`username`" . $perm . " FROM xf_user WHERE (`email`=? OR `username`=?) LIMIT 1", "ss", $login, $login)->fetch_assoc();
            if (!isset($qr['username']) && !isset($qr['user_id'])) {
                die(messages::$msg['player_not_found']);
            }
            $user = $qr['username'];
            if (isset($qr[config::$table['xf_permission_column']])) {
                $permissions = $qr[config::$table['xf_permission_column']];
            } else {
                $permissions = 0;
            }
            $qr1 = config::$mainDB->query("SELECT `data` FROM xf_user_authenticate WHERE `user_id` = ? LIMIT 1", "s", $qr['user_id'])->fetch_assoc();
            if (!isset($qr1['data'])) {
                die(messages::$msg['pass_not_found']);
            }
            pass_valid($user, mb_strimwidth($qr1['data'], 22, 60), $permissions);
        default:
            die(messages::$msg['not_impl']);
            break;
    }
}
function pass_valid($user, $pass_check, $permissions)
{
    global $pass;
    $salt = '';
    list($pass_check, $salt) = explode(":", $pass_check);
    $passMS = md5($pass . $salt);
    $passDMS = md5(md5($pass . $salt));
    $passMDS = md5(md5($pass) . $salt);
    if (password_verify($pass, $pass_check) || $passMS == $pass_check || $passDMS == $pass_check || $passMDS == $pass_check) {
        echo 'OK:' . $user . ':' . $permissions;
        exit;
    } else {
        die(messages::$msg['incorrect_pass']);
    }
}
function exists($var)
{
    if (!empty($var) && isset($var)) return true;
    else return false;
}
function exists_ip()
{
    global $ipA;
    global $ip;
    if (exists($ipA)) {
        $ip = $ipA;
    } else {
        $ip = '127.0.0.1';
    }
    return true;
}
class db
{
    private $mysqli;
    private $last;
    public function __construct($srv = '', $number = 0, $isMain = false)
    {
        if ($isMain) {
            $config = config::$settings;
            $this->mysqli = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_db'], $config['db_port']);
        }
        if ($this->mysqli->connect_errno) {
            $this->debug("Connect error: " . $this->mysqli->connect_error);
        }
        $this->mysqli->set_charset("utf8");
    }
    public function __destruct()
    {
        $this->close();
    }
    public function close()
    {
        if (!is_null($this->mysqli)) {
            $this->mysqli->close();
        }
    }
    function refValues($arr)
    {
        $refs = array();
        foreach ($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }
    private function argsToString($args)
    {
        if (count($args) == 0)
            return "";
        $str = $args[0] . "";
        for ($i = 1; $i < count($args); ++$i) {
            $str .= ", " . $args[$i];
        }
        return $str;
    }
    public function query($sql, $form = "", ...$args)
    {
        $this->debug(" Executing query " . $sql . " with params: $form ->" . $this->argsToString($args));
        $stmt = $this->mysqli->prepare($sql);
        if ($this->mysqli->errno) {
            $this->debug('Statement preparing error[1]: ' . $this->mysqli->error . " ($sql)");
            exit();
        }
        array_unshift($args, $form);
        if ($form != "") {
            call_user_func_array(array($stmt, "bind_param"), $this->refValues($args));
        }
        $stmt->execute();
        if ($stmt->errno) {
            $this->debug("Statement execution error: " . $stmt->error . "($sql)");
            exit();
        }
        $this->last = $stmt->get_result();
        $stmt->close();
        return $this->last;
    }
    public function assoc()
    {
        if ($this->last === null) {
            return null;
        }
        return $this->last->fetch_assoc();
    }
    public function all()
    {
        if ($this->last === null) {
            return null;
        }
        return $this->last->fetch_all();
    }
    public function debug($message)
    {
        if (config::$settings['debug_mysql']) {
            file_put_contents("debug.log", date('d.m.Y H:i:s - ') . $message . "\n", FILE_APPEND);
        }
    }
}
