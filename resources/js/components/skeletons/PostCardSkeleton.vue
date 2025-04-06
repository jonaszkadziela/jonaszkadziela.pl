<template>
    <Card :pt="{
        body: 'overflow-hidden p-6',
        root: 'dark:shadow-blue-800/80 duration-300 hover:shadow-xl transition-shadow w-full',
    }"
    >
        <template #header>
            <Skeleton class="rounded-t-xl rounded-b-none min-h-64" />
        </template>
        <template #title>
            <Skeleton class="max-w-[24rem] w-full"
                      height="2rem"
            />
        </template>
        <template #subtitle>
            <div class="flex flex-wrap gap-2 mb-6 mt-1">
                <Skeleton borderRadius="16px"
                          class="max-w-[6rem] w-full"
                          height="1.5rem"
                />
                <Skeleton borderRadius="16px"
                          class="max-w-[4rem] w-full"
                          height="1.5rem"
                />
                <Skeleton borderRadius="16px"
                          class="max-w-[9rem] w-full"
                          height="1.5rem"
                />
            </div>
        </template>
        <template #content>
            <Skeleton class="max-w-[16rem] mb-6 w-full"
                      height="1.5rem"
            />
            <Skeleton class="mb-2" />
            <Skeleton class="mb-2" />
            <Skeleton class="max-w-[18rem] mb-2 w-full" />
        </template>
        <template #footer>
            <Skeleton borderRadius="9999px"
                      class="mt-5"
                      height="2.5rem"
                      width="7rem"
            />
        </template>
    </Card>
</template>
