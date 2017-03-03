<?php

/*
    PHP版本：PHP5.5及以上
    需求：将$a和$b合并成$c，范例如下：

    $arr1 = [
        ['id' => 1, 'name' => '甲'],
        ['id' => 3, 'name' => '乙']
        ['id' => 2, 'name' => '丙']
    ];
    $arr2 = [
        ['id' => 3, 'gender' => '男'],
        ['id' => 1, 'gender' => '女']
    ];
    $c = [
        ['id' => 1, 'name' => '甲', 'gender' => '女'],
        ['id' => 3, 'name' => '乙', 'gender' => '男'],
        ['id' => 2, 'name' => '丙', 'gender' => '默认']
    ];

    以下是已经写好的一个效率测试模板，你要做的就是把你写好的代码放入$i === 0里面
    这个模板在执行后第一行会显示你的算法的执行时间，第二行是你要挑战的算法的执行时间
    然后剩下的行将会验证答案是否正确（左边为你的答案，右边为正确答案）
*/


echo '<pre>';

// 生成随机测试数据
$oarr1 = $oarr2 = [];
for ($i = 0; $i < 29999; ++$i) {
    if (mt_rand(0, 1) === 0) {
        $oarr1[] = ['id' => $i, 'name' => '我'];
    }
    if (mt_rand(0, 1) === 0) {
        $oarr2[] = ['id' => $i, 'gender' => ['男', '女'][rand(0, 1)]];
    }
}
shuffle($oarr1);
shuffle($oarr2);


// 测速开始
$results = [];
for ($i = 0; $i < 2; ++$i) {
    $stime = microtime(TRUE);

    $arr1 = $oarr1;
    $arr2 = $oarr2;
    
    if ($i === 0) {
        // 你的算法放这，$arr1和$arr2为范例中的$a和$b，请直接修改$arr1作为$c
        
    } else {
        // 你要做的是写出比这个算法效率更高的算法
        $indexes = array_flip(array_intersect(array_column($arr2, 'id'), array_column($arr1, 'id')));
        foreach ($arr1 as $k => $v) {
            $arr1[$k]['gender'] = isset($indexes[$v['id']]) ? $arr2[$indexes[$v['id']]]['gender'] : '默认';
        }
    }

    // 显示执行时间
    echo ($i === 0 ? '你的算法：' : '挑战算法：') . (microtime(TRUE) - $stime) . PHP_EOL;
    $results[] = $arr1;
}

// 对比正确答案
$correct = $incorrect = 0;
$txt = '';
foreach ($results[0] as $k => $v) {
    if ($v['gender'] === $results[1][$k]['gender']) {
        ++$correct;
    } else {
        ++$inccorect;
    }
    $txt .= $v['id'] . "\t" . '=> ' . $v['gender'] . ' / ' . $results[1][$k]['gender'] . PHP_EOL;
}
echo '正确数量：' . $correct . PHP_EOL . '错误数量：' . $incorrect . PHP_EOL . PHP_EOL . '答案对比：' . PHP_EOL;
echo $txt;
