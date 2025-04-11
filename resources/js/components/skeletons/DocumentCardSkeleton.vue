<template>
    <Card :pt="{
        body: 'gap-0 h-full p-0',
        caption: 'h-full',
        root: 'dark:shadow-blue-800/80 duration-300 flex flex-col hover:shadow-xl transition-shadow',
        title: 'h-full',
    }">
        <template #header>
            <Skeleton class="w-full rounded-t-xl rounded-b-none min-h-64 border-b" />
        </template>
        <template #title>
            <div class="flex flex-col gap-2 p-6">
                <Skeleton class="w-full"
                          height="2rem"
                />
                <Skeleton class="w-full"
                          height="2rem"
                />
                <Skeleton class="max-w-[12rem] w-full"
                          height="2rem"
                />
            </div>
        </template>
    </Card>
</template>
