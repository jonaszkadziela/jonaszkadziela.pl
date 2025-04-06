<template>
    <Card :pt="{
        body: 'md:w-3/4 p-6',
        footer: 'mt-auto',
        header: 'flex md:w-1/4',
        root: 'dark:shadow-blue-800/80 duration-300 flex flex-col hover:shadow-xl md:flex-row transition-shadow',
    }">
        <template #header>
            <Skeleton class="md:min-h-full md:rounded-l-xl md:rounded-tr-none min-h-72 rounded-b-none rounded-t-xl" />
        </template>
        <template #title>
            <div class="flex flex-col gap-2 justify-between lg:flex-row">
                <Skeleton class="max-w-[24rem] w-full"
                          height="2rem"
                />
                <Skeleton class="lg:min-h-8 max-w-[12rem] min-h-6 w-full" />
            </div>
        </template>
        <template #subtitle>
            <div class="flex flex-wrap gap-2 mb-6 mt-1">
                <Skeleton borderRadius="16px"
                          class="max-w-[7rem] w-full"
                          height="1.5rem"
                />
                <Skeleton borderRadius="16px"
                          class="max-w-[4rem] w-full"
                          height="1.5rem"
                />
                <Skeleton borderRadius="16px"
                          class="max-w-[4rem] w-full"
                          height="1.5rem"
                />
                <Skeleton borderRadius="16px"
                          class="max-w-[6rem] w-full"
                          height="1.5rem"
                />
                <Skeleton borderRadius="16px"
                          class="max-w-[3rem] w-full"
                          height="1.5rem"
                />
                <Skeleton borderRadius="16px"
                          class="max-w-[5rem] w-full"
                          height="1.5rem"
                />
                <Skeleton borderRadius="16px"
                          class="max-w-[3rem] w-full"
                          height="1.5rem"
                />
            </div>
        </template>
        <template #content>
            <Skeleton class="mb-2" />
            <Skeleton class="mb-2" />
            <Skeleton class="max-w-[18rem] mb-2 w-full" />
        </template>
        <template #footer>
            <div class="flex flex-col gap-2 md:flex-row mt-4">
                <Skeleton borderRadius="9999px"
                          class="md:max-w-[9rem] w-full"
                          height="2.5rem"
                />
                <Skeleton borderRadius="9999px"
                          class="md:max-w-[6rem] w-full"
                          height="2.5rem"
                />
            </div>
        </template>
    </Card>
</template>
