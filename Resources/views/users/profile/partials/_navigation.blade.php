<style>
    .panel li a {
        /*color: #555;*/
    }
    .panel li.active {
        background-color: #eee;
    }
    .panel li.active a {
        color: #555;
    }
</style>

<div class="panel">
    @if(permit("users.profile-info"))
        <h3 class="panel-title panel-heading panel-info">General</h3>
        <ul class="nav nav-list">
            <li class="{{ !active_route('users/info', 3) ?: 'active' }}"><a href="{{ route('users.show', [$user->id, "info"]) }}">Profile Information</a></li>
            <li class="{{ !active_route('users/signatures', 3) ?: 'active' }}"><a href="{{ route('users.show', [$user->id, "signatures"]) }}">Signatures</a></li>
        </ul>
    @endif

    @if(permit("users.profile-roles"))
        <h3 class="panel-title panel-heading panel-info">System Access</h3>
        <ul class="nav nav-list">
            <li class="{{ !active_route('users/roles', 3) ?: 'active' }}"><a href="{{ route('users.show', [$user->id, "roles"]) }}">Assigned Roles</a></li>
            <li class="{{ !active_route('users/permissions', 3) ?: 'active' }}"><a href="{{ route('users.show', [$user->id, "permissions"]) }}">Special Permissions</a></li>
        </ul>
    @endif

    @if(permit("users.profile-clinics"))
        <h3 class="panel-title panel-heading panel-info">Clinics</h3>
        <ul class="nav nav-list">
            <li class="{{ !active_route('users/clinics', 3) ?: 'active' }}"><a href="{{ route('users.show', [$user->id, "clinics"]) }}">Authorised clinics</a></li>
        </ul>
    @endif

    @if(permit("users.profile-credentials"))
        <h3 class="panel-title panel-heading panel-info">Login Details</h3>
        <ul class="nav nav-list">
            <li class="{{ !active_route('users/credentials', 3) ?: 'active' }}"><a href="{{ route('users.show', [$user->id, "credentials"]) }}">Credentials</a></li>
        </ul>
    @endif

    @if(m_setting('users.enable_dependants'))
        @if(permit("users.dependants.index"))
            <h3 class="panel-title panel-heading panel-info">Dependants</h3>
            <ul class="nav nav-list">
                @if(permit("users.dependants.store"))
                    <li  class="{{ !active_route('users/create-dependant', 3) ?: 'active' }}"><a href="{{ route('users.show', [$user->id, "create-dependant"]) }}">Add a dependant</a></li>
                @endif

                @if(permit("users.dependants.index"))
                    <li class="{{ !active_route('users/view-dependants', 3) ?: 'active' }}"><a href="{{ route('users.show', [$user->id, "view-dependants"]) }}">View dependants</a></li>
                @endif
            </ul>
        @endif
    @endif
</div>
