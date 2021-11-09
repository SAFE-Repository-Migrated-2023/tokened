<navbar 
    logo-name="{{config('app.name')}}"
    :menu-items="{{collect(config('menus'))}}"
    :user="{{auth()->user() ?? 'false'}}"
    ></navbar>