<?php

/**
 * @date    2017.02.16
 * @author  肚肚
 * @rate    简单，难易指数1/10
 * @req     在此题中，你需要将一串一维数组进行分类&排序
 *          比如：['COMP1234', 'ARTS1111', 'COMP0000', 'ABCD1234', 'ARTS0101'];
 *          进过处理后会变成一个二维数组：
 *          [
 *              'ABCD' => ['1234'],
 *              'ARTS' => ['0101', '1111'],
 *              'COMP' => ['0000', '1234]
 *          ]
 *          如果答案正确，页面将会显示“测试通过！”，否则将会显示错误的内容
 * @spec    $inputs为你要进行处理的数组
 *          $outputs为经过处理后的二维数组
 * @notes   严禁代码出现警告/错误提示！
 */

define('INPUTLEN', 100000); // 测试数据数量

// 生成随机测试数据
$inputs     = [];
$index      = [];
$range_pre  = ['COMP', 'MATH', 'ARTS'];
$range_rand = str_repeat(implode('', range('A', 'C')), 4);
for ($i = 0; $i < INPUTLEN; ++$i) {
    $pre = mt_rand(0, 1) === 0 ? substr(str_shuffle($range_rand), 0, 4) : $range_pre[array_rand($range_pre)];
    $num = str_pad(rand(0, 9999), 4, 0, STR_PAD_LEFT);
    $inputs[] = $pre . $num;
    $index[$pre][$num] = 1;
}


$stime   = microtime(TRUE);
$outputs = [];
// 你的代码放这


// 答案验证
$etime  = microtime(TRUE);
$debug  = '';
$keys_o = $keys_t = array_keys($outputs);
sort($keys_t);
if (json_encode($keys_o) !== json_encode($keys_t))
    $debug .= '键名顺序不对！' . PHP_EOL;
if (count(array_unique(array_map(function ($v) { return substr($v, 0, 4); }, $inputs))) !== count($keys_o))
    $debug .= '一维长度不正确！' . PHP_EOL;
if (count($inputs) !== array_reduce($outputs, function ($c, $v) { return $c + count($v); }, 0))
    $debug .= '二维长度不正确！' . PHP_EOL;
foreach ($outputs as $key => $output) {
    $output_t = $output;
    sort($output_t);
    if (json_encode($output) !== json_encode($output_t))
        $debug .= $key . '对应的键值顺序不对！' . PHP_EOL;
    if (!isset($index[$key]))
        $debug .= '不存在键值' . $key . '！' . PHP_EOL;
    else if (count(array_diff(array_keys($index[$key]), $output)) > 0)
        $debug .= $key . '的值有误！' . PHP_EOL;
}
$debug = $debug ?: '测试通过！';
$debug = '运行时间：' . ($etime - $stime) . PHP_EOL . $debug;
echo '<pre>';
echo $debug;
