<?php
/**
 * CLI Printing / Output Utilities
 */

namespace Dolphin;

class CliPrint
{
    static $FG_BLACK = '0;30';
    static $FG_WHITE = '1;37';
    static $FG_RED = '0;31';
    static $FG_GREEN = '0;32';
    static $FG_BLUE = '1;34';
    static $FG_CYAN = '0;36';

    static $BG_BLACK = '40';
    static $BG_RED = '45';
    static $BG_GREEN = '42';
    static $BG_BLUE = '44';
    static $BG_CYAN = '46';
    static $BG_WHITE = '47';

    protected $palettes;

    public function __construct()
    {
        $this->palettes = [
            'default' => [ self::$FG_BLACK, ''],
            'error'   => [ self::$FG_WHITE, self::$BG_RED],
            'success' => [ self::$FG_WHITE, self::$BG_BLACK],
            'info'    => [ self::$FG_CYAN],
            'info_alt'    => [ self::$FG_WHITE, self::$BG_CYAN],
        ];
    }

    public function format($message, $style = "default")
    {
        $style_colors = $this->getPalette($style);

        $bg = '';
        if (isset($style_colors[1])) {
            $bg = ';' . $style_colors[1];
        }

        $output = sprintf("\e[%s%sm%s\e[0m\n", $style_colors[0], $bg, $message);

        return $output;
    }

    public function getPalette($style)
    {
        return isset($this->palettes[$style]) ? $this->palettes[$style] : "default";
    }

    public function out($message, $style = "info")
    {
        echo $this->format($message, $style);
    }

    public function printBanner()
    {
        $header = '
         ,gggggggggggg,                                                                    
        dP"""88""""""Y8b,               ,dPYb,             ,dPYb,                        
        Yb,  88       `8b,              IP\'`Yb             IP\'`Yb                        
         `"  88        `8b              I8  8I             I8  8I      gg                
             88         Y8              I8  8\'             I8  8\'      ""                
             88         d8   ,ggggg,    I8 dP  gg,gggg,    I8 dPgg,    gg    ,ggg,,ggg,  
             88        ,8P  dP"  "Y8ggg I8dP   I8P"  "Yb   I8dP" "8I   88   ,8" "8P" "8, 
             88       ,8P\' i8\'    ,8I   I8P    I8\'    ,8i  I8P    I8   88   I8   8I   8I 
             88______,dP\' ,d8,   ,d8\'  ,d8b,_ ,I8 _  ,d8\' ,d8     I8,_,88,_,dP   8I   Yb,
            888888888P"   P"Y8888P"    8P\'"Y88PI8 YY88888P88P     `Y88P""Y88P\'   8I   `Y8
                                               I8                                        
                                               I8                                        
                                               I8                                        
                                               I8                                        
                                               I8                                        
                                               I8                                        
        ';

        $this->out($header, "info");
    }
}