<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Base\Paginador;

class Paginador{
    public function paginarDados(array &$dataset, $inicio_pagina_atual = 0, $por_pagina = 5) {
        $paginacao = array (
            'ha_proxima' => false,
            'ha_anterior' => false,
            'proxima_pagina' => null,
            'pagina_anterior' => null
        );
        if (count($dataset) == $por_pagina + 1) {
            $paginacao['ha_proxima'] = true;
            $paginacao['proxima_pagina'] = $inicio_pagina_atual + $por_pagina;
            unset($dataset[$por_pagina]);
        }
        if($inicio_pagina_atual != 0){
            $paginacao['ha_anterior'] = true;
            $paginacao['pagina_anterior']= $inicio_pagina_atual - 1;
        }
        return $paginacao;
    } 
}

 