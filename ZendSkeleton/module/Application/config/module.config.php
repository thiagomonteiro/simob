<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

$rota_login=array(
    'type'    => 'segment',
    'options' => array(
        'route'    => '/admin/login[:action]',
        'constraints' => array(
            'action' => '[a-zA-Z0-9_-]+',//valores de possiveis parametros

        ),
        'defaults' => array(
            'controller' => 'Application\Controller\Admin',// localizaçao do controlher
            'action'     => 'login',//action da rota
        ),
    ),
);

$rota_adm_home = array(
    'type' => 'Zend\Mvc\Router\Http\Literal',
    'options' => array(
        'route'    => '/admin/index',
        'defaults' => array(
            'controller' => 'Application\Controller\Admin',
            'action'     => 'index',
        ),
    ),
); 


$rota_home = array(
    'type' => 'Zend\Mvc\Router\Http\Literal',
    'options' => array(
        'route'    => '/',
        'defaults' => array(
            'controller' => 'Application\Controller\Index',
            'action'     => 'index',
        ),
    ),
); 



$rota_bairro = array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/bairro',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Bairro',                        
                    ),
                ),
    
    'may_terminate' => true,
    'child_routes' => array(
        'criarBairro' => array(
            'type' => 'segment',
            'options' => array(
                    'route' => '/criarBairro',
                    'defaults' => array(
                        'action' => 'criarBairro',
                    ),
                ),
            ),   
        'deletarBairro' => array(
            'type' => 'segment',
            'options' => array(
                    'route' => '/deletarBairro[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'action' => 'deletarBairro',
                    ),
                ),
            ),  
        'alterarBairro' => array(
            'type' => 'segment',
            'options' => array(
                    'route' => '/alterarBairro',
                    'defaults' => array(
                        'action' => 'alterarBairro',
                    ),
                ),
            ), 
        'salvarAlteracoes' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/salvarAlteracoes',
                'defaults' => array(
                    'action' => 'salvarAlteracoes',
                ),
            ),
        ),
        'gerenciarBairro' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/gerenciarBairro[/:filtro][/:param]',
                'constraints' => array(
                    'filtro'  => '[a-zA-Z]*',
                    'param'   => '[a-zA-Z0-9_-]+',
                ),
                'defaults' => array(
                  'action' => 'gerenciarBairro',
                ),
            ),
        ),
        'proximaPagina' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/proximaPagina[/:pagina][/:filtro][/:param]',
                'constraints' => array(
                    'pagina' => '[0-9]+',
                    'filtro' => '[a-zA-Z]*',
                    'param' => '[0-9]+'
                ),
                'defaults' => array(
                  'action' => 'proximaPagina',
                ),
            ),
        ),
        'paginaAnterior' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/paginaAnterior[/:pagina][/:filtro][/:param]',
                'constraints' => array(
                    'pagina' => '[0-9]+',
                    'filtro' => '[a-zA-Z]*',
                    'param' => '[0-9]+'
                ),
                'defaults' => array(
                  'action' => 'paginaAnterior',
                ),
            ),
        ),
        'buscaBairro' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/buscaBairro',
                'defaults' => array(
                  'action' => 'buscaBairro',
                ),
            ),
        ),
    ),
    
); 

$rota_comodo = array(
    'type' => 'Zend\Mvc\Router\Http\Literal',
    'options' => array(
        'route'    => '/comodo',
        'defaults' => array(
            'controller' => 'Application\Controller\Comodo',
        ),
    ),
    'may_terminate' => true,
    'child_routes' => array(
        'index' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/index',
                'defaults' => array(
                    'action' => 'index',
                ),
            ),
        ),
        'proximaPagina' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/proximaPagina[/:pagina][/:filtro][/:param]',
                'constraints' => array(
                    'pagina' => '[0-9]+',
                    'filtro' => '[a-zA-Z]*',
                    'param' => '[0-9]+'
                ),
                'defaults' => array(
                  'action' => 'proximaPagina',
                ),
            ),
        ),
        'paginaAnterior' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/paginaAnterior[/:pagina][/:filtro][/:param]',
                'constraints' => array(
                    'pagina' => '[0-9]+',
                    'filtro' => '[a-zA-Z]*',
                    'param' => '[0-9]+'
                ),
                'defaults' => array(
                  'action' => 'paginaAnterior',
                ),
            ),
        ),
        'buscarComodo' => array(
            'type' => 'segment',
            'options' => array(
                'route' => '/buscarComodo',
                'defaults' => array(
                    'action' => 'buscarComodo',
                ),
            ),
        ),
    ),
    
); 

$rota_get_cidade = array(
                'type' => 'Zend\Mvc\Router\Http\Segment',  //usar quando for uma requisição que necessite de parametros dinamicos
                'options' => array(
                    'route'    => '/bairro/getCidades[/:uf]',
                    'constraints' => array(
                        'uf'     => '[A-Z]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Bairro',
                        'action'     => 'getCidades',
                    ),
                ),
            ); 

$rota_get_estado = array(
                'type' => 'Zend\Mvc\Router\Http\Segment',  //usar quando for uma requisição que necessite de parametros dinamicos
                'options' => array(
                    'route'    => '/bairro/getEstados',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Bairro',
                        'action'     => 'getEstados',
                    ),
                ),
            ); 






return array(
    'router' => array(
        'routes' => array(
            'login_admin' => $rota_login,
            'home_admin'    =>  $rota_adm_home,
            'home'  => $rota_home,
            'crud_bairro'  => $rota_bairro,
            'crud_comodo' => $rota_comodo,
            'get_cidades' =>    $rota_get_cidade,
            'get_estados' =>    $rota_get_estado,
        ),
            
  
        




// The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
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
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Admin' => 'Application\Controller\AdminController',
            'Application\Controller\Imovel' =>  'Application\Controller\ImovelController',
            'Application\Controller\Bairro' =>  'Application\Controller\BairroController',
            'Application\Controller\Comodo' => 'Application\Controller\ComodoController',
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
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'application/admin/login' => __DIR__ . '/../view/application/admin/login.phtml',
            'application/admin/index' => __DIR__ . '/../view/application/admin/index.phtml',
            'application/bairro/gerenciarBairro' =>    __DIR__ . '/../view/application/bairro/gerenciar-bairro.phtml',
            'application/bairro/criarBairro' =>    __DIR__ . '/../view/application/bairro/criar-bairro.phtml',
            'application/comodo/index' => __DIR__.'/../view/application/comodo/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
