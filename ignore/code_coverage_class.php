<?php

class code_coverage
{
    private $analysis_file;
    private $reports_dir;

    function __construct($analysis_file , $reports_dir)
    {
        $this->reports_dir      = $reports_dir;
        $this->analysis_file    = $analysis_file;
    }

    public function code_coverage_reports()
    {
        require_once $this->analysis_file;

        $counter=0;
        foreach($code_coverage_analysis as $file_name=>$lines_executed)
        {
            $file_name_array=explode ('\\',$file_name);
            $file_name_html = $file_name_array[(count($file_name_array)-1)];

            if($counter != 0)
            {
                $html = "
                    <html>
                    <head>
                        <title>
                            Xdebug Code Coverage Reports
                        </title>
                    </head>
                    <body>
                    <table border='1'>
                        <tr>
                            <td>Line nr</td>
                            <td>PHP Code</td>
                        </tr>
                ";
                $source_code = file($file_name);
                foreach($source_code as $lines=>$source)
                {
                    if(isset($lines_executed[($lines+1)]))
                    {
                        $html.= '
                        <tr BGCOLOR = "grey">
                            <td>'.($lines+1).'</td>
                            <td>'.$source.'</td>
                        </tr>
                        ';
                    }
                    else
                    {
                        $html.= '
                        <tr>
                            <td>'.($lines+1).'</td>
                            <td>'.$source.'</td>
                        </tr>
                        ';
                    }
                }
                $html.= "
                    </body>
                    </html>
                ";
                file_put_contents($this->reports_dir.$file_name_html.".html",$html);
            }
            $counter++;
        }
    }    
    public function code_coverage_analysis_save()
    {
        file_put_contents($this->analysis_file,"<?php \$code_coverage_analysis = ".var_export(xdebug_get_code_coverage(),TRUE)." ?>");
        xdebug_stop_code_coverage(true);
    }
}
?>