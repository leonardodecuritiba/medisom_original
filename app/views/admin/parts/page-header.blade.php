<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold">@if(isset($title)) {{$title}} @endif</h4>
    </div>
    <div class="page-header-section">
        <!-- Toolbar -->
        <div class="toolbar">
            <ol class="breadcrumb breadcrumb-transparent nm">
                <li><a href="{{URL::route('admin.dashboard')}}">Dashboard</a></li>
                <li class="active">@if(isset($title)) {{$title}} @endif</li>
            </ol>
        </div>
        <!--/ Toolbar -->
    </div>
</div>

{{HTML::alert()}}