<template>
    <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
        <Nav/>
        <div class="flex overflow-y-hidden flex-1">
            <div class="w-1/3">Sidebar</div>
            <div class="w-2/3 overflow-x-hidden">
                <router-view/>
                <p v-for="i in 100">Morbi ac felis. Nam eget dui. Maecenas ullamcorper, dui et placerat feugiat, eros pede varius nisi, condimentum viverra felis nunc et lorem. Donec sodales sagittis magna. Curabitur nisi.</p>
            </div>
        </div>
    </div>
</template>

<script>
import Nav from "./Nav";

export default {
    name: "App",
    components: {
        Nav
    },
}
</script>

<style scoped>

</style>
