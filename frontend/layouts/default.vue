<template>
    <div>
        <header>
            <Navbar />
        </header>
        <main class="flex flex-col gap-8 py-8 px-4">
            <slot />
        </main>
    </div>
</template>

<style>
h1,
h2,
h3,
h4 {
    @apply font-serif;
}
</style>