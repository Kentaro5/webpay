<?php
	require_once ('webpay-php-full/autoload.php');
		use WebPay\WebPay;

	if ($_POST["pay"] == 1 || isset($_POST["pay"])) {

		$webpay = new WebPay('test_secret_52NdpxfNQ8qzdvVcx7dwdatx');
		try {
			$webpay->token->create(array(
				"card"=>
				array("number"=>"4242-4242-4242-4242",
				"exp_month"=>11,
				"exp_year"=>2017,
				"cvc"=>"123",
				"name"=>"KEI KUBO")
			));//
	    	// API リクエスト
			$webpay->charge->create(
				array(
					"amount"=>100,
					"currency"=>"jpy",
					"card"=>$_POST["webpay-token"],
					// "customer"=>"123",
					"shop"=>null,
					"description"=>"exanple@example.com",
					"expire_days"=>null,
					"uuid"=>null
					)
				);
		} catch (\WebPay\ErrorResponse\ErrorResponseException $e) {
			$error = $e->data->error;
			switch ($error->causedBy) {
				case 'buyer':
				die("buyer");
	            // カードエラーなど、購入者に原因がある
	            // エラーメッセージをそのまま表示するのがわかりやすい
				break;
				case 'insufficient':
				 // 実装ミスに起因する// リクエストで指定したパラメータが不正で、リクエストがおこなえなかった場合
    print("InvalidRequestException");
    print('Message is:' . $e->getMessage() . "\n");
    exit('Error');
				die("insufficient");
	            // 実装ミスに起因する
				break;
				case 'missing':
				die("missing");
	            // リクエスト対象のオブジェクトが存在しない
				break;
				case 'service':
				die("service");
	            // WebPayに起因するエラー
				break;
				default:
	            // 未知のエラー
	            die("FFFF");
				break;
			}
		} catch (\WebPay\ApiException $e) {
	    // APIからのレスポンスが受け取れない場合。接続エラーなど
			die("no response");
		} catch (\Exception $e) {
	    // WebPayとは関係ない例外の場合
			die("error");
		}
		echo "成功";
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://js.webpay.jp/v1/"></script>
</head>
<body>
	<form action="index.php" method="post" >

		<div class="form-group">
			<label for="product-title">金額 </label>
			<input type="text" name="amount" class="form-control">

		</div>

		<div class="form-group">
			<label for="product-title">カード番号</label>
			<input type="text" name="cardnumber" class="form-control">

		</div>

		<div class="form-group">
			<label for="product-title">顧客ID:</label>
			<input type="text" name="customer_id" class="form-control">

		</div>

		<div class="form-group">
			<label for="product-title">Email</label>
			<input type="text" name="customer_email" class="form-control">

		</div>


		<div class="form-group col-md-2">
			<input type="submit" name="add_user" class="btn btn-primary btn-lg" value="Add User">
			<input type="hidden" name="pay" value="1" class="form-control">
			<a href="#" onclick="create()" >送信</a>
		</div>
	</form>
	
	<script type="text/javascript">
	function create(){

			WebPay.setPublishableKey("test_public_51Hdkv6NM8DKf5z9tTe7YbVf");

			WebPay.createToken({

				number: "4242-4242-4242-4242",
				name: "KENGO HAMASAKI",
				cvc: "123",
				exp_month: "12",
				exp_year: "2018"
			}, webpayResponseHandler);

			var webpayResponseHandler = function(status, response) {
				console.log(status)
				console.log(response)

			};

	}
	</script>

</body>
</html>