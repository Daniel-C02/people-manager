<div>
    <nav class="navbar py-8">
        <div class="container-xxl">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link nav-link p-0 m-0 align-baseline">
                    Log Out
                </button>
            </form>
        </div>
    </nav>
</div>
