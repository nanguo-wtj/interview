<?php

namespace constant\verification;

class Verification
{

    /**
     *      验证数据
     *      验证数组类型：[['value'=>校验值属性,'error'  => 校验属性加附注（附注一般为大小，或者后期加）,'code'=>[0=》’检验属性提示‘，1=》’附注的提示‘]]]
     *      @author：wtj
     *      @time：2022-03-21
     */

    /* 检验值 */
    public $Validation_value    =   [];
    /* 错误提示 */
    public $Check_value         =   [];
    /* 校验属性 */
    public $Check_tybe          =   '';
    /* 校验属性附注 */
    public $Check_tybe_key      =   '';

    /* 校验 */
    public function verification(){
        switch ($this->Check_tybe){
            case 'number':
                if(!is_numeric($this->Validation_value)){

                    throw new \Exception($this->Check_value[0]);
                }
                if(!empty($this->Check_tybe_key)){
                    $cloun  =   mb_strlen($this->Validation_value,'UTF8');
                    if($cloun > $this->Check_tybe_key||$cloun < 0){
                        throw new \Exception($this->Check_value[1]);
                    }
                }
                break;
            case 'require':
                if(empty(trim($this->Validation_value))){
                    if(is_array($this->Check_value)){
                        throw new \Exception($this->Check_value[0]);
                    }else{
                        throw new \Exception($this->Check_value);
                    }
                }
                break;
            case 'array':
                if(!is_array($this->Validation_value)){
                    if(is_array($this->Check_value)){
                        throw new \Exception($this->Check_value[0]);
                    }else{
                        throw new \Exception($this->Check_value);
                    }
                }
                break;


        }
    }

}
