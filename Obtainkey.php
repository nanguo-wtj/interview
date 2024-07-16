<?php
namespace operation\obtain;
use constant\verification\Verification;
use think\facade\Request;
class Obtainkey
{
    /**
     *      将获取的post跟get值转换成数组形式
     *      @author：wtj
     *      @time：2022-03-17
     */

    /* 要接受的数组  */
    private $receive    =   array();
    /* 获取的数据 */
    private $request    =   '';

    public function receive($receive=array()){
        $this->receive = $receive;
    }

    /* post方式 */
    public function Post_Obtain(){
        if($this->request){
            $this->request  =   array_merge($this->request,Request::post());
        }else{
            $this->request = Request::post();
        }
    }
    /* get方式 */
    public function Get_Obtain(){
        if($this->request){
            $this->request  =   array_merge($this->request,Request::get());
        }else{
            $this->request = Request::get();
        }
    }
    /* 验证
     ['value'=>'money','error'  => 'number:1','code'=>[*****,*****]],案例
     ['value'=>'money','error'  => 'require','code'=>[*****]],案例
     */
    public function verification($code=array()){
        $Verification   =   new Verification();
        foreach ($code as $va){

                $Verification->Validation_value = $this->request[$va['value']];
                $Verification->Check_value = $va['code'];
                $key = explode(':', $va['error']);
                $Verification->Check_tybe = $key[0];
                $Verification->Check_tybe_key = $key[1];
                $Verification->verification();

        }
    }
    /* 验证
         ['value'=>'money','error'  => 'number:1|require','code'=>[array(*****,******),array(*****)]],案例
     */
    public function VerificationNew($code=array()){
        $Verification   =   new Verification();
        foreach ($code as $va){
            $error  =   explode('|', $va['error']);
            foreach ($error as $index=>$item){
                $Verification->Validation_value = $this->request[$va['value']];
                $Verification->Check_value = $va['code'][$index];
                $key = explode(':', $item);
                $Verification->Check_tybe = $key[0];
                $Verification->Check_tybe_key = $key[1];
                $Verification->verification();
            }
        }
    }


    /* 获取数据 */
    public function Obtain(){
        $array      =   $this->receive;
        $request    =   $this->request;
        $number     =   count($array);
        $str=array();
        for ($i=0;$i<$number;$i++){
            if($array[$i][2]!=true){
                if($request[$array[$i][0]]){
                    $str[]=$this->strFilter($request[$array[$i][0]]);

                }else{
                    $str[]=$array[$i][1];
                }
            }else{
                $str[]=$array[$i][1];
            }
        }
        return $str;
    }
    /* 过滤一些信息 */
    private function strFilter($str){
        if(is_array($str)){
            return  $str;
        }
        $str = str_replace('__style__','/style',$str);
        return trim($str);
    }


}
