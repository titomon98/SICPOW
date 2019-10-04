<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                Mantenimiento
            </li>
            <li @click="menu=1" class="nav-item nav-dropdown">
                <a class="nav-link" href="#"><i class="icon-people"></i> Familias</a>
            </li>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Reportes</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-doc"></i> Reportes</a>
                    </li>
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-chart"></i> Barras</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-lock"></i> Acceso</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-user"></i> Usuarios</a>
                    </li>
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-user"></i> Roles</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-map"></i> Lugares</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-home"></i> Distritos</a>
                    </li>
                    <li @click="menu=7" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-home"></i> Comunidades</a>
                    </li>
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-home"></i> Municipios</a>
                    </li>
                </ul>
            </li>
            <li @click="menu=9" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...</a>
            </li>
        </ul>
    </nav>
    
</div>