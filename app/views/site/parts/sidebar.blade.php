<div id="left">
    <div class="subnav">
        <div class="subnav-title">
            <a href="#" class='toggle-subnav'>
                <i class="fa fa-angle-down"></i>
                <span>Conteúdo</span>
            </a>
        </div>
        <ul class="subnav-menu">
            <li class='dropdown'>
                <a href="#" data-toggle="dropdown">Produtos</a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{URL::route('posts')}}">Todos</a>
                    </li>
                    <li>
                        <a href="#">Adicionar Novo</a>
                    </li>
                    <li>
                        <a href="{{URL::route('terms',array('action'=>'categories'))}}">Categorias</a>
                    </li>
                    <li>
                        <a href="{{URL::route('terms',array('action'=>'tags'))}}">Tags</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
    <div class="subnav">
        <div class="subnav-title">
            <a href="#" class='toggle-subnav'>
                <i class="fa fa-angle-down"></i>
                <span>Usuários</span>
            </a>
        </div>
        <ul class="subnav-menu">
            <li>
                <a href="#">Todos</a>
            </li>
            <li>
                <a href="#">Adicionar Novo</a>

            </li>
            <li>
                <a href="#">Permissões</a>

            </li>

        </ul>
    </div>
    <div class="subnav">
        <div class="subnav-title">
            <a href="#" class='toggle-subnav'>
                <i class="fa fa-angle-down"></i>
                <span>Configurações</span>
            </a>
        </div>
        <ul class="subnav-menu">
            <li>
                <a href="#">Configurações do Tema</a>
            </li>
            <li>
                <a href="#">Gateway de Pagamento</a>
            </li>
            <li li class='dropdown'>
                <a href="#" data-toggle="dropdown">Email</a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">Layout</a>
                    </li>
                    <li>
                        <a href="#">SMTP</a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>

</div>