<?php

$rota_paginacao=array(
    'type'    => 'segment',
    'options' => array(
        'route'    => '/teste/index[:action]',
        'constraints' => array(
            'action' => '[a-zA-Z0-9_-]+',//valores de possiveis parametros

        ),
        'defaults' => array(
            'controller' => 'Teste\Controller\Teste',// localizaçao do controlher
            'action'     => 'index',//action da rota
        ),
    ),
);
            


return array(
    
    
    'router' => array(
        'routes' => array(
            'paginacao' => $rota_paginacao,
        ),
    ),
    
    
    'controllers' => array(
        'invokables' => array(
            'Teste\Controller\Index' => 'Teste\Controller\TesteController',            
        ),
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/teste/layout/layout.phtml',
            'teste/teste/index' => __DIR__ . '/../view/teste/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    
    
          
);