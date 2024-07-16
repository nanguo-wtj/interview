<?php
class getExample{
    public function getPrimeNumber(int $number):array
    {
        // 检查n是否小于2，因为质数是大于1的自然数
        if ($number < 2) {
            return [];
        }
        $in_number = [];
        // 遍历从2到n-1的所有数字
        for ($i = 2; $i < $number; $i++) {
            // 假设当前数字是质数
            $isPrime = true;
            // 检查从2到sqrt(i)的所有数是否能整除i
            // 如果能，则i不是质数
            for ($j = 2; $j * $j <= $i; $j++) {
                if ($i % $j == 0) {
                    $isPrime = false;
                    break;
                }
            }
            // 如果i是质数，则打印它
            if ($isPrime) {
                $in_number[]    =   $i;
            }
        }
        return $in_number;
    }

    public function getUrlContent(string $url):array{
        if(empty($url)){
            return [];
        }

        $data = file_get_contents($url);


        $in_list = $this->getContent($data);
        $list   =   $this->getListCode($data,"/<ul class=\"chunklist chunklist_set\">(.*)<\/ul>/");

        $i = 0;
        foreach ($list as $index=>$item){
            if(in_array($item['title'],$in_list)){
                unset($list[$index]);
                $list[$i]['list'][] =   $item;
            }else{
                $i  =   $index;
            }
        }


        return  $list;

    }

    private function getListCode(string $data,string $type):array{
        preg_match($type, $data, $matches);
        return  $this->getList($matches[1]);
    }
    private function getList(string $data):array{
        preg_match_all('/<li><a href="(.*?)">(.*?)<\/a>(.*?)</', $data, $matches);
        $url = $matches[1];
        $content = $matches[2];
        $name_fu = $matches[3];
        $list   =   [];
        foreach ($content as $index=>$item){
            $list[]     =   [
                'title' =>  $item.$name_fu[$index],
                'url'   =>  'https://www.php.net/manual/zh/'.$url[$index],
            ];
        }
        return  $list;
    }

    private function getContent(string $data):array{

        preg_match_all('/<ul class="chunklist chunklist_set chunklist_children">(.*?)<\/ul>/', $data, $content);
        $list = [];

        foreach ($content[1] as $item){
            preg_match_all('/<li><a href=".*?">(.*?)<\/a>(.*?)</', $item, $matches);
            $code = [];
            foreach ($matches[1] as $a=>$b){
                $code[] =  $b.$matches[2][$a];
            }

            $list   =   array_merge($list,$code);
        }
        return $list;
    }
}

$Example    =   new getExample();
//取质数
print_r($Example->getPrimeNumber(10));
//获取网页数据
$list = $Example->getUrlContent('https://www.php.net/manual/zh/');
$file_name = '1.txt';
file_put_contents($file_name,'');
foreach ($list as $index=>$item){
    file_put_contents($file_name,'- ['.$item['title'].']('.$item['url'].')'."\n",FILE_APPEND );
    if(is_array($item['list'])){
        foreach ($item['list'] as $a=>$b){
            file_put_contents($file_name,'   - ['.$b['title'].']('.$b['url'].')'."\n",FILE_APPEND );
        }
    }
}
//简单介绍
//实现了 提交验证
$Submission =   new Obtainkey();
$Submission->Post_Obtain();
$Submission->receive([
    ['username','',false],
    ['password','',false]
]);
$Submission->verification([
    ['value'=>'username','error'  => 'require','code'=>[code::PLEASE_FILL_IN_THE_USER_NAME]],
    ['value'=>'username','error'  => 'number:11','code'=>[code::MUST_BE_A_NUMBERS,code::NO_MORE_THAN_11_NUMBERS]],
    ['value'=>'password','error'  => 'require','code'=>[code::PLEASE_FILL_IN_THE_PASSWORD]],
]);
list($this->username,$this->password)   =   $Submission->Obtain();

//经常游览网站
//https://www.csdn.net/  csdn 有些内容还是可以的
//https://www.runoob.com/?frm=msidevs.net&tg=%CB%F7oE   //里面有些基础东西还行  函数，魔术方法基本都有介绍
//https://github.com/    // 开源项目或者有些组件里面有 看的话就很少了 ，基本找到用的在看看
//https://www.bilibili.com   //  有些基础教程在这上面看的 其他语言什么的，还有一些其他学习的网站

//最近学习 go语言中  还有mysql的优化建议的