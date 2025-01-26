<template>
    <transition leave-active-class="delay-300 duration-300 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
    >
        <div v-if="loading"
             class="bg-white dark:bg-black fixed flex inset-0 items-center justify-center z-40"
        >
            <span class="animate-fade-in">
                {{ Lang.get('main.loading') }}...
            </span>
        </div>
    </transition>
</template>

<script setup>
defineProps({
    loading: Boolean,
})
</script>
