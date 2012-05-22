<?php
    require_once './code_coverage_class.php';

    xdebug_start_code_coverage();

    function a($a)
    {
         $a * 2.5;
    }

    function b($count)
    {
        for ($i = 0; $i < $count; $i++)
        {
            a($i + 0.17);
        }
    }

    b(6);
    b(10);

    $code_coverage = new code_coverage('temp.var','reports/');
    $code_coverage->code_coverage_analysis_save();
    $code_coverage->code_coverage_reports();

?>