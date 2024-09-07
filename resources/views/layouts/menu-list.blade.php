<li class="pc-item pc-caption">
    <label>Menu</label>
</li>
@role('merchant')
<li class="pc-item pc-hasmenu {{ request()->routeIs('merchant.menu.*') ? 'active pc-trigger' : '' }}">
    <a href="#!" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-fork-knife"></i>
        </span>
        <span class="pc-mtext">Menu</span>
        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="pc-submenu">
        <li class="pc-item {{ request()->routeIs('merchant.menu.*') ? 'active' : '' }}"><a class="pc-link" href="{{ route('merchant.index') }}">Daftar Menu</a></li>
    </ul>
</li>
@endrole

@role('customer')
<li class="pc-item pc-hasmenu ">
    <a href="#!" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-fork-knife"></i>
        </span>
        <span class="pc-mtext">Katering</span>
        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="pc-submenu">
        <li class="pc-item"><a class="pc-link" href="{{ route('customer.pilih-menu') }}">Pilih Menu</a></li>
    </ul>
</li>
@endrole

<li class="pc-item">
    <a href="{{ route('transaction.invoice') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-scroll"></i>
        </span>
        <span class="pc-mtext">Invoice</span>
    </a>
</li>
