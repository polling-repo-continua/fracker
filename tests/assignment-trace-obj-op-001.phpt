--TEST--
Test for tracing property assign ops [1]
--INI--
xdebug.default_enable=1
xdebug.profiler_enable=0
xdebug.auto_trace=0
xdebug.trace_format=0
xdebug.collect_vars=1
xdebug.collect_params=4
xdebug.collect_return=0
xdebug.collect_assignments=1
--FILE--
<?php
$tf = xdebug_start_trace(sys_get_temp_dir() . '/'. uniqid('xdt', TRUE));

$a = new stdClass;
$a->test = 0;
$a->test += 42;
$a->test -= 2;
$a->test *= 2;
$a->test /= 5;
$a->test %= 4;
$a->test <<= 1;
$a->test >>= 3;
$a->test |= 0xffff;
$a->test &= 0xff0f;
$a->test ^= 0xf00f;
$a->test **= 2;

xdebug_stop_trace();
echo file_get_contents($tf);
unlink($tf);
?>
--EXPECTF--
TRACE START [%d-%d-%d %d:%d:%d]
                           => $tf = '%s.xt' %sassignment-trace-obj-op-001.php:2
                           => $a = class stdClass {  } %sassignment-trace-obj-op-001.php:4
                           => $a->test = 0 %sassignment-trace-obj-op-001.php:5
                           => $a->test += 42 %sassignment-trace-obj-op-001.php:6
                           => $a->test -= 2 %sassignment-trace-obj-op-001.php:7
                           => $a->test *= 2 %sassignment-trace-obj-op-001.php:8
                           => $a->test /= 5 %sassignment-trace-obj-op-001.php:9
                           => $a->test %= 4 %sassignment-trace-obj-op-001.php:10
                           => $a->test <<= 1 %sassignment-trace-obj-op-001.php:11
                           => $a->test >>= 3 %sassignment-trace-obj-op-001.php:12
                           => $a->test |= 65535 %sassignment-trace-obj-op-001.php:13
                           => $a->test &= 65295 %sassignment-trace-obj-op-001.php:14
                           => $a->test ^= 61455 %sassignment-trace-obj-op-001.php:15
                           => $a->test **= 2 %sassignment-trace-obj-op-001.php:16
%w%f %w%d     -> xdebug_stop_trace() %sassignment-trace-obj-op-001.php:18
%w%f %w%d
TRACE END   [%d-%d-%d %d:%d:%d]
