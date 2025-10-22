<!-- ✅ الشريط الجانبي -->
<div class="d-flex">
    <div class="bg-light border-end vh-100 collapse show" id="sidebarMenu"
         style="width: 250px; position: fixed; top: 90px; bottom: 0; overflow-y: auto;">

        {{-- ✅ الجزء العلوي: شعار الإدارة واسم المستخدم --}}
        <div class="text-center border-bottom pb-3">
       
            <h6 class="fw-bold text-primary mt-4"> </h6>
            <small class="text-muted "> {{ $systemSettings->department_name ?? 'إدارة التدريب' }}</small>
            <div class="mt-2">
                <span class="badge bg-secondary">
                    {{ Auth::user()->name ?? 'اسم المستخدم' }}
                </span>
            </div>
        </div>

        {{-- ✅ القوائم --}}
        <div class="p-3">
            <h6 class="text-secondary mb-3">القائمة الرئيسية</h6>
            <ul class="nav flex-column">

                <!-- 🏠 لوحة التحكم -->
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center text-dark rounded hover-item {{ request()->routeIs('dashboard') ? 'bg-primary text-white' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2 text-primary"></i> لوحة التحكم
                    </a>
                </li>

                <!-- 🏢 إدارة القاعات -->
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex justify-content-between align-items-center text-dark rounded hover-item"
                       data-bs-toggle="collapse" href="#roomsMenu" role="button" aria-expanded="false"
                       aria-controls="roomsMenu" data-bs-parent="#sidebarMenu">
                        <span><i class="bi bi-building me-2 text-primary"></i> إدارة القاعات</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse ps-3" id="roomsMenu">
                        <ul class="nav flex-column mt-1">
                            <li><a class="nav-link text-dark hover-item py-1" href="{{route('halls.index')}}">عرض القاعات</a></li>
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('halls.create') }}">إضافة قاعة جديدة</a></li>
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('halls.bookings.index')}}"> حجز القاعات</a></li>
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('hall_reports.index') }}">    تقارير المرور </a></li>
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('halls.halls.bookings.timetable') }}">الجدول الزمني</a></li>
                        </ul>
                    </div>
                </li>

                <!-- 🧾 الدورات التدريبية -->
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex justify-content-between align-items-center text-dark rounded hover-item"
                       data-bs-toggle="collapse" href="#coursesMenu" role="button" aria-expanded="false"
                       aria-controls="coursesMenu" data-bs-parent="#sidebarMenu">
                        <span><i class="bi bi-journal-text me-2 text-primary"></i> البرامج التدريبية</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse ps-3" id="coursesMenu">
                        <ul class="nav flex-column mt-1">
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('programs.courses') }}">  الدورات التدريبية  </a></li>
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('programs.conferences') }}">  المؤتمرات العلمية  </a></li>
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('programs.days') }}">  الأيام العلمية </a></li>
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('programs.create') }}">إضافة برنامج تدريبى</a></li>
                        </ul>
                    </div>
                </li>

                {{-- 🔹 قسم المتدربين --}}
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex justify-content-between align-items-center text-dark rounded hover-item"
                        data-bs-toggle="collapse" href="#traineesMenu" role="button" aria-expanded="false"
                        aria-controls="traineesMenu" data-bs-parent="#sidebarMenu">
                        <span><i class="bi bi-person-lines-fill me-2 text-primary"></i> قسم المتدربين</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse ps-3" id="traineesMenu">
                        <ul class="nav flex-column mt-1">
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('trainees.index') }}">عرض المتدربين</a></li>
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('trainees.create') }}">إضافة متدرب جديد</a></li>
                            <li><a class="nav-link text-dark hover-item py-1" href="{{ route('trainees.reports') }}">تقارير المتدربين</a></li>
                        </ul>
                    </div>
                </li>

                <!-- 👥 المستخدمين -->
                @unless(auth()->user()->role === 'user')
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center text-dark rounded hover-item"
                     href="{{route('users.index')}}">
                        <i class="bi bi-people me-2 text-primary"></i> المستخدمين
                    </a>
                </li>
                @endunless

                <!-- ⚙️ الإعدادات -->
                @unless(auth()->user()->role === 'user')
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center text-dark rounded hover-item"
                     href="{{ route('settings.index') }}">
                        <i class="bi bi-gear me-2 text-primary"></i> الإعدادات
                    </a>
                </li>
                @endunless
            </ul>
        </div>
    </div>





<style>
.hover-item:hover {
    background-color: rgba(13, 110, 253, 0.1);
    color: #0d6efd !important;
}
</style>
