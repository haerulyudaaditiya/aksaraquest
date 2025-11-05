<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link, usePage } from "@inertiajs/vue3";
import Star from "@/Components/Icons/Star.vue";

const showingNavigationDropdown = ref(false);

// Ambil data user, bisa jadi null jika belum login
const user = usePage().props.auth.user;
</script>

<template>
    <div>
        <div class="min-h-screen bg-slate-100 font-sunda">
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </NavLink>
                                <NavLink
                                    :href="route('belajar.index')"
                                    :active="route().current('belajar.*')"
                                >
                                    Belajar
                                </NavLink>
                                <NavLink
                                    :href="route('arena.index')"
                                    :active="route().current('arena.*')"
                                >
                                    Arena
                                </NavLink>
                                <NavLink
                                    :href="route('fokus.index')"
                                    :active="route().current('fokus.*')"
                                >
                                    Tinjauan
                                </NavLink>
                                <NavLink
                                    :href="route('dongeng.index')"
                                    :active="route().current('dongeng.*')"
                                >
                                    Dongeng
                                </NavLink>
                                <NavLink
                                    :href="route('prestasi.index')"
                                    :active="route().current('prestasi.*')"
                                >
                                    Prestasi
                                </NavLink>
                                <NavLink
                                    :href="route('leaderboard.index')"
                                    :active="route().current('leaderboard.*')"
                                >
                                    Peringkat
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div
                                v-if="user"
                                class="me-4 flex items-center gap-4 border-r border-slate-200 pe-4"
                            >
                                <div
                                    class="flex items-center gap-1.5"
                                    title="Streak Harian"
                                >
                                    <span class="font-extrabold text-orange-600"
                                        >🔥 {{ user.streak_count }}</span
                                    >
                                </div>

                                <div
                                    class="flex items-center gap-1.5"
                                    title="Total XP"
                                >
                                    <Star class="h-5 w-5 text-amber-400" />
                                    <span class="font-extrabold text-amber-600"
                                        >{{ user.xp }} XP</span
                                    >
                                </div>

                                <div
                                    class="flex items-center gap-1.5"
                                    title="Level Saat Ini"
                                >
                                    <svg
                                        class="h-5 w-5 text-indigo-500"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    <span class="font-extrabold text-indigo-600"
                                        >Level {{ user.level }}</span
                                    >
                                </div>
                            </div>

                            <div class="ms-3 relative">
                                <Dropdown v-if="user" align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ user.name }}
                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profil
                                        </DropdownLink>
                                        <DropdownLink
                                            v-if="user.has_certificate"
                                            :href="route('sertifikasi.view')"
                                        >
                                            Sertifikat Saya
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            >Log Out</DropdownLink
                                        >
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('belajar.index')"
                            :active="route().current('belajar.*')"
                        >
                            Belajar
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('arena.index')"
                            :active="route().current('arena.*')"
                        >
                            Arena
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('fokus.index')"
                            :active="route().current('fokus.*')"
                        >
                            Tinjauan
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('dongeng.index')"
                            :active="route().current('dongeng.*')"
                        >
                            Dongeng
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('prestasi.index')"
                            :active="route().current('prestasi.*')"
                        >
                            Prestasi
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('leaderboard.index')"
                            :active="route().current('leaderboard.*')"
                        >
                            Peringkat
                        </ResponsiveNavLink>
                    </div>

                    <div v-if="user" class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ user.email }}
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profil
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                v-if="user.has_certificate"
                                :href="route('sertifikasi.view')"
                            >
                                Sertifikat Saya
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
