<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { sidebarVisible, sidebarExpanded } from "@/Pages/Admin/Services/sidebar.js";
import Ticket from "@/Pages/Admin/Svgs/Ticket.vue";
import Home from "@/Pages/Admin/Svgs/Home.vue";
import Bars from "@/Pages/Admin/Svgs/Bars.vue";
import ArrowLeft from "@/Pages/Admin/Svgs/ArrowLeft.vue";

const page = usePage();

const sidebarRef = ref(null);
const buttonRef = ref(null);

const updateSidebarExpanded = () => {
    sidebarExpanded.value = window.innerWidth < 640;
};

onMounted(() => {
    window.addEventListener('resize', updateSidebarExpanded);
});

onUnmounted(() => {
    window.removeEventListener('resize', updateSidebarExpanded);
});

const toggleSidebar = () => {
    sidebarVisible.value = !sidebarVisible.value;
};

const handleClickOutside = (event) => {
    if (window.innerWidth <= 640) {
        if (sidebarRef.value && !sidebarRef.value.contains(event.target) &&
            buttonRef.value && !buttonRef.value.contains(event.target)) {
            sidebarVisible.value = false;
        }
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>
<template>
    <div>
        <button ref="buttonRef" type="button" @click="toggleSidebar"
            class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 ">
            <span class="sr-only">Open sidebar</span>
            <Bars />
        </button>
        <aside ref="sidebarRef" v-if="sidebarVisible" @mouseenter="sidebarExpanded = true"
            @mouseleave="sidebarExpanded = false" class="fixed top-0 left-0 z-40 w-72 sm:w-16 sm:hover:w-60 h-screen ">

            <div class="h-full flex flex-col justify-between overflow-y-auto bg-gray-200 overflow-hidden">
                <ul class="space-y-2 font-medium">
                    <li @click="sidebarExpanded = false">
                        <Link :href="route('admin.index')" class="p-4 flex items-center hover:bg-gray-700 group"
                            :class="{ 'bg-gray-700': $page.url === '/admin' }">
                        <Home :activeRoute="$page.url" />
                        <span class="ms-3 text-gray-900 group-hover:text-white text-xs" v-show="sidebarExpanded"
                            :class="{ 'text-white': $page.url === '/admin' }">Início</span>
                        </Link>
                    </li>
                    <li @click="sidebarExpanded = false">
                        <Link :href="route('create.raffle', { clinic: $page.props?.clinicUuid })"
                            class="p-4 flex items-center hover:bg-gray-700 group"
                            :class="{ 'bg-gray-700': $page.url === '/admin/criar-rifa' }">
                        <Ticket :activeRoute="$page.url" />
                        <span class="ms-3 text-gray-900 group-hover:text-white text-xs" v-show="sidebarExpanded"
                            :class="{ 'text-white': $page.url === '/admin/criar-rifa' }">Criar Rifa</span>
                        </Link>
                    </li>
                </ul>
                <ul>
                    <li @click="sidebarExpanded = false">
                        <Link :href="route('admin.logout')" class="p-4 flex items-center bg-red-400 group">
                        <ArrowLeft />
                        <span class="ms-3 text-gray-900 font-bold group-hover:text-white"
                            v-show="sidebarExpanded">Sair</span>
                        </Link>
                    </li>
                </ul>
            </div>

        </aside>
        <div v-if="sidebarVisible" @click="toggleSidebar" class="fixed inset-0 bg-ag-dark bg-opacity-10 z-40 sm:hidden">
        </div>

    </div>
</template>
