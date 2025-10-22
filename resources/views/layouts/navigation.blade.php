<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top py-3">
    <div class="container-fluid align-items-center justify-content-between">

        {{-- ✅ الجزء الأيسر: زر القائمة + الشعار والنصوص --}}
        <div class="d-flex align-items-center">
            {{-- زر إظهار/إخفاء السايدبار --}}
            <button class="btn btn-outline-primary me-1 d-lg-inline-block" id="toggleSidebarBtn">
                <i class="bi bi-list fs-4"></i>
            </button>

            {{-- الشعار + اسم المديرية + اسم النظام --}}
            <a class="navbar-brand d-flex align-items-center text-primary fw-bold m-0" href="{{ route('dashboard') }}">
                <img src="{{ $systemSettings?->logo_path ? asset('storage/' . $systemSettings->logo_path) : asset('images/sohag_health_logo.png') }}"
                    alt="شعار"
                    width="70" height="70"
                    class="rounded-circle me-3 border shadow-sm">

                <div class="d-flex flex-column lh-sm">
                    <span class="fs-5 fw-bold">{{ $systemSettings->directorate_name ?? 'مديرية الشئون الصحية بسوهاج' }}</span>
                    <small class="text-muted fs-6">{{ $systemSettings->system_name ?? 'نظام قاعات التدريب' }}</small>
                </div>
            </a>
        </div>

        {{-- ✅ زر النفيقيشن (للشاشات الصغيرة) --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- ✅ المحتوى --}}
        <div class="collapse navbar-collapse" id="navbarContent">

            {{-- ✅ مربع البحث في المنتصف بالضبط --}}
            <form class="d-flex mx-auto my-2 my-lg-0 justify-content-center" style="max-width: 550px; flex: 1;">
                <input class="form-control me-2 form-control-lg text-center" type="search"
                       placeholder="ابحث عن قاعة أو دورة..." aria-label="Search">
                <button class="btn btn-outline-primary btn-lg" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            {{-- ✅ أيقونات الإشعارات والملف الشخصي --}}
            <ul class="navbar-nav ms-auto d-flex align-items-center">

                {{-- الإشعارات --}}
                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationsDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-4"></i>
                        @php
                            $unreadCount = auth()->user()->unreadNotifications->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadCount }}
                                <span class="visually-hidden">new notifications</span>
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationsDropdown" style="width: 300px;">
                        @forelse(auth()->user()->notifications()->latest()->take(10)->get() as $notification)
                            <li class="dropdown-item py-2">
                                <strong class="text-truncate" style="display: block; max-width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                    {{ $notification->data['title'] ?? '' }}
                                </strong>
                                <small class="text-muted text-truncate" style="display: block; max-width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                    {{ $notification->data['message'] ?? '' }}
                                </small>
                            </li>
                        @empty
                            <li class="dropdown-item text-center text-muted py-2">لا يوجد إشعارات اليوم</li>
                        @endforelse
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-center" href="{{ route('notifications.index') }}">
                                عرض كل الإشعارات
                            </a>
                        </li>
                    </ul>
                </li>



                {{-- الملف الشخصي --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-3"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person me-2"></i> الملف الشخصي</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.password.edit') }}"><i class="bi bi-lock me-2"></i> تغيير كلمة المرور</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> تسجيل خروج
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
