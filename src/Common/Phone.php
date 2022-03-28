<?php
namespace CubyBase\Common;

use Illuminate\Support\Traits\ForwardsCalls;
use CubyBase\Events\SystemNoticeEvent;

class Phone
{
    use ForwardsCalls;

    private $valid = false;
    private $country = '';
    private $zip;
    private $phone_no;
    private $input;
    private $config = [];

    function __construct(String $phone_no='')
    {
        $this->config = config('phone');

        if($phone_no) $this->create($phone_no);
        return $this;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this, $method, $parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic(string $method, array $parameters)
    {

        return (new static)->$method(...$parameters);
    }

    protected function create(String $phone_no): Phone
    {
        $this->input = $phone_no;
        return $this->parse();
    }

    /**
     * phone no: 85612345678
     * format: l
     *  => 12345678
     * format: +c-l
     *  => +856-12345678
     * format: c-4-4
     *  => 856-1234-5678
     * format: (z) +c-4-4
     *  => (zh-hk) +852-1234-5678
     *
     * @param String $format
     * @return String
     */
    public function format(String $format): String
    {
        $arr = str_split($format);
        $s = 0;
        $_phone_no = $this->phone_no . str_repeat(' ',20);
        $formatted = '';
        for($i=0;$i<count($arr);$i++){
            if($arr[$i]=='c'){
                $formatted .= $this->zip;
            }elseif($arr[$i]=='l'){
                $formatted .= $this->phone_no;
            }elseif(intval($arr[$i])>0){
                $formatted .= substr($_phone_no,$s,$arr[$i]);
                $s .= $arr[$i];
            }else{
                $formatted .= $arr[$i];
            }
        }
        return $formatted;
    }

    private function parse(): Phone
    {
        $this->country = '';
        $this->zip = '';
        $this->phone_no = '';
        $this->valid = false;

        // 只保留數字部分
        preg_match_all('/(\d+)/',$this->input,$matches);
        if(count($matches[0])==0)
        {
            // not a phone
            event(new SystemNoticeEvent('Phone','無效的電話號碼',sprintf('輸入的電話號碼不正確。輸入的電話號碼為 %s ',$this->input),''));
            return $this;
        }else{
            $this->valid(implode('',$matches[0]));
        }

        return $this;
    }

    protected function isValid(): bool
    {
        return $this->valid;
    }
    protected function getCountryCode(): String
    {
        return $this->country;
    }

    protected function valid(String $phone_no,String $country=''): bool
    {
        if($country==''){
            foreach($this->config as $k => $v){
                if($this->_valid($phone_no,$k)) return true;
            }
            switch(strlen($phone_no)){
                case 11:
                    $this->country = 'zh-cn';
                    $this->zip = '86';
                    $this->phone_no = $phone_no;
                    $this->valid = true;
                    return true;
                case 10:
                    if(substr($phone_no,0,2)!='09') return false;
                case 9:
                    $this->country = 'zh-tw';
                    $this->zip = '886';
                    $this->phone_no = $phone_no;
                    $this->valid = true;
                    return true;
            }
            event(new SystemNoticeEvent('Phone','無效的電話號碼',sprintf('無法辨認的電話號碼格式 %s',$this->input),''));
            return false;
        }else{
            // bad country code
            if(!array_key_exists($country,$this->config)){
                event(new SystemNoticeEvent('Phone','無效的國碼',sprintf('輸入的國碼 %s 不在config的名單中。請參照phone config檔。',$country),''));
                return false;
            }
            return $this->_valid($phone_no,$country);
        }
    }

    private function _valid(String $phone_no, String $country): bool
    {
        // invalid country code
        if(!str_starts_with($phone_no,$this->config[$country][0])){
            return false;
        }
        $_phone_no = substr($phone_no,strlen($this->config[$country][0]));
        // invalid phone number
        if(strlen($_phone_no) != $this->config[$country][1]){
            return false;
        }

        $this->country = $country;
        $this->zip = $this->config[$country][0];
        $this->phone_no = $_phone_no;
        $this->valid = true;
        return true;
    }
}
