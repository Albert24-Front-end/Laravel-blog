<script setup lang="ts">

import DefaultLayout from "@/components/layouts/default.vue";

// Указываем Inertia использовать этот лейаут
defineOptions({
    layout: DefaultLayout,
});
</script>

<template>
    <div class="max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow mt-8">
            <div class="card-body">
                <div>
                    <h1 class="text-3xl font-bold">Welcome to Laraveler!</h1>
                    <p class="mt-4 text-base-content/60">This is your brand new Laravel application. Time to make it
                        sing (or laraaavel)!</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
