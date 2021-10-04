<?php
namespace CubyBase\SMS;

use Illuminate\Http\Request;

Interface SMSInterface
{
    // 發送簡訊。要設定短訊語言，輸入的內容依會驗證內容長度。
    // public function send(Mixin $message): array;
    // 與簡訊主機通訊
    public function queryServer(String $url_name);
    // 解析回傳結果，若是錯誤訊息做相應的通知
    public function parseReturn(String $response);
    // 接收傳送報告
    public function callback(Request $request, $param_names);
}
