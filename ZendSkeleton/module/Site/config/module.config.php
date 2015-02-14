<?php

$rota_frontEnd=array(
    'type'    => 'segment',
    'options' => array(
        'route'    => '/site',
        'defaults' => array(
            'controller' => 'Site\Controller\Site',// localizaçao do controlher
            'action'     => 'index',//action da rota
        ),
    ),
    'may_terminate' => true,
    'child_routes' => array(
       'proximaPagina' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/proximaPagina[/:pagina][/:cidade][/:bairro][/:subcategoria][/:transacao][/:valor]',
                'constraints' => array(
                    'pagina' => '[0-9]+',
                    'cidade' => '[0-9]+',
                    'bairro' => '[0-9]+',
                    'subcategoria' => '[0-9]+',
                    'transacao'=>'[0-9]+',
                    'valor' => '[0-9]+',
                ),
                'defaults' => array(
                  'action' => 'proximaPagina',
                ),
            ),
        ),
        'paginaAnterior' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/paginaAnterior[/:pagina][/:cidade][/:bairro][/:subcategoria][/:transacao][/:valor]',
                'constraints' => array(
                    'pagina' => '[0-9]+',
                    'cidade' => '[0-9]+',
                    'bairro' => '[0-9]+',
                    'subcategoria' => '[0-9]+',
                    'transacao'=>'[0-9]+',
                    'valor' => '[0-9]+',
                ),
                'defaults' => array(
                  'action' => 'paginaAnterior',
                ),
            ),
        ),
        'buscarAnuncio' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/buscarAnuncio[/:cidade][/:bairro][/:subcategoria][/:transacao][/:valor]',
                'constraints' => array(
                    'cidade' => '[0-9]+',
                    'bairro' => '[0-9]+',
                    'subcategoria' => '[0-9]+',
                    'transacao'=>'[0-9]+',
                    'valor' => '[0-9]+',
                ),
                'defaults' => array(
                    'action' => 'buscarAnuncio'
                ),
            ),
        ),
        'detalhar' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/detalhar[/:id]',
                'constraints' => array(
                    'id' => '[0-9]+',
                ),
                'defaults' => array(
                    'action' => 'detalhar'
                ),
            ),
        ),
    ),
);
            


return array(
    
    
    'router' => array(
        'routes' => array(
            'front_end' => $rota_frontEnd,
        ),
    ),
    
    
    'controllers' => array(
        'invokables' => array(
            'Site\Controller\Site' => 'Site\Controller\SiteController',            
        ),
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'site/site/detalhar' => __DIR__ . '/../view/site/detalhar.phtml',
            'site/site/index' => __DIR__ . '/../view/site/index.phtml',
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
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
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
    
    'navigation' => array(
    'default' => array(
        array(
            'label' => 'Home',
            'route' => 'home',
        ),
        array(
            'label' => 'Album',
            'route' => 'album',
            'pages' => array(
                array(
                    'label' => 'Add',
                    'route' => 'album',
                    'action' => 'add',
                ),
                array(
                    'label' => 'Edit',
                    'route' => 'album',
                    'action' => 'edit',
                ),
                array(
                    'label' => 'Delete',
                    'route' => 'album',
                    'action' => 'delete',
                ),
            ),
        ),
    ),
),
   
);