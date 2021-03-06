<?php


namespace Qingtian\Pay;


use Exception\RefundException;
use Qingtian\Pay\Base;

/**
 * Class Refund
 * @package Pay
 * 退款类
 */
class Refund   extends Base
{
    protected $order_sn;

    protected $amount;

    protected $refund_order_sn;

    /**
     * @var \stdClass
     */
    protected $result;
    /**
     * Refund constructor.
     * @param string $order_sn 退款的订单号
     * @param $refund_order_sn string 退款的订单号
     * @param $amount int|float 退款金额
     */
    public function __construct(string $order_sn,string $refund_order_sn,float  $amount)
    {
        $this->api_url = "http://www.qingtianfu.com/order/refund";
        $this->order_sn = $order_sn;
        $this->amount = $amount;
        $this->refund_order_sn = $refund_order_sn;
    }

    /**
     * @throws RefundException
     * 执行退款操作
     */
    public function handle()
    {
        $this->postData = [
            'account' => $this->shop_no,
            'order_no' => $this->order_sn,//成功的订单号
            'pp_trade_no' => $this->refund_order_sn,//新生成的订单号
            'refund_fee' => $this->amount*100,
        ];
       $this->result = $this->makePostRequest();
       if ($this->result->resp_code!='0000'){
           throw new RefundException($this->result->resp_msg);
       }
    }

    /**
     * @return \stdClass
     */
    public function getResult():\stdClass
    {
        return $this->result;
    }
}
