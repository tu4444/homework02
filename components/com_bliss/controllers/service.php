<?php
use Aws\Sqs\SqsClient;

require_once JPATH_ADMINISTRATOR . '/components/com_bliss/vendor/autoload.php';

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/6/12
 * Time: 下午 02:42
 */

class BlissControllerService extends JControllerLegacy{

	public function donation(){
		$http = JHttpFactory::getHttp();
		$params = JComponentHelper::getParams('com_bliss');

		$url = $params->get('Aic.Endpoint');
		$key = $params->get('Aic.HashKey');
		$iv = $params->get('Aic.HashIV');

		$data = [
			'check_value' => '',
			'version' => '1.0',
			'payment_id' => time(),
			'pay_date' => JFactory::getDate()->toSql(),
			'payer_id' => 'A123456789',
			'payer_name' => 'ABC',
			'payer_email' => 'foo@foo.com',
			'payer_contact_phone' => '21234567',
			'total_amount' => 1200,
			'receipt_type_code' => 'Y',
			'address_type_code' => 'LEGACY',
			'zip_code' => 105,
			'zone1' => '台北市',
			'zone2' => '松山區',
			'mail_legacy' => '南京東路１段3號8樓',
			'mail_others' => '',
			'donator_type_code' => '1',
			'recipient_name' => 'ABC',
			'send_time' => JFactory::getDate()->toSql(),
			'detail_data' => [
				[
					'dona_use_name' => '慈心',
					'donator_name' => 'ABC',
					'receipt_amount' => 1200,
					'is_publicly' => 'Y',
					'will_to_upload_nta' => 'Y',
					'donator_id' => ''
				]
			]
		];
		//		$json = json_decode($json, true);
		$c = [
			'version'    => $data['version'],
			'payment_id' => $data['payment_id'],
			'pay_date'   => $data['pay_date'],
			'payer_id'   => $data['payer_id'],
			'total_amount' => $data['total_amount'],
			'send_time'  => $data['send_time']
		];
		ksort($c);
		$c = http_build_query($c);
		$c = urldecode($c);
		$c = "hashkey=$key&$c&hashiv=$iv";
		$c = strtoupper(hash('sha256', $c));
		$data['check_value'] = $c;

		try{
			$response = $http->post($url, json_encode($data),[
				'Content-Type' => 'application/json'
			]);

			//if($response-> code >= 200){ //嚴謹寫法

			if($response-> code !== 200){
				//儲存發生錯誤的data

				throw new \RuntimeException('HTTP fail:'. $response->code, $response->code);

				//redirect
			}

		}catch(\Exception $e){
			//儲存發生錯誤的data

		}

		print_r(json_decode($response->body));

		die;
	}

	public function push(){
		$client = $this->getSqsClient();

		$data = [
			'task' => 'send.donation.info',
			'callback' => ['Class','method'],
			'order_id' => 123,
			'order' =>[]
		];

		//$payload = json_encode($data);

		$id = $client->sendMessage([
			'QueueUrl' => $this->getQueueUrl($client),
			'MessageBody' => json_encode($data)
		])->get('MessageId');

		echo $id;
	}

	public function pop(){
		$client = $this->getSqsClient();

		$result = $client->receiveMessage([
			'QueueUrl' => $this->getQueueUrl($client),
			'AttributeNames' => ['ApproximateReceiveCount']
		]);

		if(!$result['Messages']){
			echo 'no new msg';
			die;
			//return;
		}

		$message = $result['Messages'][0];

		$body = json_decode($message['Body'],true);

		//確認次數
		$retryTimes = $message['Attributes']['ApproximateReceiveCount'];



		try{

			if($retryTimes >= 5){
				//delete message
				$client->deleteMessage([
					'QueueUrl' => $this->getQueueUrl($client),
					'ReceiptHandle' => $message['ReceiptHandle']
				]);

				echo 'failed';
				die;

			}

			switch($body['task']){
				case 'send.donation.info';
					//$this->donation();

					//@ Do success
					throw new \RuntimeException('Failed');
					break;

				//more task
			}

			//@ Delete message
			$client->deleteMessage([
				'QueueUrl' => $this->getQueueUrl($client),
				'ReceiptHandle' => $message['ReceiptHandle']
			]);

			echo 'success';
			die;

		}catch(\Exception $e){
			//確認次數
			$retryTimes = $message['Attributes']['ApproximateReceiveCount'];

			if($retryTimes+1 >= 5){
				//delete message
				$client->deleteMessage([
					'QueueUrl' => $this->getQueueUrl($client),
					'ReceiptHandle' => $message['ReceiptHandle']
				]);

				echo 'max count';
				die;

			}


			//@ Release message back
			$client->changeMessageVisibility([
				'QueueUrl' => $this->getQueueUrl($client),
				'ReceiptHandle' => $message['ReceiptHandle'],
				'VisibilityTimeout' => 1
			]);

			echo 'failed. retry times:'. $message['Attributes']['ApproximateReceiveCount'];
			die;
		}


		print_r($message);

		die;
	}

	public function getQueueUrl($client)
	{
		return $client->getQueueUrl(['QueueName' => 'bliss'])->get('QueueUrl');
	}

	public function getSqsClient(){
		return new SqsClient(array(
			'region'      => 'us-west-2',
			'version'     => 'latest',
			'credentials' => [
				'key' => 'AKIAJUFZWA3AIOD7XJ5Q',
				'secret'  => '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'
			]
		));
	}
}