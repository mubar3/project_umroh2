
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar" >
        <div class="user-panel">
            <img src="https://via.placeholder.com/60" alt="User Image">
            <p>Admin</p>
            <p><i class="fas fa-circle text-success"></i> Online</p>
        </div>
        <ul>
            <li style="background-color:#34495e;">
                <a href="#" onclick="toggleSidebar()"><i class="fas fa-bars"></i> MENU</a>
            </li>
            <li><a href="#"><i class="fas fa-home"></i> Beranda</a></li>
            <li><a href="#"><i class="fas fa-user-plus"></i> Tambah Anggota</a></li>
            <li><a href="#"><i class="fas fa-list"></i> Daftar Anggota</a></li>
            <li><a href="#"><i class="fas fa-wallet"></i> Keuangan</a></li>
            <li><a href="#"><i class="fas fa-plane"></i> Umroh & Haji</a></li>
            <li><a href="#"><i class="fas fa-briefcase"></i> Perlengkapan</a></li>
            <li><a href="{{ url('/logout') }}"><i class="fas fa-power-off"></i> Logout</a></li>
        </ul>
    </aside>
