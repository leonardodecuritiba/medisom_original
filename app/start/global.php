<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

    app_path() . '/commands',
    app_path() . '/controllers',
    app_path() . '/models',
    app_path() . '/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path() . '/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function (Exception $exception, $code) {
    Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function () {
    return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/


HTML::macro('alert', function () {

    $cod = Session::get('alert-code');
    $btn = Session::get('alert-btn');


    $cods = array(
        'P001S' => '<h4 class="semibold">Sucesso!</h4> post atualizado.',
        'P001D' => '<h4 class="semibold">Erro!</h4> não foi possível atualizar o post.',

        'P002S' => '<h4 class="semibold">Sucesso!</h4> post inserido.',
        'P002D' => '<h4 class="semibold">Erro!</h4> não foi possível inserir o post.',

        'P003S' => '<h4 class="semibold">Sucesso!</h4> post excluído.',
        'P003D' => '<h4 class="semibold">Erro!</h4> não foi possível excluir o post.',

        'PA001S' => '<h4 class="semibold">Sucesso!</h4> página salva.',
        'PA001D' => '<h4 class="semibold">Erro!</h4> não foi possível salvar a página.',

        'C001S' => '<h4 class="semibold">Sucesso!</h4> categoria atualizada.',
        'C001D' => '<h4 class="semibold">Erro!</h4> não foi possível atualizar a categoria.',

        'C002S' => '<h4 class="semibold">Sucesso!</h4> categoria inserida.',
        'C002D' => '<h4 class="semibold">Erro!</h4> não foi possível inserir a categoria.',

        'C003S' => '<h4 class="semibold">Sucesso!</h4> categoria excluída.',
        'C003D' => '<h4 class="semibold">Erro!</h4> não foi possível excluir a categoria.',


        'B001S' => '<h4 class="semibold">Sucesso!</h4> banner inserido.',
        'B001D' => '<h4 class="semibold">Erro!</h4> não foi possível inseir o banner.',

        'B002S' => '<h4 class="semibold">Sucesso!</h4> banner atualizado.',
        'B002D' => '<h4 class="semibold">Erro!</h4> não foi possível atualizar o banner.',

        'B003S' => '<h4 class="semibold">Sucesso!</h4> banner excluído.',
        'B003D' => '<h4 class="semibold">Erro!</h4> não foi possível excluir o banner.',


        'CLI001S' => '<h4 class="semibold">Sucesso!</h4> cliente inserido.',
        'CLI001D' => '<h4 class="semibold">Erro!</h4> não foi possível inseir o cliente.',

        'CLI002S' => '<h4 class="semibold">Sucesso!</h4> cliente atualizado.',
        'CLI002D' => '<h4 class="semibold">Erro!</h4> não foi possível atualizar o cliente.',

        'CLI003S' => '<h4 class="semibold">Sucesso!</h4> cliente excluído.',
        'CLI003D' => '<h4 class="semibold">Erro!</h4> não foi possível excluir o cliente.',

        'CONF002S' => '<h4 class="semibold">Sucesso!</h4> configurações salvas.',
        'CONF002D' => '<h4 class="semibold">Erro!</h4> não foi possível salvar as configurações.',

        'USR001S' => '<h4 class="semibold">Sucesso!</h4> usuário inserido.',
        'USR001D' => '<h4 class="semibold">Erro!</h4> não foi possível inserir o usuário.',
        'USR002S' => '<h4 class="semibold">Sucesso!</h4> usuário salvo.',
        'USR002D' => '<h4 class="semibold">Erro!</h4> não foi possível salvar o usuário.',
        'USR003S' => '<h4 class="semibold">Sucesso!</h4> usuário excluído.',
        'USR003D' => '<h4 class="semibold">Erro!</h4> não foi possível excluir o usuário.',
        'USR004D' => '<h4 class="semibold">Erro!</h4> este e-mail já está cadastrado.',

        'SEN000W' => '<h4 class="semibold">Opa!</h4> sensores ainda não podem ser excluídos.',
        'SEN001S' => '<h4 class="semibold">Sucesso!</h4> sensor inserido.',
        'SEN001D' => '<h4 class="semibold">Erro!</h4> não foi possível inserir o sensor.',
        'SEN002S' => '<h4 class="semibold">Sucesso!</h4> sensor salvo.',
        'SEN002D' => '<h4 class="semibold">Erro!</h4> não foi possível salvar o sensor.',
        'SEN003S' => '<h4 class="semibold">Sucesso!</h4> sensor excluído.',
        'SEN003D' => '<h4 class="semibold">Erro!</h4> não foi possível excluir o sensor.',
        'SEN004D' => '<h4 class="semibold">Erro!</h4> este sensor já está cadastrado.',
        'SEN005S' => '<h4 class="semibold">Sucesso!</h4> dados do sensor removidos com sucesso.',
        'SEN005D' => '<h4 class="semibold">Erro!</h4> não foi possível remover os dados do sensor.',
        'SEN006S' => '<h4 class="semibold">Sucesso!</h4> dados dos indicadores enviados.',

        'SITE001S' => '<h4 class="semibold">Sucesso!</h4> Mensagem enviada.',
        'SITE001D' => '<h4 class="semibold">Erro!</h4> não foi possível enviar a sua mensagem.',

        'SITE002S' => '<h4 class="semibold">Sucesso!</h4> Cadastro efetuado.',
        'SITE002D' => '<h4 class="semibold">Erro!</h4> não foi possível efetuar seu cadastro.',

        'REP003S' => '<h4 class="semibold">Sucesso!</h4> Relatório agendado removido.',
        'REP003D' => '<h4 class="semibold">Erro!</h4> não foi possível remover o relatório.',

        'ALE001S' => '<h4 class="semibold">Sucesso!</h4> alerta inserido.',
        'ALE001D' => '<h4 class="semibold">Erro!</h4> não foi possível inserir o alerta.',
        'ALE002S' => '<h4 class="semibold">Sucesso!</h4> alerta salvo.',
        'ALE002D' => '<h4 class="semibold">Erro!</h4> não foi possível salvar o alerta.',
        'ALE003S' => '<h4 class="semibold">Sucesso!</h4> alerta excluído.',
        'ALE003D' => '<h4 class="semibold">Erro!</h4> não foi possível excluir o alerta.',
        'ALE004D' => '<h4 class="semibold">Atenção!</h4> este sensor já emitiu o número máximo de alertas diários.',

        'NOT003S' => '<h4 class="semibold">Sucesso!</h4> Notificação removida.',
        'NOT003D' => '<h4 class="semibold">Erro!</h4> não foi possível remover a notificação.',
    );

    $types = array(
        'S' => 'success',
        'D' => 'danger',
        'W' => 'warning',
        'I' => 'info'
    );


    $type = (isset($cod)) ? $types[substr($cod, -1)] : '';
    $msg = (isset($cod)) ? $cods[$cod] : '';

    if ($btn) {
        $alert = '<div class="row">
                    <div class="col-md-12">
                    	<div class="alert alert-' . $type . ' fade in">
               				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                 	' . $msg . '
			           		<a href="' . $btn[0] . '" class="btn btn-' . $type . '">' . $btn[1] . '</button>
		           		</div>
		           	</div>
		         </div>';
    } else {
        $alert = '<div class="row">
                    <div class="col-md-12">
                    	<div class="alert alert-dismissable alert-' . $type . '">
	                     	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                    	' . str_replace(array('<h4 class="semibold">', '</h4>'), array('<strong>', '</strong>'), $msg) . '
	            	    </div>
		           	</div>
		         </div>';
    }

    return ($cod != '') ? $alert : '';
});
require app_path() . '/filters.php';
