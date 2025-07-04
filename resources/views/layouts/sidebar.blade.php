<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">

                <li class="menu-title">PRINCIPAL</li>

                <li>
                    <a href="{{ route('admin') }}" class="waves-effect {{ request()->is('admin') || request()->is('admin/*') ? 'mm active' : '' }}">
                        <i class="ti-home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title">GESTIÓN DE PERSONAL</li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="ti-user"></i>
                        <span> Empleados
                            <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span>
                        </span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/employees" class="{{ request()->is('employees') || request()->is('employees/*') ? 'mm active' : '' }}">
                                <i class="dripicons-view-apps"></i> Lista de Empleados
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('users.index') }}" class="waves-effect {{ request()->is('users') || request()->is('users/*') ? 'mm active' : '' }}">
                        <i class="ti-id-badge"></i>
                        <span> Usuarios del Sistema </span>
                    </a>
                </li>

                <li class="menu-title">ADMINISTRACIÓN</li>

                <li>
                    <a href="/services" class="waves-effect {{ request()->is('services') || request()->is('services/*') ? 'mm active' : '' }}">
                        <i class="ti-briefcase"></i>
                        <span> Servicios </span>
                    </a>
                </li>

                <li>
                    <a href="/schedule" class="waves-effect {{ request()->is('schedule') || request()->is('schedule/*') ? 'mm active' : '' }}">
                        <i class="ti-time"></i>
                        <span> Horarios </span>
                    </a>
                </li>

                <li>
                    <a href="/work-schedule" class="waves-effect {{ request()->is('work-schedule') || request()->is('admin/work-schedule/*') ? 'mm active' : '' }}">
                        <i class="ti-calendar"></i>
                        <span> Programación </span>
                    </a>
                </li>

                <li>
                    <a href="/attendance" class="waves-effect {{ request()->is('attendance') || request()->is('attendance/*') ? 'mm active' : '' }}">
                        <i class="ti-calendar"></i>
                        <span> Registros de Asistencia </span>
                    </a>
                </li>

                <li>
                    <a href="/latetime" class="waves-effect {{ request()->is('latetime') || request()->is('latetime/*') ? 'mm active' : '' }}">
                        <i class="dripicons-warning"></i>
                        <span> Llegadas Tardías </span>
                    </a>
                </li>

                <li>
                    <a href="/leave" class="waves-effect {{ request()->is('leave') || request()->is('leave/*') ? 'mm active' : '' }}">
                        <i class="dripicons-backspace"></i>
                        <span> Solicitudes de Permisos </span>
                    </a>
                </li>

                <li>
                    <a href="/overtime" class="waves-effect {{ request()->is('overtime') || request()->is('overtime/*') ? 'mm active' : '' }}">
                        <i class="dripicons-alarm"></i>
                        <span> Horas Extras </span>
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="ti-bar-chart"></i>
                        <span> Reportes
                            <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span>
                        </span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="/sheet-report" class="{{ request()->is('sheet-report') || request()->is('sheet-report/*') ? 'mm active' : '' }}">
                                Reporte de Asistencia
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reporte.faltas') }}" class="{{ request()->is('reporte/faltas') || request()->is('reporte/faltas/*') ? 'mm active' : '' }}">
                                Reporte de Faltas
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="waves-effect" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ti-power-off"></i>
                        <span> Cerrar Sesión </span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->
