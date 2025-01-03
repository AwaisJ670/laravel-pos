<sidebar-component
    {{-- :user="{{session('user')}}" --}}
    :user="{{ Auth::user() }}"
    :modules="{{ getUserPermissionModules() }}"
>
</sidebar-component>

