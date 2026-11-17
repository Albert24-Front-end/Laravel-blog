<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <div class="min-h-screen flex flex-col bg-base-200 font-sans">
        <nav class="navbar bg-base-100">
            <div class="navbar-start">
                <Link href="/" class="btn btn-ghost text-xl">🐦 Laraveler</Link>
            </div>
            <div class="navbar-end gap-2">
                <a href="#" class="btn btn-ghost btn-sm">Sign In</a>
                <a href="#" class="btn btn-primary btn-sm">Sign Up</a>
            </div>
        </nav>

        <main class="flex-1 container mx-auto px-4 py-8">
            <slot></slot>
        </main>

        <footer class="footer footer-center p-5 bg-base-300 text-base-content text-xs">
            <div>
                <p>© 2026 Laraveler - Built with Laravel and ❤️</p>
            </div>
        </footer>
    </div>
</template>

<style scoped>

</style>
