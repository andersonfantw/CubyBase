<?php
namespace CubyBase\SMS;

use Cuby\Meteorsis\Events\MeteorsisCallbackEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CubyBase\SMS\SMSInterface;
use CubyBase\Events\SystemWarningEvent;

/**
 * 處理簡訊的邏輯層
 */
abstract class SMSAbstract implements SMSInterface
{
    protected $valid_messages;
    protected $param_def_table;
    protected $base_param_table = [];

    abstract public function queryServer(String $url_name);
    abstract public function parseReturn(String $response);

    /**
     * 接收sms傳送報告
     * @param Request $request
     * @param $param_names
     */
    public function callback(Request $request, $param_names){
        $inputs = $this->validator_inputs($request->all(), $param_names);
        if(!$inputs){
            // 缺少必要參數
            event(new SystemWarningEvent(
                'SMSAbstract',
                'SMSAbstract 接收傳送報告時，缺少必要參數',
                '[SMSAbstract] 接收傳送報告時，缺少必要參數',
                json_encode([
                    'request' => $request->all(),
                    'required' => $param_names
                ])
            ));
        }
        $v = Validator::make(
            $inputs,
            $this->validator_rules($param_names),
            $this->valid_messages
        );

        if ($v->fails()){
            event(new SystemWarningEvent(
                'SMSAbstract',
                'SMSAbstract 驗證接收傳送報告的參數時驗證不通過',
                '[SMSAbstract] 驗證接收傳送報告的參數時驗證不通過',
                json_encode([
                    'request' => $request->all(),
                    'message' => $v->messages()
                ])
            ));
        }else{
            event(new MeteorsisCallbackEvent('SMSAbstract', $request));
        }
    }

    protected function validator_inputs($inputs, $param_names)
    {
        $arr = array_filter($inputs, function($v ,$k) use ($param_names){
            return in_array($k,$param_names);
        }, ARRAY_FILTER_USE_BOTH);
        if(count($arr)==count($param_names)) return $arr;
        return false;
    }

    protected function validator_rules($param_names)
    {
        return array_filter($this->param_def_table, function($v ,$k) use ($param_names){
            return (in_array($k,$param_names)!==false);
        },ARRAY_FILTER_USE_BOTH);
    }
}
