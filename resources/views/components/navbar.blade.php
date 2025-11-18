<!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> -->
@auth
@if(Auth::user()->role->title == 'admin')
    <nav class="relative after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10 bg-white">
        <div class="mx-auto px-2 sm-px-6 lg-px-8">
            <div class="relative flex h-16 items-center justify-between">
                <!--- logo collapse mobile---->
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                            </svg>
                    </button>
                </div>
                <!--- logo collapse mobile end---->
                <!----- desktop --->
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start px-3">
                    <div class="flex shrink-0 items-center">
                      <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" class="h-8 w-auto" />
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                      <div class="flex space-x-4">
                        <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                        <a href="{{ route('admin.dashboard') }}" aria-current="page" class="rounded-md px-3 py-2 text-sm font-medium">Dashboard</a>
                        <a href="{{ route('admin.course_category.manage') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:text-white hover:bg-orange-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">Course Categories</a>
                        <a href="{{ route('admin.course.manage') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:text-white hover:bg-orange-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">Courses</a>
                        <a href="{{ route('admin.soal.manage') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:text-white hover:bg-orange-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">Soal</a>
                        <a href="{{ route('admin.mission.dashboard') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:text-white hover:bg-orange-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">Tugas</a>
                      </div>
                    </div>
                </div>
                  <!----- eof desktop ---->
                <div class="relative me-3">
                    <div class="flex gap-2 cursor-pointer" id="profilebutton" data-state="inactive">
                        <div class="content-center text-slate-900 text-lg">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        </div>
                        @if(Auth::user()->load(['image'])->image != null)
                            <img src="{{ asset('storage/' . Auth::user()->load(['image'])->image->path) }}" alt="" class="size-10 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
                        @endif
                        @if(Auth::user()->load(['image'])->image == null)
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
                        @endif
                    </div>
                    <div id="dropdownmenu" class="hidden absolute right-0 mt-2 w-40 bg-white shadow-sm border border-gray-200 rounded-sm py-2 flex flex-col gap-2">

                        <a href="{{ route('admin.profile.manage') }}" class="p-2 text-slate-900 cursor-pointer hover:bg-gray-200">
                            <i class="fa-solid fa-user"></i> pengaturan
                        </a>
                        <a href="#" class="p-2 text-slate-900 cursor-pointer hover:bg-gray-200" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                            <i class="fa-solid fa-gear"></i> keluar
                        </a>
                        <form method="POST" action="{{route('logout')}}" class="hidden" id="logout-form">
                            @csrf
                        </form>
                    </div>
                </div>
                <el-disclosure id="mobile-menu" hidden class="block sm:hidden">
                    <div class="space-y-1 px-2 pt-2 pb-3">
                      <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                        <a href="#" aria-current="page" class="block rounded-md bg-gray-950/50 px-3 py-2 text-base font-medium text-white">Dashboard</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Team</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Projects</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Calendar</a>
                    </div>
                </el-disclosure>

            </div>
        </div>
    </nav>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const btntoggle = document.getElementById("profilebutton");
            const menu = document.getElementById("dropdownmenu");
            btntoggle.addEventListener("click", () => {
                if(btntoggle.dataset.state == "inactive"){
                    btntoggle.dataset.state = "active";
                    menu.classList.remove("hidden");
                }else if(btntoggle.dataset.state == "active"){
                    btntoggle.dataset.state = "inactive";
                    menu.classList.add("hidden");
                }
            });
        })

    </script>
@endif

@if(Auth::user()->role->title == 'student')
    <nav class="relative after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10 bg-white">
        <div class="mx-auto px-2 sm-px-6 lg-px-8 py-1">
            <div class="relative flex h-16 items-center justify-between">
                <!--- logo collapse mobile---->
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                            </svg>
                    </button>
                </div>
                <!--- logo collapse mobile end---->
                <!----- desktop --->
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start px-3">
                    <div class="flex shrink-0 items-center">
                      <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" class="h-8 w-auto" />
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                      <div class="flex space-x-4">
                        <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                        <a href="{{ route('student.dashboard') }}" aria-current="page" class="rounded-md px-3 py-2 text-sm font-medium">Dashboard</a>
                       </div>
                    </div>

                </div>
                <div class="relative me-3">
                    <div class="flex gap-2 cursor-pointer" id="profilebutton" data-state="inactive">
                        <div class="content-center text-slate-900 text-lg">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        </div>
                        @if(Auth::user()->load(['image'])->image != null)
                            <img src="{{ asset('storage/' . Auth::user()->load(['image'])->image->path) }}" alt="" class="size-10 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
                        @endif
                        @if(Auth::user()->load(['image'])->image == null)

                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
                        @endif
                    </div>
                    <div id="dropdownmenu" class="hidden absolute right-0 mt-2 w-40 bg-white shadow-sm border border-gray-200 rounded-sm py-2 flex flex-col gap-2">

                        <a href="{{ route('student.profile.manage') }}" class="p-2 text-slate-900 cursor-pointer hover:bg-gray-200">
                            <i class="fa-solid fa-user"></i> pengaturan
                        </a>
                        <a href="#" class="p-2 text-slate-900 cursor-pointer hover:bg-gray-200" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                            <i class="fa-solid fa-gear"></i> keluar
                        </a>
                        <form method="POST" action="{{route('logout')}}" class="hidden" id="logout-form">
                            @csrf
                        </form>
                    </div>
                </div>
                <el-disclosure id="mobile-menu" hidden class="block sm:hidden">
                    <div class="space-y-1 px-2 pt-2 pb-3">
                      <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                        <a href="#" aria-current="page" class="block rounded-md bg-gray-950/50 px-3 py-2 text-base font-medium text-white">Dashboard</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Team</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Projects</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Calendar</a>
                    </div>
                </el-disclosure>

            </div>
        </div>
    </nav>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const btntoggle = document.getElementById("profilebutton");
            const menu = document.getElementById("dropdownmenu");
            btntoggle.addEventListener("click", () => {
                if(btntoggle.dataset.state == "inactive"){
                    btntoggle.dataset.state = "active";
                    menu.classList.remove("hidden");
                }else if(btntoggle.dataset.state == "active"){
                    btntoggle.dataset.state = "inactive";
                    menu.classList.add("hidden");
                }
            });
        })

    </script>

@endif
@endauth
