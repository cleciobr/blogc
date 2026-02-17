<?php

namespace Php;

class PageAdmin extends Page {
    
        public function __construct($opts = array(), $tpl_dir = "/views/admin/") {
            parent::__construct($opts, $tpl_dir);
            
           

        }


    
    // public function __construct($opts = array(), $tpl_dir = "/views/admin/") {
    //     parent::__construct($opts, $tpl_dir);
    // }

        // private $showHeader = true;
        // private $showFooter = true;
        

        
        // public function __construct2($opts = array(), $tpl_dir = "/views/admin/") {
        //     parent::__construct($opts, $tpl_dir);
            
            
            

        // }

    
        // public function setTpl2($tpl_name, $data = array(), $returnHTML = false) {

        //     if (isset($opts['showHeader'])) {
        //         $this->showHeader = $opts['showHeader'];
        //     }
            
        //     if (isset($opts['showFooter'])) {
        //         $this->showFooter = $opts['showFooter'];
        //     }
        //     // Verifica se deve exibir o cabeçalho
        //     if ($this->showHeader) {
        //         $this->tpl->draw("headerfull");
        //     }
    
        //     // Desenha o conteúdo da página
        //     $this->tpl->draw($tpl_name, $data, $returnHTML);
    
        //     // Verifica se deve exibir o rodapé
        //     if ($this->showFooter) {
        //         $this->tpl->draw("footerfull");
        //     }
        // }
    }
    