<div>
    <nav class="navbar py-8">
        <div class="container-xxl">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-warning text-dark">
                    Log Out
                </button>
            </form>
        </div>
    </nav>
</div>
