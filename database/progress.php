<?php
  
    include "progress_class.php";
    
    class chamaprogress extends progress
    {

            var $ws = "chamaprogress"; // Letra Minuscula por causa do progress
         
            function executarprogress($acao,$novaentrada)
            {
                  
                    $dadosConexao = defineConexaoProgress();
                    $progresscfg    = $dadosConexao['progresscfg'];
                    $dlc            = $dadosConexao['dlc'];
                    if ($dlc == null) {
                        $dlc        = "/usr/dlc/";
                    }
                    $tmp            = $dadosConexao['tmp'];
                    if ($tmp == null) {
                        $tmp        = "/ws/works/";
                    }
                    $proginicial    = $dadosConexao['proginicial'];
                    
                    if ($this->empresa == null) {
                        if ($dadosConexao['empresa'] == null) {
                            $dadosConexao['empresa'] = 1; // default
                        } 
                        $this->empresa = $dadosConexao['empresa'];
                    }
                    $pf             = $dadosConexao['pf'];
                    if ($pf == null) {
                        if (!$this->socket) {
                            echo "faltando configuracao pf";
                        }
                    }
                    $propath        = $dadosConexao['propath'];
                    
                    $this->dlc=$dlc;
                    $this->progresscfg=$progresscfg;
                    $this->pf=$pf;
                    $this->propath=$propath;
                    $this->tmp=$tmp;
                    //echo "progress.php empresa=".$this->empresa."\n";
                    $this->proginicial=$proginicial;
                    $this->entrada = $novaentrada;


                    $this->parametro = "TERM!ws!acao!entrada!tmp!empresa";

                    //  echo $propath;
                    $this->acao = $acao; // 09082022 helio -  para colocar como -param 

                    $this->parametros = "ansi!" . $this->ws . "!" . $acao . "!"  . $novaentrada . "!" . $tmp . "!" . $this->empresa . "!" ;
                    
                    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                        $this->executa();
                    } else {
                        if ($this->socket) {
                                $this->socket();
                                if ($this->progress == "ERRO" || $this->progress == "") {
                                    $this->executa ();
                                }
                        } else {     
                            $this->executa ();
                        }
                    }
                    $this->progress = iconv('ISO-8859-1','UTF-8',$this->progress);
                    return $this->progress;

            }

    }
    
    
?>
